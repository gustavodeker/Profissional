<?php
function allRefugo()
{
    global $pdo;
    $sql = $pdo->prepare("SELECT * FROM refuse");
    $sql->execute();

    $cab = ['Maquina', 'Codigo', 'Quantidade', 'Data'];

    $arq = fopen('Todos_Refugos.csv', 'w');
    fputcsv($arq, $cab, ';');
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $dados = [$row['refuse_machine_name'], $row['refuse_code_code'], $row['refuse_value'], $row['refuse_datetime']];
        fputcsv($arq, $dados, ';');
    }

    fclose($arq);
}




















?>