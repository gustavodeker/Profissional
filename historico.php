<?php
include("config/conexao.php");
sessionVerif();

function historicoTable()
{
    global $pdo;
    global $user;
    $user = auth($_SESSION['TOKEN']);
    if($user['user_level'] == 'admin'){
        $sql = $pdo->prepare("SELECT * FROM refuse");
    }else{
        $sql = $pdo->prepare("SELECT * FROM refuse WHERE refuse_user_id = '" . $user['user_id'] . "' ORDER BY refuse_time DESC LIMIT 10");
    }
    $sql->execute();
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $sql_machine = $pdo->prepare("SELECT machine_code FROM machines WHERE machine_id = '" . $row['refuse_machine_id'] . "'");
        $sql_machine->execute();
        $row_machine = $sql_machine->fetch(PDO::FETCH_ASSOC);

        $sql_code = $pdo->prepare("SELECT code_code FROM codes WHERE code_id = '" . $row['refuse_code_id'] . "'");
        $sql_code->execute();
        $row_code = $sql_code->fetch(PDO::FETCH_ASSOC);

        echo "<tr>";
        echo "<td>" . $row_machine['machine_code'] . "</td>";
        echo "<td>" . $row_code['code_code'] . "</td>";
        echo "<td>" . $row['refuse_value'] . "</td>";
        echo "<td>" . $row['refuse_time'] . "</td>";
        echo "<td class='tdeditar'><span class='material-icons' onclick=\"location.href='historico.php?page=historico&id=" . $row['refuse_id'] . "'\">
        edit
        </span></td>";
    }
}

function historicoProducaoTable()
{
    global $pdo;
    global $user;
    $user = auth($_SESSION['TOKEN']);
    if($user['user_level'] == 'admin'){
        $sql = $pdo->prepare("SELECT * FROM production");
    }else{
        $sql = $pdo->prepare("SELECT * FROM production WHERE production_user_id = '" . $user['user_id'] . "' ORDER BY production_time DESC LIMIT 10");
    }
    $sql->execute();
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $sql_machine = $pdo->prepare("SELECT machine_code FROM machines WHERE machine_id = '" . $row['production_machine_id'] . "'");
        $sql_machine->execute();
        $row_machine = $sql_machine->fetch(PDO::FETCH_ASSOC);
        echo "<tr>";
        echo "<td>" . $row_machine['machine_code'] . "</td>";
        echo "<td>" . $row['production_value'] . "</td>";
        echo "<td>" . $row['production_reason'] . "</td>";
        echo "<td>" . $row['production_time'] . "</td>";
        echo "<td class='tdeditar'><span class='material-icons' onclick=\"location.href='historico.php?page=historico&id=" . $row['production_id'] . "&prod=1'\">
        edit
        </span></td>";
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

function machineOption()
{   
    global $user;
    $user = auth($_SESSION['TOKEN']);
    global $pdo;
    if($user['user_level'] == 'admin'){
        $sql = $pdo->prepare("SELECT * FROM machines");
    } else{
        $sql = $pdo->prepare("SELECT * FROM machines WHERE machine_user_id = '".$user['user_id']."'");
    }
    $sql->execute();
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='". $row['machine_code']."'>". $row['machine_code']."</option>";
    }
}

/**EDITAR**/
if (isset($_REQUEST["id"])) {
    include("editar.php");
}
/**EDITAR**/
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Próturbo :: Histórico</title>
    <link rel="stylesheet" href="css/geral.css">
    <link rel="stylesheet" href="css/historico.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>
        .nav_tabs{
            max-width: 500px;
            height: 700px;
            margin: auto;
            display: flex;
            justify-content: center;
            position: relative;
        }
        .nav_tabs ul{
            list-style: none;
        }
        .nav_tabs ul li{
            float: left;
        }
        .nav_tabs label{
            cursor: pointer;
            padding: 10px;
            background-color: #004479;
            display: block;
            text-align: center;
            color: whitesmoke;
            border: 2px solid whitesmoke;
        }
        .rd_tabs:checked ~ label{
            background-color: #004486;
            border: 2px solid black;
        }
        .rd_tabs{
            display: none;
        }
        .content{
            display: none;
            justify-content: center;
            position: absolute;
            height: 600px;
            max-width: 600px;
            left: 0;
        }
        .rd_tabs:checked ~ .content{
            display: flex;
        }
    </style>
