<!-- Adicione a biblioteca html2canvas ao seu projeto -->
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

<!-- Crie um elemento HTML com a classe ou id correspondente à div que você deseja baixar como imagem -->
<div id="divParaDownload">
  <!-- Conteúdo da div -->
  <h1>OIIIIIIIIIIIIIIII</h1>
</div>

<!-- Adicione um botão para acionar o download da imagem -->
<button id="btnDownload">Download da imagem</button>

<script>
// Crie uma função que capture a imagem da div e gere um link de download
function downloadDiv() {
  // Capture a imagem da div usando o html2canvas
  html2canvas(document.querySelector("#divParaDownload")).then(function(canvas) {
    // Crie um objeto URL para a imagem gerada
    var url = canvas.toDataURL("image/jpeg");

    // Crie um elemento link e atribua o objeto URL como seu href
    var link = document.createElement("a");
    link.download = "imagem.jpg";
    link.href = url;

    // Adicione o link ao documento e clique nele para iniciar o download
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  });
}

// Adicione um evento de clique ao botão para acionar o download da imagem
document.querySelector("#btnDownload").addEventListener("click", downloadDiv);
</script>
