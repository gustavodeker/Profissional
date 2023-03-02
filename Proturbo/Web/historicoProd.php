<?php
include("config/conexao.php");
sessionVerif();


function historicoProducaoTable()
{
    global $pdo;
    global $user;
    $user = auth($_SESSION['TOKEN']);
    if ($user['user_level'] == 'admin') {
        $sql = $pdo->prepare("SELECT * FROM prod");
    } else {
        $sql = $pdo->prepare("SELECT * FROM prod WHERE prod_user_name = '" . $user['user_name'] . "' ORDER BY prod_datetime DESC LIMIT 10");
    }
    $sql->execute();
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['prod_machine_name'] . "</td>";
        echo "<td>" . $row['prod_value'] . "</td>";
        echo "<td>" . $row['prod_reason'] . "</td>";
        echo "<td>" . $row['prod_datetime'] . "</td>";
        echo "<td class='tdeditar'><span class='material-icons hvr-float' onclick=\"location.href='historicoProd.php?page=historicoProd&id=" . $row['prod_id'] . "'\">
        edit
        </span></td>";
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
    <div class="main">
    <!---------------------------------------------------------------->
    <div class="div-alternar">
        <a class="btn-alternar hvr-float" href="historico.php">Refugo</a>
        <a style="border: 2px solid whitesmoke; border-radius: 3px;" class="btn-alternar hvr-float" href="historicoProd.php">Produção</a>
    </div>
    <!---------------------------------------------------------------->
    <div id="divt" class="animate__animated animate__fadeIn">
        <table id="historico-tableAdmin">
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


    <div class="janela-editProd animate__animated animate__fadeIn" id="janela-editProd">
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
        <!--prod-->
        <div id="div-producao">
        <button class="fechar" id="fechar" onclick="fecharEditProd()">X</button>

            <h1>EDITAR</h1>
            <form id="form-producao" method="POST">
                <!---------------->
                <div class="div-maquina">
                    <label class="maquina">Máquina:</label>
                    <select class="hvr-float" id="maquina" name="maquina">
                        <option><?php echo $row_n["prod_machine_name"]; ?></option>
                        <?php machineOption(); ?>
                    </select>
                </div>
                <!---------------->
                <div class="div-motivo">
                    <label class="labelmotivo">Motivo:</label>
                    <textarea class="hvr-float" name="motivo" id="motivo" cols="auto" rows="5"><?php echo $row_n["prod_reason"]; ?></textarea>
                </div>
                <!---------------->
                <div class="quantidade">
                        <label>Quantidade:</label>
                        <div class="div-qtd">
                            <div class="menos hvr-float" onclick="menos()">
                                <p>-</p>
                            </div>
                            <input id="qtd" name="qtd" class="qtd hvr-float" type="number" min="1" value="<?php echo $row_n['prod_value']  ?>">
                            <div class="mais hvr-float" onclick="mais()">+</div>
                        </div>
                    </div>
                <input id="enviar" class="hvr-float" type="submit" value="Enviar">
            </form>
        </div>
        <!---------------->
        <!---------------->
    </div>
    <!---------------------------------------------------------------->



    </div>

    <?php include('footer.php'); ?>
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