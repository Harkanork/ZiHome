<title>Temperature</title>
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

$query = "SELECT * FROM sonde_temperature";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{


$liste1 = "";
$liste2 = "";
$query0 = "SELECT * FROM `".$data['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 1 DAY)";

$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data0 = mysql_fetch_assoc($req0))
{
$liste1 .= "[".strtotime($data0['date']) * 1000 . "," . $data0['temp'] ."],";
$liste2 .= "[".strtotime($data0['date']) * 1000 . "," . $data0['hygro'] ."],";
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
            }],
            tooltip: {
                shared: true
            },
            series: [{
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
<div id="<? echo $data['id']; ?>" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
<?php } ?>

<script src="./js/highcharts.js"></script>


