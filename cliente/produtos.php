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

$msg = $_GET['msg'] ?? '';

$stmt = $conn->prepare("SELECT * FROM produtos WHERE empresa_id = ? ORDER BY id DESC");
$stmt->bind_param("i", $empresa['id']);
$stmt->execute();
$produtos = $stmt->get_result();

$acessoOk = acesso_liberado($empresa);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Produtos</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">ZapPro</div>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a class="active" href="produtos.php">Produtos</a>
        <a href="../catalogo.php?empresa=<?= (int)$empresa['id'] ?>" target="_blank">Ver catálogo</a>
        <a href="assinatura.php">Assinatura</a>
        <a href="logout.php">Sair</a>
    </nav>
</aside>

<main class="main">
    <div class="topbar">
        <div>
            <h1>Produtos</h1>
            <p>Loja: <?= e($empresa['nome']) ?></p>
        </div>
    </div>

    <?php if($msg === 'ok'): ?>
        <div class="alert success">Produto salvo com sucesso</div>
    <?php endif; ?>

    <?php if($msg === 'erro'): ?>
        <div class="alert error">Erro ao salvar produto</div>
    <?php endif; ?>

    <?php if($msg === 'excluido'): ?>
        <div class="alert success">Produto excluído com sucesso</div>
    <?php endif; ?>

    <?php if($msg === 'editado'): ?>
        <div class="alert success">Produto editado com sucesso</div>
    <?php endif; ?>

    <?php if(!$acessoOk): ?>
        <div class="alert error">
            Seu acesso está inativo no momento.
        </div>
    <?php endif; ?>

    <section class="form-panel">
        <h3>Novo produto</h3>

        <form method="POST" action="salvar_produto.php" enctype="multipart/form-data">
            <input type="text" name="nome" placeholder="Nome do produto" required>
            <input type="number" step="0.01" name="preco" placeholder="Preço" required>
            <textarea name="descricao" placeholder="Descrição"></textarea>
            <input type="file" name="imagem">

            <button type="submit" class="btn btn-primary" <?= !$acessoOk ? 'disabled' : '' ?>>
                Salvar produto
            </button>
        </form>
    </section>

    <section class="table-box" style="margin-top:24px;">
        <h3>Lista de produtos</h3>

        <table>
            <tr>
                <th>Imagem</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Ações</th>
            </tr>

            <?php if($produtos && $produtos->num_rows > 0): ?>
                <?php while($p = $produtos->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <?php if(!empty($p['imagem']) && file_exists('../uploads/' . $p['imagem'])): ?>
                                <img src="../uploads/<?= e($p['imagem']) ?>" alt="<?= e($p['nome']) ?>" style="width:70px;height:70px;object-fit:cover;border-radius:12px;">
                            <?php else: ?>
                                <div style="width:70px;height:70px;background:#f1ece4;border-radius:12px;display:flex;align-items:center;justify-content:center;color:#6b6b6b;">
                                    —
                                </div>
                            <?php endif; ?>
                        </td>
                        <td><?= e($p['nome']) ?></td>
                        <td>R$ <?= number_format((float)$p['preco'], 2, ',', '.') ?></td>
                        <td>
                            <div class="inline-actions">
                                <a class="btn btn-secondary" href="editar_produto.php?id=<?= (int)$p['id'] ?>">Editar</a>
                                <a class="btn btn-danger" href="excluir_produto.php?id=<?= (int)$p['id'] ?>" onclick="return confirm('Deseja excluir este produto?')">Excluir</a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Nenhum produto cadastrado</td>
                </tr>
            <?php endif; ?>
        </table>
    </section>
</main>

</body>
</html>