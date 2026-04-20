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

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ? AND empresa_id = ? LIMIT 1");
$stmt->bind_param("ii", $id, $empresa['id']);
$stmt->execute();
$res = $stmt->get_result();
$produto = $res->fetch_assoc();

if (!$produto) {
    redirecionar('produtos.php?msg=erro');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
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
            <h1>Editar produto</h1>
            <p>Atualize as informações da peça cadastrada.</p>
        </div>
    </div>

    <section class="form-panel">
        <form method="POST" action="atualizar_produto.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= (int)$produto['id'] ?>">

            <input type="text" name="nome" value="<?= e($produto['nome']) ?>" required>
            <input type="number" step="0.01" name="preco" value="<?= e($produto['preco']) ?>" required>
            <textarea name="descricao"><?= e($produto['descricao']) ?></textarea>

            <div style="margin-top:10px;">
                <p style="margin-bottom:10px; color:#6b6b6b;">Imagem atual:</p>

                <?php if(!empty($produto['imagem']) && file_exists('../uploads/' . $produto['imagem'])): ?>
                    <img src="../uploads/<?= e($produto['imagem']) ?>" alt="<?= e($produto['nome']) ?>" style="width:140px;height:140px;object-fit:cover;border-radius:18px;border:1px solid #e7ded2;">
                <?php else: ?>
                    <div style="width:140px;height:140px;background:#f1ece4;border-radius:18px;border:1px solid #e7ded2;display:flex;align-items:center;justify-content:center;color:#6b6b6b;">
                        Sem imagem
                    </div>
                <?php endif; ?>
            </div>

            <input type="file" name="imagem">

            <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:10px;">
                <button type="submit" class="btn btn-primary">Atualizar produto</button>
                <a href="produtos.php" class="btn btn-secondary">Voltar</a>
            </div>
        </form>
    </section>
</main>

</body>
</html>