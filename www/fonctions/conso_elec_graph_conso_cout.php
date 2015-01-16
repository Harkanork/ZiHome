<?
$query0 = "SELECT max(conso_total) as max, min(conso_total) as min, date FROM `conso_".$periph['nom']."` GROUP BY DATE_FORMAT(`date`, '%Y%m%d')";
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
                if ($heureCreuse['fin']=="00:00:00" || $heureCreuse['fin']=="24:00:00") { $heureCreuse['fin']="23:59:59";} // cas où la plage HC est à cheval sur deux jours
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
        // Create the chart
        $('#conso_elec_<? echo $periph['id']; ?>').highcharts('StockChart', {
            chart: {
                borderWidth : 1,
                borderRadius : 5,
                borderColor: '<?php echo $couleurgraph1; ?>'
            },
            title: {
                text: 'Evolution de la consommation - <? echo $periph['libelle'] ?>',
                style: {
                        color: '<?php echo $couleurgraph1; ?>',
                        fontSize: '15px',
                        fontWeight: 'bold'
                },
            },
            subtitle: {
                text: 'Historique de la consommation quotidienne',
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
                    type: 'week',
                    count: 1,
                    text: 'Semaine'
                }, {
                    type: 'month',
                    count: 1,
                    text: 'Mois'
                }, {
                    type: 'year',
                    count: 1,
                    text: 'Année'
                }, {
                    type: 'all',
                    count: 1,
                    text: 'Tout'
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
            yAxis: [{
                min:0,
                title: {
                    text: 'Consommation journalière (kWh)',
                    style: {
                        color: '<?php echo $couleurgraph1; ?>',
                        fontSize: '12px',
                        fontWeight: 'bold'
                    },
                }
            },{
                min:0,
                title: {
                    text: 'Cout (Euros)',
                    style: {
                        color: 'red',
                        fontSize: '12px',
                        fontWeight: 'bold'
                    },
                }
            }],
           plotOptions: {
                column: {
                    pointPadding: 0.1,
                    groupPadding:0.2,
                    borderWidth: 0,
                    pointPlacement: 0,
                    stacking: 'normal',
                    dataGrouping: {
                        approximation: "sum" ,
                        units: [[
                            'month',
                            [1]
                        ]]
                    },
                },
                line : {
                    dataGrouping: {
                        approximation: "sum" ,
                        units: [[
                            'month',
                            [1]
                        ]]
                    },
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
                data: [<?php echo $liste3; ?>],
                color: 'red',
                type: 'line',
                yAxis: 1
            }],
            tooltip: {
                valueDecimals: 1,
                formatter: function () {
                    var s = '<b>';
                    var conso = this.points[0].y + this.points[1].y;
                    if (this.points[0].series.currentDataGrouping) {
                        s += Highcharts.dateFormat('%B %Y', this.x) + '</b><br/>';
                        s += 'Consommation : ' + Math.round(conso) + ' kWh<br/>';
                        s += 'Coût : ' + Math.round(this.points[2].y) + ' €';
                    } 
                    if (!this.points[0].series.currentDataGrouping) {
                        s += Highcharts.dateFormat('%A %e %B %Y', this.x) + '</b><br/>';
                        s += 'Consommation : ' + Math.round(conso*10)/10 + ' kWh<br/>';
                        s += 'Coût : ' + Math.round(this.points[2].y*10)/10 + ' €';
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
            },
            legend: {
                enabled:true
            }
        });
    });
</script>



<div id="conso_elec_<? echo $periph['id']; ?>" style="width:<? echo $width; ?>;height:<? echo $height; ?>;"></div>
