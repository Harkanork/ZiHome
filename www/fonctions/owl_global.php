<?
$liste1 = "";
$liste2 = "";
include("./pages/connexion.php");
$query = "SELECT * FROM owl_journalier WHERE date > DATE_SUB(NOW(), INTERVAL 1 MONTH)";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($periph = mysql_fetch_assoc($req))
{
$liste1 .= "[".strtotime($periph['date']) * 1000 . "," . ($periph['chan1']+$periph['chan2']+$periph['chan3']) /1000 ."],";
$liste2 .= "[".strtotime($periph['date']) * 1000 . "," .$periph['cout']."],";
}
?>

		<script type="text/javascript">
$(function () {
        $('#journalier').highcharts({
            chart: {
            },
            title: {
                text: 'Consommation Electrique'
            },
            subtitle: {
                text: 'Quotidienne'
            },
            xAxis: [{
                type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                    month: '%e. %b',
                    year: '%b'
                }
            }],
            yAxis: [{
                min: 0,
		style: {
			color: '#4572A7'
		},
                title: {
                    text: 'Consommation (kWh)'
                }
            }, {
                min: 0,
		style: {
			color: '#89A54E'
		},
                title: {
                    text: 'Cout (Euro)'
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
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Consommation (kWh)',
                data: [<?php echo $liste1; ?>],
		color: '#4572A7',
		type: 'column'
            }, {
                name: 'Cout (Euro)',
		yAxis: 1,
                data: [<?php echo $liste2; ?>],
		color: '#89A54E',
		type: 'column'
            }]
        });
    });
    

		</script>

<div id="journalier" style="min-width: 400px; height: 400px; margin: 0 auto"></div>

