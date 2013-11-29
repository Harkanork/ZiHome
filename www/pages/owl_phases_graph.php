<?php
$liste1 = "";
$liste2 = "";
$liste3 = "";
$liste4 = "";
include("./pages/connexion.php");
if(isset($_GET['delai'])) {
if($_GET['delai'] == "heure") {
$query = "SELECT * FROM owl_detail WHERE date > DATE_SUB(NOW(), INTERVAL 1 HOUR)";
} else if($_GET['delai'] == "jour") {
$query = "SELECT * FROM owl_detail WHERE date > DATE_SUB(NOW(), INTERVAL 1 DAY)";
} else if($_GET['delai'] == "mois") {
$query = "SELECT * FROM owl_detail WHERE date > DATE_SUB(NOW(), INTERVAL 1 MONTH)";
} else {
$query = "SELECT * FROM owl_detail WHERE date > DATE_SUB(NOW(), INTERVAL 1 HOUR)";
}
} else {
$query = "SELECT * FROM owl_detail WHERE date > DATE_SUB(NOW(), INTERVAL 1 HOUR)";
}
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_assoc($req))
{
$liste1 .= "[".strtotime($data['date']) * 1000 . "," . $data['chan1'] /1000 ."],";
$liste2 .= "[".strtotime($data['date']) * 1000 . "," . $data['chan2'] /1000 ."],";
$liste3 .= "[".strtotime($data['date']) * 1000 . "," . $data['chan3'] /1000 ."],";
$liste4 .= "[".strtotime($data['date']) * 1000 . "," . ($data['chan1'] + $data['chan2'] + $data['chan3']) /1000 ."],";
}

?>
		<script type="text/javascript">
$(function() {
Highcharts.setOptions({
    global: {
        useUTC: false
    }
});
	$('#phases').highcharts({
            chart: {
                type: 'spline'
            },
            title: {
                text: 'Consomation Electrique'
            },
            subtitle: {
                text: 'Detaille par phase'
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
                    text: 'Consomation kWh'
                },
                min: 0
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        Highcharts.dateFormat('%e. %b', this.x) +': '+ this.y +' kWh';
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
                name: 'Phase 1',
                data: [<?php echo $liste1; ?>]
            }, {
                name: 'Phase 2',
                data: [<?php echo $liste2; ?>]
            }, {
                name: 'Phase 3',
                data: [<?php echo $liste3; ?>]
            }, {
                name: 'Cumul',
                data: [<?php echo $liste4; ?>]
            }]
        });
    });
    
		</script>

<div id="phases" style="min-width: 400px; height: 400px; margin: 0 auto"></div>

