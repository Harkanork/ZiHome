<?
$liste1 = "";
$liste2 = "";
$liste3 = "";
$query0 = "SELECT max(conso_total) as max, min(conso_total) as min, date, DATE_FORMAT(`date`, '%Y-%m') AS mois FROM `conso_".$periph['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(`date`, '%Y%m')";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value0 = mysql_fetch_assoc($req0))
{
  $consoTemp = 0;
  $query1 = "SELECT max(conso_total) as max, min(conso_total) as min, date FROM `conso_".$periph['nom']."` WHERE date > DATE_SUB('".$value0['mois']."-1', INTERVAL 0 MONTH) AND date < DATE_SUB('".$value0['mois']."-1', INTERVAL -1 MONTH) GROUP BY DATE_FORMAT(`date`, '%Y%m%d')";
  $req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while($value1 = mysql_fetch_assoc($req1))
  {
    foreach($heuresCreuses as $heureCreuse){
      if ($heureCreuse['debut'] != "00:00:00" || $heureCreuse['fin'] != "00:00:00")
      {
        $query6 = "SELECT min(conso_total) as min, max(conso_total) as max FROM `conso_".$periph['nom']."` where `date` >= '".substr($value1['date'], 0, 10)." ".$heureCreuse['debut']."' and `date` <= '".substr($value1['date'], 0, 10)." ".$heureCreuse['fin']."'";
        $res_query6 = mysql_query($query6, $link);
        if(mysql_numrows($res_query6) > 0){
          $consoTemp += mysql_result($res_query6,0,"max") - mysql_result($res_query6,0,"min");
        }
      }
    }
  }
  $liste1 .= "[".strtotime(substr_replace($value0['date'], "01",8,2)) * 1000 . "," . (($value0['max'] - $value0['min'] - $consoTemp)/1000) ."],"; // heures pleines
  $liste2 .= "[".strtotime(substr_replace($value0['date'], "01",8,2)) * 1000 . "," . ($consoTemp/1000) ."],"; // heures creuses
  $liste3 .= "[".strtotime(substr_replace($value0['date'], "01",8,2)) * 1000 . "," . number_format(((($consoTemp*$coutHC/1000)+(($value0['max'] - $value0['min'] - $consoTemp)*$coutHP)/1000)),2) ."],";
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
        useUTC:false
    }
});
        $('#conso_elec_annuel_<? echo $periph['id']; ?>').highcharts({
            chart: {
            },
            title: {
                text: 'Evolution de la consommation mensuelle - <? echo $nom; ?>'
            },
            subtitle: {
                text: 'sur lannée passée'
            },
            xAxis: [{
                type: 'datetime'
            }],
            yAxis: [{
                min: 0,
                title: {
                    text: 'Consommation (kWh)'
                },
                style: {
                  color: '<? echo $couleurgraph1; ?>'
                }
              }, {
                min: 0,
                title: {
                    text: 'Cout (Euro)'
                },
                style: {
                  color: 'red'
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
                name: 'Heures pleines (kWh)',
                data: [<?php echo $liste1; ?>],
                color: '<? echo $couleurgraph1; ?>',
                type: 'column',
                yAxis : 0
            }, {
                name: 'Heures creuses (kWh)',
                data: [<?php echo $liste2; ?>],
                color: '<? echo $couleurgraph2; ?>',
                type: 'column',
                yAxis : 0
            }, {
                name: 'Cout (Euro)',
                yAxis: 1,
                data: [<?php echo $liste3; ?>],
                color: 'red',
                type: 'line',
                yAxis: 1
            }]
        });
    });
</script>

<div id="conso_elec_annuel_<? echo $periph['id']; ?>" style="width:<? echo $width; ?>;height:<? echo $height; ?>;"></div>