</head>

<body>
    <?php include_once("header.php") ?>
    
    <!---------------------------------------------------------------->
    <nav class="nav_tabs">
        <ul>
            <li>
                <input type="radio" name="tabs" class="rd_tabs" id="tab1" checked>
                <label for="tab1">Refugo</label>
                <div class="content">
                    <!---------------------------------------------------------------->
                    <div id="divt">
                        <table id="historico-table">
                            <thead>
                                <th>Máquina</th>
                                <th>Código</th>
                                <th>Qtd</th>
                                <th>Horário</th>
                                <th id="theditar">Editar</th>
                            </thead>
                            <tbody>
                                <?php
                                    historicoTable();
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!---------------------------------------------------------------->
                </div>
            </li>
            <li>
                <input type="radio" name="tabs" class="rd_tabs" id="tab2">
                <label for="tab2">Produção</label>
                <div class="content">
                    <!---------------------------------------------------------------->
                    <div id="divt">
                        <table id="historico-table">
                            <thead>
                                <th>Máquina</th>
                                <th>Qtd</th>
                                <th>Motivo</th>
                                <th>Horário</th>
                                <th id="theditar">Editar</th>
                            </thead>
                            <tbody>
                                <?php
                                    historicoProducaoTable();
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!---------------------------------------------------------------->
                </div>
            </li>
        </ul>
    
    </nav>
    <!---------------------------------------------------------------->


    <div class="janela-edit" id="janela-edit">
        <!---------------->
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
                <!---------------->
        <div id="div-refuse">
            <button class="fechar" id="fechar" onclick="fecharEdit()">X</button>
            
            <form id="form-refuse" method="POST">
                <h1>EDITAR</a></h1>
                
                <div class="div-maquina">
                    <label class="maquina">Máquina:</label>
                    <select id="maquina" name="maquina">
                        <option value="<?php echo $row_m["machine_code"] ?>"><?php echo $row_m["machine_code"] ?></option>
                        <?php machineOption(); ?>
                    </select>
                </div>
                <!---------------->
                <p style="background: #004479; color: whitesmoke; text-align: center;">Selecione o código na tabela</p>
                <table id="table-cod">
                    <thead>
                        <th>Cod</th>
                        <th class="th-desc">Descrição</th>
                    </thead>
                    <tbody>
                        <?php codTable(); ?>
                    </tbody>
                </table>
                <!---------------->
                <div class="div-cod">
                    <label class="codigo">Selecionado:</label>
                    <input id="cod" name="cod" type="number" value="<?php echo $row_c['code_code']?>">
                </div>
                <!---------------->
                <div class="quantidade">
                    <label>Quantidade:</label>
                    <div class="div-qtd">
                        <div class="menos" onclick="menos()">-</div>
                        <input id="qtd" name="qtd" class="qtd" type="number" min="1" value="<?php echo $row_n['refuse_value']  ?>">
                        <div class="mais" onclick="mais()">+</div>
                    </div>
                </div>
                <!---------------->
                <input id="enviar" type="submit" value="Enviar">
                <!---------------->
            </form>
        </div>
        <!---------------->
    </div>
    <!---------------------------------------------------------------->

</body>

</html>

<?php
if (isset($_REQUEST["id"])) { ?>
    <script>
        let modal = document.getElementById('janela-edit');
        modal.style.display = 'flex';
    </script>
<?php } ?>

<?php
if (isset($_REQUEST["prod"])) { ?>
    <script>
        let modal = document.getElementById('janela-edit');
        modal.style.display = 'flex';
    </script>
<?php } ?>

<script>
    /**FECHAR EDIT */
    function fecharEdit() {
        let modal = document.getElementById('janela-edit');
        modal.style.display = 'none';
        location.href = 'historico.php';
    }
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
<script>
	setTimeout(function () {
		$('#mensagem').hide(); // "foo" é o id do elemento que seja manipular.
	}, 2500); // O valor é representado em milisegundos.
    setTimeout(function () {
		$('#mensagemerro').hide(); // "foo" é o id do elemento que seja manipular.
	}, 2500); // O valor é representado em milisegundos.

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


