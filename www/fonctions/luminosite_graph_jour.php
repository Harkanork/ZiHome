<?
$liste1 = "";
$query0 = "SELECT * FROM `luminosite_".$periph['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 1 DAY)";

$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value0 = mysql_fetch_assoc($req0))
{
  $liste1 .= "[".strtotime($value0['date']) * 1000 . "," . $value0['lum'] ."],";
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
                text: 'Luminosité'
            },
            xAxis: [{
                type: 'datetime'
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    formatter: function() {
                        return this.value + '';
                    },
                    style: {
                    }
                },
                title: {
                    text: 'Luminosité',
                    style: {
                    },
		style: {
			color: '#89A54E'
		}
                },
            }],
            tooltip: {
                shared: true
            },
            series: [{
                name: 'Luminosité',
                type: 'spline',
		color: '#89A54E',
                data: [<?php echo $liste1; ?>],
                marker: {
                    enabled: false
                },
                tooltip: {
                    valueSuffix: ' '
                }
            }]
        });
    });
</script>
<div id="jour-<? echo $periph['id']; ?>" style="width:<? echo $width; ?>;height:<? echo $height; ?>;"></div>
