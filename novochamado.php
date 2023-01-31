<?php
include("config/conexao.php");
sessionVerif();

if(isset($_POST["empresa"]) && isset($_POST["pessoa"]) && isset($_POST["email"]) && isset($_POST["desc"])){
    if (empty($_POST['empresa']) or empty($_POST['pessoa']) or empty($_POST['email']) or empty($_POST['desc'])) {
        echo "Todos os campos são obrigatórios !";
    } else {
        $empresa = limpaPost($_POST['empresa']);
        $pessoa = limpaPost($_POST['pessoa']);
        $email = limpaPost($_POST['email']);
        $desc = limpaPost($_POST['desc']);

        try{  /*   MEXENDOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO  */
            $sql = $pdo->prepare("INSERT INTO chamados VALUES (null,?,?,?,?,default,null,null)");
            $sql->execute(array($empresa, $pessoa, $email, $desc));

            $pesq = $pdo->prepare("SELECT prod_id FROM prod ORDER BY prod_datetime DESC LIMIT 1");
            $pesq->execute();
            $row_pesq = $pesq->fetch(PDO::FETCH_ASSOC);
            $prod_id = $row_pesq['prod_id'];

            $sqlb = $pdo->prepare("INSERT INTO gp VALUES (null,?,?,?,?,default,?)");
            $sqlb->execute(array($user['user_name'], $row_machine['machine_name'], $motivo, $qtd, $prod_id));
            $mensagem = "Registrado com sucesso!";
        }catch(PDOException $erro){
            $mensagemerro = "Falha no banco de dados, contactar suporte!".$erro;
        }
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
    <title>Próturbo :: Suporte</title>
    <style>
        #novochamado{
            display: inline-block;
        }
        label,input,textarea{
            width: 100%;
        }
    </style>
</head>
<body>
<?php include_once("header.php") ?>

<form id="novochamado" class="novochamado" method="POST">
    <label for="empresa">Nome da empresa: </label>    
    <input name="empresa" type="text">

    <label for="pessoa">Seu nome: </label>    
    <input name="pessoa" type="text">

    <label for="email">E-mail: </label>    
    <input name="email" type="email">

    <label for="desc">Descrição do problema ou dúvida: </label>    
    <textarea name="desc" type="text"></textarea>

    <input type="submit" value="Abrir chamado">
</form>

</body>
</html>