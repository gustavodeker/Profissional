<?php
$cab = [''];
$arqCsv = '';
$agora = '';

if(!empty($_POST['maquina'])){
    $maquina = $_POST['maquina'];
}

if (!empty($_POST["datetimeI"])){
    $valorI = $_POST["datetimeI"];
    // Cria um objeto DateTime a partir da string
    $datahoraI = DateTime::createFromFormat("Y-m-d\TH:i", $valorI);
    // Formata o objeto DateTime como uma string no formato apropriado para inserção no banco de dados MySQL
    $datahoraI_mysql = $datahoraI->format("Y-m-d H:i:s");
}

if (!empty($_POST["datetimeF"])){
    $valorF = $_POST["datetimeF"];
    // Cria um objeto DateTime a partir da string
    $datahoraF = DateTime::createFromFormat("Y-m-d\TH:i", $valorF);
    // Formata o objeto DateTime como uma string no formato apropriado para inserção no banco de dados MySQL
    $datahoraF_mysql = $datahoraF->format("Y-m-d H:i:s");
}

//Corpos
function corpoAllProducao()
{
    global $cab;
    global $arqCsv;
    global $download;
    global $datahoraI_mysql;
    global $datahoraF_mysql;
    global $maquina;

    $a = 'allProducao';
    //Vazio
    if (empty($_POST['maquina']) && !isset($datahoraI_mysql) && !isset($datahoraF_mysql)) {
        $sqll = "SELECT * FROM prod";
    }
    //Máquina
    if(!empty($_POST['maquina']) && !isset($datahoraI_mysql) && !isset($datahoraF_mysql)){
        $sqll = "SELECT * FROM prod WHERE prod_machine_name = '$maquina'";
    }
    //Máquina+Início
    if(!empty($_POST['maquina']) && isset($datahoraI_mysql) && !isset($datahoraF_mysql)){
        $sqll = "SELECT * FROM prod WHERE prod_machine_name = '$maquina' AND prod_datetime >= '$datahoraI_mysql'";
    }
    //Máquina+Início+Fim
    if(!empty($_POST['maquina']) && isset($datahoraI_mysql) && isset($datahoraF_mysql)){
        $sqll = "SELECT * FROM prod WHERE prod_machine_name = '$maquina' AND prod_datetime >= '$datahoraI_mysql' AND prod_datetime <= '$datahoraF_mysql'";
    }
    //Máquina+Fim
    if(!empty($_POST['maquina']) && !isset($datahoraI_mysql) && isset($datahoraF_mysql)){
        $sqll = "SELECT * FROM prod WHERE prod_machine_name = '$maquina' AND prod_datetime <= '$datahoraF_mysql'";
    }
    //Início
    if(empty($_POST['maquina']) && isset($datahoraI_mysql) && !isset($datahoraF_mysql)){
        $sqll = "SELECT * FROM prod WHERE prod_datetime >= '$datahoraI_mysql'";
    }
    //Fim
    if(empty($_POST['maquina']) && !isset($datahoraI_mysql) && isset($datahoraF_mysql)){
        $sqll = "SELECT * FROM prod WHERE prod_datetime <= '$datahoraF_mysql'";
    }
    //Início+Fim
    if(empty($_POST['maquina']) && isset($datahoraI_mysql) && isset($datahoraF_mysql)){
        $sqll = "SELECT * FROM prod WHERE prod_datetime >= '$datahoraI_mysql' AND prod_datetime <= '$datahoraF_mysql'";
    }

    $cab = ['Maquina', 'Quantidade', 'Data'];
    $now = date("d-m-Y_H-i-s");
    $agora = 'Producao_'.$now.'.csv';
    $arqCsv = $agora;
    $download = $arqCsv;
    exibir($sqll, $a);
    gerarCsv($sqll);
}
function corpoAllRefugo()
{
    global $cab;
    global $arqCsv;
    global $download;
    global $datahoraI_mysql;
    global $datahoraF_mysql;
    global $maquina;
    global $agora;

    $a = 'allRefugo';
    //Vazio
    if (empty($_POST['maquina']) && !isset($datahoraI_mysql) && !isset($datahoraF_mysql)) {
        $sqll = "SELECT * FROM refuse";
    }
    //Máquina
    if(!empty($_POST['maquina']) && !isset($datahoraI_mysql) && !isset($datahoraF_mysql)){
        $sqll = "SELECT * FROM refuse WHERE refuse_machine_name = '$maquina'";
    }
    //Máquina+Início
    if(!empty($_POST['maquina']) && isset($datahoraI_mysql) && !isset($datahoraF_mysql)){
        $sqll = "SELECT * FROM refuse WHERE refuse_machine_name = '$maquina' AND refuse_datetime >= '$datahoraI_mysql'";
    }
    //Máquina+Início+Fim
    if(!empty($_POST['maquina']) && isset($datahoraI_mysql) && isset($datahoraF_mysql)){
        $sqll = "SELECT * FROM refuse WHERE refuse_machine_name = '$maquina' AND refuse_datetime >= '$datahoraI_mysql' AND refuse_datetime <= '$datahoraF_mysql'";
    }
    //Máquina+Fim
    if(!empty($_POST['maquina']) && !isset($datahoraI_mysql) && isset($datahoraF_mysql)){
        $sqll = "SELECT * FROM refuse WHERE refuse_machine_name = '$maquina' AND refuse_datetime <= '$datahoraF_mysql'";
    }
    //Início
    if(empty($_POST['maquina']) && isset($datahoraI_mysql) && !isset($datahoraF_mysql)){
        $sqll = "SELECT * FROM refuse WHERE refuse_datetime >= '$datahoraI_mysql'";
    }
    //Fim
    if(empty($_POST['maquina']) && !isset($datahoraI_mysql) && isset($datahoraF_mysql)){
        $sqll = "SELECT * FROM refuse WHERE refuse_datetime <= '$datahoraF_mysql'";
    }
    //Início+Fim
    if(empty($_POST['maquina']) && isset($datahoraI_mysql) && isset($datahoraF_mysql)){
        $sqll = "SELECT * FROM refuse WHERE refuse_datetime >= '$datahoraI_mysql' AND refuse_datetime <= '$datahoraF_mysql'";
    }

    $cab = ['Maquina', 'Código', 'Quantidade', 'Data'];
    $now = date("d-m-Y_H-i-s");
    $agora = 'Refugo_'.$now.'.csv';
    $arqCsv = $agora;
    $download = $arqCsv;
    exibir($sqll, $a);
    gerarCsv($sqll);
}

