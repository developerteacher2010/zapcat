<?php
include 'config.php';
include 'helpers.php';

$mensagem = '';

if (isset($_SESSION['empresa_id'])) {
    header("Location: cliente/dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res && $res->num_rows > 0) {
        $user = $res->fetch_assoc();

        if (password_verify($senha, $user['senha'])) {
            $_SESSION['empresa_id'] = $user['empresa_id'];
            header("Location: cliente/dashboard.php");
            exit;
        } else {
            $mensagem = "Senha inválida.";
        }
    } else {
        $mensagem = "Usuário não encontrado.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Entrar</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="auth-page">

<div class="auth-box">
    <h1>Entrar</h1>
    <p>Acesse seu painel e gerencie seu catálogo.</p>

    <?php if ($mensagem): ?>
        <div class="alert error"><?= e($mensagem) ?></div>
    <?php endif; ?>

    <form method="POST" class="form-box">
        <input type="email" name="email" placeholder="Seu e-mail" required>
        <input type="password" name="senha" placeholder="Sua senha" required>
        <button type="submit" class="btn btn-primary">Entrar</button>
    </form>

    <p class="small-link">
        Ainda não tem conta? <a href="register.php">Criar conta</a>
    </p>
</div>

</body>
</html>