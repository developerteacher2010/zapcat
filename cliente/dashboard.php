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

$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM produtos WHERE empresa_id = ?");
$stmt->bind_param("i", $empresa['id']);
$stmt->execute();
$res = $stmt->get_result();

$totalProdutos = 0;
if ($res && $res->num_rows > 0) {
    $totalProdutos = (int) $res->fetch_assoc()['total'];
}

$assinaturaOk = acesso_liberado($empresa);
$linkCatalogo = "http://localhost/zap_pro/catalogo.php?empresa=" . (int)$empresa['id'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">ZapPro</div>
    <nav>
        <a class="active" href="dashboard.php">Dashboard</a>
        <a href="produtos.php">Produtos</a>
        <a href="../catalogo.php?empresa=<?= (int)$empresa['id'] ?>" target="_blank">Ver catálogo</a>
        <a href="assinatura.php">Assinatura</a>
        <a href="logout.php">Sair</a>
    </nav>
</aside>

<main class="main">
    <div class="topbar">
        <div>
            <h1>Dashboard</h1>
            <p>Bem-vindo, <?= e($empresa['nome']) ?></p>
        </div>

        <button class="btn btn-secondary" onclick="copiarLink()">Copiar link do catálogo</button>
    </div>

    <?php if ($assinaturaOk): ?>
        <div class="alert success">
            Acesso liberado
            <?php if (!empty($empresa['tipo_acesso']) && $empresa['tipo_acesso'] !== 'pago'): ?>
                (<?= e($empresa['tipo_acesso']) ?>)
            <?php endif; ?>

            <?php if (!empty($empresa['data_expiracao'])): ?>
                até <?= date('d/m/Y', strtotime($empresa['data_expiracao'])) ?>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="alert error">
            Seu acesso está inativo.
            <br><br>
            <a href="assinatura.php" class="btn btn-primary">Assinar agora</a>
        </div>
    <?php endif; ?>

    <section class="metric-grid">
        <div class="panel-card">
            <div class="metric-label">Peças cadastradas</div>
            <div class="metric-value"><?= $totalProdutos ?></div>
        </div>

        <div class="panel-card">
            <div class="metric-label">Tipo de acesso</div>
            <div class="metric-value">
                <?= isset($empresa['tipo_acesso']) ? e(ucfirst($empresa['tipo_acesso'])) : 'Pago' ?>
            </div>
        </div>

        <div class="panel-card">
            <div class="metric-label">Sua vitrine online</div>
            <div class="link-box" id="linkCatalogo"><?= e($linkCatalogo) ?></div>
        </div>
    </section>
</main>

<script>
function copiarLink() {
    const texto = document.getElementById('linkCatalogo').innerText;
    navigator.clipboard.writeText(texto).then(function() {
        alert('Link copiado com sucesso!');
    });
}
</script>

</body>
</html>