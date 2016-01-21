<?
if (isset($_GET['requete'])) { // si le script est bien appelé par ajax en precisant l'objet de la requête
  include("../config/conf_zibase.php");
  include("../config/variables.php");
  include("../lib/zibase.php");
  include_once("../lib/date_francais.php");
  
  $link = mysql_connect($hote,$login,$plogin);
  if (!$link) {
    die('Non connect&eacute; : ' . mysql_error());
  }
  $db_selected = mysql_select_db($base,$link);
  if (!$db_selected) {
    die ('Impossible d\'utiliser la base : ' . mysql_error());
  }





$liste1 = "";
$liste2 = "";
$query = "SELECT SUM(chan1) AS chan1, SUM(chan2) AS chan2, SUM(chan3) AS chan3, SUM(cout) AS cout, SUBSTRING(`date`,1,7) AS mdate FROM `owl_journalier` GROUP BY mdate";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($periph = mysql_fetch_assoc($req))
{
$liste1 .= "[".strtotime($periph['mdate']) * 1000 . "," . ($periph['chan1']+$periph['chan2']+$periph['chan3']) /1000 ."],";
$liste2 .= "[".strtotime($periph['mdate']) * 1000 . "," .$periph['cout']."],";
}
?>

		<script type="text/javascript">
$(function () {
        $('#mensuel').highcharts({
            chart: {
            },
            title: {
                text: 'Consommation Electrique'
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
		style: {
			color: '<? echo $couleurgraph2; ?>'
		},
                title: {
                    text: 'Consommation (kWh)'
                }
            }, {
                min: 0,
		style: {
			color: '<? echo $couleurgraph1; ?>'
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
		color: '<? echo $couleurgraph2; ?>',
		type: 'column'
            }, {
                name: 'Cout (Euro)',
		yAxis: 1,
                data: [<?php echo $liste2; ?>],
		color: '<? echo $couleurgraph1; ?>',
		type: 'column'
            }]
        });
    });
    

		</script>

<div id="mensuel" style="min-width: 400px; height: 400px; margin: 0 auto"></div>


<?
}
?>