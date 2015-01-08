<?php
$liste1 = "";
$liste2 = "";
$puiss_min=10000;
$puiss_max=0;
$query0 = "SELECT * FROM `conso_".$periph['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 8 DAY)";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value0 = mysql_fetch_assoc($req0)) {
    $HC=false;
    foreach($heuresCreuses as $heureCreuse){
        if ($heureCreuse['debut'] != "00:00:00" || $heureCreuse['fin'] != "00:00:00") {
            if (($value0['date'] >= substr($value0['date'], 0, 10)." ".$heureCreuse['debut'] ) AND ( $value0['date'] <= substr($value0['date'], 0, 10)." ".$heureCreuse['fin'])) {
                $HC=true;
            }
        }
    }
    if ($HC) { 
        $liste1 .= "[".strtotime($value0['date']) * 1000 . "," . $value0['conso'] ."],";
        $liste2 .= "[".strtotime($value0['date']) * 1000 . ",0],";
    } else {
        $liste1 .= "[".strtotime($value0['date']) * 1000 . ",0],";
        $liste2 .= "[".strtotime($value0['date']) * 1000 . "," . $value0['conso'] ."],";
    }
    if ($value0['conso'] < $puiss_min) { $puiss_min=$value0['conso'];}
    if ($value0['conso'] > $puiss_max) { $puiss_max=$value0['conso'];}
}
?>

<script type="text/javascript">
    $(function () {
        // Create the chart
        $('#conso_elec_heure_<? echo $periph['id']; ?>').highcharts('StockChart', {
            chart: {
                type: 'spline',
                borderWidth : 1,
                borderRadius : 5,
                borderColor: '<?php echo $couleurgraph1; ?>'
            },
            title: {
                text: 'Evolution de la puissance instantannée - <? echo $periph['libelle'] ?>',
                style: {
                        color: '<?php echo $couleurgraph1; ?>',
                        fontSize: '15px',
                        fontWeight: 'bold'
                },
            },
            subtitle: {
                text: 'Historique récent des puissances consommées',
                style: {
                        color: '<?php echo $couleurgraph2; ?>',
                        fontSize: '12px',
                        fontWeight: 'bold'
                },
            },
            xAxis: [{
                type: 'datetime',
                labels : {
                    style: {
                        color: '<?php echo $couleurgraph1; ?>',
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
                }, {
                    type: 'week',
                    count: 1,
                    text: 'Semaine'
                }],
                selected : 1,
                buttonSpacing : 5,
                buttonTheme: { // styles for the buttons
                    fill: '<?php echo $couleurgraph2; ?>',
                    stroke: '<?php echo $couleurgraph2; ?>',
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
                            fill: '<?php echo $couleurgraph1; ?>',
                            stroke: '<?php echo $couleurgraph1; ?>',
                        },
                        select: {
                            fill: '<?php echo $couleurgraph1; ?>',
                            stroke: '<?php echo $couleurgraph1; ?>',
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
                    text: 'Puissance instantannée en W',
                    style: {
                        color: '<?php echo $couleurgraph1; ?>',
                        fontSize: '12px',
                        fontWeight: 'bold'
                    },
                },
                plotLines : [{ // lignes min et max
                    value : <?php echo $puiss_min; ?>,
                    color : 'white',
                    dashStyle : 'shortdash',
                    width : 2,
                    label : {
                        text : 'Minimum <?php echo $puiss_min; ?> W'
                    },
                    zIndex:99
                }, {
                    value : <?php echo $puiss_max; ?>,
                    color : 'red',
                    dashStyle : 'shortdash',
                    width : 2,
                    label : {
                        text : 'Maximum <?php echo $puiss_max; ?> W'
                    },
                    zIndex:98
                }],
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
                name: 'Heures creuses',
                color: '<? echo $couleurgraph2; ?>',
                data:[<?php echo $liste1; ?>],
            },{
                type: 'areaspline',
                name: 'Heures pleines',
                color: '<? echo $couleurgraph1; ?>',
                data: [<?php echo $liste2; ?>]
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
                            s += this.series.name + ' : ' + Math.round(this.y) + ' W<br/>';
                            pos += 1 ;
                        }
                    });
                    if (pos = 0) {
                        s += 'Puissance : 0 W';
                    }
                    return s;
                }
            },
            navigator: {
                xAxis: {
                    labels: {
                        style : {
                            color: '<?php echo $couleurgraph1; ?>',
                            fontSize: '11px',
                            fontWeight: 'bold'
                        },
                    },
                },
            }
        });
    });
</script>

<div id="conso_elec_heure_<? echo $periph['id']; ?>" style="width:<? echo $width; ?>;height:<? echo $height; ?>;"></div>
