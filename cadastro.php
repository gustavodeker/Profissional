<?php
include("config/conexao.php");

//Verificar se a postagem existe de acordo com os campos
if(isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha'])){
    //Verificar se todos os campos foram preenchidos
    if(empty($_POST['nome']) or empty($_POST['email']) or empty($_POST['senha'])){
        $erro_geral = "Todos os campos são obrigatórios!";
    }else{
        //Receber e limpar dados do post
        $nome = limpaPost($_POST['nome']);
        $email = limpaPost($_POST['email']);
        $senha = limpaPost($_POST['senha']);
        $senha_cript = sha1($senha);

        //Verificação individual de campos
        //Nome
        if (!preg_match("/^[a-zA-Z-' ]*$/",$nome)) {
            $erro_nome = "Apenas letras e espaços";
        }
        //Email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erro_email = "Fomato de e-mail inválido";
        }
        //Senha
        if(strlen($senha) < 6){
            $erro_senha = "Senha devo ter 6 caracteres ou mais!";
        }

        if(!isset($erro_geral) && !isset($erro_nome) && !isset($erro_email) && !isset($erro_senha)){
            //Verificar se o usuário já está cadastrado
            $sql = $pdo->prepare("SELECT * FROM user WHERE user_email=? ");
            $sql->execute(array($email));
            $usuario = $sql->fetch();

            if(!$usuario){
                $nivel ="";
                $token="";
                $sql = $pdo->prepare("INSERT INTO user VALUES (null,?,?,?,?,?)");
                $sql->execute(array($nome, $email, $senha_cript,$nivel, $token));
                header('Location: index.php');
            }else{
                $erro_geral = "E-mail já cadastrado";
            }
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
    <title>Cadastro</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/protegida.css">
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

    <main class="main-login">
        <div class="div-login">
            <form class="form-login" method="POST">
                <h1 class="h1-login">Cadastro</h1>

                <?php //Erro $erro_geral
                    if(isset($erro_geral)){?>
                        <div class="erro-geral animate__animated animate__headShake">
                            <?php echo $erro_geral; ?>
                        </div>
                <?php }?>
                <input class="input-login" name="nome" placeholder="Nome" type="text">
                <input class="input-login" name="email" placeholder="E-mail" type="text">
                <input class="input-login" name="senha" placeholder="Senha" type="password">
                <input class="btn-login" name="cadastrar" type="submit" value="Cadastrar">
            </form>
        </div>
    </main>
</body>
</html>