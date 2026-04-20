<?php
include 'config.php';
include 'helpers.php';

$mensagem = '';

if (isset($_SESSION['empresa_id'])) {
    header("Location: cliente/dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $empresa  = trim($_POST['empresa'] ?? '');
    $whatsapp = trim($_POST['whatsapp'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $senhaRaw = $_POST['senha'] ?? '';

    if ($empresa === '' || $whatsapp === '' || $email === '' || $senhaRaw === '') {
        $mensagem = "Preencha todos os campos.";
    } else {
        $senha = password_hash($senhaRaw, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO empresas (nome, whatsapp, status, tipo_acesso) VALUES (?, ?, 'inativo', 'pago')");
        $stmt->bind_param("ss", $empresa, $whatsapp);

        if ($stmt->execute()) {
            $empresa_id = $conn->insert_id;

            $stmtUser = $conn->prepare("INSERT INTO usuarios (empresa_id, email, senha) VALUES (?, ?, ?)");
            $stmtUser->bind_param("iss", $empresa_id, $email, $senha);

            if ($stmtUser->execute()) {
                $_SESSION['empresa_id'] = $empresa_id;
                header("Location: cliente/assinatura.php");
                exit;
            } else {
                $mensagem = "Erro ao criar usuário.";
            }
        } else {
            $mensagem = "Erro ao criar empresa.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Criar conta</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="auth-page">

<div class="auth-box">
    <h1>Criar conta</h1>
    <p>Cadastre sua loja e solicite a ativação pelo WhatsApp.</p>

    <?php if ($mensagem): ?>
        <div class="alert error"><?= e($mensagem) ?></div>
    <?php endif; ?>

    <form method="POST" class="form-box">
        <input type="text" name="empresa" placeholder="Nome da loja" required>
        <input type="text" name="whatsapp" placeholder="WhatsApp da loja" required>
        <input type="email" name="email" placeholder="Seu e-mail" required>
        <input type="password" name="senha" placeholder="Sua senha" required>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>

    <p class="small-link">
        Já tem conta? <a href="login.php">Entrar</a>
    </p>
</div>

</body>
</html>