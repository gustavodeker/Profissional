<?php
include("config/conexao.php");
/*sessionVerif();
sessionVerifAdmin();*/

//Verificar se a postagem existe de acordo com os campos
if(isset($_POST['nome']) && isset($_POST['senha']) && isset($_POST['level'])){
    //Verificar se todos os campos foram preenchidos
    if(empty($_POST['nome']) or empty($_POST['senha']) or empty($_POST['level'])){
        $erro_geral = "Todos os campos são obrigatórios!";
    }else{
        //Receber e limpar dados do post
        $nome = limpaPost($_POST['nome']);
        $user = limpaPost($_POST['user']);
        $senha = limpaPost($_POST['senha']);
        $level = limpaPost($_POST['level']);
        $senha_cript = sha1($senha);

        //Verificação individual de campos
        //Nome
        if (!preg_match('/^[A-Za-z0-9-]+$/',$nome)) {
            $erro_nome = "Apenas letras e números";
        }
        //Senha
        if(strlen($senha) < 6){
            $erro_senha = "Senha devo ter 6 caracteres ou mais!";
        }
        //Level
        if(!$level == "admin" or !$level == "user"){
            $erro_senha = "Selecione user ou admin";
        }

        if(!isset($erro_geral) && !isset($erro_nome) && !isset($erro_senha) && !isset($erro_level)){
            //Verificar se o usuário já está cadastrado
            $sql = $pdo->prepare("SELECT * FROM users WHERE user_name=? or user_login=? ");
            $sql->execute(array($nome));
            $usuario = $sql->fetch();

            if(!$usuario){
                $sql = $pdo->prepare("INSERT INTO users VALUES (null,?,?,?,null)");
                $sql->execute(array($nome, $senha_cript, $level));
                $erro_geral = "Cadastrado com sucesso !";
            }else{
                $erro_geral = "Nome de máquina já cadastrado!";
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
    <?php /* include_once("header.php") */ ?>
    <div id="corpo">
        <div id="div-cadastro">
            <form id="form-cadastro" method="POST">
                <h2 id="h1-login">Cadastrar máquinas</h2>

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

                <div id="input-label">
                    <label for="">User: </label>
                    <input name="user" placeholder="User" type="text">
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

                <?php //Erro $erro_level
                    if(isset($erro_level)){?>
                        <div id="erro-geral animate__animated animate__headShake">
                            <?php echo $erro_level; ?>
                        </div>
                <?php }?>
                <div id="input-label">
                    <label for="">Level: </label>
                    <select name="level">
                        <option value="user">user</option>
                        <option value="admin">admin</option>
                    </select>
                </div>
                <input id="cadastrar" name="cadastrar" type="submit" value="Cadastrar">
            </form>
        </div>
    </div>
</body>
</html>