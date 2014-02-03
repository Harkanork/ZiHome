<?
$liste1 = "";
$liste2 = "";
$query0 = "SELECT * FROM `temperature_".$periph['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 1 DAY)";

$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value0 = mysql_fetch_assoc($req0))
{
$liste1 .= "[".strtotime($value0['date']) * 1000 . "," . $value0['temp'] ."],";
if(!($value0['hygro'] == 0)) {
$liste2 .= "[".strtotime($value0['date']) * 1000 . "," . $value0['hygro'] ."],";
}
}
if($periph['libelle'] == ""){
$nom = $periph['nom'];
} else {
$nom = $periph['libelle'];
}
?>
<script type="text/javascript">
$(function () {
Highcharts.setOptions({
    global: {
        useUTC: false
    }
});
        $('#jour-<? echo $periph['id']; ?>').highcharts({
            chart: {
            },
            title: {
                text: '<? echo $nom; ?>'
            },
            subtitle: {
                text: 'Temperature et Hygrometrie'
            },
            xAxis: [{
                type: 'datetime'
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    formatter: function() {
                        return this.value +'°C';
                    },
                    style: {
                    }
                },
                title: {
                    text: 'Temperature',
                    style: {
                    }
                },
<? if(!($liste2 == "")) { ?>
            }, { // Tertiary yAxis
                gridLineWidth: 0,
                title: {
                    text: 'Hygrometrie',
                    style: {
                    }
                },
                labels: {
                    formatter: function() {
                        return this.value +' %';
                    },
                    style: {
                    }
                },
<? } ?>
            }],
            tooltip: {
                shared: true
            },
            series: [{
<? if(!($liste2 == "")) { ?>
                name: 'Hygrometrie',
                type: 'spline',
                yAxis: 1,
                data: [<?php echo $liste2; ?>],
                marker: {
                    enabled: false
                },
                tooltip: {
                    valueSuffix: ' %'
                }
            }, {
<? } ?>
                name: 'Temperature',
                type: 'spline',
                data: [<?php echo $liste1; ?>],
                marker: {
                    enabled: false
                },
                tooltip: {
                    valueSuffix: ' °C'
                }
            }]
        });
    });
</script>
<div id="jour-<? echo $periph['id']; ?>" style="width:<? echo $width; ?>;height:<? echo $height; ?>;"></div>
