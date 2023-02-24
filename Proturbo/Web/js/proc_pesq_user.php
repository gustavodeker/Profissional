<?php
include('../config/conexao.php');

$pesquisa = isset($_POST['palavra']) ? filter_input(INPUT_POST, 'palavra', FILTER_SANITIZE_STRING) : '';

if(empty($pesquisa)){
    $sql = $pdo->prepare("SELECT * FROM itens");
    $sql->execute();
} else {
    $sql = $pdo->prepare("SELECT * FROM itens WHERE item_pn_desc LIKE '%$pesquisa%'");
    $sql->execute();
}

$count = $sql->rowCount();

if($count > 0){
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>".$row['item_pn_desc']."</td>";
        // adicione aqui os outros campos da tabela que você deseja exibir
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='2'>Nenhum resultado encontrado.</td></tr>";
}



























?>