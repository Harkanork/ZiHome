<?php
include("./config/conf_zibase.php");
echo "<CENTER><TABLE>";
echo "<TR><TD></TD><TD ALIGN=CENTER>Nom</TD><TD>&nbsp;Actif&nbsp;</TD></TR>";
include("./pages/connexion.php");
$query = "SELECT * FROM peripheriques WHERE periph = 'capteur'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($periph = mysql_fetch_assoc($req))
{
  if($periph['protocol'] == 6) {
    $protocol = true;
  } else {
    $protocol = false;
  }
  $stateactif = $zibase->getState($periph['id'], $protocol);
  if($periph['batterie'] == 0)
  {
    $batterie = "";
  } else {
    $batterie = "<img src='./img/batterie_ko.png' style='height:20px'/>";
  }
  if ($periph['libelle'] == "") {
    $nom = $periph['nom'];
  } else {
    $nom = $periph['libelle'];
  }
  echo "<TR><TD>".$batterie."</TD><TD><span style='vertical-align:3px'>".$nom."</span></TD><TD ALIGN=CENTER>".$stateactif."</TD></TR>";
}
echo "</TABLE></CENTER>";
?>
