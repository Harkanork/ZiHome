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
  $peri=$_POST['peri'];
    $query = "SELECT * FROM peripheriques WHERE id = '".$peri."';";
    $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    $periph = mysql_fetch_assoc($req);
  
    $query0 = "SELECT max(pluie) as max, min(pluie) as min, date FROM `pluie_".$periph['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(`date`, '%Y%m%d')";
    $req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    $liste1 = "";
    while($value0 = mysql_fetch_assoc($req0))
    {
    $liste1 .= "[".strtotime($value0['date']) * 1000 . "," . ($value0['max'] - $value0['min']) ."],";
    }
    if($periph['libelle'] == ""){
    $nom = $periph['nom'];
    } else {
    $nom = $periph['libelle'];
    }
    ?>
                    <script type="text/javascript">
    $(function () {
    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });
            $('#mois-<? echo $periph['id']; ?>').highcharts({
                chart: {
                },
                title: {
                    text: '<? echo $nom; ?>'
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
    			color: '<? echo $couleurgraph2; ?>'
    		},
                    title: {
                        text: 'Précipitation'
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
                    name: 'Précipitation',
                    data: [<?php echo $liste1; ?>],
    		color: '<? echo $couleurgraph2; ?>',
                    type: 'column'
                }]
            });
        });
                    </script>

    <div id="mois-<? echo $periph['id']; ?>" style="width:<? echo $width; ?>;height:<? echo $height; ?>;"></div>
<?
}
?>

