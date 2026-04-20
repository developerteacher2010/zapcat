<?php
include '../config.php';
include '../helpers.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$totalClientes = 0;
$totalPagamentos = 0;
$totalAtivos = 0;
$totalInativos = 0;
$totalProdutos = 0;
$totalPago = 0;
$totalGratis = 0;
$totalVip = 0;

$res = $conn->query("SELECT COUNT(*) AS total FROM empresas");
if ($res) {
    $totalClientes = (int)$res->fetch_assoc()['total'];
}

$res = $conn->query("SELECT COUNT(*) AS total FROM pagamentos");
if ($res) {
    $totalPagamentos = (int)$res->fetch_assoc()['total'];
}

$res = $conn->query("SELECT COUNT(*) AS total FROM empresas WHERE status = 'ativo'");
if ($res) {
    $totalAtivos = (int)$res->fetch_assoc()['total'];
}

$res = $conn->query("SELECT COUNT(*) AS total FROM empresas WHERE status = 'inativo'");
if ($res) {
    $totalInativos = (int)$res->fetch_assoc()['total'];
}

$res = $conn->query("SELECT COUNT(*) AS total FROM produtos");
if ($res) {
    $totalProdutos = (int)$res->fetch_assoc()['total'];
}

$res = $conn->query("SELECT COUNT(*) AS total FROM empresas WHERE tipo_acesso = 'pago'");
if ($res) {
    $totalPago = (int)$res->fetch_assoc()['total'];
}

$res = $conn->query("SELECT COUNT(*) AS total FROM empresas WHERE tipo_acesso = 'gratis'");
if ($res) {
    $totalGratis = (int)$res->fetch_assoc()['total'];
}

$res = $conn->query("SELECT COUNT(*) AS total FROM empresas WHERE tipo_acesso = 'vip'");
if ($res) {
    $totalVip = (int)$res->fetch_assoc()['total'];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">ZapPro Admin</div>
    <nav>
        <a class="active" href="dashboard.php">Dashboard</a>
        <a href="clientes.php">Clientes</a>
        <a href="pagamentos.php">Pagamentos</a>
        <a href="logout.php">Sair</a>
    </nav>
</aside>

<main class="main">
    <div class="topbar">
        <div>
            <h1>Painel administrativo</h1>
            <p>Visão geral da plataforma e dos tipos de acesso.</p>
        </div>
    </div>

    <section class="metric-grid">
        <div class="panel-card">
            <div class="metric-label">Total de clientes</div>
            <div class="metric-value"><?= $totalClientes ?></div>
        </div>

        <div class="panel-card">
            <div class="metric-label">Clientes pagos</div>
            <div class="metric-value"><?= $totalPago ?></div>
        </div>

        <div class="panel-card">
            <div class="metric-label">Clientes grátis</div>
            <div class="metric-value"><?= $totalGratis ?></div>
        </div>

        <div class="panel-card">
            <div class="metric-label">Clientes VIP</div>
            <div class="metric-value"><?= $totalVip ?></div>
        </div>

        <div class="panel-card">
            <div class="metric-label">Clientes ativos</div>
            <div class="metric-value green"><?= $totalAtivos ?></div>
        </div>

        <div class="panel-card">
            <div class="metric-label">Clientes inativos</div>
            <div class="metric-value"><?= $totalInativos ?></div>
        </div>

        <div class="panel-card">
            <div class="metric-label">Pagamentos recebidos</div>
            <div class="metric-value"><?= $totalPagamentos ?></div>
        </div>

        <div class="panel-card">
            <div class="metric-label">Produtos no sistema</div>
            <div class="metric-value"><?= $totalProdutos ?></div>
        </div>
    </section>

    <section class="table-box">
        <h3 style="margin-bottom:10px;">Resumo estratégico</h3>
        <p style="color:#6b6b6b; line-height:1.8;">
            Aqui você acompanha quantos clientes estão pagando, quantos estão com acesso gratuito,
            quantos foram liberados como VIP e quantos ainda estão inativos. Isso ajuda você a ter
            uma visão mais clara de crescimento, conversão e oportunidades comerciais.
        </p>
    </section>
</main>

</body>
</html>