//Cabçalhos
function exibirCabecalho()
{
    if (isset($_POST['tipo']) && $_POST['tipo'] == 'producao') {
        echo "<th>Máquina</th><th>Quantidade</th><th>Data</th>";
    }
    if (isset($_POST['tipo']) && $_POST['tipo'] == 'refugo') {
        echo "<th>Máquina</th><th>Código</th><th>Quantidade</th><th>Data</th>";
    } 
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Função para exibir a tabela
function exibir($query, $a)
{
    global $pdo;
    $sql = $pdo->prepare($query);
    $sql->execute();

    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        if ($a == 'allProducao') {
            echo "<td>" . $row['prod_machine_name'] . "</td>";
            echo "<td>" . $row['prod_value'] . "</td>";
            echo "<td>" . $row['prod_datetime'] . "</td>";
        }
        if ($a == 'allRefugo') {
            echo "<td>" . $row['refuse_machine_name'] . "</td>";
            echo "<td>" . $row['refuse_code_code'] . "</td>";
            echo "<td>" . $row['refuse_value'] . "</td>";
            echo "<td>" . $row['refuse_datetime'] . "</td>";
        }
    }
}

//Função para gerar CSV
function gerarCsv($sqll)
{


    global $pdo;
    global $cab;
    global $arqCsv;

    $sql = $pdo->prepare($sqll);
    $sql->execute();
    $arq = fopen($arqCsv, 'w');

    fputcsv($arq, $cab, ';');
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if (substr($arqCsv, 0, 3) === "Pro") {
            $dados = [$row['prod_machine_name'], $row['prod_value'], $row['prod_datetime']];
        }
        if (substr($arqCsv, 0, 3) === "Ref") {
            $dados = [$row['refuse_machine_name'], $row['refuse_code_code'], $row['refuse_value'], $row['refuse_datetime']];
        }
        fputcsv($arq, $dados, ';');
    }
    fclose($arq);
}
