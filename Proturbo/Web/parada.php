<?php 
    include("config/conexao.php");
    sessionVerif();
    
    include("processamento/novaParada.php");

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
        echo "<td class='tdeditar'><span class='material-icons hvr-grow' onclick=\"location.href='parada.php?page=parada&id=" . $sqlP['parada_id'] . "'\">
        cancel
        </span></td>";
    }
}

function tableFechadas()
{
    global $pdo;
    $sqlPendentes = $pdo->prepare("SELECT * FROM parada WHERE parada_status = 'Fechada' LIMIT 20");
    $sqlPendentes->execute();

    while ($sqlP = $sqlPendentes->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $sqlP['parada_maquina'] . "</td>";
        echo "<td>" . $sqlP['parada_titulo'] . "</td>";
        echo "<td>" . $sqlP['parada_duracao'] . "</td>";
    }
}

/**FECHAR**/
if (isset($_REQUEST["id"])) {
    include("processamento/fechar.php");
}
/**FECHAR**/
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parada</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/geral.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/parada.css">


</head>

<body>
    <?php include("header.php") ?>

    <div class="divCorpo">
            <!---------------->
            <?php //mensagem
            if (isset($mensagem)) { ?>
                <div id="mensagem" class="mensagem">
                    <?php echo "<p>" . $mensagem . "<p>"; ?>
                </div>
            <?php } ?>

            <?php //mensagemerro
            if (isset($mensagemerro)) { ?>
                <div id="mensagemerro" class="mensagemerro">
                    <?php echo "<p>" . $mensagemerro . "<p>"; ?>
                    <script>abrirNova();</script>
                </div>
            <?php } ?>
            <!---------------->
        <!--BOT??ES NOVA PARADA / PENDENTES / FECHAR -->
        <div class="botoes">
            <input onclick="abrirNova()" class="btn-novaParada" id="btn-novaParada" type="button"
                value="+ Nova parada">
            <input onclick="pend()" class="pend" id="pend" type="button" value="Pendentes">
            <input onclick="fech()" class="fech" id="fech" type="button" value="Fechados">
        </div>


        <!--NOVA PARADA-->
        <div class="janela-nova" id="janela-nova">
            <div class="divNovaParada" id="divNovaParada">
            <button class="fechar" id="fechar" onclick="fecharNova()">X</button>

                <form id="formNovaParada" action="" method="post">
                    <!---------------->
                    <div class="div-maquina">
                        <label class="maquina">M??quina:</label>
                        <select class="hvr-float" id="maquina" name="maquina">
                            <option value="<?php /* Para deixar ??ltimo c??digo usado selecionado*/if (isset($ultimachine)) {
                                echo $ultimachine;
                            } ?>"><?php /* Para deixar ??ltimo c??digo usado selecionado*/if (isset($ultimachine)) {
                                 echo $ultimachine;
                             } ?></option>
                            <?php machineOption(); ?>
                        </select>
                    </div>
                    <!---------------->
                    <div class="div-titulo">
                        <label for="titulo">T??tulo:</label>
                        <input name="titulo" id="titulo" type="text">
                    </div>
                    <!---------------->
                    <div class="div-inicio">
                        <label for="inicio">In??cio:</label>
                        <input name="inicio" id="inicio" type="datetime-local">
                    </div>
                    <!---------------->
                    <input id="enviar" class="hvr-float" type="submit" value="Enviar">
                    <!---------------->
                </form>
            </div>
        </div>
        <!--PENDENTES-->
        <div class="divPendentes" id="divPendentes">
            <!---------------------------------------------------------------->
            <div id="divTablePendentes" class="animate__animated animate__fadeIn">
                <table id="table-pendentes">
                    <thead>
                        <th>M??quina</th>
                        <th>Parada</th>
                        <th>In??cio</th>
                        <th id="theditar">Fechar</th>
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

        <!--FECHADAS-->
        <div class="divFechadas" id="divFechadas">
            <!---------------------------------------------------------------->
            <div id="divTableFechadas" class="animate__animated animate__fadeIn">
                <table id="table-fechadas">
                    <thead>
                        <th>M??quina</th>
                        <th>Parada</th>
                        <th>Tempo parado</th>
                    </thead>
                    <tbody>
                        <?php
                        tableFechadas();
                        ?>
                    </tbody>
                </table>
            </div>
            <!---------------------------------------------------------------->
        </div>

        <!--FECHAR-->
        <div class="janela-fechar" id="janela-fechar">

            <!---------------------------------------------------------------->
            <div id="divFechar" class="animate__animated animate__fadeIn">
                <button class="fechar" id="fechar" onclick="fecharFechar()">X</button>
                <form id="formFechar" action="" method="post">
                    <!---------------->
                    <div class="div-maquina">
                        <label class="maquinaf">M??quina:</label>
                        <select class="hvr-float" id="maquinaf" name="maquinaf">
                            <option>
                                <?php echo $sqlP_n['parada_maquina']; ?>
                            </option>
                            <?php machineOption(); ?>
                        </select>
                    </div>
                    <!---------------->
                    <div class="div-titulo">
                        <label for="titulof">T??tulo:</label>
                        <input name="titulof" id="titulof" type="text" value="<?php echo $sqlP_n['parada_titulo']; ?>">
                    </div>
                    <!---------------->
                    <div class="div-inicio">
                        <label for="iniciof">In??cio:</label>
                        <input name="iniciof" id="iniciof" type="datetime-local"
                            value="<?php echo $sqlP_n['parada_horainicio']; ?>">
                    </div>
                    <!---------------->
                    <div class="div-fim">
                        <label for="fimf">Fim:</label>
                        <input name="fimf" id="fimf" type="datetime-local" value="<?php echo $sqlP_n['parada_horafim']; ?>">
                    </div>
                    <!---------------->
                    <div class="div-coment">
                        <label for="comentf">Coment??rio:</label>
                        <input name="comentf" id="comentf" type="text" value="<?php echo $sqlP_n['parada_coment']; ?>">
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


