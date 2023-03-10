<?php
global $pdo;
global $user;
global $mensagemerro;
$sql_id = $pdo->prepare("SELECT * FROM prod WHERE prod_id = '" . $_REQUEST["id"] . "'");
$sql_id->execute();
$row_n = $sql_id->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['maquina']) && isset($_POST['motivo']) && isset($_POST['qtd'])) {
    if (empty($_POST['maquina']) or empty($_POST['motivo']) or empty($_POST['qtd'])) {
        $mensagemerro = "Todos os campos são obrigatórios!";
    } else {
        global $user;
        $user = auth($_SESSION['TOKEN']);
        /* Dados coletados */
        $machine = limpaPost($_POST['maquina']);
        $motivo = limpaPost($_POST['motivo']);
        $qtd = limpaPost($_POST['qtd']);

        //Conferindo se máquina existe
        $sqlmaquina = $pdo->prepare("SELECT COUNT(*) from machines WHERE machine_name = '$machine'");
        $sqlmaquina->execute();
        $count_maquina = $sqlmaquina->fetchColumn();

        if ($count_maquina != 1) {
            $mensagemerro = "Máquina inválida";
        }
        if ($qtd < 1 or $qtd > 999) {
            $mensagemerro = "Quantidade de 1 a 999!";
        }
        if ($qtd > 0 && $qtd < 1000) {

            try {
                $sqlup = $pdo->prepare("UPDATE prod SET prod_machine_name =? , prod_reason =? , prod_value =? WHERE prod_id = ?");
                $sqlup->execute(array($machine, $motivo, $qtd, $_REQUEST["id"]));
                $mensagem = "Editado com sucesso!";
            } catch (PDOException $erro) {
                $mensagemerro = "Falha ao conectar! Chamar o suporte!";
            }
        }
    }
}
?>
