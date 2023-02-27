<?php
include("config/conexao.php");
sessionVerif();

if (isset($_POST['maquina']) && isset($_POST['cod']) && isset($_POST['pn']) && isset($_POST['qtd'])) {
    if (empty($_POST['maquina']) or empty($_POST['cod']) or empty($_POST['pn']) or empty($_POST['qtd'])) {
        $mensagemerro = "Todos os campos são obrigatórios!";
        $ultimachine = limpaPost($_POST['maquina']);
        $ultimocode = limpaPost($_POST['cod']);
        $ultimopn = limpaPost($_POST['pn']);
        $ultimaqtd = $qtd = limpaPost($_POST['qtd']);
    } else {
        /* Limpando entrada */
        $machine = limpaPost($_POST['maquina']);
        $code = limpaPost($_POST['cod']);
        $pn = limpaPost($_POST['pn']);
        $qtd = limpaPost($_POST['qtd']);

        /* Verificando se cod existe */
        $sql_count = $pdo->prepare("SELECT COUNT(*) FROM codes WHERE code_code = '$code'");
        $sql_count->execute();
        $count_code = $sql_count->fetchColumn();

        /* Verificando se pn existe */
        $sql_count = $pdo->prepare("SELECT COUNT(*) FROM itens WHERE item_pn = '$pn'");
        $sql_count->execute();
        $count_pn = $sql_count->fetchColumn();

        if ($count_code != 1) {
            $mensagemerro = "Código incorreto!";
        }
        if ($count_pn != 1) {
            $mensagemerro = "Partnumber incorreto!";
        }
        if ($qtd < 1 or $qtd > 999) {
            $mensagemerro = "Quantidade de 1 a 999!";
        }
        if ($count_code == 1 && $count_pn == 1 && $qtd > 0 && $qtd < 1000) {

            /* Coletando codes */
            $sql_cod = $pdo->prepare("SELECT * FROM codes WHERE code_code = '$code'");
            $sql_cod->execute();
            $row_cod = $sql_cod->fetch(PDO::FETCH_ASSOC);

            /* Coletando itens/pn */
            $sql_pn = $pdo->prepare("SELECT * FROM itens WHERE item_pn = '$pn'");
            $sql_pn->execute();
            $row_pn = $sql_pn->fetch(PDO::FETCH_ASSOC);

            /* Coletando user */
            global $user;
            $user = auth($_SESSION['TOKEN']);

            /* ultimos dados */
            $ultimachine = $machine;
            $ultimocode = $code;
            $ultimopn = limpaPost($_POST['pn']);

            /* Todos os dados coletados */
            /*refuse_id*/
            $machine_name = $machine;
            $pn_pn = $pn;
            $pn_desc = $row_pn['item_pn_desc'];
            $pn_setor_cod = $row_pn['item_setor_cod'];
            $pn_setor_name = $row_pn['item_setor_name'];
            $code_code = $code;
            $code_desc = $row_cod["code_desc"];
            $code_processo = $row_cod["code_processo"];
            /*refuse_setor_area*/
            /*$qtd */
            /*refuse_datetime*/
            $user_name = $user['user_name'];

            try {
                $sqla = $pdo->prepare("INSERT INTO refuse VALUES (null,?,?,?,?,?,?,?,?,default,?,default,?)");
                $sqla->execute(array($machine_name, $pn_pn, $pn_desc, $pn_setor_cod, $pn_setor_name, $code_code, $code_desc, $code_processo, $qtd, $user_name));
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
    <link rel="stylesheet" href="css/datatablePesquisa.css">
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
            <h1>REFUGO</h1>
            <form id="form-refuse" method="POST">
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
                <!---------------->
                <div class="divCod">
                    <p class="titulo-tabela">MOTIVO DO REFUGO:</p>
                    <table id="table-cod">
                        <thead>
                            <th>Cod</th>
                            <th class="th-desc">Descrição</th>
                        </thead>
                        <tbody>
                            <?php codTable(); ?>
                        </tbody>
                    </table>
                    <div class="div-cod">
                        <label class="codigo">Motivo selecionado:</label>
                        <input class="hvr-float" id="cod" name="cod" type="number" value="<?php /* Para deixar último código usado selecionado*/ if (isset($ultimocode)) {
                                                                                                echo $ultimocode;
                                                                                            } ?>">
                    </div>
                </div>
                <!---------------->
                <!---------------->
                <div class="divPn">
                    <p class="titulo-tabela">PARTNUMBER:</p>
                    <table id="table-pn">
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
                        <label class="codigo">Partnumber selecionado:</label>
                        <input class="hvr-float" id="pn" name="pn" type="number" value="<?php /* Para deixar último código usado selecionado*/ if (isset($ultimopn)) {
                                                                                            echo $ultimopn;
                                                                                        } ?>">
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
<script src="js/datatable.js"></script>

<script>
    $(document).ready(function() {
        //Com responsividade e tradução
        $('#table-cod').DataTable({
            responsive: true,
            "language": {
                "emptyTable": "Nenhum registro encontrado",
                "info": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "infoEmpty": "Mostrando 0 até 0 de 0 registros",
                "infoFiltered": "(Filtrados de _MAX_ registros)",
                "infoThousands": ".",
                "loadingRecords": "Carregando...",
                "processing": "Processando...",
                "zeroRecords": "Nenhum registro encontrado",
                "search": "Pesquisar",
                "lengthMenu": "Exibir _MENU_ resultados por página",
                "paginate": {
                    "next": "Próximo",
                    "previous": "Anterior",
                    "first": "Primeiro",
                    "last": "Último"
                }
            },
            "order": [
                [0, 'asc']
            ]
        });
    });
</script>

<script>
    $(document).ready(function() {
        //Com responsividade e tradução
        $('#table-pn').DataTable({
            responsive: false,
            "language": {
                "emptyTable": "Nenhum registro encontrado",
                "info": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "infoEmpty": "Mostrando 0 até 0 de 0 registros",
                "infoFiltered": "(Filtrados de _MAX_ registros)",
                "infoThousands": ".",
                "loadingRecords": "Carregando...",
                "processing": "Processando...",
                "zeroRecords": "Nenhum registro encontrado",
                "search": "Pesquisar",
                "lengthMenu": "Exibir _MENU_ resultados por página",
                "paginate": {
                    "next": "Próximo",
                    "previous": "Anterior",
                    "first": "Primeiro",
                    "last": "Último"
                }
            },
            "order": [
                [0, 'asc']
            ]
        });
    });
</script>