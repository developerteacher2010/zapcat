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

$acessoOk = acesso_liberado($empresa);
$whats = "5531989356164";
$mensagem = "Olá! Acabei de me cadastrar no sistema e quero ativar meu acesso. Empresa: " . $empresa['nome'];
$linkWhats = "https://wa.me/" . $whats . "?text=" . urlencode($mensagem);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Ativação de acesso</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">ZapPro</div>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="produtos.php">Produtos</a>
        <a href="../catalogo.php?empresa=<?= (int)$empresa['id'] ?>" target="_blank">Ver catálogo</a>
        <a class="active" href="assinatura.php">Ativação</a>
        <a href="logout.php">Sair</a>
    </nav>
</aside>

<main class="main">
    <div class="topbar">
        <div>
            <h1>Ativação de acesso</h1>
            <p>Finalize o atendimento pelo WhatsApp para liberar seu painel.</p>
        </div>
    </div>

    <?php if ($acessoOk): ?>
        <div class="alert success">
            Seu acesso já está liberado.
        </div>
    <?php else: ?>
        <div class="alert error">
            Seu acesso ainda não foi ativado.
        </div>
    <?php endif; ?>

    <section class="metric-grid">
        <div class="panel-card">
            <div class="metric-label">Empresa</div>
            <div class="metric-value" style="font-size:24px;"><?= e($empresa['nome']) ?></div>
        </div>

        <div class="panel-card">
            <div class="metric-label">Tipo de acesso</div>
            <div class="metric-value" style="font-size:24px;">
                <?= isset($empresa['tipo_acesso']) ? e(ucfirst($empresa['tipo_acesso'])) : 'Pago' ?>
            </div>
        </div>

        <div class="panel-card">
            <div class="metric-label">Status</div>
            <div class="metric-value" style="font-size:24px;">
                <?= e(ucfirst($empresa['status'])) ?>
            </div>
        </div>
    </section>

    <section class="panel-card">
        <h3 style="margin-bottom:10px;">Próximo passo</h3>
        <p style="color:#6b6b6b; line-height:1.8; margin-bottom:18px;">
            Para ativar seu acesso, fale conosco no WhatsApp. Assim que o pagamento for confirmado,
            sua conta será liberada manualmente no sistema.
        </p>

        <a href="<?= $linkWhats ?>" target="_blank" class="btn btn-primary">
            Falar no WhatsApp para ativar
        </a>
    </section>
</main>

</body>
</html>