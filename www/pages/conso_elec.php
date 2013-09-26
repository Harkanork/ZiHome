<title>Consomation Electrique</title>
<?php
include("./pages/conf_zibase.php");
echo "<CENTER><TABLE>";
echo "<TR><TD ALIGN=CENTER>Nom</TD><TD>&nbsp;Consomation&nbsp;</TD><TD>Pile Faible</TD></TR>";
include("./pages/connexion.php");
$query = "SELECT * FROM conso_electrique";
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
echo "<TR><TD>".$data['nom']."</TD><TD ALIGN=CENTER>".$data0['conso']."</TD><TD ALIGN=CENTER>".$batterie."</TD></TR>";
}
}
echo "</TABLE></CENTER>";

$query = "SELECT * FROM conso_electrique";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
$query0 = "SELECT max(conso_total) as max, min(conso_total) as min, date FROM `".$data['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY DATE_FORMAT(`date`, '%Y%m%d')";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$liste1 = "";
$liste2 = "";
while($data0 = mysql_fetch_assoc($req0))
{
$consoTemp = 0;
foreach($heuresCreuses as $heureCreuse){
$query6 = "SELECT min(conso_total) as min, max(conso_total) as max FROM `".$data['nom']."` where `date` >= '".substr($data0['date'], 0, 10)." ".$heureCreuse['debut']."' and `date` <= '".substr($data0['date'], 0, 10)." ".$heureCreuse['fin']."'";
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
Highcharts.setOptions({
    global: {
        useUTC: false
    }
});
        $('#conso_elec_<? echo $data['id']; ?>').highcharts({
            chart: {
            },
            title: {
                text: '<? echo $data['nom']; ?>'
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

<div id="conso_elec_<? echo $data['id']; ?>" style="min-width: 400px; height: 400px; margin: 0 auto"></div>

<?php } ?>

<script src="./js/highcharts.js"></script>


