<title>Consomation Electrique</title>
<?php
include("./pages/conf_zibase.php");
echo "<CENTER><TABLE>";
echo "<TR><TD ALIGN=CENTER>Nom</TD><TD>&nbsp;Consomation&nbsp;</TD><TD>Pile Faible</TD></TR>";
include("./pages/connexion.php");
$query = "SELECT * FROM peripheriques WHERE periph = 'conso'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
if($data['batterie'] == 0)
{
$batterie = "Non"; 
} else {
$batterie = "<FONT COLOR='red'>Oui</FONT>";
}
$query0 = "SELECT * FROM `conso_".$data['nom']."` ORDER BY `date` DESC LIMIT 1";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data0 = mysql_fetch_assoc($req0))
{
if($data['libelle'] == ""){
$nom = $data['nom'];
} else {
$nom = $data['libelle'];
}
echo "<TR><TD>".$nom."</TD><TD ALIGN=CENTER>".$data0['conso']."</TD><TD ALIGN=CENTER>".$batterie."</TD></TR>";
}
}
echo "</TABLE></CENTER>";
?>
<script type="text/javascript">
$(document).ready(function() {
  $("#global").tabs();
});
</script>
<div id="global">
<ul style="width:100%;">
<?
$query = "SELECT * FROM peripheriques WHERE periph = 'conso'";
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
echo "<CENTER><TABLE CELLSPACING='9'>";
echo "<TR><TD>(kWh)</TD><TD>&nbsp;Consomation&nbsp;</TD><TD>&nbsp;Cout&nbsp;</TD></TR>";
$query0 = "SELECT max(conso_total) as max, min(conso_total) as min, date FROM `conso_".$data['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 3 DAY) GROUP BY DATE_FORMAT(`date`, '%Y%m%d') LIMIT 2";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$i=1;
while ($data0 = mysql_fetch_assoc($req0))
{
$consoTemp = 0;
foreach($heuresCreuses as $heureCreuse){
$query6 = "SELECT min(conso_total) as min, max(conso_total) as max FROM `conso_".$data['nom']."` where `date` >= '".substr($data0['date'], 0, 10)." ".$heureCreuse['debut']."' and `date` <= '".substr($data0['date'], 0, 10)." ".$heureCreuse['fin']."'";
$res_query6 = mysql_query($query6, $link);
if(mysql_numrows($res_query6) > 0){
$consoTemp += mysql_result($res_query6,0,"max") - mysql_result($res_query6,0,"min");
}
}
if($i == 1) {
echo "<TR><TD>Aujourd'hui&nbsp;</TD><TD>".(($data0['max'] - $data0['min'])/1000)."</TD><TD>".number_format(((($consoTemp*$coutHC/1000)+(($data0['max'] - $data0['min'] - $consoTemp)*$coutHP)/1000)),2)." &euro;</TD></TR>";
} else {
echo "<TR><TD>hier</TD><TD>".(($data0['max'] - $data0['min'])/1000)."</TD><TD>".number_format(((($consoTemp*$coutHC/1000)+(($data0['max'] - $data0['min'] - $consoTemp)*$coutHP)/1000)),2)." &euro;</TD></TR>";
}
$i++;
}
$query0 = "SELECT max(conso_total) as max, min(conso_total) as min, date, DATE_FORMAT(`date`, '%Y-%m') AS mois FROM `conso_".$data['nom']."` WHERE date < curdate() AND date > DATE_ADD(curdate(), INTERVAL -7 DAY)";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data0 = mysql_fetch_assoc($req0))
{
$consoTemp = 0;
$query1 = "SELECT max(conso_total) as max, min(conso_total) as min, date FROM `conso_".$data['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 7 DAY) GROUP BY DATE_FORMAT(`date`, '%Y%m%d')";
$req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data1 = mysql_fetch_assoc($req1))
{
foreach($heuresCreuses as $heureCreuse){
$query6 = "SELECT min(conso_total) as min, max(conso_total) as max FROM `conso_".$data['nom']."` where `date` >= '".substr($data0['date'], 0, 10)." ".$heureCreuse['debut']."' and `date` <= '".substr($data0['date'], 0, 10)." ".$heureCreuse['fin']."'";
$res_query6 = mysql_query($query6, $link);
if(mysql_numrows($res_query6) > 0){
$consoTemp += mysql_result($res_query6,0,"max") - mysql_result($res_query6,0,"min");
}
}
}
echo "<TR><TD>7 jours</TD><TD>".(($data0['max'] - $data0['min'])/1000)."</TD><TD>". number_format(((($consoTemp*$coutHC/1000)+(($data0['max'] - $data0['min'] - $consoTemp)*$coutHP)/1000)),2)." &euro;</TD></TR>";
}
$query0 = "SELECT max(conso_total) as max, min(conso_total) as min, date, DATE_FORMAT(`date`, '%Y-%m') AS mois FROM `conso_".$data['nom']."` WHERE date < curdate() AND date > DATE_ADD(curdate(), INTERVAL -30 DAY)";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data0 = mysql_fetch_assoc($req0))
{
$consoTemp = 0;
$query1 = "SELECT max(conso_total) as max, min(conso_total) as min, date FROM `conso_".$data['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 30 DAY) GROUP BY DATE_FORMAT(`date`, '%Y%m%d')";
$req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data1 = mysql_fetch_assoc($req1))
{
foreach($heuresCreuses as $heureCreuse){
$query6 = "SELECT min(conso_total) as min, max(conso_total) as max FROM `conso_".$data['nom']."` where `date` >= '".substr($data0['date'], 0, 10)." ".$heureCreuse['debut']."' and `date` <= '".substr($data0['date'], 0, 10)." ".$heureCreuse['fin']."'";
$res_query6 = mysql_query($query6, $link);
if(mysql_numrows($res_query6) > 0){
$consoTemp += mysql_result($res_query6,0,"max") - mysql_result($res_query6,0,"min");
}
}
}
echo "<TR><TD>30 jours</TD><TD>".(($data0['max'] - $data0['min'])/1000)."</TD><TD>". number_format(((($consoTemp*$coutHC/1000)+(($data0['max'] - $data0['min'] - $consoTemp)*$coutHP)/1000)),2)." &euro;</TD></TR>";
}
$query0 = "SELECT max(conso_total) as max, min(conso_total) as min, date, DATE_FORMAT(`date`, '%Y-%m') AS mois FROM `conso_".$data['nom']."` WHERE date < curdate() AND date > DATE_ADD(curdate(), INTERVAL -1 YEAR)";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.'<br>'.mysql_error());
while($data0 = mysql_fetch_assoc($req0))
{
$consoTemp = 0;
$query1 = "SELECT max(conso_total) as max, min(conso_total) as min, date FROM `conso_".$data['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(`date`, '%Y%m%d')";
$req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data1 = mysql_fetch_assoc($req1))
{
foreach($heuresCreuses as $heureCreuse){
$query6 = "SELECT min(conso_total) as min, max(conso_total) as max FROM `conso_".$data['nom']."` where `date` >= '".substr($data0['date'], 0, 10)." ".$heureCreuse['debut']."' and `date` <= '".substr($data0['date'], 0, 10)." ".$heureCreuse['fin']."'";
$res_query6 = mysql_query($query6, $link);
if(mysql_numrows($res_query6) > 0){
$consoTemp += mysql_result($res_query6,0,"max") - mysql_result($res_query6,0,"min");
}
}
}
echo "<TR><TD>1 an</TD><TD>".(($data0['max'] - $data0['min'])/1000)."</TD><TD>". number_format(((($consoTemp*$coutHC/1000)+(($data0['max'] - $data0['min'] - $consoTemp)*$coutHP)/1000)),2)." &euro;</TD></TR>";
}
echo "</TABLE></CENTER>";
$liste1 = "";
include("./pages/connexion.php");
$query0 = "SELECT * FROM `conso_".$data['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 1 DAY)";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data0 = mysql_fetch_assoc($req0))
{
$liste1 .= "[".strtotime($data0['date']) * 1000 . "," . $data0['conso'] ."],";
}

?>
                <script type="text/javascript">
$(function() {
Highcharts.setOptions({
    global: {
        useUTC: false
    }
});
        $('#conso_elec_heure_<? echo $data['id']; ?>').highcharts({
            chart: {
                type: 'spline'
            },
            title: {
                text: 'Consomation Electrique'
            },
            subtitle: {
                text: 'Detail sur 1 journee'
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                    month: '%e. %b',
                    year: '%b'
                }
             },
            yAxis: {
                title: {
                    text: 'Consomation Wh'
                },
                min: 0
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        Highcharts.dateFormat('%e. %b', this.x) +': '+ this.y +' Wh';
                }
             },
            plotOptions: {
                spline: {
                    marker: {
                        enabled: false
                    },
                }
            },

            series: [{
                name: 'Conso-Elec',
                data: [<?php echo $liste1; ?>]
            }]
        });
    });
                </script>
