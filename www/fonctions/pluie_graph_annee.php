<?
$query0 = "SELECT max(cumul) as max, min(cumul) as min, date FROM `pluie_".$periph['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(`date`, '%Y%m')";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$liste1 = "";
while($value0 = mysql_fetch_assoc($req0))
{
  $delta = $value0['max'] - $value0['min'];
  $liste1 .= "[".strtotime($value0['date']) * 1000 . "," . $delta ."],";
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
        $('#global-<? echo $periph['id']; ?>').highcharts({
            chart: {
            },
            title: {
                text: '<? echo $nom; ?>'
            },
            subtitle: {
                text: 'Annuel'
            },
            xAxis: [{
                type: 'datetime',
                minTickInterval: 3600*24*30*1000,//time in milliseconds
                minRange: 3600*24*30*1000,
                ordinal: false, //this sets the fixed time formats
                showEmpty: true
            }],
            yAxis: [{
                min: 0,
                style: {
                    color: '<? echo $couleurgraph2; ?>'
                },
                title: {
                    text: 'Précipitation'
                }
            }],
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Précipitation',
                data: [<?php echo $liste1; ?>],
                color: '<? echo $couleurgraph2; ?>',
                type: 'column'
            }]
        });
    });
</script>

<div id="global-<? echo $periph['id']; ?>" style="width:<? echo $width; ?>;height:<? echo $height; ?>;"></div>

