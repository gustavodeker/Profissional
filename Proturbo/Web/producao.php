<?php
include("config/conexao.php");
sessionVerif();

if (isset($_POST['maquina']) && isset($_POST['pn']) && isset($_POST['motivo']) && isset($_POST['qtd'])) {
    if (empty($_POST['maquina']) or empty($_POST['pn']) or empty($_POST['motivo']) or empty($_POST['qtd'])) {
        $mensagemerro = "Todos os campos são obrigatórios!";
        $ultimachine = limpaPost($_POST['maquina']);
        $ultimopn = limpaPost($_POST['pn']);
        $ultimomotivo = limpaPost($_POST['motivo']);
    } else {
        /* Limpando entrada */
        $machine = limpaPost($_POST['maquina']);
        $motivo = limpaPost($_POST['motivo']);
        $pn = limpaPost($_POST['pn']);
        $qtd = limpaPost($_POST['qtd']);

        /* Verificando se pn existe */
        $sql_count = $pdo->prepare("SELECT COUNT(*) FROM itens WHERE item_pn = '$pn'");
        $sql_count->execute();
        $count_pn = $sql_count->fetchColumn();

        if ($count_pn != 1) {
            $mensagemerro = "Partnumber incorreto!";
        }

        if ($qtd < 1 or $qtd > 999) {
            $mensagemerro = "Quantidade de 1 a 999!";
        }
        if ($count_pn == 1 && $qtd > 0 && $qtd < 1000) {

            /* Coletando itens/pn */
            $sql_pn = $pdo->prepare("SELECT * FROM itens WHERE item_pn = '$pn'");
            $sql_pn->execute();
            $row_pn = $sql_pn->fetch(PDO::FETCH_ASSOC);

            /* Coletando user_id */
            global $user;
            $user = auth($_SESSION['TOKEN']);

            /* ultimos dados */
            $ultimachine = $machine;
            $ultimopn = limpaPost($_POST['pn']);
            $ultimomotivo = $motivo;

            /* Todos os dados coletados */
            /*prod_id*/
            $machine_name = $machine;
            $pn_pn = $pn;
            $pn_desc = $row_pn['item_pn_desc'];
            $pn_setor_cod = $row_pn['item_setor_cod'];
            $pn_setor_name = $row_pn['item_setor_name'];
            $qtd = limpaPost($_POST['qtd']);
            /*prod_datetime*/
            $user_name = $user['user_name'];
            $motivo = limpaPost($_POST['motivo']);

            try {
                $sqla = $pdo->prepare("INSERT INTO prod VALUES (null,?,?,?,?,?,?,default,?,?)");
                $sqla->execute(array($machine_name, $pn_pn, $pn_desc, $pn_setor_cod, $pn_setor_name, $qtd, $user_name, $motivo));

                $mensagem = "Registrado com sucesso!";
            } catch (PDOException $erro) {
                $mensagemerro = "Falha no banco de dados, contactar suporte!" . $erro;
            }
        }
    }
}


?>
<!DOCTYPE html>
<html lang="pr-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/geral.css">
    <link rel="stylesheet" href="css/producao.css">
    <link rel="stylesheet" href="css/refugo.css">
    <title>Próturbo :: Produção</title>
</head>

<body>
    <?php include_once("header.php") ?>

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

    <div id="corpo">
        <!--ALTERNAR
        <div id="alternar">
            <a class="hvr-float" style="border: 2px solid whitesmoke" id="btn-refuse" href="refugo.php">Refugo</a>
            <a class="hvr-float" style="border: 2px solid black" id="btn-production" href="producao.php">Produção</a>
        </div>
        -------------->
        <!--prod-->
        <div id="div-producao" class="animate__animated animate__fadeIn">
            <h1>PRODUÇÃO</h1>
            <p class="pform">O formulário de produção manual deve ser utilizado apenas quando for relatado problema no
                sistema automatizado.</p>
            <form id="form-producao" method="POST">
                <!---------------->
                <div class="div-maquina">
                    <label class="maquina">Máquina:</label>
                    <select class="hvr-float" id="maquina" name="maquina">
                        <option value="<?php /* Para deixar último código usado selecionado*/if (isset($ultimachine)) {
                            echo $ultimachine;
                        } ?>">
                            <?php /* Para deixar último código usado selecionado*/if (isset($ultimachine)) {
                                echo $ultimachine;
                            } ?></option>
                        <?php machineOption(); ?>
                    </select>
                </div>
                <!---------------->
                <p style="background: #004479; color: whitesmoke; text-align: center;">Selecione o Partnumber:</p>
                <table id="tabled">
                    <thead>
                        <th>PN</th>
                        <th class="th">Descrição</th>
                    </thead>
                    <tbody>
                        <?php itemTable(); ?>
                    </tbody>
                </table>
                <!---------------->
                <!---------------->
                <div class="div-cod">
                    <label class="codigo">Selecionado:</label>
                    <input class="hvr-float" id="pn" name="pn" type="number" value="<?php /* Para deixar último código usado selecionado*/if (isset($ultimopn)) {
                        echo $ultimopn;
                    } ?>">
                </div>
                <!---------------->
                <!---------------->
                <div class="div-motivo">
                    <label class="labelmotivo">Motivo:</label>
                    <textarea class="hvr-float" name="motivo" id="motivo" cols="auto" rows="5"><?php /*o*/if (isset($ultimomotivo)) {echo $ultimomotivo;}?></textarea>
                </div>
                <!---------------->
                <div class="div-qtd">
                    <label>Quantidade:</label>
                    <div class="menos hvr-float" onclick="menos()">-</div>
                    <input id="qtd" name="qtd" class="qtd hvr-float" type="number" min="1" value="<?php /* Para deixar último código usado selecionado*/if (isset($ultimaqtd)) {
                        echo $ultimaqtd;
                    } ?>" placeholder="">
                    <div class="mais hvr-float" onclick="mais()">+</div>
                </div>
                <input id="enviar" class="hvr-float" type="submit" value="Enviar">
            </form>
        </div>
        <!---------------->
    </div>

    <?php include('footer.php'); ?>
</body>

</html>

<script>
    document.getElementById('form-producao').addEventListener('submit', function (event) {
        event.preventDefault();
        document.getElementById('enviar').setAttribute('disabled', 'disabled');
        this.submit();
    });
</script>

<script>
    setTimeout(function () {
        $('#mensagem').hide(); // "foo" é o id do elemento que seja manipular.
    }, 2500); // O valor é representado em milisegundos.
    setTimeout(function () {
        $('#mensagemerro').hide(); // "foo" é o id do elemento que seja manipular.
    }, 2500); // O valor é representado em milisegundos.

</script>
<script>
    function menos() {
        var qtd = document.getElementById("qtd");
        if (qtd.value > 1) {
            qtd.value--;
        }
    }
    function mais() {
        var qtd = document.getElementById("qtd");
        if (qtd.value < 999) {
            qtd.value++;
        }
    }

    function list2(td) {
        var tede = document.getElementById(td).innerHTML;
        var input = document.getElementById("pn");
        input.value = tede;
    }

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>