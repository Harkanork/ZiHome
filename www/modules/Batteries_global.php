<?php
if (isset($_GET['requete'])) { // si le script est bien appelé par ajax en precisant l'objet de la requête

  include("../config/conf_zibase.php");
  include("../config/variables.php");
  include("../lib/zibase.php");
  $zibase = new ZiBase($ipzibase);
  include_once("../lib/date_francais.php");
  
  $link = mysql_connect($hote,$login,$plogin);
  if (!$link) {
    die('Non connect&eacute; : ' . mysql_error());
  }
  $db_selected = mysql_select_db($base,$link);
  if (!$db_selected) {
    die ('Impossible d\'utiliser la base : ' . mysql_error());
  }





$i=0;
echo "<CENTER><TABLE width=500px>";
echo "<TR class=tab-titre><TD style='width:16px'></TD><TD>Capteur</TD><TD style='width:100px'>Dernier<br>changement</TD><TD style='width:140px'>Batterie<br>faible</TD></TR>";

$query = "SELECT * FROM owl_detail ORDER BY `date` DESC LIMIT 1";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($periph = mysql_fetch_assoc($req))
{
  if($periph['battery'] == "100%") {
    $batterie = "<img src='./img/batterie_ok.png' height='20px'/>";
  } else {
    $batterie = "<img src='./img/batterie_ko.png' height='20px'/>";
  }
  echo "<TR bgcolor='".( ($i % 2 == 1) ? '#dddddd' : '#eeeeee' )."'><TD>".$batterie."<span style='vertical-align:3px'>OWL CM180</span></TD><TD></TD><TD></TD></TR>";
  $i++;
}

$query = "SELECT * FROM peripheriques WHERE gerer_batterie = '1'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($periph = mysql_fetch_assoc($req))
{
  if($periph['batterie'] == 0)
  {
    $batterie = "<img src='./img/batterie_ok.png' height='20px'/>";
  } else {
    $batterie = "<img src='./img/batterie_ko.png' height='20px'/>";
  }
  if($periph['libelle'] == ""){
    $nom = $periph['nom'];
  } else {
    $nom = $periph['libelle'];
  }
  echo "<TR class=tab-ligne bgcolor='".( ($i % 2 == 1) ? '#dddddd' : '#eeeeee' )."'>";
  $i++;
  echo "<TD>".$batterie."</TD>";
  echo "<TD><span style='vertical-align:3px'>".$nom."</span></TD>";
  if ($periph['date_chgt_batterie'] != "0000-00-00")
  {
    echo "<TD style='text-align: center;'>".date_francais($periph['date_chgt_batterie'])."</TD>";
  }
  else
  {
    echo "<TD></TD>";
  }
  if ($periph['alerte_batterie'] != "0000-00-00 00:00:00")
  {
    echo "<TD style='text-align: center;'>".date_simplifiee($periph['alerte_batterie'])."</TD>";
  }
  else
  {
    echo "<TD></TD>";
  }
  echo "</TR>";
}
?>
</TABLE></CENTER>


<?
}
?>
