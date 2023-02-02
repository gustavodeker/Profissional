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
                    <a id='botaologin' href='acompanhamento.php'>Acompanhamento</a>
                    <a id='botaologin' href='refugo.php'>Refugo</a>
                    <a id='botaologin' href='producao.php'>Produção</a>
                    <a id='botaologin' href='historico.php'>Histórico</a>
                    <a id='botaologin' href='https://suporte.highpot.tech/' target="_blank">Suporte</a>
                    <a id='botaologin' href='logout.php'>Sair</a>
                </ul>
            <?php } else { ?>
                <ul class="menu" id="menu" role="menu">
                    <a id='botaologin' href='refugo.php'>Refugo</a>
                    <a id='botaologin' href='producao.php'>Produção</a>
                    <a id='botaologin' href='historico.php'>Histórico</a>
                    <a id='botaologin' href='logout.php'>Sair</a>
                </ul>
        <?php }
        }
        ?>
    </nav>
</header>

<!--<style>
    footer {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 5px;
    background-color: #f5f5f5;
    border-top: 1px solid #ddd;
    text-align: center;
}
.prodape{
    color: gray;
}
</style>
<footer>
    <p class="prodape">Created by Highpot Tech.</p>
</footer>-->

<style>
        footer {
            position: fixed;
            display: flex;
            align-items: center;
            justify-content: center;;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3rem;
            padding-top: 3px;
            text-align: center;
            border-top: 1px solid rgba(245,245,245,0.3);
            background-color: #004479;
        }
        .hot {
            width: 100px;
            opacity: 0.9;
            margin-left: 5px;
        }
        .prodape {
            color: whitesmoke;
            padding-bottom: 14px;
        }
    </style>
    <footer>
        <p class="prodape">Created by</p><img class="hot" src="img/high.png" alt="">
    </footer>