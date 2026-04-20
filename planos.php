<?php include 'config.php'; include 'helpers.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planos - ZapPro</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/app.js" defer></script>
</head>
<body>
<header class="nav">
    <div class="logo">ZapPro</div>
    <nav>
        <a href="index.php">Início</a>
        <a href="login.php">Entrar</a>
        <a href="register.php" class="btn">Criar conta</a>
    </nav>
</header>

<section class="section fade-in">
    <div class="container center">
        <span class="badge">Planos</span>
        <h1>Escolha o plano ideal</h1>
        <p class="lead">Comece simples ou suba para uma operação mais profissional.</p>
    </div>
</section>

<section class="section fade-in">
    <div class="container pricing-grid">
        <div class="pricing-card">
            <h3>Starter</h3>
            <div class="price">R$ 29<span>/mês</span></div>
            <ul>
                <li>Até 10 produtos</li>
                <li>Catálogo público</li>
                <li>Pedidos via WhatsApp</li>
            </ul>
            <a href="register.php" class="btn full">Começar</a>
        </div>

        <div class="pricing-card featured">
            <div class="badge-inline">Mais vendido</div>
            <h3>Pro</h3>
            <div class="price">R$ 49<span>/mês</span></div>
            <ul>
                <li>Produtos ilimitados</li>
                <li>Upload de imagens</li>
                <li>Painel profissional</li>
            </ul>
            <a href="register.php" class="btn full">Assinar</a>
        </div>

        <div class="pricing-card">
            <h3>Premium</h3>
            <div class="price">R$ 79<span>/mês</span></div>
            <ul>
                <li>Tudo do Pro</li>
                <li>Atendimento prioritário</li>
                <li>Personalização</li>
            </ul>
            <a href="register.php" class="btn full">Quero esse</a>
        </div>
    </div>
</section>
</body>
</html>