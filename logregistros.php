<?php include_once("config/conexao.php");
sessionVerif();
sessionVerifAdmin();

function indexTable()
{
    global $pdo;
    $sql = $pdo->prepare("SELECT * FROM registro");
    $sql->execute();
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['registro_nome'] . "</td>";
        echo "<td>" . $row['registro_setor'] . "</td>";
        echo "<td>" . $row['registro_servico'] . "</td>";
        echo "<td>" . $row['registro_desc'] . "</td>";
        echo "<td>" . $row['registro_data'] . "</td>";
        echo "<td><span class='material-icons' onclick=\"location.href='logregistros.php?page=logregistros&id=" . $row['registro_id'] . "'\">
        edit
        </span></td>";
        echo "<td><span class='material-icons'>delete</span></td>";
    }
}
 /**EDITAR**/
if(isset($_REQUEST["id"])){
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
    <title>Registros</title>
    <link rel="stylesheet" href="css/geral.css">
    <link rel="stylesheet" href="css/logregistros.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">

</head>
<body>
    <?php include_once("header.php") ?>
<!---------------------------------------------------------------->
    <div id="divt">
        <table id="index-table">
            <thead>
                <th>Nome</th>
                <th>Setor</th>
                <th>Serviço</th>
                <th>Descrição</th>
                <th>Data</th>
                <th>#</th>
                <th>#</th>
            </thead>
            <tbody>
                <?php
                    indexTable();
                ?>
            </tbody>
        </table>
    </div>
<!---------------------------------------------------------------->
    <div class="janela-edit" id="janela-edit">    
    <div class="modal-novo">
    <button class="fechar" id="fechar" onclick="fecharEdit()">X</button>
        <form id="form-novo" class="form-novo" method="POST" action="">
            <?php // Mensagem de erro ou sucesso
            if (isset($erro_geral)) { ?>
            <div class="erro-geral animate__animated animate__headShake">
                <?php echo $erro_geral; ?>
            </div>
            <?php } else if (isset($sucesso)) { ?>
            <div class="sucesso animate__animated animate__headShake">
                <?php echo $sucesso; ?>
            </div>
            <?php } ?>
                <div class="form-item">
                    <label>Nome: </label>
                    <input type="text" name="nome" id="nome" value="<?php echo $row_n['registro_nome'] ?>">
                </div>

                <div class="form-item">
                    <label>Setor: </label>
                    <input type="text" name="setor" id="setor" value="<?php echo $row_n['registro_setor'] ?>">
                </div>

                <div class="form-item">
                    <label>Serviço: </label>
                    <input type="text" name="servico" id="servico" value="<?php echo $row_n['registro_servico'] ?>">
                </div>

                <div class="form-item">
                    <label>Descrição: </label>
                    <input type="text" name="desc" id="desc" value="<?php echo $row_n['registro_desc'] ?>">
                </div>
    
                <input class="btn-editar" type="submit" id="submit" value="Editar"></input>
        </form>
    </div>
</div>
<!---------------------------------------------------------------->
</body>
</html>

<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script> /* Datatable index com edições necessárias*/
    $(document).ready(function () {
        //Com responsividade e tradução
        $('#index-table').DataTable({
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
            }, "order": [[3, 'desc']/*QTD AVALIAÇÕES*/, [2, 'desc']/*MÉDIA AVALIAÇÕES*/]
        });
    });

</script>