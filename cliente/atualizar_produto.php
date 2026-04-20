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

$id = (int)($_POST['id'] ?? 0);
$nome = trim($_POST['nome'] ?? '');
$preco = (float)($_POST['preco'] ?? 0);
$descricao = trim($_POST['descricao'] ?? '');

if ($id <= 0 || $nome === '' || $preco <= 0) {
    redirecionar('produtos.php?msg=erro');
}

$stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ? AND empresa_id = ? LIMIT 1");
$stmt->bind_param("ii", $id, $empresa['id']);
$stmt->execute();
$res = $stmt->get_result();
$produto = $res->fetch_assoc();

if (!$produto) {
    redirecionar('produtos.php?msg=erro');
}

$imagemNome = $produto['imagem'];

if (!empty($_FILES['imagem']['name']) && $_FILES['imagem']['error'] === 0) {
    $permitidas = ['jpg', 'jpeg', 'png', 'webp'];
    $ext = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));

    if (in_array($ext, $permitidas, true)) {
        if (!is_dir('../uploads')) {
            mkdir('../uploads', 0777, true);
        }

        $novaImagem = uniqid('prod_', true) . '.' . $ext;
        $destino = '../uploads/' . $novaImagem;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
            if (!empty($imagemNome) && file_exists('../uploads/' . $imagemNome)) {
                unlink('../uploads/' . $imagemNome);
            }
            $imagemNome = $novaImagem;
        }
    }
}

$stmt = $conn->prepare("UPDATE produtos SET nome = ?, preco = ?, descricao = ?, imagem = ? WHERE id = ? AND empresa_id = ?");
$stmt->bind_param("sdssii", $nome, $preco, $descricao, $imagemNome, $id, $empresa['id']);

if ($stmt->execute()) {
    redirecionar('produtos.php?msg=editado');
} else {
    redirecionar('produtos.php?msg=erro');
}