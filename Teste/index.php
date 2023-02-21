<?php
include('conexao.php');
include('funcoes_csv.php');

if (isset($_POST['allRefugo'])) {
    allRefugo();
}

if (isset($_POST['exibirAllRefugo'])) {
    exibir();
}
function exibir()
{
    global $pdo;
    $sql = $pdo->prepare("SELECT * FROM refuse");
    $sql->execute();

    echo "
    <table>
    <thead>
        <th>Máquina</th>
        <th>Código</th>
        <th>Quantidade</th>
        <th>Data</th>
    </thead>
    <tbody>";
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['refuse_machine_name'] . "</td>";
        echo "<td>" . $row['refuse_code_code'] . "</td>";
        echo "<td>" . $row['refuse_value'] . "</td>";
        echo "<td>" . $row['refuse_datetime'] . "</td>";
    }
    echo "
        </tbody>
    </table>";
}
?>

<form method="post">
    <button type="submit" name="exibirAllRefugo">Refugo</button>
</form>

<form method="post">
    <button type="submit" name="allRefugo">Gerar CSV</button>
</form>
<a href="Todos_Refugos.csv" download><button>Download</button></a>