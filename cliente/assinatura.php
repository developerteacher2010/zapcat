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

$assinaturaOk = acesso_liberado($empresa);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Assinatura</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">ZapPro</div>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="produtos.php">Produtos</a>
        <a href="../catalogo.php?empresa=<?= (int)$empresa['id'] ?>" target="_blank">Ver catálogo</a>
        <a class="active" href="assinatura.php">Assinatura</a>
        <a href="logout.php">Sair</a>
    </nav>
</aside>

<main class="main">
    <div class="topbar">
        <div>
            <h1>Assinatura</h1>
            <p>Gerencie o acesso da sua loja à plataforma.</p>
        </div>
    </div>

    <?php if ($assinaturaOk): ?>
        <div class="alert success">
            Seu acesso está liberado.
        </div>
    <?php else: ?>
        <div class="alert error">
            Seu acesso está inativo no momento.
        </div>
    <?php endif; ?>

    <section class="metric-grid">
        <div class="panel-card">
            <div class="metric-label">Tipo de acesso</div>
            <div class="metric-value">
                <?= isset($empresa['tipo_acesso']) ? e(ucfirst($empresa['tipo_acesso'])) : 'Pago' ?>
            </div>
        </div>

        <div class="panel-card">
            <div class="metric-label">Status</div>
            <div class="metric-value <?= $assinaturaOk ? 'green' : '' ?>">
                <?= $assinaturaOk ? 'Liberado' : 'Inativo' ?>
            </div>
        </div>

        <div class="panel-card">
            <div class="metric-label">Validade</div>
            <div class="metric-value" style="font-size:22px;">
                <?= !empty($empresa['data_expiracao']) ? date('d/m/Y', strtotime($empresa['data_expiracao'])) : 'Sem prazo' ?>
            </div>
        </div>
    </section>

    <section class="panel-card">
        <h3 style="margin-bottom:10px;">Pagamento</h3>
        <p style="color:#6b6b6b; line-height:1.7; margin-bottom:18px;">
            Se o cliente for pago, ele pode renovar por aqui. Se for grátis ou VIP, você pode controlar manualmente pelo banco.
        </p>

        <div style="display:flex;gap:12px;flex-wrap:wrap;">
            <a href="../pagamento/criar_pagamento.php" class="btn btn-primary">Assinar agora</a>
            <a href="dashboard.php" class="btn btn-secondary">Voltar ao painel</a>
        </div>
    </section>
</main>

</body>
</html>