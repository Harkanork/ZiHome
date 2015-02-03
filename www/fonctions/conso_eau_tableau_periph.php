<?php
echo "<p class=titre-texte>Statistiques pour ".$nom." :</p>";
echo "<p><CENTER><TABLE width=500px>";
echo "<TR class=tab-titre><TD><b>P&eacute;riode</b></TD><TD width=120px><b>&nbsp;Consommation&nbsp;</b></TD><TD width=150px><b>&nbsp;Co&ucirc;t&nbsp;</b></TD></TR>";

// Calcul la consommation journaliere pour hier et aujourd'hui
$query0 = "SELECT SUM(conso) as somme_conso, date FROM `eau_".$periph['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 3 DAY) GROUP BY DATE_FORMAT(`date`, '%Y%m%d') ORDER BY DATE_FORMAT(`date`, '%Y%m%d') DESC LIMIT 2";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$i=1;
while ($value0 = mysql_fetch_assoc($req0))
{
  if($i == 1) {
    $jour = "Aujourd'hui&nbsp;";
  } else {
    $jour = "Hier";
  }
  echo "<TR bgcolor='#eeeeee' class=tab-ligne><TD>" . $jour . "</TD><TD style='text-align: right'>".number_format($value0['somme_conso'],0, ',', ' ')." l&nbsp;</TD><TD style='text-align: right'>".number_format($value0['somme_conso'] * $coutEau,2,',',' ')." &euro;&nbsp;</TD></TR>";
  $i++;
}

// Calcul la consommation de la semaine courante
$query0 = "SELECT SUM(conso) as somme_conso, date FROM `eau_".$periph['nom']."` WHERE  CONCAT(YEAR(date), '/', WEEK(date)) = CONCAT(YEAR(curdate()), '/', WEEK(curdate()))";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value0 = mysql_fetch_assoc($req0))
{
  echo "<TR bgcolor='#dddddd' class=tab-ligne><TD>Semaine courante</TD><TD style='text-align: right'>".number_format($value0['somme_conso'],0, ',', ' ')." l&nbsp;</TD><TD style='text-align: right'>". number_format($value0['somme_conso'] * $coutEau,2,',',' ')." &euro;&nbsp;</TD></TR>";
}

// Calcul la consommation de la derniere semaine
$query0 = "SELECT SUM(conso) as somme_conso, date FROM `eau_".$periph['nom']."` WHERE  CONCAT(YEAR(date), '/', WEEK(date)) = CONCAT(YEAR(curdate()), '/', WEEK(curdate()) - 1)";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value0 = mysql_fetch_assoc($req0))
{
  echo "<TR bgcolor='#dddddd' class=tab-ligne><TD>Semaine pr&eacute;c&eacute;dente</TD><TD style='text-align: right'>".number_format($value0['somme_conso'],0, ',', ' ')." l&nbsp;</TD><TD style='text-align: right'>". number_format($value0['somme_conso'] * $coutEau,2,',',' ')." &euro;&nbsp;</TD></TR>";
}

// Calcul la consommation du mois courant
$query0 = "SELECT SUM(conso) as somme_conso, date FROM `eau_".$periph['nom']."` WHERE  CONCAT(YEAR(date), '/', MONTH(date)) = CONCAT(YEAR(curdate()), '/', MONTH(curdate()))";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value0 = mysql_fetch_assoc($req0))
{
  echo "<TR bgcolor='#dddddd' class=tab-ligne><TD>Mois courant</TD><TD style='text-align: right'>".number_format($value0['somme_conso'],0, ',', ' ')." l&nbsp;</TD><TD style='text-align: right'>". number_format($value0['somme_conso'] * $coutEau,2,',',' ')." &euro;&nbsp;</TD></TR>";
}

// Calcul la consommation du dernier mois
$query0 = "SELECT SUM(conso) as somme_conso, date FROM `eau_".$periph['nom']."` WHERE  CONCAT(YEAR(date), '/', MONTH(date)) = CONCAT(YEAR(curdate()), '/', MONTH(curdate()) - 1)";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value0 = mysql_fetch_assoc($req0))
{
  echo "<TR bgcolor='#dddddd' class=tab-ligne><TD>Mois pr&eacute;c&eacute;dent</TD><TD style='text-align: right'>".number_format($value0['somme_conso'],0, ',', ' ')." l&nbsp;</TD><TD style='text-align: right'>". number_format($value0['somme_conso'] * $coutEau,2,',',' ')." &euro;&nbsp;</TD></TR>";
}

// Calcul la consommation de la derniere annee
$query0 = "SELECT SUM(conso) as somme_conso, date FROM `eau_".$periph['nom']."` WHERE  YEAR(date) = YEAR(curdate())";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value0 = mysql_fetch_assoc($req0))
{
  echo "<TR bgcolor='#dddddd' class=tab-ligne><TD>Ann&eacute;e</TD><TD style='text-align: right'>".number_format($value0['somme_conso'],0, ',', ' ')." l&nbsp;</TD><TD style='text-align: right'>". number_format($value0['somme_conso'] * $coutEau,2,',',' ')." &euro;&nbsp;</TD></TR>";
}

echo "</TABLE></CENTER></p>";
?>
