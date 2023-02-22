<?php
include("config/conexao.php");
sessionVerif();

if (isset($_POST['maquina']) && isset($_POST['cod']) && isset($_POST['qtd'])) {
    if (empty($_POST['maquina']) or empty($_POST['cod']) or empty($_POST['qtd'])) {
        $mensagemerro = "Todos os campos são obrigatórios!";
        $ultimachine = limpaPost($_POST['maquina']);
        $ultimocode = limpaPost($_POST['cod']);
        $ultimaqtd = $qtd = limpaPost($_POST['qtd']);
    } else {
        /* Dados coletados */
        $machine = limpaPost($_POST['maquina']);
        $code = limpaPost($_POST['cod']);
        $qtd = limpaPost($_POST['qtd']);

        /* Verificando se cod existe */
        $sql_count = $pdo->prepare("SELECT COUNT(*) FROM codes WHERE code_code = '$code'");
        $sql_count->execute();
        $count_code = $sql_count->fetchColumn();

        if ($count_code != 1) {
            $mensagemerro = "Código incorreto!";
        }
        if ($qtd < 1 or $qtd > 999) {
            $mensagemerro = "Quantidade de 1 a 999!";
        }
        if ($count_code == 1 && $qtd > 0 && $qtd < 1000) {
            /* Coletando code_id */
            $sql_cod = $pdo->prepare("SELECT * FROM codes WHERE code_code = '$code'");
            $sql_cod->execute();
            $row_cod = $sql_cod->fetch(PDO::FETCH_ASSOC);
            $ultimocode = $row_cod["code_code"];

            /* Coletando machine_id */
            $sql_machine = $pdo->prepare("SELECT * FROM machines WHERE machine_name = '$machine'");
            $sql_machine->execute();
            $row_machine = $sql_machine->fetch(PDO::FETCH_ASSOC);
            $machine_name = $row_machine['machine_name'];
            $ultimachine = $row_machine["machine_name"];

            /* Coletando user_id */
            global $user;
            $user = auth($_SESSION['TOKEN']);

            /* Dados coletados */
            $user_name = $user['user_name'];
            $code_code = $row_cod['code_code'];

            try {
                $sqla = $pdo->prepare("INSERT INTO refuse VALUES (null,?,?,?,?,default,null,null)");
                $sqla->execute(array($user_name, $machine_name, $code_code, $qtd));

                $pesq = $pdo->prepare("SELECT refuse_id FROM refuse ORDER BY refuse_datetime DESC LIMIT 1");
                $pesq->execute();
                $row_pesq = $pesq->fetch(PDO::FETCH_ASSOC);
                $refuse_id = $row_pesq['refuse_id'];

                $sqlb = $pdo->prepare("INSERT INTO gr VALUES (null,?,?,?,?,default,?)");
                $sqlb->execute(array($user['user_name'], $row_machine['machine_name'], $row_cod['code_code'], $qtd, $refuse_id));
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
    <link rel="stylesheet" href="css/refugo.css">
    <title>Próturbo :: Refugo</title>
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

        <!--REFUSE-->
        <div id="div-refuse" class="animate__animated animate__fadeIn">
            <form id="form-refuse" method="POST">
                <h1>REFUGO</h1>

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
                <p style="background: #004479; color: whitesmoke; text-align: center;">Selecione o código na tabela</p>
                <table id="table-cod">
                    <thead>
                        <th>Cod</th>
                        <th class="th-desc">Descrição</th>
                    </thead>
                    <tbody>
                        <?php codTable(); ?>
                    </tbody>
                </table>
                <!---------------->
                <div class="div-cod">
                    <label class="codigo">Selecionado:</label>
                    <input class="hvr-float" id="cod" name="cod" type="number" value="<?php /* Para deixar último código usado selecionado*/ if (isset($ultimocode)) {
                                                                                            echo $ultimocode;
                                                                                        } ?>">
                </div>
                <!---------------->
                                <!---------------->
                                <div class="div-cod">
                    <label class="codigo">Selecionado:</label>
                    <input class="hvr-float" id="pn" name="pn" type="number" value="<?php /* Para deixar último código usado selecionado*/ if (isset($ultimocode)) {
                                                                                            echo $ultimocode;
                                                                                        } ?>">
                </div>
                <!---------------->
                <!---------------->
                <p style="background: #004479; color: whitesmoke; text-align: center;">Selecione o código na tabela</p>
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
                <div class="quantidade">
                    <label>Quantidade:</label>
                    <div class="div-qtd">
                        <div class="menos hvr-float" onclick="menos()">-</div>
                        <input id="qtd" name="qtd" class="qtd hvr-float" type="number" min="1" value="<?php /* Para deixar último código usado selecionado*/ if (isset($ultimaqtd)) {
                                                                                                            echo $ultimaqtd;
                                                                                                        } ?>" placeholder="">
                        <div class="mais hvr-float" onclick="mais()">+</div>
                    </div>
                </div>
                <!---------------->
                <input id="enviar" class="hvr-float" type="submit" value="Enviar">
                <!---------------->
            </form>
        </div>
        <!---------------->

    </div>

    <?php include('footer.php'); ?>
</body>

</html>

<script>
    document.getElementById('form-refuse').addEventListener('submit', function(event) {
        event.preventDefault();
        document.getElementById('enviar').setAttribute('disabled', 'disabled');
        this.submit();
    });
</script>

<script>
    setTimeout(function() {
        $('#mensagem').hide(); // "foo" é o id do elemento que seja manipular.
    }, 2500); // O valor é representado em milisegundos.
    setTimeout(function() {
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

    function list(td) {
        var tede = document.getElementById(td).innerHTML;
        var input = document.getElementById("cod");
        input.value = tede;
    }
    function list2(td) {
        var tede = document.getElementById(td).innerHTML;
        var input = document.getElementById("pn");
        input.value = tede;
    }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>