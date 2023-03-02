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
        } catch (PDOException $erro) {
            $mensagemerro = "Falha no banco de dados, contactar suporte!" . $erro;
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
        echo "<td class='tdeditar'><span class='material-icons hvr-float' onclick=\"location.href='parada.php?page=parada&id=" . $sqlP['parada_id'] . "'\">
        close
        </span></td>";
    }
}

function tableFechadas()
{
    global $pdo;
    $sqlPendentes = $pdo->prepare("SELECT * FROM parada WHERE parada_status = 'Fechada'");
    $sqlPendentes->execute();

    while ($sqlP = $sqlPendentes->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $sqlP['parada_maquina'] . "</td>";
        echo "<td>" . $sqlP['parada_titulo'] . "</td>";
        echo "<td>" . $sqlP['parada_horainicio'] . "</td>";
        echo "<td>" . $sqlP['parada_horafim'] . "</td>";
    }
}

/**FECHAR**/
if (isset($_REQUEST["id"])) {
    include("fechar.php");
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
    <link rel="stylesheet" href="css/geral.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/parada.css">
</head>

<body>
    <?php include("header.php") ?>

    <div class="divCorpo">

        <!--BOTÕES NOVA PARADA / PENDENTES / FECHAR -->
        <div class="botoes">
            <input onclick="abrirNovaParada()" class="btn-novaParada" id="btn-novaParada" type="button" value="+ Nova parada">
            <input onclick="pend()" class="pend" id="pend" type="button" value="Pendentes">
            <input onclick="fech()" class="fech" id="fech" type="button" value="+ Fechados">
        </div>


        <!--NOVA PARADA-->
        <div class="divNovaParada" id="divNovaParada">
            <button class="fecharN" id="fecharN" onclick="fecharNovaParada()">X</button>

            <form id="formNovaParada" action="" method="post">
                <!---------------->
                <div class="div-maquina">
                    <label class="maquina">Máquina:</label>
                    <select class="hvr-float" id="maquina" name="maquina">
                        <option value="<?php /* Para deixar último código usado selecionado*/ if (isset($ultimachine)) {
                                            echo $ultimachine;
                                        } ?>"><?php /* Para deixar último código usado selecionado*/ if (isset($ultimachine)) {
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

        <!--PENDENTES-->
        <div class="divPendentes" id="divPendentes">
            <!---------------------------------------------------------------->
            <div id="divTablePendentes" class="animate__animated animate__fadeIn">
                <table id="table-pendentes">
                    <thead>
                        <th>Máquina</th>
                        <th>Parada</th>
                        <th>Início</th>
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
        
        <!--PENDENTES-->
        <div class="divFechadas" id="divFechadas">
            <!---------------------------------------------------------------->
            <div id="divTableFechadas" class="animate__animated animate__fadeIn">
                <table id="table-fechadas">
                    <thead>
                        <th>Máquina</th>
                        <th>Parada</th>
                        <th>Início</th>
                        <th>Fim</th>
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
        <div class="divFechar">
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
                </div>
            <?php } ?>
            <!---------------->
            <!---------------------------------------------------------------->
            <div id="divFechar" class="animate__animated animate__fadeIn">
                <button class="fechar" id="fechar" onclick="fecharFechar()">X</button>

                <form id="formFechar" action="" method="post">
                    <!---------------->
                    <div class="div-maquina">
                        <label class="maquina">Máquina:</label>
                        <select class="hvr-float" id="maquinaf" name="maquinaf">
                            <option><?php echo $sqlP_n['parada_maquina']; ?></option>
                            <?php machineOption(); ?>
                        </select>
                    </div>
                    <!---------------->
                    <div class="div-titulo">
                        <label for="titulof">Título:</label>
                        <input name="titulof" id="titulof" type="text" value="<?php echo $sqlP_n['parada_titulo']; ?>">
                    </div>
                    <!---------------->
                    <div class="div-inicio">
                        <label for="iniciof">Início:</label>
                        <input name="iniciof" id="iniciof" type="datetime-local" value="<?php echo $sqlP_n['parada_horainicio'];  ?>">
                    </div>
                    <!---------------->
                    <div class="div-fim">
                        <label for="fimf">Fim:</label>
                        <input name="fimf" id="fimf" type="datetime-local">
                    </div>
                    <!---------------->
                    <div class="div-coment">
                        <label for="comentf">Comentário:</label>
                        <input name="comentf" id="comentf" type="text">
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


<?php /**ABRIR FECHAR**/
if (isset($_REQUEST["id"])) { ?>
    <script>
        let modal = document.getElementById('divFechar');
        modal.style.display = 'flex';
    </script>
<?php } ?>
<script>
    /**FECHAR FECHAR */
    function fecharFechar() {
        let modal = document.getElementById('divFechar');
        modal.style.display = 'none';
        location.href = 'parada.php';
    }
</script>

<script>
    /**ABRIR NOVA PARADA */
    function abrirNovaParada() {
        let modal = document.getElementById('divNovaParada');
        modal.style.display = 'flex';
    }
    /**FECHAR NOVA PARADA */
    function fecharNovaParada() {
        let modal = document.getElementById('divNovaParada');
        modal.style.display = 'none';
    }
</script>

<script>
    /** */
    function pend() {
        let modal = document.getElementById('divPendentes');
        modal.style.display = 'flex';
        let modal2 = document.getElementById('divFechadas');
        modal2.style.display = 'none';
    }

    function fech() {
        let modal = document.getElementById('divPendentes');
        modal.style.display = 'none';
        let modal2 = document.getElementById('divFechadas');
        modal2.style.display = 'flex';
        let modal3 = document.getElementById('divNovaParada');
        modal3.style.display = 'none';
        let modal4 = document.getElementById('divFechar');
        modal4.style.display = 'none';
    }
</script>




<script>
    /**DESABILITAR BOTÃO DE ENVIAR */
    document.getElementById('form-refuse').addEventListener('submit', function(event) {
        event.preventDefault();
        document.getElementById('enviar').setAttribute('disabled', 'disabled');
        this.submit();
    });
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    /** MENSAGENS E MENSAGEM ERRO**/
    setTimeout(function() {
        $('#mensagem').hide(); // "foo" é o id do elemento que seja manipular.
    }, 2500); // O valor é representado em milisegundos.
    setTimeout(function() {
        $('#mensagemerro').hide(); // "foo" é o id do elemento que seja manipular.
    }, 2500); // O valor é representado em milisegundos.
</script>