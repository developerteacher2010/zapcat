<?php
include '../config.php';
include '../helpers.php';

$msg = '';

if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();
    $admin = $res->fetch_assoc();

    if ($admin && password_verify($senha, $admin['senha'])) {
        $_SESSION['admin_id'] = $admin['id'];
        header("Location: dashboard.php");
        exit;
    } else {
        $msg = "Login inválido.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="auth-page">

<div class="auth-box">
    <h1>Área administrativa</h1>
    <p>Acesse o painel principal do sistema.</p>

    <?php if ($msg): ?>
        <div class="alert error"><?= e($msg) ?></div>
    <?php endif; ?>

    <form method="POST" class="form-box">
        <input type="email" name="email" placeholder="E-mail admin" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit" class="btn btn-primary">Entrar</button>
    </form>
</div>

</body>
</html>