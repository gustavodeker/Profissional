<?php
include("config/conexao.php");
sessionVerif();


function historicoProducaoTable()
{
    global $pdo;
    global $user;
    $user = auth($_SESSION['TOKEN']);
    if ($user['user_level'] == 'admin') {
        $sql = $pdo->prepare("SELECT * FROM production");
    } else {
        $sql = $pdo->prepare("SELECT * FROM production WHERE production_user_id = '" . $user['user_id'] . "' ORDER BY production_time DESC LIMIT 10");
    }
    $sql->execute();
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $sql_machine = $pdo->prepare("SELECT machine_code FROM machines WHERE machine_id = '" . $row['production_machine_id'] . "'");
        $sql_machine->execute();
        $row_machine = $sql_machine->fetch(PDO::FETCH_ASSOC);
        echo "<tr>";
        echo "<td>" . $row_machine['machine_code'] . "</td>";
        echo "<td>" . $row['production_value'] . "</td>";
        echo "<td>" . $row['production_reason'] . "</td>";
        echo "<td>" . $row['production_time'] . "</td>";
        echo "<td class='tdeditar'><span class='material-icons' onclick=\"location.href='historicoProd.php?page=historicoProd&id=" . $row['production_id'] . "'\">
        edit
        </span></td>";
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
if (isset($_REQUEST["id"])) {
    include("editarProd.php");
}
/**EDITAR**/
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Próturbo :: Histórico Produção</title>
    <link rel="stylesheet" href="css/geral.css">
    <link rel="stylesheet" href="css/historico.css">
    <link rel="stylesheet" href="css/datatable.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <?php include_once("header.php") ?>

    <!---------------------------------------------------------------->
    <div class="div-alternar">
        <a class="btn-alternar" href="historico.php">Refugo</a>
        <a style="border: 2px solid black; border-radius: 3px;" class="btn-alternar" href="historicoProd.php">Produção</a>
    </div>
    <!---------------------------------------------------------------->
    <div id="divt">
        <h2>Histórico Produção</h2>
        <table id="<?php if ($user['user_level'] == 'admin') {
        echo "historico-tableAdmin";}else{ echo "historico-table";} ?>">
            <thead>
                <th>Máquina</th>
                <th>Qtd</th>
                <th>Motivo</th>
                <th>Horário</th>
                <th id="theditar">Editar</th>
            </thead>
            <tbody>
                <?php
                    historicoProducaoTable();
                ?>
            </tbody>
        </table>
    </div>
    <!---------------------------------------------------------------->

    <!---------------------------------------------------------------->


    <div class="janela-editProd" id="janela-editProd">
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
        <!--PRODUCTION-->
        <div id="div-producao">
        <button class="fechar" id="fechar" onclick="fecharEditProd()">X</button>

            <h1>EDITAR</h1>
            <form id="form-producao" method="POST">
                <!---------------->
                <div class="div-maquina">
                    <label class="maquina">Máquina:</label>
                    <select id="maquina" name="maquina">
                        <option value="<?php echo $row_m["machine_code"]; ?>"><?php echo $row_m["machine_code"]; ?></option>
                        <?php machineOption(); ?>
                    </select>
                </div>
                <!---------------->
                <div class="div-motivo">
                    <label class="labelmotivo">Motivo:</label>
                    <textarea name="motivo" id="motivo" cols="auto" rows="5"><?php echo $row_n["production_reason"]; ?></textarea>
                </div>
                <!---------------->
                <div class="div-qtd">
                    <label>Quantidade:</label>
                    <div class="menos" onclick="menos()">-</div>
                    <input id="qtd" name="qtd" class="qtd" type="number" min="1" value="<?php echo $row_n['production_value'] ?>">
                    <div class="mais" onclick="mais()">+</div>
                </div>
                <input id="enviar" type="submit" value="Enviar">
            </form>
        </div>
        <!---------------->
        <!---------------->
    </div>
    <!---------------------------------------------------------------->

</body>

</html>

<?php /**ABRIR JANELA EDITPROD**/
if (isset($_REQUEST["id"])) { ?>
    <script>
        let modal = document.getElementById('janela-editProd');
        modal.style.display = 'flex';
    </script>
<?php } ?>

<script>
    /**FECHAR EDITPROD */
    function fecharEditProd() {
        let modal = document.getElementById('janela-editProd');
        modal.style.display = 'none';
        location.href = 'historicoProd.php';
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