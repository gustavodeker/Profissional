<?php
include("config/conexao.php");

function verificaLogin()
{
    global $pdo;
    global $erro_login;
    //Receber os dados vindos do post e limpar
    $name = limpaPost($_POST['name']);
    $senha = limpaPost($_POST['senha']);
    $senha_cript = sha1($senha);

    //Verificar se existe o usuário no banco
    $sql = $pdo->prepare("SELECT * FROM users WHERE user_name =? AND user_pass =? LIMIT 1");
    $sql->execute(array($name, $senha_cript));
    $usuario = $sql->fetch(PDO::FETCH_ASSOC); //Para vir como matriz associativa, como tabela

    if($usuario){
        //Existe usuario
            //Criar um token
            $token = sha1(uniqid().date('d-m-Y-H-i-s'));
            //Atualizar o token deste usuario no banco
            $sql = $pdo->prepare("UPDATE users SET user_token=? WHERE user_name=? AND user_pass=?");
            if($sql->execute(array($token,$name,$senha_cript))){
            //Armazenar este token na sessão
            $_SESSION['TOKEN'] = $token;
            header('location: registro.php'); ?>
            <?php }
    }else{
        $erro_login = "Dados incorretos!";
    }
}

if(isset($_POST['name']) && isset($_POST['senha']) && !empty($_POST['name']) && !empty($_POST['senha'])){
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
                <img src="img/logo.png" alt="">

                <?php //Erro login
                    if(isset($erro_login)){?>
                        <div class="erro_login">
                            <?php echo "<p>" . $erro_login . "</p>"; ?>
                        </div>
                <?php }?>
                
                <label for="">Login: </label>
                <input class="input-login" name="name" type="text">
                <label for="">Senha:</label>
                <input class="input-login" name="senha" ype="password">
                <input class="btn-login" name="entrar" type="submit" value="Entrar">
            </form>
        </div>
    </main>
</body>
</html>