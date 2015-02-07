<?php

function ajoutLigneConsoEau($couleur, $desc, $conso, $coutEau)
{
  if ($conso > 0)
  {
    echo "<TR bgcolor='" . $couleur . "' class=tab-ligne><TD>" . $desc . "</TD><TD style='text-align: right'>".number_format($conso,0, ',', ' ')." l&nbsp;</TD><TD style='text-align: right'>".number_format($conso / 1000, 2, ',', ' ')." m&sup3;&nbsp;</TD><TD style='text-align: right'>".number_format(($conso * $coutEau) / 1000, 2, ',', ' ')." &euro;&nbsp;</TD></TR>";
  }
}


echo "<p class=titre-texte>Statistiques pour ".$nom." :</p>";
echo "<p><CENTER><TABLE width=500px>";
echo "<TR class=tab-titre><TD width=140px><b>P&eacute;riode</b></TD><TD width=120px><b>&nbsp;Conso. litres&nbsp;</b></TD><TD width=120px><b>&nbsp;Conso. m&sup3;&nbsp;</b></TD><TD width=150px><b>&nbsp;Co&ucirc;t&nbsp;</b></TD></TR>";

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
  ajoutLigneConsoEau('#eeeeee', $jour, $value0['somme_conso'], $coutEau);
  $i++;
}

// Calcul la consommation de la derniere annee
$consoAnneeCourante = 0;
$query0 = "SELECT SUM(conso) as somme_conso, date FROM `eau_".$periph['nom']."` WHERE  YEAR(date) = YEAR(curdate())";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value0 = mysql_fetch_assoc($req0))
{
  $consoAnneeCourante = $value0['somme_conso'];
}

// Calcul de la valeur moyenne sur l'annee
if ($consoAnneeCourante > 0)
{
  $query1 = "SELECT min(date) as min_date, max(date) as max_date FROM `eau_".$periph['nom']."` WHERE  YEAR(date) = YEAR(curdate())";
  $req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while($value1 = mysql_fetch_assoc($req1))
  {
    $dateDebut = strptime($value1['min_date'], '%Y-%m-%e %k:%M:%S')[tm_yday];
    $dateFin = strptime($value1['max_date'], '%Y-%m-%e %k:%M:%S')[tm_yday];
    if ($dateDebut != $dateFin)
    {
      ajoutLigneConsoEau('#eeeeee', 'Moyenne annuelle', $consoAnneeCourante / ($dateFin - $dateDebut), $coutEau);
    }
  }
}

// Calcul la consommation de la semaine courante
$query0 = "SELECT SUM(conso) as somme_conso, date FROM `eau_".$periph['nom']."` WHERE  CONCAT(YEAR(date), '/', WEEK(date)) = CONCAT(YEAR(curdate()), '/', WEEK(curdate()))";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value0 = mysql_fetch_assoc($req0))
{
  ajoutLigneConsoEau('#dddddd', 'Semaine courante', $value0['somme_conso'], $coutEau);
}

// Calcul la consommation de la derniere semaine
$query0 = "SELECT SUM(conso) as somme_conso, date FROM `eau_".$periph['nom']."` WHERE  CONCAT(YEAR(date), '/', WEEK(date)) = CONCAT(YEAR(curdate()), '/', WEEK(curdate()) - 1)";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value0 = mysql_fetch_assoc($req0))
{
  ajoutLigneConsoEau('#dddddd', 'Semaine pr&eacute;c&eacute;dente', $value0['somme_conso'], $coutEau);
}

// Calcul la consommation du mois courant
$query0 = "SELECT SUM(conso) as somme_conso, date FROM `eau_".$periph['nom']."` WHERE  CONCAT(YEAR(date), '/', MONTH(date)) = CONCAT(YEAR(curdate()), '/', MONTH(curdate()))";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value0 = mysql_fetch_assoc($req0))
{
  ajoutLigneConsoEau('#eeeeee', 'Mois courant', $value0['somme_conso'], $coutEau);
}

// Calcul la consommation du dernier mois
$query0 = "SELECT SUM(conso) as somme_conso, date FROM `eau_".$periph['nom']."` WHERE  CONCAT(YEAR(date), '/', MONTH(date)) = CONCAT(YEAR(curdate()), '/', MONTH(curdate()) - 1)";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value0 = mysql_fetch_assoc($req0))
{
  ajoutLigneConsoEau('#eeeeee', 'Mois pr&eacute;c&eacute;dent', $value0['somme_conso'], $coutEau);
}

// Affichage de la consommation de la derniere annee
ajoutLigneConsoEau('#dddddd', 'Ann&eacute;e courante', $consoAnneeCourante, $coutEau);

// Calcul la consommation de l'annee précédente
$query0 = "SELECT SUM(conso) as somme_conso, date FROM `eau_".$periph['nom']."` WHERE  YEAR(date) = YEAR(curdate()) - 1";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value0 = mysql_fetch_assoc($req0))
{
  ajoutLigneConsoEau('#dddddd', 'Ann&eacute;e pr&eacute;c&eacute;dente', $value0['somme_conso'], $coutEau);
}

echo "</TABLE></CENTER></p>";
?>
