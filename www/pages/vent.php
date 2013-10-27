<title>Vent</title>
<?php
echo "<CENTER><TABLE>";
echo "<TR><TD ALIGN=CENTER>Nom</TD><TD>&nbsp;Direction&nbsp;</TD><TD>&nbsp;Vitesse&nbsp;</TD><TD>Pile Faible</TD></TR>";
include("./pages/connexion.php");
$query = "SELECT * FROM sonde_vent";
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
echo "<TR><TD>".$data['nom']."</TD><TD ALIGN=CENTER>".$data0['direction']."</TD><TD ALIGN=CENTER>".($data0['vitesse']/10)." m/s</TD><TD ALIGN=CENTER>".$batterie."</TD></TR>";
}
}
echo "</TABLE></CENTER>";

$query = "SELECT * FROM sonde_vent";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{


$liste1 = "";
$query0 = "SELECT * FROM `".$data['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 1 DAY)";

$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data0 = mysql_fetch_assoc($req0))
{
$liste1 .= "[".strtotime($data0['date']) * 1000 . "," . ($data0['vitesse']/10) ."],";
}

?>
<script type="text/javascript">
$(function () {
Highcharts.setOptions({
    global: {
        useUTC: false
    }
});
        $('#<? echo $data['id']; ?>').highcharts({
            chart: {
            },
            title: {
                text: '<? echo $data['nom']; ?>'
            },
            subtitle: {
                text: 'Vitesse du vent'
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
                        return this.value +'m/s';
                    },
                    style: {
                    }
                },
                title: {
                    text: 'Vitesse',
                    style: {
                    }
                },
            }],
            tooltip: {
                shared: true
            },
            series: [{
                name: 'Vent',
                type: 'spline',
                data: [<?php echo $liste1; ?>],
                marker: {
                    enabled: false
                },
                tooltip: {
                    valueSuffix: ' m/s'
                }
            }]
        });
    });
</script>
<div id="<? echo $data['id']; ?>" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
<script type="text/javascript">
$(function () {

    $('#<? echo $data['id']; ?>-r').highcharts({
        data: {
                table: 'freq',
                startRow: 1,
                endRow: 17,
                endColumn: 7
            },

            chart: {
                polar: true,
                type: 'column'
            },

            title: {
                text: 'Rose des vents'
            },

            pane: {
                size: '85%'
            },

            legend: {
                reversed: true,
                align: 'right',
                verticalAlign: 'top',
                y: 100,
                layout: 'vertical'
            },

            xAxis: {
                tickmarkPlacement: 'on'
            },

            yAxis: {
                min: 0,
                endOnTick: false,
                showLastLabel: true,
                title: {
                        text: 'Frequency (%)'
                },
                labels: {
                        formatter: function () {
                                return this.value + '%';
                        }
                }
            },

            tooltip: {
                valueSuffix: '%',
                followPointer: true
            },

            plotOptions: {
                series: {
                        stacking: 'normal',
                        shadow: false,
                        groupPadding: 0,
                        pointPlacement: 'on'
                }
            }
        });
});
                </script>

<div style="display:none">
        <table id="freq" border="0" cellspacing="0" cellpadding="0">
                <tr nowrap bgcolor="#CCCCFF">
                        <th colspan="9" class="hdr">Table of Frequencies (percent)</th>
                </tr>
                <tr nowrap bgcolor="#CCCCFF">
                        <th class="freq">Direction</th>
<?
$vit = array(0.5, 2, 4, 6, 8, 10);
$j = 0;
while($j < (count($vit)+1)) {
if($j == 0) {
?>
                        <th class="freq">&lt; <? echo $vit[$j]; ?> m/s</th>
<?
} else if($j == (count($vit))) {
?>
                        <th class="freq">&gt; <? echo $vit[$j-1]; ?> m/s</th>
<?
} else {
?>
                        <th class="freq"><? echo $vit[($j-1)]; ?>-<? echo $vit[$j]; ?> m/s</th>
<?
}
$j++;
}
?>
                        <th class="freq">Total</th>
                </tr>
<?
$pc = array("N", "NNE", "NE", "ENE", "E", "ESE", "SE", "SSE", "S", "SSW", "SW", "WSW", "W", "WNW", "NW", "NNW");
$i=0;
while($i < count($pc)) {

?>
                <tr nowrap<? if(strlen($pc[$i]) == 3){ ?> bgcolor="#DDDDDD"<? } ?>>
                        <td class="dir"><? echo $pc[$i]; ?></td>
<?
$j = 0;
while($j < (count($vit))) {
if($j == 0) {
$query0 = "SELECT count(vitesse) AS sum FROM `".$data['nom']."` WHERE direction = '".$pc[$i]."' AND vitesse < '".($vit[$j]*10)."'";
} else if($j == (count($vit))) {
$query0 = "SELECT count(vitesse) AS sum FROM `".$data['nom']."` WHERE direction = '".$pc[$i]."' AND vitesse > '".($vit[($j-1)]*10)."'";
} else {
$query0 = "SELECT count(vitesse) AS sum FROM `".$data['nom']."` WHERE direction = '".$pc[$i]."' AND vitesse < '".($vit[$j]*10)."' AND vitesse > '".($vit[($j-1)]*10)."'";
}
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data0 = mysql_fetch_assoc($req0))
{
?>
                        <td class="data"><? echo $data0['sum']; ?></td>
<?
}
$j++;
}
?>
                </tr>
<?
$i++;
}
?>
        </table>
</div>
<div id="<? echo $data['id']; ?>-r" style="width: 1200px; height: 800px; margin: 0 auto"></div>
<?php } ?>

<script src="./js/highcharts.js"></script>
<script src="./js/highcharts-more.js"></script>
<script src="./js/modules/data.js"></script>
<script src="./js/modules/exporting.js"></script>

