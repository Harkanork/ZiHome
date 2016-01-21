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
    $conso_max = 0;

    $query0 = "SELECT SUM(conso) as somme_conso, date FROM `eau_".$periph['nom']."` GROUP BY DATE_FORMAT(`date`, '%Y%m%d') ORDER BY DATE_FORMAT(`date`, '%Y%m%d')";
    $req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

    while ($value0 = mysql_fetch_assoc($req0))
    {
      $conso = $value0['somme_conso'];
      $liste1 .= "[" . strtotime($value0['date']) * 1000 . "," . $conso ."],";
      if ($conso_max < $conso)
      {
        $conso_max = $conso;
      }
    }

    if($periph['libelle'] == ""){
      $nom = $periph['nom'];
    } else {
      $nom = $periph['libelle'];
    }
    ?>

    <script type="text/javascript">
        $(function () {
            Highcharts.setOptions(
            {
                global: 
                {
                    useUTC: false
                }
            });
            $('#eau_<? echo $periph['id']; ?>-barres').highcharts(
            'StockChart',
            {
                chart: {
                    borderWidth : 1,
                    borderRadius : 5,
                    borderColor: '<?php echo $couleurgraph2; ?>'
                },
                title: {
                    text: 'Consommation journalière - <? echo $nom ?>',
                    style: {
                            color: '<?php echo $couleurgraph2; ?>',
                            fontSize: '15px',
                            fontWeight: 'bold'
                    },
                },
                xAxis: [{
                    type: 'datetime'
                }],
                rangeSelector : {
                    buttons: [{
                        type: 'week',
                        count: 1,
                        text: 'Semaine'
                    }, 
                    {
                        type: 'month',
                        count: 1,
                        text: 'Mois'
                    }
                    ],
                    selected : 1,
                    buttonSpacing : 5,
                    buttonTheme: { // styles for the buttons
                        fill: '<?php echo $couleurgraph1; ?>',
                        stroke: '<?php echo $couleurgraph1; ?>',
                        width : 60,
                        height : 12,
                        r:4,
                        style: {
                            color: '#FFFFFF',
                            fontSize: '9px',
                            fontWeight: 'bold'
                        },
                        states: {
                            hover: {
                                fill: '<?php echo $couleurgraph2; ?>',
                                stroke: '<?php echo $couleurgraph2; ?>',
                            },
                            select: {
                                fill: '<?php echo $couleurgraph2; ?>',
                                stroke: '<?php echo $couleurgraph2; ?>',
                                style: {
                                    color: '#FFFFFF',
                                    fontSize: '10px',
                                    fontWeight: 'bold'
                                },
                            }
                        }
                    },
                    inputEnabled: false
                },
                yAxis: [
                {
                    min: 0,
                    max: <? echo ($conso_max * 1.1); ?>,
                    title: {
                        text: 'Consommation en litre',
                        style: {
                            color: '<?php echo $couleurgraph2; ?>',
                            fontSize: '12px',
                            fontWeight: 'bold'
                        },
                    },
                    style: {
                       color: '#0000a0'
                    },
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
                series: [
                {
                    name: 'Conso en litres',
                    data: [<?php echo $liste1; ?>],
                    color: '<? echo $couleurgraph2; ?>',
                    type: 'column'
                }],
                navigator: {
                    xAxis: {
                        labels: {
                            style : {
                                color: '<?php echo $couleurgraph2; ?>',
                                fontSize: '11px',
                                fontWeight: 'bold'
                            },
                        },
                    },
                }
            });
        });
    </script>

    <div id="eau_<? echo $periph['id']; ?>-barres" style="width:<? echo $width; ?>;height:<? echo $height; ?>;"></div>
<?
}
?>
