<?php
$liste1 = "";
$liste2 = "";
$puiss_min=10000;
$puiss_max=0;
$query0 = "SELECT * FROM `conso_".$periph['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 1 DAY)";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value0 = mysql_fetch_assoc($req0))
{
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
$(function() {
Highcharts.setOptions({
    global: {
        useUTC:false
    },
    lang: {
        numericSymbols: null 
    }
});
        $('#conso_elec_heure_<? echo $periph['id']; ?>').highcharts({
            chart: {
                type: 'spline'
            },
            title: {
                text: 'Evolution de la puissance instantannée - <? echo $periph['libelle'] ?>'
            },
            subtitle: {
                text: 'Détail sur 1 journee'
            },
            xAxis: [{
                type: 'datetime'
             }],
            yAxis: {
                title: {
                    text: 'Puissance instantannée en W'
                },
                plotLines : [{ // lignes min et max
                    value : <?php echo $puiss_min; ?>,
                    color : 'white',
                    dashStyle : 'shortdash',
                    width : 2,
                    label : {
                        text : 'Minimum journalier <?php echo $puiss_min; ?> W'
                    },
                    zIndex:99
                }, {
                    value : <?php echo $puiss_max; ?>,
                    color : 'red',
                    dashStyle : 'shortdash',
                    width : 2,
                    label : {
                        text : 'Maximum journalier <?php echo $puiss_max; ?> W'
                    }
                }],
                style: {
	               color: '<? echo $couleurgraph1; ?>'
                },
                min: 0
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        Highcharts.dateFormat('%H:%M', this.x) +'- '+ this.y +' W';
                }
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
                data: [<?php echo $liste1; ?>]
            },{
                type: 'areaspline',
                name: 'Heures pleines',
                color: '<? echo $couleurgraph1; ?>',
                data: [<?php echo $liste2; ?>]
            }],
            legend : {
                enabled:false
            }
        });
    });
                </script>
<div id="conso_elec_heure_<? echo $periph['id']; ?>" style="width:<? echo $width; ?>;height:<? echo $height; ?>;"></div>
