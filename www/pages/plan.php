<div id="plan">
<?
include("./pages/connexion.php");
include("./pages/conf_zibase.php");
include("./lib/zibase.php");
$zibase = new ZiBase($ipzibase);
$query = "SELECT * FROM plan";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
$query1 = "SELECT * FROM sonde_temperature WHERE id_plan = '".$data['id']."'";
$req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$data3 = mysql_fetch_assoc($req1);
$query2 = "SELECT * FROM actioneurs WHERE id_plan = '".$data['id']."'";
$req2 = mysql_query($query2, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$data4 = mysql_fetch_assoc($req2);
$query3 = "SELECT * FROM conso_electrique WHERE id_plan = '".$data['id']."'";
$req3 = mysql_query($query3, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$data5 = mysql_fetch_assoc($req3);
$query5 = "SELECT * FROM scenarios WHERE id_plan = '".$data['id']."'";
$req5 = mysql_query($query5, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$data7 = mysql_fetch_assoc($req5);

if($data3 == null && ($data4 == null || (!(isset($_SESSION['auth'])))) && $data5 == null && $data7 == null) {
?>
<div id ="piece<? echo $data['id']; ?>"><div id="texte<? echo $data['id']; ?>"><? echo $data['libelle']; ?></div></div>
<? } else { ?>
<a href="javascript:showPopup('custom<? echo $data['id']; ?>');"><div id ="piece<? echo $data['id']; ?>"><div id="texte<? echo $data['id']; ?>"><? echo $data['libelle']; ?></div>
<?
$query4 = "SELECT * FROM capteurs WHERE id_plan = '".$data['id']."' AND icone ='1'";
$req4 = mysql_query($query4, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data6 = mysql_fetch_assoc($req4)) {
if($data6['protocol'] == 6) {
$protocol = true;
} else {
$protocol = false;
}
$value = $zibase->getState($data6['id'], $protocol);
if($value == 1) {
$ic = "c";
} else {
$ic = "g";
}
echo "<img src=\"./img/icones/".$icone.$ic."_".$data6['logo']."\" width=\"60\" style=\"position:absolute;top:".$data6['top']."px;left:".$data6['left']."px;border-style:none;\">";
}
$query6 = "SELECT * FROM actioneurs WHERE id_plan = '".$data['id']."' AND icone ='1'";
$req6 = mysql_query($query6, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data8 = mysql_fetch_assoc($req6)) {
if($data8['protocol'] == 6) {
$protocol = true;
} else {
$protocol = false;
}
$value = $zibase->getState($data8['id'], $protocol);
if($value == 1) {
$ic = "c";
} else {
$ic = "g";
}
echo "<img src=\"./img/icones/".$icone.$ic."_".$data8['logo']."\" width=\"60\" style=\"position:absolute;top:".$data8['top']."px;left:".$data8['left']."px;border-style:none;\">";
}
$query7 = "SELECT * FROM sonde_temperature WHERE id_plan = '".$data['id']."' AND icone ='1'";
$req7 = mysql_query($query7, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data9 = mysql_fetch_assoc($req7)) {
$query0 = "SELECT * FROM `".$data9['nom']."` ORDER BY `date` DESC LIMIT 1";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data0 = mysql_fetch_assoc($req0))
{
$temperature=$data0['temp'];
}
echo "<div style=\"position:absolute;top:".$data9['top']."px;left:".$data9['left']."px;border-style:none;\"><img src=\"./img/icones/".$icone."c_".$data9['logo']."\" width=\"60\" style=\"position:absolute;top:0px;left:0px;border-style:none;\"><img src=\"./img/icones/".$icone."AndroidNumberYellow.png\" width=\"50\" style=\"position:absolute;top:0px;left:30px;border-style:none;\"><span style=\"position:absolute;top:3px;left:36px;font-size:12px;font-weight:bold;border-style:none;\">".$temperature."&deg;</span></div>";
}
?>
</div></a>
<script type="text/javascript">
$(document).ready(function() {
  $("#tabs-<? echo $data['id']; ?>").tabs();
});
</script>
<div id="custom<? echo $data['id']; ?>">
<div id="tabs-<? echo $data['id']; ?>" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
<?
if(!($data3 == null)){
?>
<li class="ui-state-default ui-corner-top"><a href="#tabs-<? echo $data['id']; ?>-1">Temperature</a></li>
<?
}
if((!($data4 == null)) && isset($_SESSION['auth'])){
?>
<li class="ui-state-default ui-corner-top"><a href="#tabs-<? echo $data['id']; ?>-2">Actionneur</a></li>
<? 
} 
if(!($data5 == null)){
?>
<li class="ui-state-default ui-corner-top"><a href="#tabs-<? echo $data['id']; ?>-3">Conso-Elec</a></li>
<?
}
if(!($data7 == null)){
?>
<li class="ui-state-default ui-corner-top"><a href="#tabs-<? echo $data['id']; ?>-4">Scenario</a></li>
<?
}
?>

</ul>
<?
if(!($data3 == null)){
?>
<div id="tabs-<? echo $data['id']; ?>-1" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
<?
$query1 = "SELECT * FROM sonde_temperature WHERE id_plan = '".$data['id']."'";
$req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data1 = mysql_fetch_assoc($req1)) {
$liste1 = "";
$liste2 = "";
$query0 = "SELECT * FROM `".$data1['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 1 DAY)";
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
        $('#<? echo $data1['id']; ?>').highcharts({
            chart: {
            },
            title: {
                text: '<? echo $data1['nom']; ?>'
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
            },
		 { // Tertiary yAxis
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
            }
             ],
            tooltip: {
                shared: true
            },
            series: [
<? if(!($liste2 == "")) { ?>
		{
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
            }, 
<? } ?>
		{
                name: 'Temperature',
                type: 'spline',
                data: [<?php echo $liste1; ?>],
                marker: {
                    enabled: false
                },
                tooltip: {
                    valueSuffix: ' °C'
                }
            }
	     ]
        });
    });
</script>
<div id="<? echo $data1['id']; ?>" style="min-width: 640px; height: 340px; margin: 0 auto"></div>
<? 
}
?>
</div>
<?
}
if(isset($_SESSION['auth']))
{
if(!($data4 == null)){
$query2 = "SELECT * FROM actioneurs WHERE id_plan = '".$data['id']."'";
$req2 = mysql_query($query2, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
?>
<div id="tabs-<? echo $data['id']; ?>-2" class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide">
<?
while($data2 = mysql_fetch_assoc($req2)) {
?>
<div id="actionneur">
<center><h1><? echo $data2['nom']; ?></h1></center>
<center>
<? if($data2['type'] == 'dim') {
?>
<form method="get" action="./pages/actioneur.php">
<input type="range" name="dim" value="0" max="100" min="0" step="5">
<input type="hidden" name="ordre" value="2">
<input type="hidden" name="action" value="<? echo $data2['id']; ?>">
<input type="hidden" name="protocol" value="<? echo $data2['protocol']; ?>">
<input type="submit" name="Valider" value="Valider">
</form>
<a href="./pages/actioneur.php?ordre=1&action=<? echo $data2['id']; ?>&protocol=<? echo $data2['protocol']; ?>" class="button green">ON</a>
<a href="./pages/actioneur.php?ordre=0&action=<? echo $data2['id']; ?>&protocol=<? echo $data2['protocol']; ?>" class="button red close">OFF</a>
<? } else { ?>
<a href="./pages/actioneur.php?ordre=1&action=<? echo $data2['id']; ?>&protocol=<? echo $data2['protocol']; ?>" class="button green">ON</a>
<? if($data2['type'] == 'on_off') { ?><a href="./pages/actioneur.php?ordre=0&action=<? echo $data2['id']; ?>&protocol=<? echo $data2['protocol']; ?>" class="button red close">OFF</a><? }
}
?></center></div><?
}
?> 
</div>
<?
}
}
if(!($data7 == null)){
?>
<div id="tabs-<? echo $data['id']; ?>-4" class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide">
<?
$query5 = "SELECT * FROM scenarios WHERE id_plan = '".$data['id']."'";
$req5 = mysql_query($query5, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data2 = mysql_fetch_assoc($req5)) {
?>
<div id="actionneur">
<center><h1><? echo $data2['nom']; ?></h1></center>
<center>
<a href="./pages/scenario.php?action=<? echo $data2['id']; ?>" class="button green">RUN</a>
</center></div>
</div>
<?
}
}
if(!($data5 == null)){
?>
<div id="tabs-<? echo $data['id']; ?>-3" class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide">
<?
$query1 = "SELECT * FROM conso_electrique WHERE id_plan = '".$data['id']."'";
$req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data1 = mysql_fetch_assoc($req1)) {
$query0 = "SELECT max(conso_total) as max, min(conso_total) as min, date FROM `".$data1['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(`date`, '%Y%m%d')";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$liste1 = "";
$liste2 = "";
while($data0 = mysql_fetch_assoc($req0))
{
$consoTemp = 0;
foreach($heuresCreuses as $heureCreuse){
$query6 = "SELECT min(conso_total) as min, max(conso_total) as max FROM `".$data1['nom']."` where `date` >= '".substr($data0['date'], 0, 10)." ".$heureCreuse['debut']."' and `date` <= '".substr($data0['date'], 0, 10)." ".$heureCreuse['fin']."'";
$res_query6 = mysql_query($query6, $link);
if(mysql_numrows($res_query6) > 0){
$consoTemp += mysql_result($res_query6,0,"max") - mysql_result($res_query6,0,"min");
}
}
$liste1 .= "[".strtotime($data0['date']) * 1000 . "," . ($data0['max'] - $data0['min']) ."],";
$liste2 .= "[".strtotime($data0['date']) * 1000 . "," . number_format(((($consoTemp*$coutHC/1000)+(($data0['max'] - $data0['min'] - $consoTemp)*$coutHP)/1000)*100),2) ."],";
}
?>
                <script type="text/javascript">
$(function () {
        $('#conso_elec_<? echo $data1['id']; ?>').highcharts({
            chart: {
            },
            title: {
                text: '<? echo $data1['nom']; ?>'
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
                title: {
                    text: 'Consomation (Wh)'
                }
            }, {
                min: 0,
                title: {
                    text: 'Cout (Cent)'
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
                name: 'Consomation (Wh)',
                data: [<?php echo $liste1; ?>],
                type: 'column'

            }, {
                name: 'Cout (Cent)',
                yAxis: 1,
                data: [<?php echo $liste2; ?>],
                type: 'column'
            }]
        });
    });
                </script>

<div id="conso_elec_<? echo $data1['id']; ?>" style="min-width: 640px; height: 340px; margin: 0 auto"></div>
<?
}
?>
</div>
<?
}
?>
</div>
</div>
<? 
}
} ?>
</div>
<script src="./js/highcharts.js"></script>

