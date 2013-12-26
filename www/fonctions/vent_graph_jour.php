<?php
$liste1 = "";
$query0 = "SELECT * FROM `vent_".$data['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 1 DAY)";

$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data0 = mysql_fetch_assoc($req0))
{
$liste1 .= "[".strtotime($data0['date']) * 1000 . "," . ($data0['vitesse']/10) ."],";
}

?>
<script type="text/javascript">
$(function () {
Highcharts.setOptions({
    global: {
        useUTC: false
    }
});
        $('#<? echo $data['id']; ?>').highcharts({
            chart: {
            },
            title: {
                text: '<? echo $data['nom']; ?>'
            },
            subtitle: {
                text: 'Vitesse du vent'
            },
            xAxis: [{
                type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                    month: '%e. %b',
                    year: '%b'
                }
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    formatter: function() {
                        return this.value +'m/s';
                    },
                    style: {
                    }
                },
                title: {
                    text: 'Vitesse',
                    style: {
                    }
                },
            }],
            tooltip: {
                shared: true
            },
            series: [{
                name: 'Vent',
                type: 'spline',
                data: [<?php echo $liste1; ?>],
                marker: {
                    enabled: false
                },
                tooltip: {
                    valueSuffix: ' m/s'
                }
            }]
        });
    });
</script>
<div id="<? echo $data['id']; ?>" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
