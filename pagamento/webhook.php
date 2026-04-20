<?php
include '../config.php';
include '../helpers.php';

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

// id do pagamento vindo da notificação
$payment_id = $data['data']['id'] ?? null;

if (!$payment_id) {
    http_response_code(200);
    exit('OK');
}

// consulta o pagamento direto na API do Mercado Pago
$ch = curl_init('https://api.mercadopago.com/v1/payments/' . $payment_id);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $mp_token
]);

$response = curl_exec($ch);
curl_close($ch);

$payment = json_decode($response, true);

if (!is_array($payment)) {
    http_response_code(200);
    exit('OK');
}

$status = $payment['status'] ?? '';
$empresa_id = isset($payment['external_reference']) ? (int)$payment['external_reference'] : 0;
$valor = isset($payment['transaction_amount']) ? (float)$payment['transaction_amount'] : 0;

// registra a notificação
if ($empresa_id > 0) {
    $stmt = $conn->prepare('INSERT INTO pagamentos (empresa_id, mp_id, status, valor) VALUES (?, ?, ?, ?)');
    $mpid = (string)$payment_id;
    $stmt->bind_param('issd', $empresa_id, $mpid, $status, $valor);
    $stmt->execute();
}

// ativa assinatura
if ($status === 'approved' && $empresa_id > 0) {
    $novaData = date('Y-m-d', strtotime('+30 days'));
    $stmt = $conn->prepare('UPDATE empresas SET status = "ativo", data_expiracao = ? WHERE id = ?');
    $stmt->bind_param('si', $novaData, $empresa_id);
    $stmt->execute();
}

http_response_code(200);
echo 'OK';