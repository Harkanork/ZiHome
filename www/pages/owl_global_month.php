<?
$liste1 = "";
$liste2 = "";
include("./pages/connexion.php");
$query = "SELECT SUM(chan1) AS chan1, SUM(chan2) AS chan2, SUM(chan3) AS chan3, SUM(cout) AS cout, SUBSTRING(`date`,1,7) AS mdate FROM `journalier` GROUP BY mdate";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_assoc($req))
{
$liste1 .= "[".strtotime($data['mdate']) * 1000 . "," . ($data['chan1']+$data['chan2']+$data['chan3']) /1000 ."],";
$liste2 .= "[".strtotime($data['mdate']) * 1000 . "," .$data['cout']."],";
}
?>

		<script type="text/javascript">
$(function () {
        $('#mensuel').highcharts({
            chart: {
            },
            title: {
                text: 'Consomation Electrique'
            },
            subtitle: {
                text: 'Mensuelle'
            },
            xAxis: [{
                type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                    //month: '%e. %b',
                    //year: '%b'
                }
            }],
            yAxis: [{
                min: 0,
                title: {
                    text: 'Consomation (kWh)'
                }
            }, {
                min: 0,
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
                name: 'Consomation (kWh)',
                data: [<?php echo $liste1; ?>],
		type: 'column'
            }, {
                name: 'Cout (Euro)',
		yAxis: 1,
                data: [<?php echo $liste2; ?>],
		type: 'column'
            }]
        });
    });
    

		</script>

<div id="mensuel" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
