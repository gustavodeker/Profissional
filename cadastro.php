<?php
include("config/conexao.php");
sessionVerif();
sessionVerifAdmin();

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
    <link rel="stylesheet" href="css/geral.css">
    <link rel="stylesheet" href="css/cadastro.css">
</head>
<body>
    <?php include_once("header.php") ?>
    <div id="corpo">
        <div id="div-cadastro">
            <form id="form-cadastro" method="POST">
                <h2 id="h1-login">Cadastrar acesso de cliente</h2>

                <?php //Erro $erro_geral
                    if(isset($erro_geral)){?>
                        <div id="erro-geral animate__animated animate__headShake">
                            <?php echo $erro_geral; ?>
                        </div>
                <?php }?>

                <?php //Erro $erro_nome
                    if(isset($erro_nome)){?>
                        <div id="erro-geral animate__animated animate__headShake">
                            <?php echo $erro_nome; ?>
                        </div>
                <?php }?>
                <div id="input-label">
                    <label for="">Nome: </label>
                    <input name="nome" placeholder="Nome" type="text">
                </div>

                <?php //Erro $erro_email
                    if(isset($erro_email)){?>
                        <div id="erro-geral animate__animated animate__headShake">
                            <?php echo $erro_email; ?>
                        </div>
                <?php }?>
                <div id="input-label">
                    <label for="">E-mail: </label>
                    <input name="email" placeholder="E-mail" type="text">
                </div>

                <?php //Erro $erro_senha
                    if(isset($erro_senha)){?>
                        <div id="erro-geral animate__animated animate__headShake">
                            <?php echo $erro_senha; ?>
                        </div>
                <?php }?>
                <div id="input-label">
                    <label for="">Senha: </label>
                    <input name="senha" placeholder="Senha" type="password">
                </div>
                <input id="cadastrar" name="cadastrar" type="submit" value="Cadastrar">
            </form>
        </div>
    </div>
</body>
</html>