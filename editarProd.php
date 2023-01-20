<?php
    global $pdo;
    global $user;
    global $mensagemerro;
    $sql_id = $pdo->prepare("SELECT * FROM production WHERE production_id = '".$_REQUEST["id"]."'");
    $sql_id->execute();
    $row_n = $sql_id->fetch(PDO::FETCH_ASSOC);

    $sql_m = $pdo->prepare("SELECT * FROM machines WHERE machine_id = '".$row_n['production_machine_id']."'");
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
            $data = date("Y-m-d H:i:s");

            if($qtd < 1 or $qtd > 999){
                $mensagemerro = "Quantidade de 1 a 999!";
            }
            if ($qtd > 0 && $qtd < 1000) {
                /* Coletando machine_id */
                $sql_machine = $pdo->prepare("SELECT * FROM machines WHERE machine_code = '$machine'");
                $sql_machine->execute();
                $row_machine = $sql_machine->fetch(PDO::FETCH_ASSOC);
                $machine_id = $row_machine["machine_id"];

                try {
                    $sqlup = $pdo->prepare("UPDATE production SET production_machine_id =? , production_reason =? , production_value =?, production_altertime =? , production_alterby =? WHERE production_id = ?");
                    $sqlup->execute(array($machine_id, $motivo, $qtd, $data, $user['user_id'], $_REQUEST["id"]));
                    $mensagem = "Editado com sucesso!";
                } catch (PDOException $erro) {
                    $mensagemerro = "Falha ao conectar! Chamar o suporte!";
                }
            }
        }
    }
?>
