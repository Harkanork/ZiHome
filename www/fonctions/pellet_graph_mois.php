<?
$liste1 = "";
$liste2 = "";
$query9 = "SELECT COUNT(date) AS somme, date FROM `pellet` WHERE `date` > DATE_SUB(curdate(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(`date`, '%Y%m%d') ORDER BY DATE_FORMAT(`date`, '%Y%m%d')";
$req9 = mysql_query($query9, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value9 = mysql_fetch_assoc($req9)){
$somme = 0;
if(!(empty($value9))) {
$somme = $value9['somme'];
} else {
$somme = 0;
}
$liste1 .= "[".strtotime($value9['date']) * 1000 . "," . ($somme) ."],";
}
$nom = "Pellet";
?>
                <script type="text/javascript">
$(function () {
Highcharts.setOptions({
    global: {
        useUTC: false
    }
});
        $('#pellet-mois').highcharts({
            chart: {
            },
            title: {
                text: '<? echo $nom; ?>'
            },
            subtitle: {
                text: 'Quotidienne'
            },
            xAxis: [{
                type: 'datetime'
            }],
            yAxis: [{
                min: 0,
                title: {
                    text: 'Nb Activations'
                },
		style: {
		    color: '#89A54E'
		}
            }],
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
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
                name: 'Nb Activation',
                data: [<?php echo $liste1; ?>],
		color: '#89A54E',
                type: 'column'

            }]
        });
    });
                </script>

<div id="pellet-mois" style="width:<? echo $width; ?>;height:<? echo $height; ?>;"></div>
