<?
include("./pages/connexion.php");
include("./config/conf_zibase.php");
include("./lib/zibase.php");
$zibase = new ZiBase($ipzibase);
$query = "SELECT max( `width` + `left` ) AS width FROM `plan`";
$res_query = mysql_query($query, $link);
if(mysql_numrows($res_query) > 0){
$width = mysql_result($res_query,0,"width") + 2;
}
$query = "SELECT max( `height` + `top` ) AS height FROM `plan`";
$res_query = mysql_query($query, $link);
if(mysql_numrows($res_query) > 0){
$height = mysql_result($res_query,0,"height") + 2;
}
?>
<div id="plan" style="position: absolute;padding: 15px;margin: 15px;height: <? echo $height; ?>px;width: <? echo $width; ?>px;">
<?$query = "SELECT * FROM plan";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
$query1 = "SELECT * FROM peripheriques WHERE periph = 'temperature' AND id_plan = '".$data['id']."'";
$req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$data3 = mysql_fetch_assoc($req1);
$query2 = "SELECT * FROM peripheriques WHERE periph = 'actioneur' AND id_plan = '".$data['id']."'";
$req2 = mysql_query($query2, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$data4 = mysql_fetch_assoc($req2);
$query3 = "SELECT * FROM peripheriques WHERE periph = 'conso' AND id_plan = '".$data['id']."'";
$req3 = mysql_query($query3, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$data5 = mysql_fetch_assoc($req3);
$query5 = "SELECT * FROM scenarios WHERE id_plan = '".$data['id']."'";
$req5 = mysql_query($query5, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$data7 = mysql_fetch_assoc($req5);

if($data3 == null && ($data4 == null || (!(isset($_SESSION['auth'])))) && $data5 == null && $data7 == null) {
?>
<div style="background-color: #fff;background:url(../img/plan/<? echo $data['id']; ?>.jpg);background-size:<? echo $data['width']; ?>px <? echo $data['height']; ?>px;background-repeat:no-repeat;width: <? echo $data['width']; ?>px;height: <? echo $data['height']; ?>px;top: <? echo $data['top']; ?>px;left: <? echo $data['left']; ?>px;border: solid <? echo $data['border']; ?>px #CCC;position: absolute;z-index: <? echo $data['id']; ?>;color: black;font-size: 20px;text-align: <? echo $data['text-align']; ?>;<? echo $data['supplementaire']; ?>;">
<div style="line-height: <? echo $data['line-height']; ?>px;"><? echo $data['libelle']; ?></div></div>
<? } else { ?>
<a href="javascript:showPopup('custom<? echo $data['id']; ?>');"><div style="background-color: #fff;background:url(../img/plan/<? echo $data['id']; ?>.jpg);background-size:<? echo $data['width']; ?>px <? echo $data['height']; ?>px;background-repeat:no-repeat;width: <? echo $data['width']; ?>px;height: <? echo $data['height']; ?>px;top: <? echo $data['top']; ?>px;left: <? echo $data['left']; ?>px;border: solid <? echo $data['border']; ?>px #CCC;position: absolute;z-index: <? echo $data['id']; ?>;color: black;font-size: 20px;text-align: <? echo $data['text-align']; ?>;<? echo $data['supplementaire']; ?>;">
<div style="line-height: <? echo $data['line-height']; ?>px;"><? echo $data['libelle']; ?></div>
<?
$query4 = "SELECT * FROM peripheriques WHERE periph = 'capteur' AND id_plan = '".$data['id']."' AND icone ='1'";
$req4 = mysql_query($query4, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data6 = mysql_fetch_assoc($req4)) {
if($data6['protocol'] == 6) {
$protocol = true;
} else {
$protocol = false;
}
if($protocol == true) {
$value = $zibase->getState(substr($data6['id'], 1), $protocol);
} else {
$value = $zibase->getState($data6['id'], $protocol);
}
if($value == "1") {
$ic = "c";
} else {
$ic = "g";
}
echo "<img src=\"./img/icones/".$icone.$ic."_".$data6['logo']."\" width=\"60\" style=\"position:absolute;top:".$data6['top']."px;left:".$data6['left']."px;border-style:none;\">";
}
$query6 = "SELECT * FROM peripheriques WHERE periph = 'actioneur' AND id_plan = '".$data['id']."' AND icone ='1'";
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
$query7 = "SELECT * FROM peripheriques WHERE periph = 'temperature' AND id_plan = '".$data['id']."' AND icone ='1'";
$req7 = mysql_query($query7, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data9 = mysql_fetch_assoc($req7)) {
$query0 = "SELECT * FROM `temperature_".$data9['nom']."` ORDER BY `date` DESC LIMIT 1";
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
<div id="custom<? echo $data['id']; ?>" style="position: fixed;display: none;left: 50%;top: 50%;z-index: 2000;padding: 10px;width:640px;max-height:90%;background-color: #EEEEEE;font-size: 12px;line-height: 16px;color: #202020;border : 3px outset #555555;">
<div id="tabs-<? echo $data['id']; ?>" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" style="width: 640px;">
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
if((!($data7 == null)) && (isset($_SESSION['auth']))){
?>
<li class="ui-state-default ui-corner-top"><a href="#tabs-<? echo $data['id']; ?>-4">Scenario</a></li>
<?
}
?>

</ul>
<?
if(!($data3 == null)){
?>
<div id="tabs-<? echo $data['id']; ?>-1" class="ui-tabs-panel ui-widget-content ui-corner-bottom" style="overflow:auto;max-height:600px;">
<?
$query1 = "SELECT * FROM peripheriques WHERE periph = 'temperature' AND id_plan = '".$data['id']."'";
$req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data1 = mysql_fetch_assoc($req1)) {
$liste1 = "";
$liste2 = "";
$query0 = "SELECT * FROM `temperature_".$data1['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 1 DAY)";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data0 = mysql_fetch_assoc($req0))
{
$liste1 .= "[".strtotime($data0['date']) * 1000 . "," . $data0['temp'] ."],";
if(!($data0['hygro'] == 0)) {
$liste2 .= "[".strtotime($data0['date']) * 1000 . "," . $data0['hygro'] ."],";
}
}
if($data1['libelle'] == ""){
$nom = $data1['nom'];
} else {
$nom = $data1['libelle'];
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
                text: '<? echo $nom; ?>'
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
$query2 = "SELECT * FROM peripheriques WHERE periph = 'actioneur' AND id_plan = '".$data['id']."'";
$req2 = mysql_query($query2, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
?>
<div id="tabs-<? echo $data['id']; ?>-2" class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" style="overflow:auto;max-height:600px;">
<?
while($data2 = mysql_fetch_assoc($req2)) {
if($data2['libelle'] == ""){
$nom = $data2['nom'];
} else {
$nom = $data2['libelle'];
}
?>
<div id="actionneur">
<center><h1><? echo $nom; ?></h1></center>
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
if((!($data7 == null)) && (isset($_SESSION['auth']))){
?>
<div id="tabs-<? echo $data['id']; ?>-4" class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" style="overflow:auto;max-height:600px;">
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
<div id="tabs-<? echo $data['id']; ?>-3" class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" style="overflow:auto;max-height:600px;">
<?
$query1 = "SELECT * FROM peripheriques WHERE periph = 'conso' AND id_plan = '".$data['id']."'";
$req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data1 = mysql_fetch_assoc($req1)) {
$query0 = "SELECT max(conso_total) as max, min(conso_total) as min, date FROM `conso_".$data1['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(`date`, '%Y%m%d')";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$liste1 = "";
$liste2 = "";
while($data0 = mysql_fetch_assoc($req0))
{
$consoTemp = 0;
foreach($heuresCreuses as $heureCreuse){
$query6 = "SELECT min(conso_total) as min, max(conso_total) as max FROM `conso_".$data1['nom']."` where `date` >= '".substr($data0['date'], 0, 10)." ".$heureCreuse['debut']."' and `date` <= '".substr($data0['date'], 0, 10)." ".$heureCreuse['fin']."'";
$res_query6 = mysql_query($query6, $link);
if(mysql_numrows($res_query6) > 0){
$consoTemp += mysql_result($res_query6,0,"max") - mysql_result($res_query6,0,"min");
}
}
$liste1 .= "[".strtotime($data0['date']) * 1000 . "," . ($data0['max'] - $data0['min']) ."],";
$liste2 .= "[".strtotime($data0['date']) * 1000 . "," . number_format(((($consoTemp*$coutHC/1000)+(($data0['max'] - $data0['min'] - $consoTemp)*$coutHP)/1000)*100),2) ."],";
}
if($data1['libelle'] == ""){
$nom = $data1['nom'];
} else {
$nom = $data1['libelle'];
}
?>
                <script type="text/javascript">
$(function () {
        $('#conso_elec_<? echo $data1['id']; ?>').highcharts({
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

