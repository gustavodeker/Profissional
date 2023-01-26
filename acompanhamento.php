<?php
include("config/conexao.php");
sessionVerif();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/geral.css">
    <link rel="stylesheet" href="css/suporte.css">
    <title>Próturbo :: Acompanhamento</title>
    <style>
        .corpo {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            max-width: 800px;
            overflow: auto;
            margin-left: auto;
            margin-right: auto;
            background-color: whitesmoke;
            overflow: auto;
        }

        #refugo,
        #producao {
            margin: 10px;   
            padding: 10px;
            max-height: 400px;
            box-shadow: 0px 0px 10px #cecece;
            overflow: auto;
        }
    </style>
</head>

<body>
    <?php include_once("header.php") ?>
    <h1>Gráficos</h1>

    <div class="corpo">
        <div id="refugo" style="width: 320px;"></div>

        <div id="producao" style="width: 320px;"></div>
    </div>

</body>

</html>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['bar']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Máquina', 'Quantidade'],
            <?php
            $sql = $pdo->prepare("SELECT DISTINCT gr_machine, SUM(gr_value) AS gr_value FROM gr 
            GROUP BY gr_machine ORDER BY SUM(gr_value)");
            $sql->execute();
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) { ?>['<?php echo $row['gr_machine'] ?>', '<?php echo $row['gr_value'] ?>'],
            <?php } ?>

        ]);

        var options = {
            chart: {
                title: 'Refugo'
            },
            bars: 'horizontal', // Required for Material Bar Charts.
            legend: {
                position: "none"
            },
            animation: {
                duration: 1000,
                easing: 'out',
                startup: true
            },
            vAxis: {
                title: ''
            },
            titleTextStyle: {
                fontSize: 20
            },
            colors: ['#004479'],
            backgroundColor: {
                fill: 'transparent',
            },
            hAxis: {
                gridlines: {
                    count: 0
                }
            },
            chartArea: {
                backgroundColor: 'transparent',
            },

        };


        var chart = new google.charts.Bar(document.getElementById('refugo'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
</script>

<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['bar']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Máquina', 'Quantidade'],
            <?php
            $sql = $pdo->prepare("SELECT DISTINCT gp_machine, SUM(gp_value) AS gp_value FROM gp 
            GROUP BY gp_machine ORDER BY SUM(gp_value)");
            $sql->execute();
            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) { ?>['<?php echo $row['gp_machine'] ?>', '<?php echo $row['gp_value'] ?>'],
            <?php } ?>
        ]);

        var options = {
            chart: {
                title: 'Produção'
            },
            bars: 'horizontal', // Required for Material Bar Charts.
            legend: {
                position: "none"
            },
            animation: {
                duration: 1000,
                easing: 'out',
                startup: true
            },
            vAxis: {
                title: ''
            },
            titleTextStyle: {
                fontSize: 20
            },
            colors: ['#004479'],
            backgroundColor: {
                fill: 'transparent',
            },
            hAxis: {
                gridlines: {
                    count: 0
                }
            },
            chartArea: {
                backgroundColor: 'transparent',
            },

        };


        var chart = new google.charts.Bar(document.getElementById('producao'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
</script>