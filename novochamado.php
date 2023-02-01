<?php
include("config/conexao.php");
sessionVerif();

if (isset($_POST["empresa"]) && isset($_POST["pessoa"]) && isset($_POST["email"]) && isset($_POST["desc"])) {
    if (empty($_POST['empresa']) or empty($_POST['pessoa']) or empty($_POST['email']) or empty($_POST['desc'])) {
        echo "Todos os campos são obrigatórios !";
    } else {
        global $user;
        $user = auth($_SESSION['TOKEN']);
        $empresa = limpaPost($_POST['empresa']);
        $pessoa = limpaPost($_POST['pessoa']);
        $email = limpaPost($_POST['email']);
        $desc = limpaPost($_POST['desc']);

        try {
            $sql = $pdo->prepare("INSERT INTO chamados VALUES (null,?,?,?,?,?,default,'Aberto')");
            $sql->execute(array($empresa, $user['user_name'], $pessoa, $email, $desc));
            $mensagem = "Registrado com sucesso!";
        } catch (PDOException $erro) {
            $mensagemerro = "Falha no banco de dados, contactar suporte!" . $erro;
        }
    }
}

function chamadosTable()
{
    global $pdo;
    global $user;
    $user = auth($_SESSION['TOKEN']);
    if ($user['user_level'] == 'admin') {
        $sql = $pdo->prepare("SELECT * FROM chamados");
    } else {
        $sql = $pdo->prepare("SELECT * FROM chamados WHERE chamados_user_name = '" . $user['user_name'] . "' ORDER BY chamados_datetime DESC LIMIT 10");
    }
    $sql->execute();
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['chamados_id'] . "</td>";
        echo "<td>" . $row['chamados_pessoa'] . "</td>";
        echo "<td>" . $row['chamados_email'] . "</td>";
        echo "<td>" . $row['chamados_datetime'] . "</td>";
        echo "<td>" . $row['chamados_status'] . "</td>";
        echo "<td class='tdeditar'><span class='material-icons hvr-float' onclick=\"location.href='novochamado.php?page=novochamado&id=" . $row['chamados_id'] . "'\">
        Botão
        </span></td>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/geral.css">
    <link rel="stylesheet" type="text/css" href="css/datatableChamado.css" />
    <title>Próturbo :: Suporte</title>
    <style>
        body {
            overflow: hidden;
        }
        #novochamado{
            display: flex;
            flex-wrap: wrap;
            width: 350px;
            padding: 5px;
        }
        label{
            width: 40%;
        }
        input{
            width: 60%;
        }
        input[Type="submit"]{
            width: 100%;
            padding: 10px;
        }
        .corpo {
            padding: 5%;
            overflow: hidden;
            height: 90vh;
        }
        .divchamados {
            height: 400px;
            padding: 5px;
            overflow-y: auto;
        }
        .wd100{
            width: 100%;
        }
    </style>
</head>

<body>

    <?php include_once("header.php") ?>

    <div class="corpo">
        <form id="novochamado" class="novochamado" method="POST">
            <label for="empresa">Nome da empresa: </label>
            <input name="empresa" type="text">

            <label for="pessoa">Seu nome: </label>
            <input name="pessoa" type="text">

            <label for="email">E-mail: </label>
            <input name="email" type="email">

            <label class="wd100" for="desc">Descrição do problema ou dúvida: </label>
            <textarea class="wd100" name="desc" type="text" rows="5"></textarea>

            <input type="submit" value="Abrir chamado">
        </form>

        <div class="divchamados">
            <table id="chamadosTable">
                <thead>
                    <th>Ticket#</th>
                    <th>Pessoa</th>
                    <th>E-mail</th>
                    <th>Data</th>
                    <th>Status</th>
                    <th id="theditar">Responder</th>
                </thead>
                <tbody>
                    <?php
                    chamadosTable();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/ju/dt-1.13.1/r-2.4.0/datatables.min.js"></script>

<script src="js/datatable.js"></script>


<script>
    /* Datatable Admin com edições necessárias*/
    $(document).ready(function() {
        //Com responsividade e tradução
        $('#chamadosTable').DataTable({
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
                [3, 'desc']
            ]
        });
    });
</script>