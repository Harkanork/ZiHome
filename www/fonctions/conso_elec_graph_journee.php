<?php
$liste1 = "";
include("./pages/connexion.php");
$query0 = "SELECT * FROM `conso_".$periph['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 1 DAY)";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value0 = mysql_fetch_assoc($req0))
{
$liste1 .= "[".strtotime($value0['date']) * 1000 . "," . $value0['conso'] ."],";
}

?>
                <script type="text/javascript">
$(function() {
Highcharts.setOptions({
    global: {
        useUTC: false
    }
});
        $('#conso_elec_heure_<? echo $periph['id']; ?>').highcharts({
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
<div id="conso_elec_heure_<? echo $periph['id']; ?>" style="width:<? echo $width; ?>;height:<? echo $height; ?>;"></div>
