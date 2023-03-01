<?php
include("config/conexao.php");
sessionVerif();

if (isset($_POST['maquina']) && isset($_POST['titulo']) && isset($_POST['inicio'])) {
    if (empty($_POST['maquina']) or empty($_POST['titulo']) or empty($_POST['inicio'])) {
        $mensagemerro = "Preencher todos os campos!";
        echo $mensagemerro;
    } else {
        $maquina = limpaPost($_POST['maquina']);
        $titulo = limpaPost($_POST['titulo']);
        $inicio = limpaPost($_POST['inicio']);

        //Conferindo se máquina existe
        $sqlmaquina = $pdo->prepare("SELECT COUNT(*) from machines WHERE machine_name = '$maquina'");
        $sqlmaquina->execute();
        $count_maquina = $sqlmaquina->fetchColumn();
        if ($count_maquina != 1) {
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

function tablePendentes()
{
    global $pdo;
    $sqlPendentes = $pdo->prepare("SELECT * FROM parada WHERE parada_status = 'Pendente'");
    $sqlPendentes->execute();

    while ($sqlP = $sqlPendentes->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $sqlP['parada_maquina'] . "</td>";
        echo "<td>" . $sqlP['parada_titulo'] . "</td>";
        echo "<td>" . $sqlP['parada_horainicio'] . "</td>";
        echo "<td>Fechar</td>";
    }
}

if (isset($_POST['maquina']) && $_POST['titulo'] && isset($_POST['inicio']) && isset($_POST['fim']) && $_POST['coment']) {
    if (empty($_POST['maquina']) or empty($_POST['titulo']) or empty($_POST['inicio']) or empty($_POST['fim'])) {
        $mensagemerro = "Os campos são obrigatórios, apenas comentário é opcional!";
        echo $mensagemerro;
    } else {
        $maquina = limpaPost($_POST['maquina']);
        $titulo = limpaPost($_POST['titulo']);
        $inicio = limpaPost($_POST['inicio']);
        $fim = limpaPost($_POST['fim']);
        $coment = limpaPost($_POST['coment']);

        //Conferindo se máquina existe
        $sqlmaquina = $pdo->prepare("SELECT COUNT(*) from machines WHERE machine_name = '$maquina'");
        $sqlmaquina->execute();
        $count_maquina = $sqlmaquina->fetchColumn();
        if ($count_maquina != 1) {
            $mensagemerro = "Máquina inválida";
        }
        //Pegando username
        global $user;
        $user = auth($_SESSION['TOKEN']);
        $user_name = $user['user_name'];

        //Status
        $status = "Fechada";
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
        <!--PARADA-->
        <div class="divNovaParada">
            <form id="formNovaParada" action="" method="post">
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

        <!--PARADA-->
        <div class="divPendentes">
            <!---------------------------------------------------------------->
            <div id="divTablePendentes" class="animate__animated animate__fadeIn">
                <table id="table-pendentes">
                    <thead>
                        <th>Máquina</th>
                        <th>Parada</th>
                        <th>Início</th>
                        <th id="theditar">Editar</th>
                    </thead>
                    <tbody>
                        <?php
                        tablePendentes();
                        ?>
                    </tbody>
                </table>
            </div>
            <!---------------------------------------------------------------->
        </div>

        <!--FECHAR-->
        <div class="divFechar">
            <!---------------------------------------------------------------->
            <div id="divFechar" class="animate__animated animate__fadeIn">
                <form id="formFechar" action="" method="post">
                    <!---------------->
                    <div class="div-maquina">
                        <label class="maquina">Máquina:</label>
                        <select class="hvr-float" id="maquina" name="maquina">
                            <option value="<?php //MAQUINA RECUPERADA DO INDICE ?>"><?php //MAQUINA RECUPERADA DO INDICE                  ?></option>
                            <?php machineOption(); ?>
                        </select>
                    </div>
                    <!---------------->
                    <div class="div-titulo">
                        <label for="titulo">Título:</label>
                        <input name="titulo" id="titulo" type="text" value="<?php //TITULO RECUPERADA DO INDICE ?>">
                    </div>
                    <!---------------->
                    <div class="div-inicio">
                        <label for="inicio">Início:</label>
                        <input name="inicio" id="inicio" type="datetime-local"
                            value="<?php //DATA INICIO RECUPERADA DO INDICE ?>">
                    </div>
                    <!---------------->
                    <div class="div-fim">
                        <label for="fim">Fim:</label>
                        <input name="fim" id="fim" type="datetime-local">
                    </div>
                    <!---------------->
                    <div class="div-coment">
                        <label for="coment">Comentário:</label>
                        <input name="coment" id="coment" type="text">
                    </div>
                    <!---------------->
                    <input id="enviar" class="hvr-float" type="submit" value="Fechar">
                    <!---------------->
                </form>
            </div>
            <!---------------------------------------------------------------->
        </div>

    </div><!--/divCorpo-->

    <?php include('footer.php'); ?>
</body>

</html>