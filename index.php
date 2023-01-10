<?php
include("config/conexao.php");

function verificaLogin()
{
    global $pdo;
    global $erro_login;
    //Receber os dados vindos do post e limpar
    $email = limpaPost($_POST['email']);
    $senha = limpaPost($_POST['senha']);
    $senha_cript = sha1($senha);

    //Verificar se existe o usuário no banco
    $sql = $pdo->prepare("SELECT * FROM user WHERE user_email =? AND user_senha =? LIMIT 1");
    $sql->execute(array($email,$senha_cript));
    $usuario = $sql->fetch(PDO::FETCH_ASSOC); //Para vir como matriz associativa, como tabela

    if($usuario){
        //Existe usuario
            //Criar um token
            $token = sha1(uniqid().date('d-m-Y-H-i-s'));
            //Atualizar o token deste usuario no banco
            $sql = $pdo->prepare("UPDATE user SET user_token=? WHERE user_email=? AND user_senha=?");
            if($sql->execute(array($token,$email,$senha_cript))){
            //Armazenar este token na sessão
            $_SESSION['TOKEN'] = $token;
            header('location: ../index.php'); ?>
            <?php }
    }else{
        $erro_login = "Dados incorretos!";
    }
}

if(isset($_POST['email']) && isset($_POST['senha']) && !empty($_POST['email']) && !empty($_POST['senha'])){
    verificaLogin();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <main class="main-login">
        <div class="div-login">
            <form class="form-login" method="POST">
                <h1 class="h1-login">System</h1>

                <?php //Erro login
                    if(isset($erro_login)){?>
                        <div class="erro-geral animate__animated animate__headShake">
                            <?php echo $erro_login; ?>
                        </div>
                <?php }?>

                <input class="input-login" name="email" placeholder="E-mail" type="text">
                <input class="input-login" name="senha" placeholder="Senha" type="password">
                <input class="btn-login" name="entrar" type="submit" value="Entrar">
            </form>
        </div>
    </main>
</body>
</html>