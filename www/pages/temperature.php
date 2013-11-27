<title>Temperature</title>
<!--
<?php
echo "<CENTER><TABLE>";
echo "<TR><TD ALIGN=CENTER>Nom</TD><TD>&nbsp;Temperature&nbsp;</TD><TD>&nbsp;Hygrometrie&nbsp;</TD><TD>Pile Faible</TD></TR>";
include("./pages/connexion.php");
$query = "SELECT * FROM sonde_temperature";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
if($data['batterie'] == 0)
{
$batterie = "Non"; 
} else {
$batterie = "<FONT COLOR='red'>Oui</FONT>";
}
$query0 = "SELECT * FROM `".$data['nom']."` ORDER BY `date` DESC LIMIT 1";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data0 = mysql_fetch_assoc($req0))
{
echo "<TR><TD>".$data['nom']."</TD><TD ALIGN=CENTER>".$data0['temp']."</TD><TD ALIGN=CENTER>".$data0['hygro']."</TD><TD ALIGN=CENTER>".$batterie."</TD></TR>";
}
}
echo "</TABLE></CENTER>";
?>
-->
<br>
<script type="text/javascript">
$(document).ready(function() {
  $("#global").tabs();
});
</script>
<div id="global">
<ul style="width:100%;">
<?
$query = "SELECT * FROM sonde_temperature";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
?>
<li><a href="#onglet-<? echo $data['id']; ?>"><? echo $data['nom']; ?></a></li>
<?
}
?>
</ul>
<?
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
?>
<div id="onglet-<? echo $data['id']; ?>" style="width:100%;">
<?
$liste1 = "";
$liste2 = "";
$query0 = "SELECT * FROM `".$data['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 1 DAY)";

$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data0 = mysql_fetch_assoc($req0))
{
$liste1 .= "[".strtotime($data0['date']) * 1000 . "," . $data0['temp'] ."],";
if(!($data0['hygro'] == 0)) {
$liste2 .= "[".strtotime($data0['date']) * 1000 . "," . $data0['hygro'] ."],";
}
}

?>
<script type="text/javascript">
$(function () {
Highcharts.setOptions({
    global: {
        useUTC: false
    }
});
        $('#jour-<? echo $data['id']; ?>').highcharts({
            chart: {
            },
            title: {
                text: '<? echo $data['nom']; ?>'
            },
            subtitle: {
                text: 'Temperature et Hygrometrie'
            },
            xAxis: [{
                type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                    month: '%e. %b',
                    year: '%b'
                }
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    formatter: function() {
                        return this.value +'°C';
                    },
                    style: {
                    }
                },
                title: {
                    text: 'Temperature',
                    style: {
                    }
                },
<? if(!($liste2 == "")) { ?>    
            }, { // Tertiary yAxis
                gridLineWidth: 0,
                title: {
                    text: 'Hygrometrie',
                    style: {
                    }
                },
                labels: {
                    formatter: function() {
                        return this.value +' %';
                    },
                    style: {
                    }
                },
<? } ?>
            }],
            tooltip: {
                shared: true
            },
            series: [{
<? if(!($liste2 == "")) { ?>
                name: 'Hygrometrie',
                type: 'spline',
                yAxis: 1,
                data: [<?php echo $liste2; ?>],
                marker: {
                    enabled: false
                },
                tooltip: {
                    valueSuffix: ' %'
                }
            }, {
<? } ?>
                name: 'Temperature',
                type: 'spline',
                data: [<?php echo $liste1; ?>],
                marker: {
                    enabled: false
                },
                tooltip: {
                    valueSuffix: ' °C'
                }
            }]
        });
    });
</script>
<div id="jour-<? echo $data['id']; ?>" style="min-width: 400px; width:100%; height: 400px; margin: 0 auto"></div>
<?
$liste1 = "";
$query0 = "SELECT date, max(temp) AS max, min(temp) as min FROM `".$data['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(`date`, '%Y%m%d')";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data0 = mysql_fetch_assoc($req0))
{
$liste1 .= "[".strtotime($data0['date']) * 1000 . "," . $data0['min'] ."," . $data0['max'] ."],";
}
?>
<script type="text/javascript">
$(function () {

        $('#mois-<? echo $data['id']; ?>').highcharts({

            chart: {
                type: 'columnrange',
                //inverted: true
            },

            title: {
                text: 'Variation de temperature sur 1 mois'
            },

            xAxis: [{
                type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                    month: '%e. %b',
                    year: '%b'
                }
            }],

            yAxis: {
                title: {
                    text: 'Temperature ( °C )'
                }
            },

            tooltip: {
                valueSuffix: '°C'
            },

            plotOptions: {
                columnrange: {
                        dataLabels: {
                                enabled: true,
                                formatter: function () {
                                        return this.y + '°C';
                                }
                        }
                }
            },

            legend: {
                enabled: false
            },

            series: [{
                name: 'Temperatures',
                data: [<?php echo $liste1; ?>]
            }]

        });

});
                </script>
<div id="mois-<? echo $data['id']; ?>" style="min-width: 400px; width:100%; height: 400px; margin: 0 auto"></div>
<?
$liste1 = "";
$query0 = "SELECT date, max(temp) AS max, min(temp) as min FROM `".$data['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(`date`, '%Y%m')";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data0 = mysql_fetch_assoc($req0))
{
$liste1 .= "[".strtotime($data0['date']) * 1000 . "," . $data0['min'] ."," . $data0['max'] ."],";
}
?>
<script type="text/javascript">
$(function () {

        $('#year-<? echo $data['id']; ?>').highcharts({

            chart: {
                type: 'columnrange',
                //inverted: true
            },

            title: {
                text: 'Variation de temperature sur 1 an'
            },

            xAxis: [{
                type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                    month: '%e. %b',
                    year: '%b'
                }
            }],

            yAxis: {
                title: {
                    text: 'Temperature ( °C )'
                }
            },

            tooltip: {
                valueSuffix: '°C'
            },

            plotOptions: {
                columnrange: {
                        dataLabels: {
                                enabled: true,
                                formatter: function () {
                                        return this.y + '°C';
                                }
                        }
                }
            },

            legend: {
                enabled: false
            },

            series: [{
                name: 'Temperatures',
                data: [<?php echo $liste1; ?>]
            }]

        });

});
                </script>
<div id="year-<? echo $data['id']; ?>" style="min-width: 400px; width:100%; height: 400px; margin: 0 auto"></div>
</div>
<?php } ?>
</div>
<script src="./js/highcharts.js"></script>
<script src="./js/highcharts-more.js"></script>

