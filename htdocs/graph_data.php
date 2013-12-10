<?php
define('NOS_ENTRY_POINT', 'front');

$_SERVER['NOS_ROOT'] = realpath(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..');

require_once $_SERVER['NOS_ROOT'].DIRECTORY_SEPARATOR.'novius-os'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'bootstrap.php';


$res = Novius\Sieste\Helper::getDatas(\Fuel::$env === \Fuel::PRODUCTION ? 3000 : 100);
$res = array_reverse($res);
?>
<html>
    <head>
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="http://code.highcharts.com/stock/highstock.js"></script>
        <script src="http://code.highcharts.com/stock/modules/exporting.js"></script>
        <script type="text/javascript">
<?php if (\Fuel::$env === \Fuel::DEVELOPMENT) { ?>
            setInterval(function() {
                var temp = Math.random() * 4 + 22;
                $.ajax({
                    url: 'save_data.php',
                    data: {
                        v: temp * 100,
                        a: (temp + Math.random() * 2 - 1) * 100,
                        t: 'p'
                    }
                });
            }, 2000);
<?php } ?>
            function processValues(newData, seriesId, data, isOriginal) {
                for (var i = 0; i < newData.length; i++) {
                    console.log(newData[i]);
                    var dataItem = [
                        newData[i].date * 1000,
                        parseFloat(newData[i].datas[seriesId].value)
                    ];
                    if (isOriginal) {
                        data.push(dataItem);
                    } else {
                        data.addPoint(dataItem, true, false, {duration: 0});
                    }
                    lastDate = newData[i].date;
                }
            }

            function processMeans(newData, seriesId, data, isOriginal) {
                for (var i = 0; i < newData.length; i++) {
                    var value = parseFloat(newData[i]['datas'][seriesId]['value']);
                    var average = parseFloat(newData[i]['datas'][seriesId]['average']);
                    if (average < 20) {
                        average = value;
                    }

                    var dataItem = [
                        newData[i].date * 1000,
                        average
                    ];

                    if (isOriginal) {
                        data.push(dataItem);
                    } else {
                        data.addPoint(dataItem, true, false, {duration: 0});
                    }
                    lastDate = newData[i].date;
                }
            }


            var originalDatas = <?= json_encode($res) ?>;
            var lastDate = 0;
            $(function() {

                Highcharts.setOptions({
                    global : {
                        useUTC : false
                    }
                });

                // Create the chart
                $('#container').highcharts('StockChart', {
                    chart : {
                        events : {
                            load : function() {
                                // set up the updating of the chart each second
                                var seriesValues = this.series[0];
                                var seriesMeans = this.series[1];
                                setInterval(function() {
                                    $.ajax({
                                        url: 'export_data.php',
                                        data: {
                                            from_date: lastDate
                                        },
                                        success: function(data) {
                                            if (data) {
                                                processValues(data, 0, seriesValues, false);
                                                processMeans(data, 0, seriesMeans, false);
                                            }
                                        }
                                    });
                                }, 1000);
                            }
                        }
                    },

                    rangeSelector: {
                        buttons: [{
                            count: 1,
                            type: 'minute',
                            text: '1M'
                        }, {
                            count: 5,
                            type: 'minute',
                            text: '5M'
                        }, {
                            count: 1,
                            type: 'hour',
                            text: '1H'
                        }, {
                            count: 1,
                            type: 'day',
                            text: '1D'
                        }, {
                            type: 'all',
                            text: 'All'
                        }],
                        inputEnabled: false,
                        selected: 3
                    },

                    title : {
                        text : 'Salle de sieste'
                    },

                    exporting: {
                        enabled: false
                    },
                    xAxis: {
                        ordinal: false
                    },
                    plotOptions: {
                        series: {
                            animation: false
                        }
                    },
                    series : [{
                        name : 'Valeurs',
                        animation: false,
                        data : (function() {
                            // generate an array of random data
                            //console.log(originalDatas);
                            var data = [];
                            processValues(originalDatas, 0, data, true);
                            return data;
                        })()
                    },
                    {
                        name : 'Moyenne',
                        animation: false,
                        data : (function() {
                            // generate an array of random data
                            var data = [];
                            processMeans(originalDatas, 0, data, true);
                            return data;
                        })()
                    }]
                });

            });
/*

 {
 name : 'Moyenne',
 id : 'datamoyenne',
 data : (function() {
 // generate an array of random data
 //console.log(originalDatas);
 var data = [];
 for (var i = 0; i < originalDatas.length; i++) {
 var value = parseFloat(originalDatas[i]['datas'][0]['value']);
 var average = parseFloat(originalDatas[i]['datas'][0]['average']);
 if (average < 20) {
 average = value;
 }

 data.push([
 originalDatas[i].date * 1000,
 average
 ]);
 }
 return data;
 })()
 },
 {
 type : 'flags',
 data : (function() {
 // generate an array of random data
 //console.log(originalDatas);
 var data = [];
 prev = 0;
 j=0;
 for (var i = 0; i < originalDatas.length; i++) {
 if (originalDatas[i]['datas'][0]['type'] == 'boom') {
 //console.log(originalDatas[i]['datas'][0]['type']);
 if (prev + 300 < originalDatas[i].date) {
 var d = new Date(originalDatas[i].date);

 data.push({
 x : originalDatas[i].date * 1000,
 title : d.getHours() + " " + d.getMinutes() + " " + d.getSeconds(),
 });
 prev = originalDatas[i].date;
 }
 }
 }
 return data;
 })(),
 onSeries : 'datamoyenne',
 //shape : 'circlepin',
 width : 16
 }
             */




        </script>
    </head>
    <body>
        <div id="container" style="height: 500px; min-width: 500px"></div>
    </body>
</html>