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
        <div>
            <h1>Clientes</h1>
            <p>Gerencie o acesso dos clientes da plataforma.</p>
        </div>
    </div>

    <?php if ($msg === 'ok'): ?>
        <div class="alert success">Cliente atualizado com sucesso.</div>
    <?php endif; ?>

    <?php if ($msg === 'erro'): ?>
        <div class="alert error">Erro ao atualizar cliente.</div>
    <?php endif; ?>

    <section class="table-box">
        <table>
            <tr>
                <th>ID</th>
                <th>Empresa</th>
                <th>WhatsApp</th>
                <th>Tipo de acesso</th>
                <th>Status</th>
                <th>Validade</th>
                <th>Ação</th>
            </tr>

            <?php if ($res && $res->num_rows > 0): ?>
                <?php while($c = $res->fetch_assoc()): ?>
                    <tr>
                        <td><?= (int)$c['id'] ?></td>
                        <td><?= e($c['nome']) ?></td>
                        <td><?= e($c['whatsapp']) ?></td>
                        <td><?= !empty($c['tipo_acesso']) ? e($c['tipo_acesso']) : 'pago' ?></td>
                        <td><?= e($c['status']) ?></td>
                        <td>
                            <?= !empty($c['data_expiracao']) ? date('d/m/Y', strtotime($c['data_expiracao'])) : 'Sem prazo' ?>
                        </td>
                        <td>
                            <form method="POST" action="salvar_cliente.php" style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
                                <input type="hidden" name="id" value="<?= (int)$c['id'] ?>">

                                <select name="tipo_acesso" style="min-width:110px;">
                                    <option value="pago" <?= (isset($c['tipo_acesso']) && $c['tipo_acesso'] === 'pago') ? 'selected' : '' ?>>Pago</option>
                                    <option value="gratis" <?= (isset($c['tipo_acesso']) && $c['tipo_acesso'] === 'gratis') ? 'selected' : '' ?>>Grátis</option>
                                    <option value="vip" <?= (isset($c['tipo_acesso']) && $c['tipo_acesso'] === 'vip') ? 'selected' : '' ?>>VIP</option>
                                </select>

                                <input type="date" name="data_expiracao" value="<?= !empty($c['data_expiracao']) ? e($c['data_expiracao']) : '' ?>" style="min-width:150px;">

                                <select name="status" style="min-width:110px;">
                                    <option value="ativo" <?= ($c['status'] === 'ativo') ? 'selected' : '' ?>>Ativo</option>
                                    <option value="inativo" <?= ($c['status'] === 'inativo') ? 'selected' : '' ?>>Inativo</option>
                                </select>

                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Nenhum cliente cadastrado.</td>
                </tr>
            <?php endif; ?>
        </table>
    </section>
</main>

</body>
</html>