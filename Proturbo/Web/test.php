<?php
include("config/conexao.php");

$sql = $pdo->prepare("SELECT machines.machine_name,
(SELECT SUM(gp.gp_value) FROM gp WHERE gp.gp_machine = machines.machine_name) AS prod,
(SELECT SUM(gr.gr_value) FROM gr WHERE gr.gr_machine = machines.machine_name) AS ref
FROM machines
ORDER BY prod DESC");
$sql->execute();

$labels = [];
$data = [];
$data2 =[];

while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
  $labels[] = $row['machine_name'];
  $data[] = $row['prod'];
  $data2[] = $row['ref'];
}

$data_json = json_encode($data);
$data2_json = json_encode($data2);
$labels_json = json_encode($labels);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Próturbo :: Acompanhamento</title>
    <link rel="stylesheet" href="css/geral.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    .out {
        max-width: 600px;
        max-height: 600px;
        overflow: auto;
        margin-left: auto;
        margin-right: auto;
    }
    .in{
      width: 100px;
        height: 1000px;
    }
    #myChart {
        width: 100px;
        height: 1000px;
    }

    .linkgrafana {
            padding: 10px;
            background-color: #004479;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bolder;
        }

        .linkgrafana:hover {
            background-color: #004470;
        }

        p {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <?php include_once("header.php") ?>

    <div class="out">
        <div class="in">
            <canvas id="myChart"></canvas>
        </div>
    </div>

    <p>Acesse: <a class="linkgrafana hvr-float" href="http://54.207.211.112:3000/d/ra73L20Vk" target="_blank">GRÁFICOS COMPLETOS</a> </p>
    <script>
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo $labels_json; ?>,
            datasets: [{  
                label: 'Produção',
                data: <?php echo $data_json; ?>,
                borderWidth: 1
            },
            {  
                label: 'Refugo',
                data: <?php echo $data2_json; ?>,
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            scales: {
                xAxes: [{
                    type: 'linear',
                    position: 'bottom'
                }],
                yAxes: [{
                    type: 'category',
                    position: 'left',
                    labels: <?php echo $labels_json; ?>
                }]
            },
            elements: {
                rectangle: {
                    borderWidth: 30,
                }
            }
        }
    });
    </script>
</body>

</html>