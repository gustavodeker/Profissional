<link rel="stylesheet" href="css/header.css">
<link rel="stylesheet" href="css/animate.css"> <!--Animações-->
<link rel="stylesheet" href="css/hover.css"> <!--Animações-->
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<header>
           <nav class='nav-menu'>
                <?php
                    global $user;
                    $user = auth($_SESSION['TOKEN']);
                    if ($user){
                        if ($user['user_level'] == 'admin') { ?>
                        <!-- <p><php echo "Administrador: ".$user['user_name'] ?></p> -->
                        <a class='logoadmin hvr-grow' href='refugo.php'><img class="imgadmin" src="img/logo.png" alt=""></a>
                        <a class='a-menu hvr-grow' id='botaologin' href='acompanhamento.php'>Acompanhameto</a>
                        <a class='a-menu hvr-grow' id='botaologin' href='historico.php'>Histórico</a>
                        <a class='a-menu hvr-grow' id='botaologin' href='suporte.php'>Suporte</a> 
                        <a class='a-menu hvr-grow sair' id='botaologin' href='logout.php'>Sair</a>
                    <?php } else{ ?>
                        <a class='logouser hvr-grow' href='refugo.php'><img class="imguser" src="img/logo.png" alt=""></a>
                        <a class='a-menu hvr-grow' id='botaologin' href='historico.php'>Histórico</a>
                        <a class='a-menu hvr-grow sair' id='botaologin' href='logout.php'>Sair</a>
                    <?php }
                    }
                ?>
           </nav>

</header>