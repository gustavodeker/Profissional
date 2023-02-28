<?php
include("config/conexao.php");
sessionVerif();

if(isset($_POST['maquina']) && isset($_POST['titulo']) && isset($_POST['inicio'])){
    if(empty($_POST['maquina']) or empty($_POST['titulo']) or empty($_POST['inicio'])){
        $mensagemerro = "Preencher todos os campos!";
        echo $mensagemerro;
    } else{
        $maquina = limpaPost($_POST['maquina']);
        $titulo = limpaPost($_POST['titulo']);
        $inicio = limpaPost($_POST['inicio']);

        //Conferindo se máquina existe
        $sqlmaquina = $pdo->prepare("SELECT COUNT(*) from machines WHERE machine_name = '$maquina'");
        $sqlmaquina->execute();
        $count_maquina = $sqlmaquina->fetchColumn();
        if($count_maquina != 1){
            $mensagemerro = "Máquina inválida";
        }
        //Pegando username
        global $user;
        $user = auth($_SESSION['TOKEN']);
        $user_name = $user['user_name'];

        //Status
        $status = "Pendente";

        //Realizando insert
        try {
            $sqla = $pdo->prepare("INSERT INTO parada VALUES (null,?,?,?,default,default,default,?,?)");
            $sqla->execute(array($maquina, $titulo, $inicio, $status, $user_name));
            $mensagem = "Registrado com sucesso!";
            echo $mensagem;
        } catch (PDOException $erro) {
            $mensagemerro = "Falha no banco de dados, contactar suporte!" . $erro;
            echo $mensagemerro;
        }
    }
}


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parada</title>
    <link rel="stylesheet" href="css/geral.css">
    <link rel="stylesheet" href="css/header.css">
</head>

<body>
    <?php include("header.php") ?>

    <div class="divCorpo">
        <form id="novaParada" action="" method="post">
            <!---------------->
            <div class="div-maquina">
                <label class="maquina">Máquina:</label>
                <select class="hvr-float" id="maquina" name="maquina">
                    <option value="<?php /* Para deixar último código usado selecionado*/if (isset($ultimachine)) {
                        echo $ultimachine;
                    } ?>"><?php /* Para deixar último código usado selecionado*/if (isset($ultimachine)) {
                         echo $ultimachine;
                     } ?></option>
                    <?php machineOption(); ?>
                </select>
            </div>
            <!---------------->
            <div class="div-titulo">
                <label for="titulo">Título:</label>
                <input name="titulo" id="titulo" type="text">
            </div>
            <!---------------->
            <div class="div-inicio">
                <label for="inicio">Início:</label>
                <input name="inicio" id="inicio" type="datetime-local">
            </div>
            <!---------------->
            <input id="enviar" class="hvr-float" type="submit" value="Enviar">
            <!---------------->
        </form>
    </div>

    <?php include('footer.php'); ?>
</body>

</html>