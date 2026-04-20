<?php
include 'config.php';
include 'helpers.php';

$empresa_id = isset($_GET['empresa']) ? (int)$_GET['empresa'] : 0;

if ($empresa_id <= 0) {
    die("Empresa inválida.");
}

$stmt = $conn->prepare("SELECT * FROM empresas WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $empresa_id);
$stmt->execute();
$res = $stmt->get_result();
$empresa = $res->fetch_assoc();

if (!$empresa) {
    die("Empresa não encontrada.");
}

$stmt = $conn->prepare("SELECT * FROM produtos WHERE empresa_id = ? ORDER BY id DESC");
$stmt->bind_param("i", $empresa_id);
$stmt->execute();
$produtos = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($empresa['nome']) ?> | Catálogo</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
:root{
    --bg:#f8f5f0;
    --card:#ffffff;
    --text:#2b2b2b;
    --text-soft:#6b6b6b;
    --primary:#b08d57;
    --primary-dark:#8c6d3f;
    --border:#e7ded2;
    --dark:#1f1f1f;
    --shadow:0 12px 30px rgba(0,0,0,0.06);
}

*{margin:0;padding:0;box-sizing:border-box;}

body{
    font-family:'Inter',sans-serif;
    background:var(--bg);
    color:var(--text);
}

.header{
    text-align:center;
    padding:50px 20px 30px;
}

.header h1{
    font-family:'Playfair Display', serif;
    font-size:42px;
    margin-bottom:10px;
}

.header p{
    color:var(--text-soft);
}

.container{
    max-width:1200px;
    margin:auto;
    padding:20px;
}

.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
    gap:24px;
}

.card{
    background:var(--card);
    border-radius:22px;
    overflow:hidden;
    border:1px solid var(--border);
    box-shadow:var(--shadow);
    transition:transform .25s ease, box-shadow .25s ease;
    position:relative;
}

.card:hover{
    transform:translateY(-6px);
    box-shadow:0 18px 38px rgba(0,0,0,0.10);
}

.image{
    width:100%;
    height:250px;
    background:#f1ece4;
    overflow:hidden;
    position:relative;
    cursor:zoom-in;
}

.image img{
    width:100%;
    height:100%;
    object-fit:cover;
    transition:transform .35s ease;
}

.card:hover .image img{
    transform:scale(1.06);
}

.zoom-badge{
    position:absolute;
    right:12px;
    top:12px;
    background:rgba(31,31,31,.82);
    color:#fff;
    font-size:12px;
    padding:8px 10px;
    border-radius:999px;
    z-index:2;
}

.content{
    padding:18px;
}

.content h3{
    font-family:'Playfair Display', serif;
    font-size:22px;
    margin-bottom:8px;
}

.content p{
    font-size:14px;
    color:var(--text-soft);
    margin-bottom:12px;
    min-height:42px;
    line-height:1.5;
}

.price{
    font-size:20px;
    font-weight:700;
    color:var(--primary-dark);
    margin-bottom:14px;
    display:block;
}

.actions{
    display:grid;
    gap:10px;
}

.btn{
    display:flex;
    align-items:center;
    justify-content:center;
    width:100%;
    text-align:center;
    padding:12px 14px;
    border-radius:12px;
    font-weight:600;
    text-decoration:none;
    border:none;
    cursor:pointer;
    transition:.2s ease;
}

.btn-dark{
    background:var(--dark);
    color:#fff;
}

.btn-dark:hover{
    background:#000;
}

.btn-light{
    background:#fff;
    color:var(--primary-dark);
    border:1px solid var(--border);
}

.btn-light:hover{
    background:#f6efe6;
}

.empty{
    text-align:center;
    background:#fff;
    border:1px solid var(--border);
    border-radius:20px;
    padding:30px;
    color:var(--text-soft);
}

.whatsapp-float{
    position:fixed;
    right:20px;
    bottom:20px;
    width:60px;
    height:60px;
    border-radius:50%;
    background:#25d366;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:26px;
    text-decoration:none;
    box-shadow:0 10px 28px rgba(37,211,102,.28);
    z-index:100;
}

/* MODAL */
.modal{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.75);
    display:none;
    align-items:center;
    justify-content:center;
    padding:20px;
    z-index:999;
}

.modal.active{
    display:flex;
}

.modal-box{
    width:min(980px, 100%);
    background:#fff;
    border-radius:24px;
    overflow:hidden;
    display:grid;
    grid-template-columns:1.1fr .9fr;
    box-shadow:0 20px 50px rgba(0,0,0,.25);
}

.modal-image{
    background:#f5efe7;
    min-height:420px;
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
}

.modal-image img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.modal-info{
    padding:28px;
    position:relative;
}

.modal-close{
    position:absolute;
    right:16px;
    top:16px;
    width:40px;
    height:40px;
    border:none;
    border-radius:50%;
    background:#f4eee5;
    color:#333;
    cursor:pointer;
    font-size:20px;
}

