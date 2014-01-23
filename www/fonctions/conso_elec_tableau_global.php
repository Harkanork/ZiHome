<?php
include("./config/conf_zibase.php");
echo "<CENTER><TABLE>";
echo "<TR><TD></TD><TD ALIGN=CENTER>Nom</TD><TD>&nbsp;Consommation&nbsp;</TD></TR>";
include("./pages/connexion.php");
$query = "SELECT * FROM peripheriques WHERE periph = 'conso'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($periph = mysql_fetch_assoc($req))
{
  if($periph['batterie'] == 0)
  {
    $batterie = "";
  } else {
    $batterie = "<img src='./img/batterie_ko.png' style='height:20px'/>";
  }
  $query0 = "SELECT * FROM `conso_".$periph['nom']."` ORDER BY `date` DESC LIMIT 1";
  $req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while ($value0 = mysql_fetch_assoc($req0))
  {
    if ($periph['libelle'] == "") {
      $nom = $periph['nom'];
    } else {
      $nom = $periph['libelle'];
    }
    echo "<TR><TD>".$batterie."</TD><TD><span style='vertical-align:3px'>".$nom."</span></TD><TD ALIGN=CENTER>".$value0['conso']."</TD></TR>";
  }
}
echo "</TABLE></CENTER>";
?>
