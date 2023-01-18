<?php
include("config/conexao.php");
sessionVerif();

function historicoTable()
{
    global $pdo;
    global $user;
    $user = auth($_SESSION['TOKEN']);

    $sql = $pdo->prepare("SELECT * FROM refuse WHERE refuse_user_id = '".$user['user_id']."' ORDER BY refuse_time DESC LIMIT 10");
    $sql->execute();
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $sql_machine = $pdo->prepare("SELECT machine_code FROM machines WHERE machine_id = '".$row['refuse_machine_id']."'");
        $sql_machine->execute();
        $row_machine = $sql_machine->fetch(PDO::FETCH_ASSOC);

        $sql_code = $pdo->prepare("SELECT code_code FROM codes WHERE code_id = '".$row['refuse_code_id']."'");
        $sql_code->execute();
        $row_code = $sql_code->fetch(PDO::FETCH_ASSOC);

        echo "<tr>";
        echo "<td>" . $row_machine['machine_code'] . "</td>";
        echo "<td>" . $row_code['code_code'] . "</td>";
        echo "<td>" . $row['refuse_value'] . "</td>";
        echo "<td>" . $row['refuse_time'] . "</td>";
        echo "<td><span class='material-icons' onclick=\"location.href='logregistros.php?page=logregistros&id=" . $row['refuse_id'] . "'\">
        edit
        </span></td>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Próturbo :: Histórico</title>
    <link rel="stylesheet" href="css/geral.css">
    <link rel="stylesheet" href="css/refugo.css">
</head>
<body>
    <?php include_once("header.php") ?>
<!--ALTERNAR-->
<!---------------------------------------------------------------->
    <div id="alternar">
        <a id="btn-production" href="producao.php">Produção</a>
        <a id="btn-refuse" href="refugo.php">Refugo</a>
    </div>
<!---------------------------------------------------------------->

<!---------------------------------------------------------------->
    <div id="divt">
        <table id="historico-table">
            <thead>
                <th>Máquina</th>
                <th>Código</th>
                <th>Quantidade</th>
                <th>Horário</th>
                <th>#</th>
            </thead>
            <tbody>
                <?php
                    historicoTable();
                ?>
            </tbody>
        </table>
    </div>
<!---------------------------------------------------------------->

<!---------------------------------------------------------------->
    <div style="display: none" class="janela-edit" id="janela-edit">    
        <div class="modal-novo">
        <button class="fechar" id="fechar" onclick="fecharEdit()">X</button>
            <form id="form-novo" class="form-novo" method="POST" action="">
                <?php // Mensagem de erro ou sucesso
                if (isset($erro_geral)) { ?>
                <div class="erro-geral animate__animated animate__headShake">
                    <?php echo $erro_geral; ?>
                </div>
                <?php } else if (isset($sucesso)) { ?>
                <div class="sucesso animate__animated animate__headShake">
                    <?php echo $sucesso; ?>
                </div>
                <?php } ?>
                    <div class="form-item">
                        <label>Nome: </label>
                        <input type="text" name="nome" id="nome" value="<?php echo $row_n['registro_nome'] ?>">
                    </div>

                    <div class="form-item">
                        <label>Setor: </label>
                        <input type="text" name="setor" id="setor" value="<?php echo $row_n['registro_setor'] ?>">
                    </div>

                    <div class="form-item">
                        <label>Serviço: </label>
                        <input type="text" name="servico" id="servico" value="<?php echo $row_n['registro_servico'] ?>">
                    </div>

                    <div class="form-item">
                        <label>Descrição: </label>
                        <input type="text" name="desc" id="desc" value="<?php echo $row_n['registro_desc'] ?>">
                    </div>
        
                    <input type="submit" id="submit" value="Editar"></input>
            </form>
        </div>

        <!--REFUSE-------------------------------------------------->
        <div id="div-refuse">
            <button class="fechar" id="fechar" onclick="fecharEdit()">X</button>

            <form id="form-refuse" method="POST">
                <h1>EDITAR</a></h1>
                <?php // Mensagem de erro ou sucesso
                if (isset($erro_geral)) { ?>
                <div class="erro-geral animate__animated animate__headShake">
                    <?php echo $erro_geral; ?>
                </div>
                <?php } else if (isset($sucesso)) { ?>
                <div class="sucesso animate__animated animate__headShake">
                    <?php echo $sucesso; ?>
                </div>
                <?php } ?>
                <!---------------->
                <div class="div-maquina">
                    <label class="maquina">Máquina:</label>
                    <select id="maquina" name="maquina">
                        <option value="<?php/******/ echo $row_n['registro_nome'] ?>"><?php echo $row_n['registro_nome']?></option>
                        <?php machineOption(); ?>
                    </select>
                </div>
                <!---------------->
                <p style="background: #004479; color: whitesmoke; text-align: center;">Selecione o código na tabela</p>
                <table id="table-cod" >
                    <thead>
                        <th>Cod</th>
                        <th class="th-desc">Descrição</th>
                    </thead>
                    <tbody>
                        <?php codTable(); ?>
                    </tbody>
                </table>
                <!---------------->
                <div class="div-cod">
                    <label class="codigo">Selecionado:</label>
                    <input id="cod" name="cod" type="number" value="<?php/******/ echo $row_n['registro_nome'] ?>">
                </div>
                <!---------------->
                <div class="quantidade">
                    <label>Quantidade:</label>
                    <div class="div-qtd">
                        <div class="menos" onclick="menos()">-</div>
                        <input id="qtd" name="qtd" class="qtd" type="number" min="1"  value="<?php/******/ echo $row_n['registro_nome'] ?>">
                        <div class="mais" onclick="mais()">+</div>
                    </div>
                </div>
                <!---------------->
                <input id="enviar" type="submit" value="Enviar">
                <!---------------->
            </form>
        </div>
        <!---------------->
    </div>
<!---------------------------------------------------------------->

</body>
</html>