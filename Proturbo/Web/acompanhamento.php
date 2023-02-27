<?php
include("config/conexao.php");
sessionVerif();

$dir = __DIR__; // substitua pelo caminho para o diretório
$files = scandir($dir); // lê o conteúdo do diretório
foreach ($files as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) === 'csv') { // verifica se a extensão do arquivo é .csv
        unlink($dir . '/' . $file); // exclui o arquivo
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Próturbo :: Acompanhamento</title>
    <link rel="stylesheet" href="css/geral.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/datatable.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,700,0,0" />
    <style>
        .linkgrafana {
            display: flex;
            padding: 10px;
            background-color: #004479;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bolder;
            font-size: 30px;
            width: 98%;
            align-items: center;
            justify-content: center;
        }

        h1 {
            font-size: 30px;
        }

        span {
            color: whitesmoke;
        }

        .linkgraficos {
            width: 100%;
        }
    </style>

    <style>
        .corpo {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 5px;
            margin-bottom: 5rem;
            height: 100%;
        }

        .divConsultas {
            border: 2px solid #004479;
            text-align: left;
            width: 330px;
            padding: 10px;
            display: block;
            margin: 5px;
            border-radius: 5px;
        }

        .divTabela {
            display: block;
            padding: 10px;
            border: 2px solid #004470;
            width: 500px;
            margin: 5px;
            max-height: 600px;
            overflow-y: auto;
            border-radius: 5px;
        }

        form {
            display: flex;
            flex-wrap: wrap;
            padding: 5px;
        }

        form .item {
            width: 100%;
        }

        form .item input,
        form .item select {
            height: 30px;
            width: 200px;
            margin-bottom: 2px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            padding-left: 10px;
        }

        form .item label {
            display: inline-block;
            margin: 0px 5px 0px 10px;
            width: 65px;
        }

        form .item button {
            width: 250px;
            height: 40px;
            display: block;
            width: 100%;
            margin: 10px 0px;
            background-color: #004479;
            color: whitesmoke;
            font-weight: bolder;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .downloada {
            display: flex !important;
            align-items: center;
            justify-content: center;
            background-color: green;
            margin-bottom: 5px;
            border-radius: 5px;
            width: 100%;
        }

        .download {
            line-height: 30px;
            display: block;
            margin: 10px 0px;
            background-color: green;
            color: whitesmoke;
            font-weight: bolder;
            border: none;
            cursor: pointer;
        }

        @media(max-width: 600px) {
            .corpo {
                justify-content: center;
            }

            .divConsultas {
                width: 100%;
            }

            .divTabela {
                width: 100%;
            }

            form .item label {
                margin: 0px 5px 0px 40px;
            }
        }
    </style>
</head>

<body>
    <?php include_once("header.php") ?>

    <div class="corpo">

        <p class="linkgraficos hvr-shrink"><a class="linkgrafana" href="http://54.207.211.112:3000/d/ra73L20Vk" target="_blank">GRÁFICOS <span class="material-symbols-outlined">
                    display_external_input
                </span></a> </p>
        <!--------------------------------------------------------------------------------------->

        <div class="divConsultas">
            <h1>CONSULTAS</h1>
            <form method="post">
                <div class="item">
                    <label for="tipo">Tipo:</label>
                    <select name="tipo" id="tipo">
                        <option value=""></option>
                        <option value="producao">Produção</option>
                        <option value="refugo">Refugo</option>
                    </select>
                </div>


                <div class="item">
                    <label for="maquina">Máquina:</label>
                    <select name="maquina" id="maquina">
                        <option value="">
                            <?php machineOption(); ?>
                        </option>
                    </select>
                </div>
                <div class="item">
                    <label for="datetimeI">Início:</label>
                    <input type="datetime-local" id="datetimeI" name="datetimeI">
                </div>
                <div class="item">
                    <label for="datetimeF">Fim:</label>
                    <input type="datetime-local" id="datetimeF" name="datetimeF">
                </div>

                <div class="item">
                    <button type="submit" name="exibir" class="hvr-float">Buscar</button>
                </div>
            </form>
        </div>


        <!----------------------------------------------------------------->

        <div class="divTabela" id="divTabela">
            <table id="tableExibir">
                <thead>
                    <?php exibirCabecalho(); ?>
                </thead>
                <tbody>
                    <?php
                    if (isset($_POST['tipo']) && $_POST['tipo'] == 'producao') {
                        corpoAllProducao();
                    }
                    if (isset($_POST['tipo']) && $_POST['tipo'] == 'refugo') {
                        corpoAllRefugo();
                    }
                    ?>
                </tbody>
                <?php if (isset($download)) { ?>
                    <a class="downloada hvr-shrink" href="<?php echo $download; ?>" download><button class="download">CSV </button><span class="material-symbols-outlined">
                            download
                        </span></a>
                <?php } ?>

            </table>
        </div>

    </div>



    <!--------------------------------------------------------------------------------------->

    <?php include('footer.php'); ?>
</body>

</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="js/datatable.js"></script>
<script>
    $(document).ready(function() {
        //Com responsividade e tradução
        $('#tableExibir').DataTable({
            responsive: true,
            "language": {
                "emptyTable": "Nenhum registro encontrado",
                "info": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "infoEmpty": "Mostrando 0 até 0 de 0 registros",
                "infoFiltered": "(Filtrados de _MAX_ registros)",
                "infoThousands": ".",
                "loadingRecords": "Carregando...",
                "processing": "Processando...",
                "zeroRecords": "Nenhum registro encontrado",
                "search": "Pesquisar",
                "lengthMenu": "Exibir _MENU_ resultados por página",
                "paginate": {
                    "next": "Próximo",
                    "previous": "Anterior",
                    "first": "Primeiro",
                    "last": "Último"
                }
            },
            "order": [
                [2, 'desc']
            ]
        });
    });
</script>

<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<button id="btnDownload">Download da imagem</button>

<script>
// Crie uma função que capture a imagem da div e gere um link de download
function downloadDiv() {
  // Capture a imagem da div usando o html2canvas
  html2canvas(document.querySelector("#divTabela")).then(function(canvas) {
    // Crie um objeto URL para a imagem gerada
    var url = canvas.toDataURL("image/jpeg");

    // Crie um elemento link e atribua o objeto URL como seu href
    var link = document.createElement("a");
    link.download = "imagem.jpg";
    link.href = url;

    // Adicione o link ao documento e clique nele para iniciar o download
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  });
}

// Adicione um evento de clique ao botão para acionar o download da imagem
document.querySelector("#btnDownload").addEventListener("click", downloadDiv);
</script>