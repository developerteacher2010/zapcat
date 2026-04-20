function desenharGraficoProdutos(canvasId, totalProdutos) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    const largura = canvas.width;
    const altura = canvas.height;

    ctx.clearRect(0, 0, largura, altura);

    // fundo
    ctx.fillStyle = '#111827';
    ctx.fillRect(0, 0, largura, altura);

    // eixo base
    ctx.strokeStyle = '#334155';
    ctx.lineWidth = 2;
    ctx.beginPath();
    ctx.moveTo(50, altura - 40);
    ctx.lineTo(largura - 40, altura - 40);
    ctx.stroke();

    // barra
    const barraAltura = Math.min(totalProdutos * 15, altura - 80);
    ctx.fillStyle = '#22c55e';
    ctx.fillRect(100, altura - 40 - barraAltura, 100, barraAltura);

    // textos
    ctx.fillStyle = '#e2e8f0';
    ctx.font = '16px Arial';
    ctx.fillText('Produtos cadastrados', 80, 30);
    ctx.fillText(String(totalProdutos), 130, altura - 10);
}