<?php
echo "<CENTER><TABLE>";
echo "<TR style='text-align: center'><TD></TD><TD ALIGN=CENTER>Nom</TD><TD>&nbsp;Pr&eacute;cipitation&nbsp;</TD><TD>&nbsp;Cumul&nbsp;</TD></TR>";
include("./pages/connexion.php");
$query = "SELECT * FROM peripheriques WHERE periph = 'pluie'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($periph = mysql_fetch_assoc($req))
{
  if($periph['batterie'] == 0)
  {
    $batterie = "";
  } else {
    $batterie = "<img src='./img/batterie_ko.png' style='height:20px'/>";
  }
  $query0 = "SELECT * FROM `pluie_".$periph['nom']."` ORDER BY `date` DESC LIMIT 1";
  $req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while ($value0 = mysql_fetch_assoc($req0))
  {
    echo "<TR><TD>".$batterie."</TD><TD><span style='vertical-align:3px'>".$periph['nom']."</span></TD><TD ALIGN=CENTER>".$value0['pluie']." mm/h</TD><TD ALIGN=CENTER>".($value0['cumul'])." mm</TD></TR>";
  }
}
echo "</TABLE></CENTER>";
?>
