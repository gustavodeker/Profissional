<?php
include("config/conexao.php");
sessionVerif();

if(isset($_POST["empresa"]) && isset($_POST["pessoa"]) && isset($_POST["email"]) && isset($_POST["desc"])){
    if (empty($_POST['empresa']) or empty($_POST['pessoa']) or empty($_POST['email']) or empty($_POST['desc'])) {
        echo "Todos os campos são obrigatórios !";
    } else {
        global $user;
        $user = auth($_SESSION['TOKEN']);
        $empresa = limpaPost($_POST['empresa']);
        $pessoa = limpaPost($_POST['pessoa']);
        $email = limpaPost($_POST['email']);
        $desc = limpaPost($_POST['desc']);

        try{  /*   MEXENDOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO  */
            $sql = $pdo->prepare("INSERT INTO chamados VALUES (null,?,?,?,?,?,default,'Aberto')");
            $sql->execute(array($empresa, $user['user_name'], $pessoa, $email, $desc));
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
    <link rel="stylesheet" href="css/suporte.css">
    <title>Próturbo :: Suporte</title>
    <style>
        p{
            color: black;
        }
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

<div class="divsup">
    <p>Aplicação desenvolvida por Highpot Tech, para dúvidas ou problemas tecnicos entre em contato por um dos seguintes meios de comunicação:</p>
    <p>Email: suporte@highpottech.com.br</p>
    <p>Whatsapp: (11) 97285-9138</p>
    <img src="img/highpot.png">
</div>

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