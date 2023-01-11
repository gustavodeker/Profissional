<?php
include("config/conexao.php");
sessionVerif();

?>
<!DOCTYPE html>
<html lang="pr-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/protegida.css">
    <title>Protegida</title>
</head>
<body>
    <header>
           <nav class='nav-menu'>
                <?php
                    global $user;
                    $user = auth($_SESSION['TOKEN']);
                    if ($user){?>
                        <a class='a-menu' id='botaologin' href='protegida.php'>Início</a>
                        <a class='a-menu' id='botaologin' href='cadastro.php'><?php /* echo $user['user_nome']*/ echo "Cadastro" ?></a>
                        <a class='a-menu sair' id='botaologin' href='logout.php'>Sair</a>
                    <?php }else{ ?>
                            <a class='a-menu login-menu' id='botaologin' href='../acesso/login.php'>Login</a>
                    <?php } ?>
           </nav>
    </header>
    <h1>Página protegida</h1>

    <form method="POST">
        <input type="text">
    </form>
</body>
</html>