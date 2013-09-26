<title>Consomation Electrique</title>

<?php
echo "<CENTER><TABLE>";
echo "<TR><TD>";
include("./pages/connexion.php");
$query = "SELECT * FROM detail ORDER BY `date` DESC LIMIT 1";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
$batterie = $data['battery'];
echo "<CENTER><TABLE>";
echo "<TR><TD>Phase 1 : </TD><TD>".$data['chan1']." Watt/h</TD></TR>";
echo "<TR><TD>Phase 2 : </TD><TD>".$data['chan2']." Watt/h</TD></TR>";
echo "<TR><TD>Phase 3 : </TD><TD>".$data['chan3']." Watt/h</TD></TR>";
echo "<TR><TD>Total   : </TD><TD>".($data['chan1'] + $data['chan2'] + $data['chan3'])." Watt/h</TD></TR>";
echo "</TABLE></CENTER>";
}
echo "</TD><TD>&nbsp;</TD><TD>";
echo "<CENTER><TABLE CELLSPACING='9'>";
echo "<TR><TD>(kWh)</TD><TD>&nbsp;Phase 1&nbsp;</TD><TD>&nbsp;Phase 2&nbsp;</TD><TD>&nbsp;Phase 3&nbsp;</TD><TD>&nbsp;Total&nbsp;</TD><TD>&nbsp;Cout&nbsp;</TD></TR>";
$query = "SELECT FORMAT(chan1/1000,2) as chan1, FORMAT(chan2/1000,2) as chan2, FORMAT(chan3/1000,2) as chan3, FORMAT((chan1+chan2+chan3)/1000,2) as total, FORMAT(cout,2) as cout FROM journalier ORDER BY `date` DESC LIMIT 1";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
echo "<TR><TD>Aujourd'hui&nbsp;</TD><TD>".$data['chan1']."</TD><TD>".$data['chan2']."</TD><TD>".$data['chan3']."</TD><TD>".$data['total']."</TD><TD>".$data['cout']." &euro;</TD></TR>";
}
$query = "SELECT FORMAT(chan1/1000,2) as chan1, FORMAT(chan2/1000,2) as chan2, FORMAT(chan3/1000,2) as chan3, FORMAT((chan1+chan2+chan3)/1000,2) as total, FORMAT(cout,2) as cout FROM journalier ORDER BY `date` DESC LIMIT 1,1";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
echo "<TR><TD>hier</TD><TD>".$data['chan1']."</TD><TD>".$data['chan2']."</TD><TD>".$data['chan3']."</TD><TD>".$data['total']."</TD><TD>".$data['cout']." &euro;</TD></TR>";
}
$query = "SELECT FORMAT(SUM(chan1)/1000,2) as chan1, FORMAT(SUM(chan2)/1000,2) as chan2, FORMAT(SUM(chan3)/1000,2) as chan3, FORMAT((SUM(chan1)+SUM(chan2)+SUM(chan3))/1000,2) as total, FORMAT(SUM(cout),2) as cout FROM `journalier` WHERE date < curdate() AND date > DATE_ADD(curdate(), INTERVAL -8 DAY)";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
echo "<TR><TD>7 jours</TD><TD>".$data['chan1']."</TD><TD>".$data['chan2']."</TD><TD>".$data['chan3']."</TD><TD>".$data['total']."</TD><TD>".$data['cout']." &euro;</TD></TR>";
}
$query = "SELECT FORMAT(SUM(chan1)/1000,2) as chan1, FORMAT(SUM(chan2)/1000,2) as chan2, FORMAT(SUM(chan3)/1000,2) as chan3, FORMAT((SUM(chan1)+SUM(chan2)+SUM(chan3))/1000,2) as total, FORMAT(SUM(cout),2) as cout FROM `journalier` WHERE date < curdate() AND date > DATE_ADD(curdate(), INTERVAL -1 MONTH)";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
echo "<TR><TD>30 jours</TD><TD>".$data['chan1']."</TD><TD>".$data['chan2']."</TD><TD>".$data['chan3']."</TD><TD>".$data['total']."</TD><TD>".$data['cout']." &euro;</TD></TR>";
}
$query = "SELECT FORMAT(SUM(chan1)/1000,2) as chan1, FORMAT(SUM(chan2)/1000,2) as chan2, FORMAT(SUM(chan3)/1000,2) as chan3, FORMAT((SUM(chan1)+SUM(chan2)+SUM(chan3))/1000,2) as total, FORMAT(SUM(cout),2) as cout FROM `journalier` WHERE date < curdate() AND date > DATE_ADD(curdate(), INTERVAL -1 YEAR)";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
echo "<TR><TD>1 an</TD><TD>".$data['chan1']."</TD><TD>".$data['chan2']."</TD><TD>".$data['chan3']."</TD><TD>".$data['total']."</TD><TD>".$data['cout']." &euro;</TD></TR>";
}

echo "</TABLE></CENTER>";
echo "<BR><CENTER>Batterie : ".$batterie."</CENTER>";
echo "</TD></TR></TABLE>";

echo "<CENTER><A HREF=\"./index.php?page=owl&delai=heure\">Heure</A> , <A HREF=\"./index.php?page=owl&delai=jour\">Jour</A></CENTER>";

include("./pages/owl_phases_graph.php");

include("./pages/owl_global.php");

include("./pages/owl_global_month.php");

?>

<script src="./js/highcharts.js"></script>

