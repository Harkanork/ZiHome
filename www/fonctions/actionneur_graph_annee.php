<?
$liste1 = "";
$liste2 = "";
$query9 = "SELECT SUM(actif) AS somme, date FROM `periph_".$periph['nom']."` WHERE `date` > DATE_SUB(curdate(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(`date`, '%Y%m') ORDER BY DATE_FORMAT(`date`, '%Y%m')";
$req9 = mysql_query($query9, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value9 = mysql_fetch_assoc($req9)){
$somme = 0;
$duree = 0;
if(!(empty($value9))) {
$somme = $value9['somme'];
} else {
$somme = 0;
}
if(!($somme == 0)) {
$duree = 0;
$query0 = "SELECT date FROM `periph_".$periph['nom']."` WHERE actif = 1 AND  DATE_FORMAT('".$value9['date']."', '%Y%m') = DATE_FORMAT(`date`, '%Y%m') ORDER BY date";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value0 = mysql_fetch_assoc($req0)) {
$query1 = "SELECT `date` FROM `periph_".$periph['nom']."` WHERE actif = 0 AND `date` > '".$value0['date']."' ORDER BY `date` LIMIT 1";
$req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$value1 = mysql_fetch_assoc($req1);
$query2 = "SELECT TIMESTAMPDIFF(SECOND, '".$value0['date']."', '".$value1['date']."') AS duree";
$req2 = mysql_query($query2, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$value2 = mysql_fetch_assoc($req2);
$duree += $value2['duree'];
}
} else {
$duree = 0;
}
$liste1 .= "[".strtotime($value9['date']) * 1000 . "," . ($somme) ."],";
$liste2 .= "[".strtotime($value9['date']) * 1000 . "," . ($duree) ."],";
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
        $('#actioneur_<? echo $periph['id']; ?>-annee').highcharts({
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
            }, {
                min: 0,
                title: {
                    text: 'Duree Activation (s)'
                },
		style: {
			color: '#4572A7'
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

            }, {
                name: 'Duree Activation',
                yAxis: 1,
                data: [<?php echo $liste2; ?>],
		color: '#4572A7',
                type: 'column'
            }]
        });
    });
                </script>

<div id="actioneur_<? echo $periph['id']; ?>-annee" style="width:<? echo $width; ?>;height:<? echo $height; ?>;"></div>
