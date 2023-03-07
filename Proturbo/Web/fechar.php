<?php
global $pdo;
global $user;
global $mensagemerro;

$sqlPendentes_n = $pdo->prepare("SELECT * FROM parada WHERE parada_id = '" . $_REQUEST["id"] . "'");
$sqlPendentes_n ->execute();
$sqlP_n = $sqlPendentes_n->fetch(PDO::FETCH_ASSOC);

if ($sqlP_n['parada_status'] == 'Fechada'){
    $mensagemerro = "Parada já fechada";
    header('Location: parada.php');
}

if (isset($_POST['maquinaf']) && $_POST['titulof'] && isset($_POST['iniciof']) && isset($_POST['fimf']) && $_POST['comentf']) {
    if (empty($_POST['maquinaf']) or empty($_POST['titulof']) or empty($_POST['iniciof']) or empty($_POST['fimf']) or empty($_POST['comentf'])) {
        $mensagemerro = "Os campos são obrigatórios!";
    } else {
        $maquina = limpaPost($_POST['maquinaf']);
        $titulo = limpaPost($_POST['titulof']);
        $inicio = limpaPost($_POST['iniciof']);
        $fim = limpaPost($_POST['fimf']);
        $coment = limpaPost($_POST['comentf']);
        $status = "Fechada"; //Status

        //Conferindo se máquina existe
        $sqlmaquina = $pdo->prepare("SELECT COUNT(*) from machines WHERE machine_name = '$maquina'");
        $sqlmaquina->execute();
        $count_maquina = $sqlmaquina->fetchColumn();
        if ($count_maquina != 1) {
            $mensagemerro = "Máquina inválida";
        }

        try {
            $sqlup = $pdo->prepare("UPDATE parada SET parada_maquina =? , parada_titulo =? , parada_horainicio =? , parada_horafim =? , parada_coment =? , parada_status =? WHERE parada_id =?");
            $sqlup->execute(array($maquina, $titulo, $inicio, $fim, $coment, $status, $_REQUEST["id"]));
            $mensagem = "Fechada com sucesso!";
        } catch (PDOException $erro) {
            $mensagemerro = "Falha ao conectar! Chamar o suporte!" . $erro;
        }
    }
}
?>