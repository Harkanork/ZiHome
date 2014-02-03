<?php
$liste1 = "";
$query0 = "SELECT * FROM `vent_".$periph['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 1 DAY)";

$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value0 = mysql_fetch_assoc($req0))
{
$liste1 .= "[".strtotime($value0['date']) * 1000 . "," . ($value0['vitesse']/10) ."],";
}

?>
<script type="text/javascript">
$(function () {
Highcharts.setOptions({
    global: {
        useUTC: false
    }
});
        $('#<? echo $periph['id']; ?>').highcharts({
            chart: {
            },
            title: {
                text: '<? echo $periph['nom']; ?>'
            },
            subtitle: {
                text: 'Vitesse du vent'
            },
            xAxis: [{
                type: 'datetime'
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
<div id="<? echo $periph['id']; ?>" style="width:<? echo $width; ?>;height:<? echo $height; ?>; margin: 0 auto"></div>
