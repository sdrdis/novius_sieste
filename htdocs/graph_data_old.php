<?php
define('NOS_ENTRY_POINT', 'front');

$_SERVER['NOS_ROOT'] = realpath(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..');

require_once $_SERVER['NOS_ROOT'].DIRECTORY_SEPARATOR.'novius-os'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'bootstrap.php';


$res = Novius\Sieste\Helper::getDatas(3000); // limit ?
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Graph demo</title>

    <style type="text/css">
        body {font: 10pt arial;}
    </style>

    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript" src="/static/apps/novius_sieste/plugins/graph-1.3.2/graph.js"></script>
    <!--[if IE]><script type="text/javascript" src="/static/apps/novius_sieste/plugins/graph-1.3.2/excanvas.js"></script><![endif]-->
    <link rel="stylesheet" type="text/css" href="/static/apps/novius_sieste/plugins/graph-1.3.2/graph.css">
    <meta http-equiv="refresh" content="10">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript">
        var datas = <?= json_encode($res) ?>;
        google.load("visualization", "1");

        // Set callback to run when API is loaded
        google.setOnLoadCallback(drawVisualization);

        // Called when the Visualization API is loaded.
        function drawVisualization() {
            // Create and populate a data table.
            var data = new google.visualization.DataTable();
            data.addColumn('datetime', 'time');
            data.addColumn('number', 'Value 1');
            data.addColumn('number', 'Average 1');

            // create data
            for (var i = 0; i < datas.length; i++) {
                //data.addRow([new Date(d), functionA(i), functionB(i)]);
                var value = parseFloat(datas[i]['datas'][0]['value']);
                var average = parseFloat(datas[i]['datas'][0]['average']);
                if (average < 20) {
                    average = value;
                }
                var val = [new Date(datas[i]['date'] * 1000), value, average];
                data.addRow(val);

            }

            // specify options
            var options = {
                "width":  "100%",
                "height": "350px"
            };

            // Instantiate our graph object.
            var graph = new links.Graph(document.getElementById('mygraph'));

            // Draw our graph with the created data and options
            graph.draw(data, options);
            console.log(data);
            data.removeRows(0, data.getNumberOfRows());
            var dateAfter = new Date();
            dateAfter.setHours(23);

            data.addRow([new Date(), 100, 50]);
            data.addRow([dateAfter, 150, 20]);
            graph.draw(data);
            //graph.refresh();
            //graph.redraw();
        }
    </script>
</head>

<body>
<div id="mygraph"></div>

<div id="info"></div>
</body>
</html>
