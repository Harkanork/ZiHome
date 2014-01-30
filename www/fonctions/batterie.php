<?php
include("./lib/date_francais.php");
echo "<CENTER><TABLE border=0 ><TR class='title' style='text-align: center'><TD>Sonde</TD><TD style='width:100px'>Dernier<br>changement</TD><TD style='width:140px'>Batterie<br>faible</TD></TR>";
include("./pages/connexion.php");
$query = "SELECT * FROM owl_detail ORDER BY `date` DESC LIMIT 1";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($periph = mysql_fetch_assoc($req))
{
  if($periph['battery'] == "100%") {
    $batterie = $periph['battery'];
  } else {
    $batterie = "<FONT COLOR='red'>".$periph['battery']."</FONT>";
  }
  echo "<TR><TD>OWL CM180</TD><TD ALIGN=CENTER>".$batterie."</TD></TR>";
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
  echo "<TR class=\"contenu\">";
  echo "<TD>".$batterie."<span style='vertical-align:3px'>".$nom."</span></TD>";
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
    echo "<TD style='text-align: center;'>".date_francais($periph['alerte_batterie'])."</TD>";
  }
  else
  {
    echo "<TD></TD>";
  }
  echo "</TR>";
}
?>
</TABLE></CENTER>
