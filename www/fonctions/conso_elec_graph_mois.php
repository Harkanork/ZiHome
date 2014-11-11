<?
$query0 = "SELECT max(conso_total) as max, min(conso_total) as min, date FROM `conso_".$periph['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 21 DAY) GROUP BY DATE_FORMAT(`date`, '%Y%m%d')";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$liste1 = "";
$liste2 = "";
$liste3 = "";
$i=0;
while($value0 = mysql_fetch_assoc($req0))
{
    if ($i>0) {   // ne traite pas le premier jour, source d'erreur à cause du dacalage entre les deux requêtes (la première en intervalle depuis l'heure actuelle, la seconde sur la totalité de chaque jour, y compris le premier)
        $consoTemp = 0;
        foreach($heuresCreuses as $heureCreuse){
            if ($heureCreuse['debut'] != "00:00:00" || $heureCreuse['fin'] != "00:00:00")
            {
                $query6 = "SELECT min(conso_total) as min, max(conso_total) as max FROM `conso_".$periph['nom']."` where `date` >= '".substr($value0['date'], 0, 10)." ".$heureCreuse['debut']."' and `date` <= '".substr($value0['date'], 0, 10)." ".$heureCreuse['fin']."'";
                $res_query6 = mysql_query($query6, $link);
                if(mysql_numrows($res_query6) > 0){
                    $consoTemp += mysql_result($res_query6,0,"max") - mysql_result($res_query6,0,"min");
                }
            }
        }
        $liste1 .= "[".strtotime(substr($value0['date'], 0, 10)." 12:00:00") * 1000 . "," . ($value0['max'] - $value0['min'] - $consoTemp)/1000 ."],"; // Conso journalière heures pleines
        $liste2 .= "[".strtotime(substr($value0['date'], 0, 10)." 12:00:00") * 1000 . "," . ($consoTemp)/1000 ."],"; // Conso journalière heures creuses
        $liste3 .= "[".strtotime(substr($value0['date'], 0, 10)." 12:00:00") * 1000 . "," . number_format(((($consoTemp*$coutHC/1000)+(($value0['max'] - $value0['min'] - $consoTemp)*$coutHP)/1000)*100)/100,1) ."],";
    }
    $i++;
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
            legend: {
                enabled:true
            },
            title: {
                text: 'Evolution de la consommation quotidienne - <? echo $nom; ?>'
            },
            subtitle: {
                text: 'sur les 20 derniers jours'
            },
            xAxis: [{
                type: 'datetime'
            }],
            yAxis: [{
                min: 0,
                style: {
                  color: '<? echo $couleurgraph1; ?>'
                },
                title: {
                    text: 'Consommation journalière (kWh)'
                }
              }, {
                min: 0,
                style: {
                  color: 'red'
                },
                title: {
                    text: 'Cout (Euros)'
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
                    pointPadding: 0.1,
                    groupPadding:0.2,
                    borderWidth: 0,
                    pointPlacement: 0,
                    stacking: 'normal'
                }
            },
            series: [{
                name: 'Heures Pleines',
                data: [<?php echo $liste1; ?>],
                color: '<? echo $couleurgraph1; ?>',
                type: 'column',
                yAxis: 0
            }, {
                name: 'Heures Creuses',
                data: [<?php echo $liste2; ?>],
                color: '<? echo $couleurgraph2; ?>',
                type: 'column',
                yAxis : 0
            }, {
                name: 'Cout (Euros)',
                yAxis: 1,
                data: [<?php echo $liste3; ?>],
                color: 'red',
                type: 'line',
                yAxis: 1
            }]
        });
    });
</script>

<div id="conso_elec_<? echo $periph['id']; ?>" style="width:<? echo $width; ?>;height:<? echo $height; ?>;"></div>
