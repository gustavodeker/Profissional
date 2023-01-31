<?php
include("config/conexao.php");
sessionVerif();
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

</body>
</html>