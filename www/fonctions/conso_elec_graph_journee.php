<?php
$liste1 = "";
include("./pages/connexion.php");
$query0 = "SELECT * FROM `conso_".$data['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 1 DAY)";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data0 = mysql_fetch_assoc($req0))
{
$liste1 .= "[".strtotime($data0['date']) * 1000 . "," . $data0['conso'] ."],";
}

?>
                <script type="text/javascript">
$(function() {
Highcharts.setOptions({
    global: {
        useUTC: false
    }
});
        $('#conso_elec_heure_<? echo $data['id']; ?>').highcharts({
            chart: {
                type: 'spline'
            },
            title: {
                text: 'Consommation Electrique'
            },
            subtitle: {
                text: 'Detail sur 1 journee'
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                    month: '%e. %b',
                    year: '%b'
                }
             },
            yAxis: {
                title: {
                    text: 'Consommation Wh'
                },
                min: 0
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        Highcharts.dateFormat('%e. %b', this.x) +': '+ this.y +' Wh';
                }
             },
            plotOptions: {
                spline: {
                    marker: {
                        enabled: false
                    },
                }
            },

            series: [{
                name: 'Conso-Elec',
                data: [<?php echo $liste1; ?>]
            }]
        });
    });
                </script>
<div id="conso_elec_heure_<? echo $data['id']; ?>" style="min-width: 400px; width:100%; height: 400px; margin: 0 auto"></div>
