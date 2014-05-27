<?php
include_once("./lib/date_francais.php");
$i=0;
echo "<CENTER><TABLE>";
echo "<TR style='text-align: center'><TD></TD><TD ALIGN=CENTER><b>Nom</b></TD><TD><b>&nbsp;Consommation&nbsp;</b></TD><TD><b>Date - Heure</b></TD></TR>";
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
    echo "<TR bgcolor='".( ($i % 2 == 1) ? '#dddddd' : '#eeeeee' )."'><TD>".$batterie."</TD><TD><span style='vertical-align:3px'>".$nom."</span></TD><TD ALIGN=CENTER>".$value0['conso']."</TD><TD>".date_francais($value0['date'])."</TD></TR>";
    $i=$i+1;
  }
}
echo "</TABLE></CENTER>";
?>