<script>
    /**ABRIR NOVA PARADA */
    function abrirNova() {
    pend();
    window.location.href = 'parada.php?nova=parada';
    let modal = document.getElementById('janela-nova');
    modal.style.display = 'flex';
}
    /**FECHAR NOVA PARADA */
    function fecharNova() {
        window.location.href = 'parada.php';
        let modal = document.getElementById('janela-nova');
        modal.style.display = 'none';
    }
</script>

<?php /**ABRIR NOVA PARADA REQUEST**/
if (isset($_REQUEST["nova"])) { ?>
    <script>
        let modal = document.getElementById('janela-nova');
        modal.style.display = 'flex';
    </script>
<?php } ?>

<?php /**ABRIR FECHAR**/
if (isset($_REQUEST["id"])) { ?>
    <script>
        let modal = document.getElementById('janela-fechar');
        modal.style.display = 'flex';
    </script>
<?php } ?>
<script>
    /**FECHAR FECHAR */
    function fecharFechar() {
        let modal = document.getElementById('janela-fechar');
        modal.style.display = 'none';
        location.href = 'parada.php';
    }
</script>

<script>
    /* ALTENAR VISUALIZA????O PARA PENDENTES */
    function pend() {
        let modal = document.getElementById('divPendentes');
        modal.style.display = 'flex';
        let modal2 = document.getElementById('divFechadas');
        modal2.style.display = 'none';
    }
    /* ALTENAR VISUALIZA????O PARA FECHADAS */
    function fech() {
        let modal = document.getElementById('divPendentes');
        modal.style.display = 'none';
        let modal2 = document.getElementById('divFechadas');
        modal2.style.display = 'flex';
    }
</script>

<script>
    /**DESABILITAR BOT??O DE ENVIAR */
    document.getElementById('formNovaParada').addEventListener('submit', function (event) {
        event.preventDefault();
        document.getElementById('enviar').setAttribute('disabled', 'disabled');
        this.submit();
    });
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    /** MENSAGENS E MENSAGEM ERRO**/
    setTimeout(function () {
        $('#mensagem').hide(); // "foo" ?? o id do elemento que seja manipular.
    }, 2500); // O valor ?? representado em milisegundos.
    setTimeout(function () {
        $('#mensagemerro').hide(); // "foo" ?? o id do elemento que seja manipular.
    }, 2500); // O valor ?? representado em milisegundos.
</script>
