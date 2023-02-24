<?php 
include('config/conexao.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TESTE</title>
</head>
<body>
    <form action="" method="post"></form>
    <label for="pesquisa">Pesquisar: </label>
    <input type="text" name="pesquisa" id="pesquisa">

    <div class="divPn">
                    <table id="table-pn">
                        <p style="background: #004479; color: whitesmoke; text-align: center;">PARTNUMBER:</p>
                        <thead>
                            <th>PN</th>
                            <th class="th">Descrição</th>
                        </thead>
                        <tbody class="resultado">

                        </tbody>
                    </table>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="js/pesquisa.js"></script>


























</body>
</html>