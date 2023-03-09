<?php
include("config/conexao.php");
sessionVerif();

$stmt = $pdo->query('SELECT operador_nome FROM operadores');
$operadores = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operador</title>
    <style>
#janela-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

#janela-modal-conteudo {
    background-color: #fff;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

    </style>
</head>

<body>
<button onclick="abrirModal()">Abrir janela modal</button>
<div id="janela-modal">
    <div id="janela-modal-conteudo">
                <!---------------->
                <div class="div-maquina">
                    <label class="maquina">Célula:</label>
                    <select class="hvr-float" id="maquina" name="maquina">
                        <option value="<?php /* Para deixar último código usado selecionado*/ if (isset($ultimachine)) {
                                            echo $ultimachine;
                                        } ?>"><?php /* Para deixar último código usado selecionado*/ if (isset($ultimachine)) {
                                    echo $ultimachine;
                                } ?></option>
                        <?php celulaOption(); ?>
                    </select>
                </div>
                <!---------------->
    <div>
        <p>Pessoas na Célula</p>
    </div>
    <div>
        <input type="number">
    </div>
    <div>
        <input type="text">
    </div>
    <div>
        <button></button>
    </div>
</div>
        <button onclick="fecharModal()">Cancelar</button>
        <button onclick="confirmarOperacao()">OK</button>
    </div>
</div>
</body>

</html>
<script>
    function abrirModal() {
    document.getElementById("janela-modal").style.display = "block";
}

function fecharModal() {
    document.getElementById("janela-modal").style.display = "none";
}
function confirmarOperacao() {
    // Executa a operação desejada, por exemplo:
    // Envia um formulário usando AJAX
    // Deleta um registro do banco de dados usando PHP e MySQL
    // etc.
    
    // Fecha a janela modal
    fecharModal();
}
</script>