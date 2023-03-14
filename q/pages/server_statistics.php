<?php

initiate_html_columns();

?>

<?php include 'template/includes/widgets/server_header.php'; ?>


<div class="panel panel-default">
    <div class="panel-body">

        <?php
        $result = $database->query("
					SELECT
						FROM_UNIXTIME(`points`.`timestamp`, '%Y-%m-%d') AS `date`,
						(SELECT COUNT(`points`.`id`) FROM `points` WHERE `type` = 0 AND `server_id` = {$server->server_id} AND  FROM_UNIXTIME(`points`.`timestamp`, '%Y-%m-%d') = `date`) AS `hits_count`,
						(SELECT COUNT(`points`.`id`) FROM `points` WHERE `type` = 1 AND `server_id` = {$server->server_id} AND FROM_UNIXTIME(`points`.`timestamp`, '%Y-%m-%d') = `date`) AS `votes_count`
					FROM `points`
					WHERE `points`.`timestamp` > UNIX_TIMESTAMP(NOW() - INTERVAL 7 DAY) AND `server_id` = {$server->server_id}
					GROUP BY `date`
					ORDER BY `date`
					");
        ?>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript">
            google.load("visualization", "1", {packages:["corechart"]});
            google.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Date', 'Hits', 'Votes'],
                    <?php
                    while($data = $result->fetch_object())
                        echo "['" . $data->date . "', " . $data->hits_count . ", " . $data->votes_count . "],";
                    ?>
                ]);

                var options = {
                    title: <?php echo '\'' . $language['server']['statistics'] . '\''; ?>
                };

                var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
                chart.draw(data, options);
            }

            $(window).resize(function(){
                drawChart();
            });

            $('[href=#statistics]').on('shown.bs.tab', function() {
                drawChart();
            });
        </script>

        <div id="chart_div" style="width: 100%; height: 500px;"></div>

    </div>
</div>





<hr class="custom-one" />

<?php include 'template/includes/widgets/server_options.php'; ?>
