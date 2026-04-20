<?php
include '../config.php';
include '../helpers.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$msg = $_GET['msg'] ?? '';
$res = $conn->query("SELECT * FROM empresas ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Clientes</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">ZapPro Admin</div>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a class="active" href="clientes.php">Clientes</a>
        <a href="pagamentos.php">Pagamentos</a>
        <a href="logout.php">Sair</a>
    </nav>
</aside>

<main class="main">
    <div class="topbar">
        <h1>Clientes</h1>
    </div>

    <?php if ($msg === 'ok'): ?>
        <div class="alert success">Atualizado com sucesso</div>
    <?php endif; ?>

    <section class="table-box">
        <table>
            <tr>
                <th>ID</th>
                <th>Empresa</th>
                <th>WhatsApp</th>
                <th>Plano</th>
                <th>Status</th>
                <th>Validade</th>
                <th>Ação</th>
            </tr>

            <?php while($c = $res->fetch_assoc()): ?>
                <tr>
                    <td><?= $c['id'] ?></td>
                    <td><?= e($c['nome']) ?></td>
                    <td><?= e($c['whatsapp']) ?></td>
                    <td><?= $c['tipo_acesso'] ?? 'pago' ?></td>
                    <td><?= $c['status'] ?></td>
                    <td><?= $c['data_expiracao'] ?? '-' ?></td>

                    <td>
                        <form method="POST" action="salvar_cliente.php" style="display:flex;gap:6px;flex-wrap:wrap;">
                            
                            <input type="hidden" name="id" value="<?= $c['id'] ?>">

                            <select name="tipo_acesso">
                                <option value="pago" <?= ($c['tipo_acesso'] == 'pago') ? 'selected' : '' ?>>Pago</option>
                                <option value="gratis" <?= ($c['tipo_acesso'] == 'gratis') ? 'selected' : '' ?>>Grátis</option>
                                <option value="vip" <?= ($c['tipo_acesso'] == 'vip') ? 'selected' : '' ?>>VIP</option>
                            </select>

                            <select name="status">
                                <option value="ativo" <?= ($c['status'] == 'ativo') ? 'selected' : '' ?>>Ativo</option>
                                <option value="inativo" <?= ($c['status'] == 'inativo') ? 'selected' : '' ?>>Inativo</option>
                            </select>

                            <input type="date" name="data_expiracao" value="<?= $c['data_expiracao'] ?>">

                            <button class="btn btn-primary">Salvar</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>

        </table>
    </section>
</main>

</body>
</html>