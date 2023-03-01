<?php
global $pdo;
global $user;
global $mensagemerro;
$sql_id = $pdo->prepare("SELECT * FROM refuse WHERE refuse_id = '" . $_REQUEST["id"] . "'");
$sql_id->execute();
$row_n = $sql_id->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['maquina']) && isset($_POST['cod']) && isset($_POST['qtd'])) {
    if (empty($_POST['maquina']) or empty($_POST['cod']) or empty($_POST['qtd'])) {
        $mensagemerro = "Todos os campos são obrigatórios!";
    } else {
        global $user;
        $user = auth($_SESSION['TOKEN']);
        /* Dados coletados */
        $machine = limpaPost($_POST['maquina']);
        $code = limpaPost($_POST['cod']);
        $qtd = limpaPost($_POST['qtd']);

        //Conferindo se máquina existe
        $sqlmaquina = $pdo->prepare("SELECT COUNT(*) from machines WHERE machine_name = '$machine'");
        $sqlmaquina->execute();
        $count_maquina = $sqlmaquina->fetchColumn();

        /* Verificando se cod existe */
        $sql_count = $pdo->prepare("SELECT COUNT(*) FROM codes WHERE code_code = '$code'");
        $sql_count->execute();
        $count_code = $sql_count->fetchColumn();

        if ($count_maquina != 1) {
            $mensagemerro = "Máquina inválida";
        }
        if ($count_code != 1) {
            $mensagemerro = "Código incorreto!";
        }
        if ($qtd < 1 or $qtd > 999) {
            $mensagemerro = "Quantidade de 1 a 999!";
        }
        if ($count_code == 1 && $qtd > 0 && $qtd < 1000) {
            try {
                $sqlup = $pdo->prepare("UPDATE refuse SET refuse_machine_name =? , refuse_code_code =? , refuse_value =? WHERE refuse_id =?");
                $sqlup->execute(array($machine, $code, $qtd, $_REQUEST["id"]));


                /*$sqlupb = $pdo->prepare("UPDATE gr SET gr_machine =? , gr_code =? , gr_value =? WHERE gr_refuse_id = ?");
                $sqlupb->execute(array($machine, $code, $qtd, $_REQUEST["id"]));*/
                $mensagem = "Editado com sucesso!";
            } catch (PDOException $erro) {
                $mensagemerro = "Falha ao conectar! Chamar o suporte!" . $erro;
            }
        }
    }
}
?>