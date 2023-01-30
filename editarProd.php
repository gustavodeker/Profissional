<?php
    global $pdo;
    global $user;
    global $mensagemerro;
    $sql_id = $pdo->prepare("SELECT * FROM prod WHERE prod_id = '".$_REQUEST["id"]."'");
    $sql_id->execute();
    $row_n = $sql_id->fetch(PDO::FETCH_ASSOC);

    $sql_m = $pdo->prepare("SELECT * FROM machines WHERE machine_name = '".$row_n['prod_machine_name']."'");
    $sql_m->execute();
    $row_m = $sql_m->fetch(PDO::FETCH_ASSOC);

    if(isset($_POST['maquina']) && isset($_POST['motivo']) && isset($_POST['qtd'])){
        if(empty($_POST['maquina']) or empty($_POST['motivo']) or empty($_POST['qtd'])){
            $mensagemerro = "Todos os campos são obrigatórios!";
        } else { 
            global $user;
            $user = auth($_SESSION['TOKEN']);
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
                $machine_name = $row_machine["machine_name"];

                try {
                    $sqlup = $pdo->prepare("UPDATE prod SET prod_machine_name =? , prod_reason =? , prod_value =?, prod_altertime = default , prod_alterby =? WHERE prod_id = ?");
                    $sqlup->execute(array($machine_name, $motivo, $qtd, $user['user_id'], $_REQUEST["id"]));

                    $sqlupb = $pdo->prepare("UPDATE gp SET gp_machine =? , gp_reason =? , gp_value =? WHERE gp_prod_id = ?");
                    $sqlupb->execute(array($row_machine["machine_name"], $motivo, $qtd, $_REQUEST["id"]));
                    $mensagem = "Editado com sucesso!";
                } catch (PDOException $erro) {
                    $mensagemerro = "Falha ao conectar! Chamar o suporte!";
                }
            }
        }
    }
?>
