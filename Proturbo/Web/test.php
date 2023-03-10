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
    </style>
</head>

<body>
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
    </div>
</body>

</html>