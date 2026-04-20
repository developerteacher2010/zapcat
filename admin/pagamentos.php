<?php
include '../config.php';
include '../helpers.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$sql = "
    SELECT p.*, e.nome AS empresa_nome
    FROM pagamentos p
    LEFT JOIN empresas e ON e.id = p.empresa_id
    ORDER BY p.id DESC
";
$res = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Pagamentos</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">ZapPro Admin</div>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="clientes.php">Clientes</a>
        <a class="active" href="pagamentos.php">Pagamentos</a>
        <a href="logout.php">Sair</a>
    </nav>
</aside>

<main class="main">
    <div class="topbar">
        <div>
            <h1>Pagamentos</h1>
            <p>Controle dos pagamentos recebidos pela plataforma.</p>
        </div>
    </div>

    <section class="table-box">
        <table>
            <tr>
                <th>ID</th>
                <th>Empresa</th>
                <th>MP ID</th>
                <th>Status</th>
                <th>Valor</th>
                <th>Data</th>
            </tr>

            <?php if ($res && $res->num_rows > 0): ?>
                <?php while($p = $res->fetch_assoc()): ?>
                    <tr>
                        <td><?= (int)$p['id'] ?></td>
                        <td><?= e($p['empresa_nome'] ?? '—') ?></td>
                        <td><?= e($p['mp_id'] ?? '—') ?></td>
                        <td><?= e($p['status'] ?? '—') ?></td>
                        <td>
                            <?= isset($p['valor']) && $p['valor'] !== null ? 'R$ ' . number_format((float)$p['valor'], 2, ',', '.') : '—' ?>
                        </td>
                        <td>
                            <?= !empty($p['created_at']) ? date('d/m/Y H:i', strtotime($p['created_at'])) : '—' ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Nenhum pagamento encontrado.</td>
                </tr>
            <?php endif; ?>
        </table>
    </section>
</main>

</body>
</html>