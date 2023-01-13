<?php
include("config/conexao.php");
sessionVerif();

if(isset($_POST['nome']) && isset($_POST['setor']) && isset($_POST['servico']) && isset($_POST['desc'])){
    if(empty($_POST['nome']) or empty($_POST['setor']) or empty($_POST['servico']) or empty($_POST['desc'])){
        $mensagem = "Todos os campos são obrigatórios!";
    } else {
        $nome = limpaPost($_POST['nome']);
        $setor = limpaPost($_POST['setor']);
        $servico = limpaPost($_POST['servico']);
        $desc = limpaPost($_POST['desc']);
        $data = date("Y-m-d H:i:s");
        try{
            $sql = $pdo->prepare("INSERT INTO registro VALUES (null,?,?,?,?,?)");
            $sql->execute(array($nome, $setor, $servico, $desc, $data));
            $mensagem = "---------- Registrado com sucesso! ----------";
        }catch(PDOException $erro){
            echo "Falha no banco de dados";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="pr-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/geral.css">
    <link rel="stylesheet" href="css/registro.css">
    <title>Registro</title>
</head>
<body>
    <?php include_once("header.php") ?>
    
    <div id="corpo">

        <div id="div-registro">

            <form id="form-registro" method="POST">
                
                <div class="div-cod">
                    <label class="cod">Código</label>
                    <input class="cod" type="text">
                </div>
                
                <div class="div-qtd">
                    <label>Quantidade</label>
                    <div class="menos" onclick="menos()">-</div>
                    <input id="qtd" class="qtd" type="text" value="1" disabled="">
                    <div class="mais" onclick="mais()">+</div>
                </div>
                <input id="enviar" type="submit" value="Enviar">

            </form>

        </div>

    </div>

</body>
</html>



<script>
    function menos(){
        var qtd = document.getElementById("qtd");
        if(qtd.value > 1){
            qtd.value--;
        }
    }
    function mais(){
        var qtd = document.getElementById("qtd");
        qtd.value++;
    }
    
</script>
<?php //Erro geral
if(isset($mensagem)){?>
                        <div class="erro-geral animate__animated animate__headShake">
                            <?php echo $mensagem; ?>
                        </div>
<?php }?>