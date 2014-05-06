<?php
$i=0;
echo "<CENTER><TABLE>";
echo "<TR style='text-align: center'><TD></TD><TD ALIGN=CENTER><b>Nom</b></TD><TD><b>&nbsp;Direction&nbsp;</b></TD><TD><b>&nbsp;Vitesse&nbsp;</b></TD></TR>";
$query = "SELECT * FROM peripheriques WHERE periph = 'vent'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($periph = mysql_fetch_assoc($req))
{
  if($periph['batterie'] == 0)
  {
    $batterie = "";
  } else {
    $batterie = "<img src='./img/batterie_ko.png' style='height:20px'/>";
  }
  $query0 = "SELECT * FROM `vent_".$periph['nom']."` ORDER BY `date` DESC LIMIT 1";
  $req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while ($value0 = mysql_fetch_assoc($req0))
  {
    echo "<TR bgcolor='".( ($i % 2 == 1) ? '#dddddd' : '#eeeeee' )."'><TD>".$batterie."</TD><TD><span style='vertical-align:3px'>".$periph['nom']."</span></TD><TD ALIGN=CENTER>".$value0['direction']."</TD><TD ALIGN=CENTER>".($value0['vitesse']/10)." m/s</TD></TR>";
    $i++;
  }
}
echo "</TABLE></CENTER>";
?>
