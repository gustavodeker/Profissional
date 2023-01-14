<?php
include("config/conexao.php");
sessionVerif();

if(isset($_POST['cod']) && isset($_POST['qtd'])){
    if(empty($_POST['cod']) or empty($_POST['qtd'])){
        $mensagemerro = "Todos os campos são obrigatórios!";
        $ultimocode = limpaPost($_POST['cod']);
        $ultimaqtd = $qtd = limpaPost($_POST['qtd']);
    } else {
        /* Dados coletados */
        $code = limpaPost($_POST['cod']);
        $qtd = limpaPost($_POST['qtd']);
        
        /* Coletando code_id */
        $sql_count = $pdo->prepare("SELECT COUNT(*) FROM codes WHERE code_code = '$code'");
        $sql_count->execute();
        $count_code = $sql_count->fetchColumn();

        if($count_code != 1){
            $mensagemerro = "Código incorreto!";
        }
        if($qtd < 1 or $qtd > 999){
            $mensagemerro = "Quantidade de 1 a 999!";
        }
        if ($count_code == 1 && $qtd > 0 && $qtd < 1000) {
            $sql_cod = $pdo->prepare("SELECT * FROM codes WHERE code_code = '$code'");
            $sql_cod->execute();
            $row_cod = $sql_cod->fetch(PDO::FETCH_ASSOC);
            $ultimocode = $row_cod["code_code"];

            /* Coletando user_id */
            global $user;
            $user = auth($_SESSION['TOKEN']);

            /* Dados coletados */
            $user_id = $user['user_id'];
            $code_id = $row_cod['code_id'];
            $date = date("Y-m-d H:i:s");

            try{
                $sqla = $pdo->prepare("INSERT INTO records VALUES (null,?,?,?,?)");
                $sqla->execute(array($user_id, $code_id, $qtd, $date));
                $mensagem = "Registrado com sucesso!";
            }catch(PDOException $erro){
                $mensagemerro = "Falha no banco de dados, contactar suporte!";
            }
        }
    }
}

function codTable()
{
    global $pdo;
    $sql = $pdo->prepare("SELECT * FROM codes");
    $sql->execute();
    $i = 1;
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        $ide = 'td' . $i;
        ?>
        <td class="tdcod" id='<?php echo $ide ?>' onclick="list('<?php echo $ide ?>')"><?php echo $row['code_code'] ?></td>
        <td class="tddesc" id='<?php echo $ide ?>' onclick="list('<?php echo $ide ?>')"><?php echo $row['code_desc'] ?></td>
        <?php
        $i++;
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

    <?php //mensagem
        if(isset($mensagem)){?>
            <div id="mensagem" class="mensagem">
                <?php echo "<p>" . $mensagem . "<p>"; ?>
            </div>
    <?php }?>

    <?php //mensagemerro
        if(isset($mensagemerro)){?>
            <div id="mensagemerro" class="mensagemerro">
                <?php echo "<p>" . $mensagemerro . "<p>"; ?>
            </div>
    <?php }?>
    
    <div id="corpo">
        <div id="div-registro">
            <p style="background: cornflowerblue; color: whitesmoke; text-align: center;">Selecione o código de problema na tabela</p>
            <table id="table-cod" >
                <thead>
                    <th>Cod</th>
                    <th class="th-desc">Descrição</th>
                </thead>
                <tbody>
                    <?php codTable(); ?>
                </tbody>
            </table>

            <form id="form-registro" method="POST">
                <div class="div-cod">
                    <label class="codigo">Código</label>
                    <input id="cod" name="cod" type="number"     value="<?php /* Para deixar último código usado selecionado*/ if (isset($ultimocode)){echo $ultimocode;} ?>">
                </div>
                
                <div class="div-qtd">
                    <label>Quantidade</label>
                    <div class="menos" onclick="menos()">-</div>
                    <input id="qtd" name="qtd" class="qtd" type="number" min="1"  value="<?php /* Para deixar último código usado selecionado*/ if (isset($ultimaqtd)){echo $ultimaqtd;} ?>" placeholder="">
                    <div class="mais" onclick="mais()">+</div>
                </div>
                <input id="enviar" type="submit" value="Enviar">
            </form>

        </div>

    </div>

</body>
</html>

<script>
	setTimeout(function () {
		$('#mensagem').hide(); // "foo" é o id do elemento que seja manipular.
	}, 2500); // O valor é representado em milisegundos.
    setTimeout(function () {
		$('#mensagemerro').hide(); // "foo" é o id do elemento que seja manipular.
	}, 2500); // O valor é representado em milisegundos.

</script>
<script>
    function menos(){
        var qtd = document.getElementById("qtd");
        if(qtd.value > 1){
            qtd.value--;
        }
    }
    function mais(){
        var qtd = document.getElementById("qtd");
        if(qtd.value < 999){
            qtd.value++;
        }
    }
    
    function list(td){
        var tede = document.getElementById(td).innerHTML;
        var input = document.getElementById("cod");
        input.value = tede;
    }
    
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>