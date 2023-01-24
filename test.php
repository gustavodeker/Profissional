<html>

<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', { 'packages': ['bar'] });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Máquina', 'Quantidade'],
                <?php
                include 'config/conexao.php';
                $sql = $pdo->prepare("SELECT DISTINCT gr_machine, SUM(gr_value) AS gr_value FROM gr 
            GROUP BY gr_machine");
                $sql->execute();
                while ($row = $sql->fetch(PDO::FETCH_ASSOC)) { ?>
                    ['<?php echo $row['gr_machine'] ?>', '<?php echo $row['gr_value'] ?>'],
                <?php } ?>

            ]);

            var options = {
                chart: {
                    title: 'Refugo',
                    subtitle: 'Valores do turno atual',
                }
            };

            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>
</head>

<body>
    <div id="columnchart_material" style="width: 600px; height: 500px;"></div>
</body>

</html>