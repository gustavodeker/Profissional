<?php
include("config/conexao.php");
sessionVerif();

if(isset($_POST['maquina']) && isset($_POST['motivo']) && isset($_POST['qtd'])){
    if(empty($_POST['maquina']) or empty($_POST['motivo']) or empty($_POST['qtd'])){
        $mensagemerro = "Todos os campos são obrigatórios!";
        $ultimaqtd = $qtd = limpaPost($_POST['qtd']);
        $ultimachine = limpaPost($_POST['maquina']);
    } else {
        /* Dados coletados */
        $machine = limpaPost($_POST['maquina']);
        $motivo = limpaPost($_POST['motivo']);
        $qtd = limpaPost($_POST['qtd']);
        
        if($qtd < 1 or $qtd > 999){
            $mensagemerro = "Quantidade de 1 a 999!";
        }
        if ($qtd > 0 && $qtd < 1000) {
            /* Coletando machine_id */
            $sql_machine = $pdo->prepare("SELECT * FROM machines WHERE machine_name = '$machine'");
            $sql_machine->execute();
            $row_machine = $sql_machine->fetch(PDO::FETCH_ASSOC);
            $machine_name = $row_machine['machine_name'];
            $ultimachine = $row_machine["machine_name"];

            /* Coletando user_id */
            global $user;
            $user = auth($_SESSION['TOKEN']);

            /* Dados coletados */
            $user_name = $user['user_name'];

            try{
                $sqla = $pdo->prepare("INSERT INTO prod VALUES (null,?,?,?,?,default,null,null)");
                $sqla->execute(array($user_name, $machine_name, $qtd, $motivo));

                $pesq = $pdo->prepare("SELECT prod_id FROM prod ORDER BY prod_datetime DESC LIMIT 1");
                $pesq->execute();
                $row_pesq = $pesq->fetch(PDO::FETCH_ASSOC);
                $prod_id = $row_pesq['prod_id'];

                $sqlb = $pdo->prepare("INSERT INTO gp VALUES (null,?,?,?,?,default,?)");
                $sqlb->execute(array($user['user_name'], $row_machine['machine_name'], $motivo, $qtd, $prod_id));
                $mensagem = "Registrado com sucesso!";
            }catch(PDOException $erro){
                $mensagemerro = "Falha no banco de dados, contactar suporte!".$erro;
            }
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
    <link rel="stylesheet" href="css/producao.css">
    <title>Próturbo :: Produção</title>
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
        <!--ALTERNAR
        <div id="alternar">
            <a class="hvr-float" style="border: 2px solid whitesmoke" id="btn-refuse" href="refugo.php">Refugo</a>
            <a class="hvr-float" style="border: 2px solid black" id="btn-production" href="producao.php">Produção</a>
        </div>
        -------------->
        <!--prod-->
        <div id="div-producao" class="animate__animated animate__fadeIn">
            <h1>PRODUÇÃO</h1>
            <p class="pform">O formulário de produção manual deve ser utilizado apenas quando for relatado problema no sistema automatizado.</p>
            <form id="form-producao" method="POST">
                <!---------------->
                <div class="div-maquina">
                    <label class="maquina">Máquina:</label>
                    <select class="hvr-float" id="maquina" name="maquina">
                        <option value="<?php /* Para deixar último código usado selecionado*/ if (isset($ultimachine)){echo $ultimachine;} ?>"><?php /* Para deixar último código usado selecionado*/ if (isset($ultimachine)){echo $ultimachine;} ?></option>
                        <?php machineOption(); ?>
                    </select>
                </div>
                <!---------------->
                <div class="div-motivo">
                    <label class="labelmotivo">Motivo:</label>
                    <textarea class="hvr-float" name="motivo" id="motivo" cols="auto" rows="5"></textarea>
                </div>
                <!---------------->
                <div class="div-qtd">
                    <label>Quantidade:</label>
                    <div class="menos hvr-float" onclick="menos()">-</div>
                    <input id="qtd" name="qtd" class="qtd hvr-float" type="number" min="1"  value="<?php /* Para deixar último código usado selecionado*/ if (isset($ultimaqtd)){echo $ultimaqtd;} ?>" placeholder="">
                    <div class="mais hvr-float" onclick="mais()">+</div>
                </div>
                <input id="enviar" class="hvr-float" type="submit" value="Enviar">
            </form>
        </div>
        <!---------------->
    </div>

</body>
</html>

<script>
  document.getElementById('form-producao').addEventListener('submit', function(event) {
    event.preventDefault();
    document.getElementById('enviar').setAttribute('disabled', 'disabled');
    this.submit();
  });
</script>

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