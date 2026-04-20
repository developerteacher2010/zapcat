function configurarPreview(inputId, previewId) {
  const input = document.getElementById(inputId);
  const preview = document.getElementById(previewId);

  if (!input || !preview) return;

  input.addEventListener('change', function () {
    const file = this.files && this.files[0];
    if (!file) {
      preview.innerHTML = 'Sem imagem selecionada';
      return;
    }

    const reader = new FileReader();
    reader.onload = function (e) {
      preview.innerHTML = `<img src="${e.target.result}" style="width:120px;height:120px;object-fit:cover;border-radius:12px;">`;
    };
    reader.readAsDataURL(file);
  });
}