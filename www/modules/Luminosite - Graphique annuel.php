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

    $liste1 = "";
    $query0 = "SELECT date, max(lum) AS max, min(lum) as min FROM `luminosite_".$periph['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(`date`, '%Y%m')";
    $req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while($value0 = mysql_fetch_assoc($req0))
    {
      $liste1 .= "[".strtotime($value0['date']) * 1000 . "," . $value0['min'] ."," . $value0['max'] ."],";
    }
    ?>
    <script type="text/javascript">
    $(function () {

            $('#year-<? echo $periph['id']; ?>').highcharts({
                chart: {
                    type: 'columnrange',
                    //inverted: true
                },

                title: {
                    text: 'Variation de luminosité sur 1 an'
                },

                xAxis: [{
                    type: 'datetime'
                }],

                yAxis: {
                    title: {
                        text: 'Luminosité'
                    },
    		style: {
    			color: '<? echo $couleurgraph1; ?>'
    		}
                },

                tooltip: {
                    valueSuffix: ''
                },

                plotOptions: {
                    columnrange: {
                            dataLabels: {
                                    enabled: true,
                                    formatter: function () {
                                            return this.y + '';
                                    }
                            }
                    }
                },

                legend: {
                    enabled: false
                },

                series: [{
                    name: 'Luminosités',
    		color: '<? echo $couleurgraph1; ?>',
                    data: [<?php echo $liste1; ?>]
                }]

            });

    });
                    </script>
    <div id="year-<? echo $periph['id']; ?>" style="width:<? echo $width; ?>;height:<? echo $height; ?>;"></div>
<?
}
?>
