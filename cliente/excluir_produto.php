<?php
include '../config.php';
include '../helpers.php';

exigir_login_cliente();

$empresa = empresa_logada($conn);

if (!$empresa) {
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_destroy();
    }
    redirecionar('../login.php');
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    redirecionar('produtos.php?msg=erro');
}

$stmt = $conn->prepare("SELECT imagem FROM produtos WHERE id = ? AND empresa_id = ? LIMIT 1");
$stmt->bind_param("ii", $id, $empresa['id']);
$stmt->execute();
$res = $stmt->get_result();
$produto = $res->fetch_assoc();

if (!$produto) {
    redirecionar('produtos.php?msg=erro');
}

if (!empty($produto['imagem']) && file_exists('../uploads/' . $produto['imagem'])) {
    unlink('../uploads/' . $produto['imagem']);
}

$stmt = $conn->prepare("DELETE FROM produtos WHERE id = ? AND empresa_id = ?");
$stmt->bind_param("ii", $id, $empresa['id']);

if ($stmt->execute()) {
    redirecionar('produtos.php?msg=excluido');
} else {
    redirecionar('produtos.php?msg=erro');
}