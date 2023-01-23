<?php
include("config/conexao.php");
sessionVerif();


function historicoTable()
{
    global $pdo;
    global $user;
    $user = auth($_SESSION['TOKEN']);
    if ($user['user_level'] == 'admin') {
        $sql = $pdo->prepare("SELECT * FROM refuse");
    } else {
        $sql = $pdo->prepare("SELECT * FROM refuse WHERE refuse_user_id = '" . $user['user_id'] . "' ORDER BY refuse_time DESC LIMIT 10");
    }
    $sql->execute();
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $sql_machine = $pdo->prepare("SELECT machine_code FROM machines WHERE machine_id = '" . $row['refuse_machine_id'] . "'");
        $sql_machine->execute();
        $row_machine = $sql_machine->fetch(PDO::FETCH_ASSOC);

        $sql_code = $pdo->prepare("SELECT code_code FROM codes WHERE code_id = '" . $row['refuse_code_id'] . "'");
        $sql_code->execute();
        $row_code = $sql_code->fetch(PDO::FETCH_ASSOC);

        echo "<tr>";
        echo "<td>" . $row_machine['machine_code'] . "</td>";
        echo "<td>" . $row_code['code_code'] . "</td>";
        echo "<td>" . $row['refuse_value'] . "</td>";
        echo "<td>" . $row['refuse_time'] . "</td>";
        echo "<td class='tdeditar'><span class='material-icons' onclick=\"location.href='historico.php?page=historico&id=" . $row['refuse_id'] . "'\">
        edit
        </span></td>";
    }
}

function codTable()
{
    global $pdo;
    $sql = $pdo->prepare("SELECT * FROM codes");
    $sql->execute();
    $i = 1;
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        $ide = 'td' . $i;
?>
        <td class="tdcod" id='<?php echo $ide ?>' onclick="list('<?php echo $ide ?>')"><?php echo $row['code_code'] ?></td>
        <td class="tddesc" id='<?php echo $ide ?>' onclick="list('<?php echo $ide ?>')"><?php echo $row['code_desc'] ?></td>
<?php
        $i++;
    }
}

function machineOption()
{
    global $user;
    $user = auth($_SESSION['TOKEN']);
    global $pdo;
    if ($user['user_level'] == 'admin') {
        $sql = $pdo->prepare("SELECT * FROM machines");
    } else {
        $sql = $pdo->prepare("SELECT * FROM machines WHERE machine_user_id = '" . $user['user_id'] . "'");
    }
    $sql->execute();
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='" . $row['machine_code'] . "'>" . $row['machine_code'] . "</option>";
    }
}

/**EDITAR**/
if (isset($_REQUEST["id"]) && !isset($_REQUEST["prod"])) {
    include("editar.php");
}
/**EDITAR**/
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Próturbo :: Histórico Refugo</title>
    <link rel="stylesheet" href="css/geral.css">
    <link rel="stylesheet" href="css/historico.css">
    <link rel="stylesheet" href="css/datatable.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <?php include_once("header.php") ?>

    <!---------------------------------------------------------------->
    <div class="div-alternar">
        <a style="border: 2px solid black; border-radius: 3px;" class="btn-alternar" href="historico.php">Refugo</a>
        <a class="btn-alternar" href="historicoProd.php">Produção</a>
    </div>
    <!---------------------------------------------------------------->
    <div id="divt" class="animate__animated animate__fadeIn">
        <h2>Histórico Refugo</h2>
        <table id="<?php if ($user['user_level'] == 'admin') {
        echo "historico-tableAdmin";}else{ echo "historico-table";} ?>">
            <thead>
                <th>Máquina</th>
                <th>Código</th>
                <th>Qtd</th>
                <th>Horário</th>
                <th id="theditar">Editar</th>
            </thead>
            <tbody>
                <?php
                    historicoTable();
                ?>
            </tbody>
        </table>
    </div>
    <!---------------------------------------------------------------->

    <!---------------------------------------------------------------->


    <div class="janela-edit animate__animated animate__fadeIn" id="janela-edit">
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
        <div id="div-refuse">
            <button class="fechar" id="fechar" onclick="fecharEdit()">X</button>

            <form id="form-refuse" method="POST">
                <h1>EDITAR</a></h1>

                <div class="div-maquina">
                    <label class="maquina">Máquina:</label>
                    <select id="maquina" name="maquina">
                        <option value="<?php echo $row_m["machine_code"] ?>"><?php echo $row_m["machine_code"] ?></option>
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
                    <input id="cod" name="cod" type="number" value="<?php echo $row_c['code_code'] ?>">
                </div>
                <!---------------->
                <div class="quantidade">
                    <label>Quantidade:</label>
                    <div class="div-qtd">
                        <div class="menos" onclick="menos()">-</div>
                        <input id="qtd" name="qtd" class="qtd" type="number" min="1" value="<?php echo $row_n['refuse_value']  ?>">
                        <div class="mais" onclick="mais()">+</div>
                    </div>
                </div>
                <!---------------->
                <input id="enviar" type="submit" value="Enviar">
                <!---------------->
            </form>
        </div>
        <!---------------->
    </div>
    <!---------------------------------------------------------------->
</body>

</html>

<?php /**ABRIR JANELA EDIT**/
if (isset($_REQUEST["id"]) && !isset($_REQUEST["prod"])) { ?>
    <script>
        let modal = document.getElementById('janela-edit');
        modal.style.display = 'flex';
    </script>
<?php } ?>

<script>
    /**FECHAR EDIT */
    function fecharEdit() {
        let modal = document.getElementById('janela-edit');
        modal.style.display = 'none';
        location.href = 'historico.php';
    }
</script>

<script>
    /**MAIS, MENOS, LIST**/
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
</script>

<script>
    /** MENSAGENS E MENSAGEM ERRO**/
    setTimeout(function() {
        $('#mensagem').hide(); // "foo" é o id do elemento que seja manipular.
    }, 2500); // O valor é representado em milisegundos.
    setTimeout(function() {
        $('#mensagemerro').hide(); // "foo" é o id do elemento que seja manipular.
    }, 2500); // O valor é representado em milisegundos.
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="js/datatable.js"></script>


<script> /* Datatable Admin com edições necessárias*/
    $(document).ready(function () {
        //Com responsividade e tradução
        $('#historico-tableAdmin').DataTable({
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
            }, "order": [[3, 'desc']]
        });
    });
</script>



