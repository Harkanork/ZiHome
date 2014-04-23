<?php
include("./lib/date_francais.php");
include("./pages/connexion.php");
$i=0;
echo "<CENTER><TABLE ><TR class='title' style='text-align: center'><TD><b>Sonde</b></TD><TD style='width:100px'><b>Dernier<br>changement</b></TD><TD style='width:140px'><b>Batterie<br>faible</b></TD></TR>";

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
  echo "<TR class=\"contenu\" bgcolor='".( ($i % 2 == 1) ? '#dddddd' : '#eeeeee' )."'>";
  $i++;
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
