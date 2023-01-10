<?php
include("config/conexao.php");

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro     </title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <main class="main-login">
        <div class="div-login">
            <form class="form-login" method="POST">
                <h1 class="h1-login">Cadastro</h1>

                <?php //Erro login
                    if(isset($erro_login)){?>
                        <div class="erro-geral animate__animated animate__headShake">
                            <?php echo $erro_login; ?>
                        </div>
                <?php }?>
                <input class="input-login" name="nome" placeholder="Nome" type="text">
                <input class="input-login" name="email" placeholder="E-mail" type="text">
                <input class="input-login" name="senha" placeholder="Senha" type="password">
                <input class="btn-login" name="entrar" type="submit" value="Entrar">
            </form>
        </div>
    </main>
</body>
</html>