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
    $liste2 = "";
    $query0 = "SELECT date, max(temp) AS max, min(temp) as min, max(hygro) as maxh, min(hygro) as minh FROM `temperature_".$periph['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(`date`, '%Y%m%d')";
    $req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while($value0 = mysql_fetch_assoc($req0))
    {
    $liste1 .= "[".strtotime($value0['date']) * 1000 . "," . $value0['min'] ."," . $value0['max'] ."],";
    if(!($value0['maxh'] == 0)) {
    $liste2 .= "[".strtotime($value0['date']) * 1000 . "," . $value0['minh'] ."," . $value0['maxh'] ."],";
    }
    }
    ?>
    <script type="text/javascript">
    $(function () {

            $('#mois-<? echo $periph['id']; ?>').highcharts({

                chart: {
                    type: 'columnrange',
                    //inverted: true
                },

                title: {
                    text: 'Variation de température sur 1 mois'
                },

                xAxis: [{
                    type: 'datetime'
                }],

                yAxis: [{
                    labels: {
                        formatter: function() {
                            return this.value +'°C';
                        }
                    },
    				title: {
                        text: 'Température ( °C )',
    					style: {
                            color: '<? echo $couleurgraph1; ?>'
                        }
                    },
    <? if(!($liste2 == "")) { ?>
                }, {
                    title: {
                        text: 'Hygrométrie',
                        style: {
                            color: '<? echo $couleurgraph2; ?>'
                        }
                    },
                    labels: {
                        formatter: function() {
                            return this.value +' %';
                        },
                    },
    <? } ?>

                }],

                plotOptions: {
                    columnrange: {
                    }
                },

                legend: {
                    enabled: false
                },
                series: [{
    <? if(!($liste2 == "")) { ?>
                    name: 'Hygrométrie',
                    color: '<? echo $couleurgraph2; ?>',
                    yAxis: 1,
                    data: [<?php echo $liste2; ?>],
                    tooltip: {
                        valueSuffix: ' %'
                    }
                }, {
    <? } ?>
                    name: 'Température',
                    color: '<? echo $couleurgraph1; ?>',
                    data: [<?php echo $liste1; ?>],
                    tooltip: {
                        valueSuffix: ' °C'
                    }
                }]

            });

    });
                    </script>
    <div id="mois-<? echo $periph['id']; ?>" style="width:<? echo $width; ?>;height:<? echo $height; ?>;"></div>
<?
}
?>
