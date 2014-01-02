<?
$query0 = "SELECT max(conso_total) as max, min(conso_total) as min, date FROM `conso_".$periph['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(`date`, '%Y%m%d')";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$liste1 = "";
$liste2 = "";
while($value0 = mysql_fetch_assoc($req0))
{
$consoTemp = 0;
foreach($heuresCreuses as $heureCreuse){
$query6 = "SELECT min(conso_total) as min, max(conso_total) as max FROM `conso_".$periph['nom']."` where `date` >= '".substr($value0['date'], 0, 10)." ".$heureCreuse['debut']."' and `date` <= '".substr($value0['date'], 0, 10)." ".$heureCreuse['fin']."'";
$res_query6 = mysql_query($query6, $link);
if(mysql_numrows($res_query6) > 0){
$consoTemp += mysql_result($res_query6,0,"max") - mysql_result($res_query6,0,"min");
}
}
$liste1 .= "[".strtotime($value0['date']) * 1000 . "," . ($value0['max'] - $value0['min']) ."],";
$liste2 .= "[".strtotime($value0['date']) * 1000 . "," . number_format(((($consoTemp*$coutHC/1000)+(($value0['max'] - $value0['min'] - $consoTemp)*$coutHP)/1000)*100),2) ."],";
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
        $('#conso_elec_<? echo $periph['id']; ?>').highcharts({
            chart: {
            },
            title: {
                text: '<? echo $nom; ?>'
            },
            subtitle: {
                text: 'Quotidienne'
            },
            xAxis: [{
                type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                    month: '%e. %b',
                    year: '%b'
                }
            }],
            yAxis: [{
                min: 0,
                title: {
                    text: 'Consommation (Wh)'
                }
            }, {
                min: 0,
                title: {
                    text: 'Cout (Cent)'
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
                name: 'Consommation (Wh)',
                data: [<?php echo $liste1; ?>],
                type: 'column'

            }, {
                name: 'Cout (Cent)',
                yAxis: 1,
                data: [<?php echo $liste2; ?>],
                type: 'column'
            }]
        });
    });
                </script>

<div id="conso_elec_<? echo $periph['id']; ?>" style="width:<? echo $width; ?>;height:<? echo $height; ?>;"></div>
