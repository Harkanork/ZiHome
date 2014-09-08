<?php
$liste1 = "";
$query0 = "SELECT * FROM `pluie_".$periph['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 1 DAY) order by `date`";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$value0 = mysql_fetch_assoc($req0);
if ($value0)
{
  $prev = $value0['cumul'];
  while($value0 = mysql_fetch_assoc($req0))
  {
    $delta = $value0['cumul'] - $prev;
    $prev = $value0['cumul'];
    $liste1 .= "[".strtotime($value0['date']) * 1000 . "," . $delta ."],";
  }
}

if($periph['libelle'] == ""){
  $nom = $periph['nom'];
} else {
  $nom = $periph['libelle'];
}

?>
  <script type="text/javascript">
    $(function() {
        Highcharts.setOptions({
            global: {
                useUTC: false
            }
    });
        $('#pluie_heure_<? echo $periph['id']; ?>').highcharts({
            chart: {
                type: 'spline'
            },
            title: {
                text: '<? echo $nom; ?>'
            },
            subtitle: {
                text: 'Détail sur 1 journée'
            },
            xAxis: {
                type: 'datetime'
             },
            yAxis: {
                title: {
                    text: 'Précipitation'
                },
                style: {
                    color: '<? echo $couleurgraph2; ?>'
                },
                min: 0
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                spline: {
                    marker: {
                        enabled: false
                    },
                }
            },

            series: [{
                name: 'Précipitation',
                color: '<? echo $couleurgraph2; ?>',
                data: [<?php echo $liste1; ?>]
            }]
        });
    });
  </script>
<div id="pluie_heure_<? echo $periph['id']; ?>" style="width:<? echo $width; ?>;height:<? echo $height; ?>;"></div>
