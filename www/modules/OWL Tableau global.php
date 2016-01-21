<?php
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





$query = "SELECT * FROM owl_detail ORDER BY `date` DESC LIMIT 1";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($periph = mysql_fetch_assoc($req))
{
echo "<CENTER><TABLE>";
echo "<TR bgcolor='#dddddd'><TD>Phase 1 : </TD><TD>".$periph['chan1']." Watt/h</TD></TR>";
echo "<TR bgcolor='#eeeeee'><TD>Phase 2 : </TD><TD>".$periph['chan2']." Watt/h</TD></TR>";
echo "<TR bgcolor='#dddddd'><TD>Phase 3 : </TD><TD>".$periph['chan3']." Watt/h</TD></TR>";
echo "<TR bgcolor='#eeeeee'><TD>Total   : </TD><TD>".($periph['chan1'] + $periph['chan2'] + $periph['chan3'])." Watt/h</TD></TR>";
echo "</TABLE></CENTER>";
}
echo "</TD><TD>&nbsp;</TD><TD>";
echo "<CENTER><TABLE>";
echo "<TR style='text-align: center'><TD><b>(kWh)</b></TD><TD><b>&nbsp;Phase 1&nbsp;</b></TD><TD><b>&nbsp;Phase 2&nbsp;</b></TD><TD><b>&nbsp;Phase 3&nbsp;</b></TD><TD><b>&nbsp;Total&nbsp;</b></TD><TD><b>&nbsp;Cout&nbsp;</b></TD></TR>";
$query = "SELECT FORMAT(chan1/1000,2) as chan1, FORMAT(chan2/1000,2) as chan2, FORMAT(chan3/1000,2) as chan3, FORMAT((chan1+chan2+chan3)/1000,2) as total, FORMAT(cout,2) as cout FROM owl_journalier ORDER BY `date` DESC LIMIT 1";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($periph = mysql_fetch_assoc($req))
{
echo "<TR bgcolor='#dddddd'><TD>Aujourd'hui&nbsp;</TD><TD>".$periph['chan1']."</TD><TD>".$periph['chan2']."</TD><TD>".$periph['chan3']."</TD><TD>".$periph['total']."</TD><TD>".$periph['cout']." &euro;</TD></TR>";
}
$query = "SELECT FORMAT(chan1/1000,2) as chan1, FORMAT(chan2/1000,2) as chan2, FORMAT(chan3/1000,2) as chan3, FORMAT((chan1+chan2+chan3)/1000,2) as total, FORMAT(cout,2) as cout FROM owl_journalier ORDER BY `date` DESC LIMIT 1,1";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($periph = mysql_fetch_assoc($req))
{
echo "<TR bgcolor='#eeeeee'><TD>hier</TD><TD>".$periph['chan1']."</TD><TD>".$periph['chan2']."</TD><TD>".$periph['chan3']."</TD><TD>".$periph['total']."</TD><TD>".$periph['cout']." &euro;</TD></TR>";
}
$query = "SELECT FORMAT(SUM(chan1)/1000,2) as chan1, FORMAT(SUM(chan2)/1000,2) as chan2, FORMAT(SUM(chan3)/1000,2) as chan3, FORMAT((SUM(chan1)+SUM(chan2)+SUM(chan3))/1000,2) as total, FORMAT(SUM(cout),2) as cout FROM `owl_journalier` WHERE date < curdate() AND date > DATE_ADD(curdate(), INTERVAL -8 DAY)";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($periph = mysql_fetch_assoc($req))
{
echo "<TR bgcolor='#dddddd'><TD>7 jours</TD><TD>".$periph['chan1']."</TD><TD>".$periph['chan2']."</TD><TD>".$periph['chan3']."</TD><TD>".$periph['total']."</TD><TD>".$periph['cout']." &euro;</TD></TR>";
}
$query = "SELECT FORMAT(SUM(chan1)/1000,2) as chan1, FORMAT(SUM(chan2)/1000,2) as chan2, FORMAT(SUM(chan3)/1000,2) as chan3, FORMAT((SUM(chan1)+SUM(chan2)+SUM(chan3))/1000,2) as total, FORMAT(SUM(cout),2) as cout FROM `owl_journalier` WHERE date < curdate() AND date > DATE_ADD(curdate(), INTERVAL -1 MONTH)";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($periph = mysql_fetch_assoc($req))
{
echo "<TR bgcolor='#eeeeee'><TD>30 jours</TD><TD>".$periph['chan1']."</TD><TD>".$periph['chan2']."</TD><TD>".$periph['chan3']."</TD><TD>".$periph['total']."</TD><TD>".$periph['cout']." &euro;</TD></TR>";
}
$query = "SELECT FORMAT(SUM(chan1)/1000,2) as chan1, FORMAT(SUM(chan2)/1000,2) as chan2, FORMAT(SUM(chan3)/1000,2) as chan3, FORMAT((SUM(chan1)+SUM(chan2)+SUM(chan3))/1000,2) as total, FORMAT(SUM(cout),2) as cout FROM `owl_journalier` WHERE date < curdate() AND date > DATE_ADD(curdate(), INTERVAL -1 YEAR)";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($periph = mysql_fetch_assoc($req))
{
echo "<TR bgcolor='#dddddd'><TD>1 an</TD><TD>".$periph['chan1']."</TD><TD>".$periph['chan2']."</TD><TD>".$periph['chan3']."</TD><TD>".$periph['total']."</TD><TD>".$periph['cout']." &euro;</TD></TR>";
}
echo "</TABLE></CENTER>";





}
?>