<div id="conso_elec_heure_<? echo $data['id']; ?>" style="min-width: 400px; width:100%; height: 400px; margin: 0 auto"></div>

<?
$query0 = "SELECT max(conso_total) as max, min(conso_total) as min, date FROM `conso_".$data['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(`date`, '%Y%m%d')";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$liste1 = "";
$liste2 = "";
while($data0 = mysql_fetch_assoc($req0))
{
$consoTemp = 0;
foreach($heuresCreuses as $heureCreuse){
$query6 = "SELECT min(conso_total) as min, max(conso_total) as max FROM `conso_".$data['nom']."` where `date` >= '".substr($data0['date'], 0, 10)." ".$heureCreuse['debut']."' and `date` <= '".substr($data0['date'], 0, 10)." ".$heureCreuse['fin']."'";
$res_query6 = mysql_query($query6, $link);
if(mysql_numrows($res_query6) > 0){
$consoTemp += mysql_result($res_query6,0,"max") - mysql_result($res_query6,0,"min");
}
}
$liste1 .= "[".strtotime($data0['date']) * 1000 . "," . ($data0['max'] - $data0['min']) ."],";
$liste2 .= "[".strtotime($data0['date']) * 1000 . "," . number_format(((($consoTemp*$coutHC/1000)+(($data0['max'] - $data0['min'] - $consoTemp)*$coutHP)/1000)*100),2) ."],";
}
if($data['libelle'] == ""){
$nom = $data['nom'];
} else {
$nom = $data['libelle'];
}
?>
                <script type="text/javascript">
$(function () {
Highcharts.setOptions({
    global: {
        useUTC: false
    }
});
        $('#conso_elec_<? echo $data['id']; ?>').highcharts({
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

<div id="conso_elec_<? echo $data['id']; ?>" style="min-width: 400px; width:100%; height: 400px; margin: 0 auto"></div>

<?
$liste1 = "";
$liste2 = "";
$query0 = "SELECT max(conso_total) as max, min(conso_total) as min, date, DATE_FORMAT(`date`, '%Y-%m') AS mois FROM `conso_".$data['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(`date`, '%Y%m')";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data0 = mysql_fetch_assoc($req0))
{
$consoTemp = 0;
$query1 = "SELECT max(conso_total) as max, min(conso_total) as min, date FROM `conso_".$data['nom']."` WHERE date > DATE_SUB('".$data0['mois']."-1', INTERVAL 0 MONTH) AND date < DATE_SUB('".$data0['mois']."-1', INTERVAL -1 MONTH) GROUP BY DATE_FORMAT(`date`, '%Y%m%d')";
$req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data1 = mysql_fetch_assoc($req1))
{
//$consoTemp = 0;
foreach($heuresCreuses as $heureCreuse){
$query6 = "SELECT min(conso_total) as min, max(conso_total) as max FROM `conso_".$data['nom']."` where `date` >= '".substr($data0['date'], 0, 10)." ".$heureCreuse['debut']."' and `date` <= '".substr($data0['date'], 0, 10)." ".$heureCreuse['fin']."'";
$res_query6 = mysql_query($query6, $link);
if(mysql_numrows($res_query6) > 0){
$consoTemp += mysql_result($res_query6,0,"max") - mysql_result($res_query6,0,"min");
}
}
}
$liste1 .= "[".strtotime($data0['date']) * 1000 . "," . (($data0['max'] - $data0['min'])/1000) ."],";
$liste2 .= "[".strtotime($data0['date']) * 1000 . "," . number_format(((($consoTemp*$coutHC/1000)+(($data0['max'] - $data0['min'] - $consoTemp)*$coutHP)/1000)),2) ."],";
}
if($data['libelle'] == ""){
$nom = $data['nom'];
} else {
$nom = $data['libelle'];
}
?>
                <script type="text/javascript">
$(function () {
Highcharts.setOptions({
    global: {
        useUTC: false
    }
});
        $('#conso_elec_annuel_<? echo $data['id']; ?>').highcharts({
            chart: {
            },
            title: {
                text: '<? echo $nom; ?>'
            },
            subtitle: {
                text: 'Annuel'
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
                    text: 'Consomation (kWh)'
                }
            }, {
                min: 0,
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
                name: 'Consomation (kWh)',
                data: [<?php echo $liste1; ?>],
                type: 'column'

            }, {
                name: 'Cout (Euro)',
                yAxis: 1,
                data: [<?php echo $liste2; ?>],
                type: 'column'
            }]
        });
    });
                </script>

<div id="conso_elec_annuel_<? echo $data['id']; ?>" style="min-width: 400px; width:100%; height: 400px; margin: 0 auto"></div>

</div>
<?php } ?>
</div>
<script src="./js/highcharts.js"></script>


