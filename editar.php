<?php
    global $pdo;
    global $user;
    global $mensagemerro;
    $sql_id = $pdo->prepare("SELECT * FROM refuse WHERE refuse_id = '".$_REQUEST["id"]."'");
    $sql_id->execute();
    $row_n = $sql_id->fetch(PDO::FETCH_ASSOC);

    $sql_m = $pdo->prepare("SELECT * FROM machines WHERE machine_id = '".$row_n['refuse_machine_id']."'");
    $sql_m->execute();
    $row_m = $sql_m->fetch(PDO::FETCH_ASSOC);

    $sql_c = $pdo->prepare("SELECT * FROM codes WHERE code_id = '".$row_n['refuse_code_id']."'");
    $sql_c->execute();
    $row_c = $sql_c->fetch(PDO::FETCH_ASSOC);

    if(isset($_POST['maquina']) && isset($_POST['cod']) && isset($_POST['qtd'])){
        if(empty($_POST['maquina']) or empty($_POST['cod']) or empty($_POST['qtd'])){
            $mensagemerro = "Todos os campos são obrigatórios!";
        } else { 
            global $user;
            $user = auth($_SESSION['TOKEN']);
            /* Dados coletados */
            $machine = limpaPost($_POST['maquina']);
            $code = limpaPost($_POST['cod']);
            $qtd = limpaPost($_POST['qtd']);
            $data = date("Y-m-d H:i:s");

            /* Verificando se cod existe */
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
                /* Coletando cod_id */
                $sql_cod = $pdo->prepare("SELECT * FROM codes WHERE code_code = '$code'");
                $sql_cod->execute();
                $row_cod = $sql_cod->fetch(PDO::FETCH_ASSOC);
                $code_id = $row_cod["code_id"];

                /* Coletando machine_id */
                $sql_machine = $pdo->prepare("SELECT * FROM machines WHERE machine_code = '$machine'");
                $sql_machine->execute();
                $row_machine = $sql_machine->fetch(PDO::FETCH_ASSOC);
                $machine_id = $row_machine["machine_id"];

                try {
                    $sqlup = $pdo->prepare("UPDATE refuse SET refuse_machine_id =? , refuse_code_id =? , refuse_value =?, refuse_altertime =? , refuse_alterby =? WHERE refuse_id = ?");
                    $sqlup->execute(array($machine_id, $code_id, $qtd, $data, $user['user_id'], $_REQUEST["id"]));

                    $sqlupb = $pdo->prepare("UPDATE gr SET gr_machine =? , gr_code =? , gr_value =?, gr_altertime =? , gr_alterby =? WHERE gr_refuse_id = ?");
                    $sqlupb->execute(array($row_machine["machine_code"], $row_cod["code_code"], $qtd, $data, $user['user_name'], $_REQUEST["id"]));
                    $mensagem = "Editado com sucesso!";
                } catch (PDOException $erro) {
                    $mensagemerro = "Falha ao conectar! Chamar o suporte!";
                }
            }
        }
    }
?>
