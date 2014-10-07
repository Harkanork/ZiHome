<?php
$i=0;
include_once("./lib/date_francais.php");
echo "<CENTER><TABLE>";
echo "<TR style='text-align: center'><TD></TD><TD ALIGN=CENTER><b>Nom</b></TD><TD><b>&nbsp;Pr&eacute;cipitation&nbsp;</b></TD><TD><b>&nbsp;Cumul&nbsp;</b></TD><TD><b>Date - Heure</b></TD></TR>";
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
    echo "<TR bgcolor='".( ($i % 2 == 1) ? '#dddddd' : '#eeeeee' )."' id='TR_".$periph['id']."'>";
    echo "  <TD>".$batterie."</TD>";
    echo "  <TD><span style='vertical-align:3px'>".$periph['nom']."</span></TD>";
    echo "  <TD ALIGN=CENTER>".$value0['pluie']." mm/h</TD>";
    echo "  <TD ALIGN=CENTER>".($value0['cumul'])." mm</TD>";
    echo "  <TD>".date_francais($value0['date'])."</TD>";
    echo "</TR>";
    $i++;
  }
}
echo "</TABLE></CENTER>";
?>
