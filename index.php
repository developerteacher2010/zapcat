<?php
include 'config.php';

if (isset($_SESSION['empresa_id'])) {
    header("Location: cliente/dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZapPro | Catálogo online para vender mais no WhatsApp</title>
    <meta name="description" content="Crie um catálogo online profissional para sua loja e receba pedidos direto no WhatsApp. Ideal para lojas de roupas, acessórios e pequenos negócios.">

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root{
            --bg: #f8f5f0;
            --bg-soft: #efe8dd;
            --card: #ffffff;
            --text: #2b2b2b;
            --text-soft: #6b6b6b;
            --primary: #b08d57;
            --primary-dark: #8c6d3f;
            --accent: #d9c2a7;
            --border: #e7ded2;
            --dark: #1f1f1f;
            --success: #25d366;
            --shadow: 0 14px 40px rgba(0,0,0,0.06);
        }

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }
.btn-primary{
    background: var(--dark);
    color: #fff !important;
}

.btn-primary:hover{
    color: #fff !important;
}
        html{
            scroll-behavior:smooth;
        }

        body{
            font-family:'Inter', sans-serif;
            background:var(--bg);
            color:var(--text);
        }

        a{
            text-decoration:none;
        }

        .container{
            width:min(1180px, calc(100% - 32px));
            margin:0 auto;
        }

        .topbar{
            position:sticky;
            top:0;
            z-index:100;
            background:rgba(255,250,244,0.92);
            backdrop-filter:blur(10px);
            border-bottom:1px solid var(--border);
        }

        .topbar-inner{
            min-height:78px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:20px;
        }

        .logo{
            font-family:'Playfair Display', serif;
            font-size:32px;
            color:var(--primary-dark);
        }

        .nav{
            display:flex;
            align-items:center;
            gap:12px;
            flex-wrap:wrap;
        }

        .nav a{
            color:var(--text);
            font-weight:500;
            padding:10px 14px;
            border-radius:10px;
        }

        .nav a:hover{
            background:var(--bg-soft);
        }

        .btn{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:8px;
            padding:14px 20px;
            border-radius:14px;
            border:none;
            cursor:pointer;
            font-weight:700;
            transition:.2s ease;
        }

        .btn-primary{
            background:var(--dark);
            color:#fff;
        }

        .btn-primary:hover{
            transform:translateY(-2px);
            background:#000;
        }

        .btn-secondary{
            background:#fff;
            color:var(--primary-dark);
            border:1px solid var(--border);
        }

        .btn-secondary:hover{
            background:var(--bg-soft);
        }

        .hero{
            padding:70px 0 40px;
        }

        .hero-grid{
            display:grid;
            grid-template-columns:1.1fr 0.9fr;
            gap:28px;
            align-items:center;
        }

        .badge{
            display:inline-block;
            padding:8px 12px;
            border-radius:999px;
            border:1px solid var(--border);
            background:#f3eadf;
            color:var(--primary-dark);
            font-size:13px;
            font-weight:700;
            margin-bottom:18px;
        }

        .hero h1{
            font-family:'Playfair Display', serif;
            font-size:62px;
            line-height:1.05;
            margin-bottom:18px;
        }

        .hero p{
            font-size:18px;
            color:var(--text-soft);
            line-height:1.75;
            max-width:640px;
        }

        .hero-actions{
            display:flex;
            gap:14px;
            flex-wrap:wrap;
            margin-top:26px;
        }

        .hero-card{
            background:linear-gradient(145deg, #fffaf4, #f2eadf);
            border:1px solid var(--border);
            border-radius:28px;
            box-shadow:var(--shadow);
            padding:28px;
        }

        .hero-card h3{
            font-family:'Playfair Display', serif;
            font-size:30px;
            margin-bottom:16px;
        }

        .hero-card ul{
            list-style:none;
            display:grid;
            gap:14px;
        }

        .hero-card li{
            background:#ffffffaa;
            border:1px solid #eadfce;
            border-radius:16px;
            padding:14px;
            color:var(--text-soft);
        }

        .numbers{
            padding:24px 0 12px;
        }

        .numbers-grid{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:20px;
        }

        .number-card{
            background:var(--card);
            border:1px solid var(--border);
            border-radius:22px;
            box-shadow:var(--shadow);
            padding:24px;
            text-align:center;
        }

        .number-card strong{
            display:block;
            font-size:34px;
            color:var(--primary-dark);
            margin-bottom:6px;
        }

        .number-card span{
            color:var(--text-soft);
        }

        .section{
            padding:64px 0;
        }

        .section-header{
            text-align:center;
            margin-bottom:30px;
        }

        .section-header h2{
            font-family:'Playfair Display', serif;
            font-size:44px;
            margin-bottom:12px;
        }

        .section-header p{
            color:var(--text-soft);
            font-size:17px;
            max-width:760px;
            margin:0 auto;
            line-height:1.7;
        }

        .features{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:22px;
        }

        .feature-card{
            background:var(--card);
            border:1px solid var(--border);
            border-radius:24px;
            box-shadow:var(--shadow);
            padding:26px;
        }

        .feature-icon{
            width:52px;
            height:52px;
            border-radius:14px;
            background:#f1e7d9;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:24px;
            margin-bottom:18px;
        }

        .feature-card h3{
            font-family:'Playfair Display', serif;
            font-size:26px;
            margin-bottom:10px;
        }

        .feature-card p{
            color:var(--text-soft);
            line-height:1.7;
        }

        .audience{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:24px;
            align-items:stretch;
        }

        .audience-box{
            background:var(--card);
            border:1px solid var(--border);
            border-radius:26px;
            box-shadow:var(--shadow);
            padding:28px;
        }

        .audience-box h3{
            font-family:'Playfair Display', serif;
            font-size:30px;
            margin-bottom:14px;
        }

        .audience-box ul{
            list-style:none;
            display:grid;
            gap:12px;
        }

        .audience-box li{
            color:var(--text-soft);
            padding-left:2px;
        }

        .pricing{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:24px;
        }

        .pricing-card{
            background:var(--card);
            border:1px solid var(--border);
            border-radius:26px;
            box-shadow:var(--shadow);
            padding:28px;
            text-align:center;
            position:relative;
        }

        .pricing-card.featured{
            border:2px solid var(--primary);
            transform:translateY(-6px);
        }

        .tag{
            position:absolute;
            top:16px;
            right:16px;
            background:#f3eadf;
            color:var(--primary-dark);
            font-size:12px;
            font-weight:700;
            padding:8px 10px;
            border-radius:999px;
            border:1px solid var(--border);
        }

        .pricing-card h3{
            font-family:'Playfair Display', serif;
            font-size:28px;
            margin-bottom:10px;
        }

        .price{
            font-size:46px;
            font-weight:800;
            color:var(--primary-dark);
            margin-bottom:8px;
        }

        .price small{
            font-size:16px;
            color:var(--text-soft);
            font-weight:500;
        }

        .pricing-card p{
            color:var(--text-soft);
            margin-bottom:18px;
        }

        .pricing-card ul{
            list-style:none;
            display:grid;
            gap:12px;
            text-align:left;
            margin-bottom:24px;
            color:var(--text-soft);
        }

        .showcase{
            background:linear-gradient(145deg, #fffaf4, #efe6da);
            border:1px solid var(--border);
            border-radius:30px;
            box-shadow:var(--shadow);
            padding:34px;
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:24px;
            align-items:center;
        }

        .showcase h2{
            font-family:'Playfair Display', serif;
            font-size:46px;
            margin-bottom:16px;
        }

        .showcase p{
            color:var(--text-soft);
            line-height:1.8;
            font-size:17px;
            margin-bottom:22px;
        }

        .mockup{
            background:#ffffff;
            border:1px solid var(--border);
            border-radius:24px;
            padding:20px;
            box-shadow:var(--shadow);
        }

        .mockup-header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:16px;
        }

        .mockup-title{
            font-family:'Playfair Display', serif;
            color:var(--primary-dark);
            font-size:24px;
        }

        .mockup-grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:14px;
        }

        .mock-card{
            background:#faf7f2;
            border:1px solid var(--border);
            border-radius:18px;
            overflow:hidden;
        }

        .mock-photo{
            height:140px;
            background:linear-gradient(135deg, #eadfce, #f5ece2);
        }

        .mock-body{
            padding:12px;
        }

        .mock-body strong{
            display:block;
            color:var(--text);
            margin-bottom:6px;
        }

        .mock-body span{
            color:var(--primary-dark);
            font-weight:700;
        }

        .cta{
            text-align:center;
            padding:80px 0;
        }

        .cta-box{
            background:#1f1f1f;
            color:#fff;
            border-radius:30px;
            padding:46px 28px;
            box-shadow:0 20px 40px rgba(0,0,0,0.14);
        }

        .cta-box h2{
            font-family:'Playfair Display', serif;
            font-size:46px;
            margin-bottom:14px;
        }

        .cta-box p{
            color:#d8d8d8;
            max-width:700px;
            margin:0 auto 24px;
            line-height:1.8;
            font-size:17px;
        }

        .cta-actions{
            display:flex;
            justify-content:center;
            gap:14px;
            flex-wrap:wrap;
        }
.mock-photo {
    height: 140px;
    overflow: hidden;
    border-bottom: 1px solid #e7ded2;
}

.mock-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
        .footer{
            text-align:center;
            padding:26px 20px 42px;
            color:var(--text-soft);
            font-size:14px;
        }

        .whatsapp-float{
            position:fixed;
            right:20px;
            bottom:20px;
            width:62px;
            height:62px;
            border-radius:50%;
            background:var(--success);
            color:#fff;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:28px;
            box-shadow:0 10px 30px rgba(37,211,102,0.3);
            z-index:120;
        }

        @media (max-width: 980px){
            .hero-grid,
            .audience,
            .showcase,
            .features,
            .pricing,
            .numbers-grid{
                grid-template-columns:1fr;
            }

            .hero h1{
                font-size:44px;
            }

            .section-header h2,
            .showcase h2,
            .cta-box h2{
                font-size:34px;
            }
        }

        @media (max-width: 640px){
            .topbar-inner{
                padding:8px 0;
            }

            .nav{
                width:100%;
                justify-content:flex-start;
            }

            .logo{
                font-size:26px;
            }

            .hero{
                padding-top:40px;
            }

            .hero h1{
                font-size:36px;
            }

            .section{
                padding:46px 0;
            }
        }
    </style>
</head>
<body>

    <header class="topbar">
        <div class="container topbar-inner">
            <div class="logo">ZapPro</div>

            <nav class="nav">
                <a href="#beneficios">Benefícios</a>
                <a href="#planos">Planos</a>
                <a href="login.php">Entrar</a>
                <a href="register.php" class="btn btn-primary">Criar conta</a>
            </nav>
        </div>
    </header>

    <section class="hero">
        <div class="container hero-grid">
            <div>
                <span class="badge">Catálogo online para vender mais no WhatsApp</span>
                <h1>Transforme sua loja em uma vitrine digital bonita e profissional</h1>
                <p>
                    Crie um catálogo online elegante, compartilhe o link com seus clientes e receba pedidos direto no WhatsApp.
                    Ideal para lojas de roupas, acessórios, calçados, moda feminina, masculina e pequenos negócios.
                </p>

                <div class="hero-actions">
                    <a href="register.php" class="btn btn-primary">Começar agora</a>
                    <a href="#planos" class="btn btn-secondary">Ver planos</a>
                </div>
            </div>

            <div class="hero-card">
                <h3>Por que seus clientes vão gostar?</h3>
                <ul>
                    <li>Seu catálogo fica bonito e organizado</li>
                    <li>O cliente escolhe a peça sem você mandar foto por foto</li>
                    <li>O pedido vai direto para o seu WhatsApp</li>
                    <li>Você passa muito mais profissionalismo</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="numbers">
        <div class="container numbers-grid">
            <div class="number-card">
                <strong>100%</strong>
                <span>Responsivo no celular</span>
            </div>
            <div class="number-card">
                <strong>+ rápido</strong>
                <span>Atendimento com link pronto</span>
            </div>
            <div class="number-card">
                <strong>+ valor</strong>
                <span>Visual profissional para sua marca</span>
            </div>
        </div>
    </section>

    <section class="section" id="beneficios">
        <div class="container">
            <div class="section-header">
                <h2>Feito para quem quer vender mais</h2>
                <p>
                    A ZapPro ajuda sua loja a sair do improviso e ter uma apresentação muito mais bonita,
                    organizada e profissional.
                </p>
            </div>

            <div class="features">
                <div class="feature-card">
                    <div class="feature-icon">🛍️</div>
                    <h3>Catálogo elegante</h3>
                    <p>Mostre seus produtos com imagem, preço e descrição em uma página bonita e fácil de navegar.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">📲</div>
                    <h3>Pedido no WhatsApp</h3>
                    <p>O cliente escolhe o produto e já fala com você com um clique, sem complicação.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">✨</div>
                    <h3>Mais profissionalismo</h3>
                    <p>Uma apresentação bonita aumenta a confiança e valoriza sua loja perante o cliente.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container audience">
            <div class="audience-box">
                <h3>Ideal para</h3>
                <ul>
                    <li>• Lojas de roupas femininas</li>
                    <li>• Lojas de roupas masculinas</li>
                    <li>• Moda infantil</li>
                    <li>• Boutique e multimarcas</li>
                    <li>• Acessórios, bolsas e calçados</li>
                </ul>
            </div>

            <div class="audience-box">
                <h3>Você ganha</h3>
                <ul>
                    <li>• Mais agilidade no atendimento</li>
                    <li>• Menos tempo mandando foto manualmente</li>
                    <li>• Um link bonito para divulgar</li>
                    <li>• Mais organização dos produtos</li>
                    <li>• Mais percepção de valor da sua marca</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container showcase">
            <div>
                <h2>Uma página bonita vende melhor</h2>
                <p>
                    Quando seu cliente entra em uma página bem apresentada, com fotos organizadas e botão direto para compra,
                    a experiência fica muito mais agradável e a chance de fechar pedido aumenta.
                </p>

                <a href="register.php" class="btn btn-primary">Quero minha página</a>
            </div>

            <div class="mockup">
                <div class="mockup-header">
                    <div class="mockup-title">Exemplo de catálogo</div>
                    <div style="color:#8c6d3f;font-weight:700;">Moda</div>
                </div>

                <div class="mockup-grid">
                    <div class="mock-card">
    <div class="mock-photo">
        <img src="https://images.unsplash.com/photo-1521334884684-d80222895322">
    </div>
    <div class="mock-body">
        <strong>Vestido Elegance</strong>
        <span>R$ 129,90</span>
    </div>
</div>

<div class="mock-card">
    <div class="mock-photo">
        <img src="https://images.unsplash.com/photo-1541099649105-f69ad21f3246">
    </div>
    <div class="mock-body">
        <strong>Conjunto Casual</strong>
        <span>R$ 159,90</span>
    </div>
</div>

<div class="mock-card">
    <div class="mock-photo">
        <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d">
    </div>
    <div class="mock-body">
        <strong>Blazer Premium</strong>
        <span>R$ 189,90</span>
    </div>
</div>

<div class="mock-card">
    <div class="mock-photo">
        <img src="https://images.unsplash.com/photo-1519741497674-611481863552">
    </div>
    <div class="mock-body">
        <strong>Bolsa Chic</strong>
        <span>R$ 99,90</span>
    </div>
</div>
        </div>
    </section>

    <section class="section" id="planos">
        <div class="container">
            <div class="section-header">
                <h2>Planos acessíveis para começar</h2>
                <p>
                    Escolha o plano ideal para o tamanho da sua loja e comece a divulgar seu catálogo hoje mesmo.
                </p>
            </div>

            <div class="pricing">
                <div class="pricing-card">
                    <h3>Starter</h3>
                    <div class="price">R$ 49,90 <small>/mês</small></div>
                    <p>Ideal para quem está começando</p>
                    <ul>
                        <li>• Até 10 produtos</li>
                        <li>• Link do catálogo</li>
                        <li>• Pedido via WhatsApp</li>
                        <li>• Visual profissional</li>
                    </ul>
                    <a href="register.php" class="btn btn-secondary" style="width:100%;">Começar</a>
                </div>

                <div class="pricing-card featured">
                    <div class="tag">Mais vendido</div>
                    <h3>Pro</h3>
                    <div class="price">R$ 79,90 <small>/mês</small></div>
                    <p>Perfeito para lojas de moda</p>
                    <ul>
                        <li>• Produtos ilimitados</li>
                        <li>• Upload de imagens</li>
                        <li>• Catálogo premium</li>
                        <li>• Melhor apresentação da marca</li>
                    </ul>
                    <a href="register.php" class="btn btn-primary" style="width:100%;">Assinar plano Pro</a>
                </div>

                <div class="pricing-card">
                    <h3>Premium</h3>
                    <div class="price">R$ 119,90 <small>/mês</small></div>
                    <p>Para quem quer mais exclusividade</p>
                    <ul>
                        <li>• Tudo do Pro</li>
                        <li>• Prioridade no suporte</li>
                        <li>• Mais personalização</li>
                        <li>• Experiência ainda mais refinada</li>
                    </ul>
                    <a href="register.php" class="btn btn-secondary" style="width:100%;">Quero Premium</a>
                </div>
            </div>
        </div>
    </section>

    <section class="cta">
        <div class="container cta-box">
            <h2>Seu próximo cliente pode conhecer sua loja hoje</h2>
            <p>
                Tenha uma página bonita, compartilhe no Instagram, no status do WhatsApp e comece a apresentar seus produtos de forma muito mais profissional.
            </p>

            <div class="cta-actions">
                <a href="register.php" class="btn btn-primary">Criar conta agora</a>
                <a href="https://wa.me/5531989356164?text=Ol%C3%A1!%20Quero%20conhecer%20o%20cat%C3%A1logo%20online" target="_blank" class="btn btn-secondary">
                    Falar no WhatsApp
                </a>
            </div>
        </div>
    </section>

    <footer class="footer">
        © <?= date('Y') ?> ZapPro • Catálogo online profissional para lojas e negócios
    </footer>

    <a class="whatsapp-float" target="_blank" href="https://wa.me/5531989356164?text=Ol%C3%A1!%20Quero%20saber%20mais%20sobre%20o%20servi%C3%A7o">
        💬
    </a>

</body>
</html>