<?php 

if (isset($_POST['maquina']) && isset($_POST['titulo']) && isset($_POST['inicio'])) {
        if (empty($_POST['maquina']) or empty($_POST['titulo']) or empty($_POST['inicio'])) {
            $mensagemerro = "Preencher todos os campos!";
        } else {
            $maquina = limpaPost($_POST['maquina']);
            $titulo = limpaPost($_POST['titulo']);
            $inicio = limpaPost($_POST['inicio']);
    
            //Conferindo se máquina existe
            $sqlmaquina = $pdo->prepare("SELECT COUNT(*) from machines WHERE machine_name = '$maquina'");
            $sqlmaquina->execute();
            $count_maquina = $sqlmaquina->fetchColumn();
            if ($count_maquina != 1) {
                $mensagemerro = "Máquina inválida";
            }
            //Pegando username
            global $user;
            $user = auth($_SESSION['TOKEN']);
            $user_name = $user['user_name'];
    
            //Status
            $status = "Pendente";
    
            //Realizando insert
            try {
                $sqla = $pdo->prepare("INSERT INTO parada VALUES (null,?,?,?,default,default,default,?,?)");
                $sqla->execute(array($maquina, $titulo, $inicio, $status, $user_name));
                $mensagem = "Registrado com sucesso!";
            } catch (PDOException $erro) {
                $mensagemerro = "Falha no banco de dados, contactar suporte!" . $erro;
            }
        }
    }

    ?>