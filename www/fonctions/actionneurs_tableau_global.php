<?php
$i=0;
echo "<CENTER><TABLE>";
echo "<TR style='text-align: center'><TD></TD><TD ALIGN=CENTER><b>Nom</b></TD><TD><b>&nbsp;Actif&nbsp;</b></TD></TR>";
$query = "SELECT * FROM peripheriques WHERE periph = 'actioneur'";
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
  echo "<TR  bgcolor='".( ($i % 2 == 1) ? '#dddddd' : '#eeeeee' )."'><TD>".$batterie."</TD><TD><span style='vertical-align:3px'>".$nom."</span></TD><TD ALIGN=CENTER>".$stateactif."</TD></TR>";
$i = $i+1;
}
echo "</TABLE></CENTER>";
?>
