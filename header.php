<link rel="stylesheet" href="css/header.css">
<header>
           <nav class='nav-menu'>
                <?php
                    global $user;
                    $user = auth($_SESSION['TOKEN']);
                    if ($user){
                        if ($user['user_nivel'] == 'admin') { ?>
                        <a class='a-menu' id='botaologin' href='registro.php'>Início</a>
                        <a class='a-menu' id='botaologin' href='logregistros.php'>Registros</a>
                        <a class='a-menu' id='botaologin' href='cadastro.php'><?php /* echo $user['user_nome']*/echo "Cadastro" ?></a>
                        <a class='a-menu sair' id='botaologin' href='logout.php'>Sair</a>
                    <?php } else{ ?>
                        <a class='a-menu' id='botaologin' href='registro.php'>Início</a>
                        <a class='a-menu sair' id='botaologin' href='logout.php'>Sair</a>
                    <?php }
                    }
                ?>
           </nav>
</header>