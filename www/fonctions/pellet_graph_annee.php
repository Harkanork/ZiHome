<?
$query = "SELECT * FROM paramettres WHERE libelle = 'pellet'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
  $pellet = $data['value'];
}
$liste1 = "";
$query9 = "SELECT COUNT(date) AS somme, date FROM `pellet` WHERE `date` > DATE_SUB(curdate(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(`date`, '%Y%m') ORDER BY DATE_FORMAT(`date`, '%Y%m')";
$req9 = mysql_query($query9, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value9 = mysql_fetch_assoc($req9)){
$somme = 0;
$duree = 0;
if(!(empty($value9))) {
$somme = $value9['somme']*$pellet;
} else {
$somme = 0;
}
$liste1 .= "[".strtotime($value9['date']) * 1000 . "," . ($somme) ."],";
}
$nom = "pellet";
?>
                <script type="text/javascript">
$(function () {
Highcharts.setOptions({
    global: {
        useUTC: false
    }
});
        $('#pellet-annee').highcharts({
            chart: {
            },
            title: {
                text: '<? echo $nom; ?>'
            },
            subtitle: {
                text: 'Annuel'
            },
            xAxis: [{
                type: 'datetime'
            }],
            yAxis: [{
                min: 0,
                title: {
                    text: 'Qte Pellet'
                },
		style: {
			color: '<? echo $couleurgraph1; ?>'
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
                name: 'Qte Pellet',
                data: [<?php echo $liste1; ?>],
		color: '<? echo $couleurgraph1; ?>',
                type: 'column'
            }]
        });
    });
                </script>

<div id="pellet-annee" style="width:<? echo $width; ?>;height:<? echo $height; ?>;"></div>
