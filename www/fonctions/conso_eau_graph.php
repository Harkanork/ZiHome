<?php
$liste1 = "";
$datePrecedente=0;
$query0 = "SELECT * FROM `eau_".$periph['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL " . $graphInterval . " DAY)";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value0 = mysql_fetch_assoc($req0)) 
{
  $dateCourante = strtotime($value0['date']);
  
  // On rajoute des valeurs nulles pour éviter les interpolations a rallonge
  // On part du principe que les valeurs sont en moyenne toutes les secondes
  if ($datePrecedente > 0 && $dateCourante - $datePrecedente > 15 * 60)
  {
    $liste1 .= "[". (($datePrecedente + 5 * 60) * 1000) . "," . 0 ."],";
    $liste1 .= "[". (($dateCourante - 5 * 60) * 1000) . "," . 0 ."],";
  }
    
  $liste1 .= "[". ($dateCourante * 1000) . "," . $value0['conso'] ."],";
  
  $datePrecedente = $dateCourante;
}

$dateCourante = time();
if ($datePrecedente > 0 && $dateCourante - $datePrecedente > 15 * 60)
{
  $liste1 .= "[". (($datePrecedente + 5 * 60) * 1000) . "," . 0 ."],";
  $liste1 .= "[". ($dateCourante * 1000) . "," . 0 ."],";
}

if($periph['libelle'] == ""){
  $nom = $periph['nom'];
} else {
  $nom = $periph['libelle'];
}
?>

<script type="text/javascript">
    $(function () {
        // Create the chart
        $('#conso_eau_<? echo $periph['id']; ?>').highcharts('StockChart', {
            chart: {
                type: 'spline',
                borderWidth : 1,
                borderRadius : 5,
                borderColor: '<?php echo $couleurgraph2; ?>'
            },
            title: {
                text: 'Evolution de la consommation - <? echo $nom ?>',
                style: {
                        color: '<?php echo $couleurgraph2; ?>',
                        fontSize: '15px',
                        fontWeight: 'bold'
                },
            },
            xAxis: [{
                type: 'datetime',
                ordinal: false,
                labels : {
                    style: {
                        color: '<?php echo $couleurgraph2; ?>',
                        fontSize: '12px',
                        fontWeight: 'bold'
                    }
                },
             }],
            rangeSelector : {
                buttons: [{
                    type: 'hour',
                    count: 1,
                    text: 'Heure'
                }, {
                    type: 'day',
                    count: 1,
                    text: 'Journée'
                }
                <? 
                  if ($graphInterval > 7) {
                    echo ", { type: 'week', count: 1, text: 'Semaine' }";
                  }
                ?>
                ],
                selected : 1,
                buttonSpacing : 5,
                buttonTheme: { // styles for the buttons
                    fill: '<?php echo $couleurgraph1; ?>',
                    stroke: '<?php echo $couleurgraph1; ?>',
                    width : 60,
                    height : 12,
                    r:4,
                    style: {
                        color: '#FFFFFF',
                        fontSize: '9px',
                        fontWeight: 'bold'
                    },
                    states: {
                        hover: {
                            fill: '<?php echo $couleurgraph2; ?>',
                            stroke: '<?php echo $couleurgraph2; ?>',
                        },
                        select: {
                            fill: '<?php echo $couleurgraph2; ?>',
                            stroke: '<?php echo $couleurgraph2; ?>',
                            style: {
                                color: '#FFFFFF',
                                fontSize: '10px',
                                fontWeight: 'bold'
                            },
                        }
                    }
                },
                inputEnabled: false
            },
            yAxis: {
                title: {
                    text: 'Consommation en litre',
                    style: {
                        color: '<?php echo $couleurgraph2; ?>',
                        fontSize: '12px',
                        fontWeight: 'bold'
                    },
                },
                style: {
                   color: '#0000a0'
                },
                min: 0
            },
            plotOptions: {
                areaspline: {
                    marker: {
                        enabled: false
                    },
                }
            },
            series: [{
                type: 'areaspline',
                name: 'Consommation',
                color: '<? echo $couleurgraph2; ?>',
                data:[<?php echo $liste1; ?>],
            }],
            legend : {
                enabled:false
            },
            tooltip: {
                valueDecimals: 0,
                formatter: function () {
                    var s = '<b>' + Highcharts.dateFormat('%A %e %B %Y - %H:%M', this.x) + '</b><br/>';
                    var pos=0;
                    $.each(this.points, function () {
                        if (this.y > 0) {
                            s += this.series.name + ' : ' + Math.round(this.y) + ' l<br/>';
                            pos += 1 ;
                        }
                        else {
                            s += this.series.name + ' : 0 l<br/>';
                            pos += 1 ;
                        }
                    });
                    if (pos = 0) {
                        s += 'Consommation : 0 l';
                    }
                    return s;
                }
            },
            navigator: {
                xAxis: {
                    labels: {
                        style : {
                            color: '<?php echo $couleurgraph2; ?>',
                            fontSize: '11px',
                            fontWeight: 'bold'
                        },
                    },
                },
            }
        });
    });
</script>

<div id="conso_eau_<? echo $periph['id']; ?>" style="width:<? echo $width; ?>;height:<? echo $height; ?>;"></div>
