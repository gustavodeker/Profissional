<?php
    global $pdo;
    global $user;
    global $erro_geral;
    $sql_id = $pdo->prepare("SELECT * FROM registro WHERE registro_id = '".$_REQUEST["id"]."'");
    $sql_id->execute();
    $row_n = $sql_id->fetch(PDO::FETCH_ASSOC);

    if (isset($_POST['nome']) && isset($_POST['setor']) && isset($_POST['servico']) && isset($_POST['desc'])) {
        if (empty($_POST['nome']) or empty($_POST['setor']) or empty($_POST['servico']) or empty($_POST['desc'])) {
            $erro_geral = "Todos os campos são obrigatórios!";
        } else {
            global $user;
            $user = auth($_SESSION['TOKEN']);
            $nome = limpaPost($_POST['nome']); //canal OK
            $setor = $_POST['setor']; // VERIFICAR LIMPEZA
            $servico = limpaPost($_POST['servico']); //categ OK
            $desc = limpaPost($_POST['desc']); //nota OK
            $data = date("Y-m-d H:i:s");
            try {
                $sqlup = $pdo->prepare("UPDATE registro SET registro_nome =? , registro_setor =? , registro_servico =? , registro_desc =? , registro_data =? WHERE registro_id = ?");
                $sqlup->execute(array($nome, $setor, $servico, $desc, $data, $_REQUEST["id"]));
                $sucesso = "Registro atualizado!";
            } catch (PDOException $erro) {
                $erro_geral = "Falha ao conectar, ERRO:  " . $erro->getMessage();
            }
        }
    }
?>
