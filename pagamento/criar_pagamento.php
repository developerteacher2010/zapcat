<?php
include '../config.php';
include '../helpers.php';

exigir_login_cliente();
$empresa = empresa_logada($conn);

if (!$empresa) {
    session_destroy();
    redirecionar('../login.php');
}

$valor = 49;
if ($empresa['plano'] === 'starter') $valor = 29;
if ($empresa['plano'] === 'premium') $valor = 79;

$payload = [
    'items' => [[
        'title' => 'Plano ' . ucfirst($empresa['plano']) . ' ZapPro',
        'quantity' => 1,
        'currency_id' => 'BRL',
        'unit_price' => $valor
    ]],
    'external_reference' => (string)$empresa['id'],
    'notification_url' => $app_url . '/pagamento/webhook.php',
    'back_urls' => [
        'success' => $app_url . '/cliente/assinatura.php',
        'failure' => $app_url . '/cliente/assinatura.php',
        'pending' => $app_url . '/cliente/assinatura.php'
    ],
    'auto_return' => 'approved'
];

$ch = curl_init('https://api.mercadopago.com/checkout/preferences');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $mp_token,
    'Content-Type: application/json'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$result = json_decode($response, true);

if ($httpCode >= 200 && $httpCode < 300 && !empty($result['init_point'])) {
    redirecionar($result['init_point']);
}

echo '<pre>';
print_r($result);
echo '</pre>';