.modal-info h2{
    font-family:'Playfair Display', serif;
    font-size:32px;
    margin-bottom:12px;
    padding-right:40px;
}

.modal-desc{
    color:var(--text-soft);
    line-height:1.7;
    margin-bottom:18px;
}

.modal-price{
    font-size:28px;
    font-weight:700;
    color:var(--primary-dark);
    margin-bottom:18px;
}

.modal-tag{
    display:inline-block;
    background:#f3eadf;
    color:var(--primary-dark);
    padding:8px 12px;
    border-radius:999px;
    font-size:13px;
    margin-bottom:16px;
}

@media(max-width:820px){
    .modal-box{
        grid-template-columns:1fr;
    }

    .modal-image{
        min-height:300px;
    }

    .header h1{
        font-size:32px;
    }
}
</style>
</head>
<body>

<div class="header">
    <h1><?= e($empresa['nome']) ?></h1>
    <p>Confira nossos produtos</p>
</div>

<div class="container">
    <div class="grid">
        <?php if($produtos && $produtos->num_rows > 0): ?>
            <?php while($p = $produtos->fetch_assoc()): 
                $img = (!empty($p['imagem']) && file_exists("uploads/" . $p['imagem']))
                    ? "uploads/" . e($p['imagem'])
                    : "";
                $nome = e($p['nome']);
                $descricao = e($p['descricao']);
                $preco = number_format((float)$p['preco'], 2, ',', '.');
                $whatsLink = "https://wa.me/55" . e($empresa['whatsapp']) . "?text=Ol%C3%A1!%20Tenho%20interesse%20no%20produto%20" . urlencode($p['nome']);
            ?>
                <div class="card">
                    <div class="image"
                         onclick="abrirModal('<?= $img ?>','<?= htmlspecialchars($nome, ENT_QUOTES) ?>','<?= htmlspecialchars($descricao, ENT_QUOTES) ?>','<?= $preco ?>','<?= $whatsLink ?>')">
                        <div class="zoom-badge">Zoom</div>
                        <?php if($img): ?>
                            <img src="<?= $img ?>" alt="<?= $nome ?>">
                        <?php else: ?>
                            <div style="display:flex;align-items:center;justify-content:center;height:100%;color:#999;">
                                Sem imagem
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="content">
                        <h3><?= $nome ?></h3>
                        <p><?= $descricao ?></p>
                        <span class="price">R$ <?= $preco ?></span>

                        <div class="actions">
                            <button class="btn btn-light"
                                onclick="abrirModal('<?= $img ?>','<?= htmlspecialchars($nome, ENT_QUOTES) ?>','<?= htmlspecialchars($descricao, ENT_QUOTES) ?>','<?= $preco ?>','<?= $whatsLink ?>')">
                                Ver detalhes
                            </button>

                            <a class="btn btn-dark" target="_blank" href="<?= $whatsLink ?>">
                                Comprar no WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="empty">Nenhum produto cadastrado.</div>
        <?php endif; ?>
    </div>
</div>

<!-- MODAL -->
<div class="modal" id="produtoModal">
    <div class="modal-box">
        <div class="modal-image">
            <img id="modalImg" src="" alt="">
        </div>
        <div class="modal-info">
            <button class="modal-close" onclick="fecharModal()">×</button>
            <div class="modal-tag">Detalhes do produto</div>
            <h2 id="modalTitulo"></h2>
            <p class="modal-desc" id="modalDescricao"></p>
            <div class="modal-price" id="modalPreco"></div>
            <a id="modalComprar" class="btn btn-dark" target="_blank" href="#">
                Comprar no WhatsApp
            </a>
        </div>
    </div>
</div>

<a class="whatsapp-float" target="_blank"
   href="https://wa.me/55<?= e($empresa['whatsapp']) ?>?text=Ol%C3%A1!%20Quero%20atendimento%20sobre%20os%20produtos">
    💬
</a>

<script>
function abrirModal(img, titulo, descricao, preco, link){
    const modal = document.getElementById('produtoModal');
    const modalImg = document.getElementById('modalImg');
    const modalTitulo = document.getElementById('modalTitulo');
    const modalDescricao = document.getElementById('modalDescricao');
    const modalPreco = document.getElementById('modalPreco');
    const modalComprar = document.getElementById('modalComprar');

    if(img){
        modalImg.src = img;
        modalImg.style.display = 'block';
    } else {
        modalImg.style.display = 'none';
    }

    modalTitulo.textContent = titulo;
    modalDescricao.textContent = descricao || 'Sem descrição.';
    modalPreco.textContent = 'R$ ' + preco;
    modalComprar.href = link;

    modal.classList.add('active');
}

function fecharModal(){
    document.getElementById('produtoModal').classList.remove('active');
}

document.getElementById('produtoModal').addEventListener('click', function(e){
    if(e.target === this){
        fecharModal();
    }
});

document.addEventListener('keydown', function(e){
    if(e.key === 'Escape'){
        fecharModal();
    }
});
</script>

</body>
</html>