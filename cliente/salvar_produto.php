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

$nome = trim($_POST['nome'] ?? '');
$preco = (float)($_POST['preco'] ?? 0);
$descricao = trim($_POST['descricao'] ?? '');
$imagemNome = null;

if ($nome === '' || $preco <= 0) {
    redirecionar('produtos.php?msg=erro');
}

if (!empty($_FILES['imagem']['name']) && $_FILES['imagem']['error'] === 0) {
    $permitidas = ['jpg', 'jpeg', 'png', 'webp'];
    $ext = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));

    if (in_array($ext, $permitidas, true)) {
        if (!is_dir('../uploads')) {
            mkdir('../uploads', 0777, true);
        }

        $imagemNome = uniqid('prod_', true) . '.' . $ext;
        $destino = '../uploads/' . $imagemNome;

        if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
            redirecionar('produtos.php?msg=erro');
        }
    }
}

$stmt = $conn->prepare("INSERT INTO produtos (empresa_id, nome, preco, descricao, imagem) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("isdss", $empresa['id'], $nome, $preco, $descricao, $imagemNome);

if ($stmt->execute()) {
    redirecionar('produtos.php?msg=ok');
} else {
    redirecionar('produtos.php?msg=erro');
}