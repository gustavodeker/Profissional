<link rel="stylesheet" href="css/header.css">
<link rel="stylesheet" href="css/animate.css"> <!--Animações-->
<link rel="stylesheet" href="css/hover.css"> <!--Animações-->
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<script defer src="js/header.js"></script>
<style>
    /* Adicionando a classe CSS para esconder o menu */
    .nav-menu {
        display: none;
    }

    /* Adicionando a classe CSS para mostrar o menu */
    .nav-menu-open {
        display: block;
    }
</style>
<header class="header">
    <a class="logo" href="refugo.php">Início</a>
    <nav class="nav">
        <button class="btn-menu" aria-label="Abrir Menu" aria-haspopup="true" aria-controls="menu" aria-expanded="false">
            Menu<span class="hamburger"></span>
        </button>
        <?php
        global $user;
        $user = auth($_SESSION['TOKEN']);
        if ($user) {
            if ($user['user_level'] == 'admin') { ?>
                <!-- <p><php echo "Administrador: ".$user['user_name'] ?></p> -->

                <ul class="menu" id="menu" role="menu">
                    <a id='botaologin' href='acompanhamento.php'>Acompanhameto</a>
                    <a id='botaologin' href='historico.php'>Histórico</a>
                    <a id='botaologin' href='suporte.php'>Suporte</a>
                    <a id='botaologin' href='logout.php'>Sair</a>
                </ul>
            <?php } else { ?>
                <ul class="menu" id="menu" role="menu">
                    <a id='botaologin' href='historico.php'>Histórico</a>
                    <a id='botaologin' href='logout.php'>Sair</a>
                </ul>
        <?php }
        }
        ?>
    </nav>
</header>