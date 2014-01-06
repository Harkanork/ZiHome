<?php
echo "<CENTER><TABLE>";
echo "<TR><TD ALIGN=CENTER>Nom</TD><TD>&nbsp;Prepitation&nbsp;</TD><TD>&nbsp;Cumul&nbsp;</TD><TD>Pile Faible</TD></TR>";
include("./pages/connexion.php");
$query = "SELECT * FROM peripheriques WHERE periph = 'pluie'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($periph = mysql_fetch_assoc($req))
{
if($periph['batterie'] == 0)
{
$batterie = "Non";
} else {
$batterie = "<FONT COLOR='red'>Oui</FONT>";
}
$query0 = "SELECT * FROM `pluie_".$periph['nom']."` ORDER BY `date` DESC LIMIT 1";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($value0 = mysql_fetch_assoc($req0))
{
echo "<TR><TD>".$periph['nom']."</TD><TD ALIGN=CENTER>".$value0['pluie']." mm</TD><TD ALIGN=CENTER>".($value0['cumul'])." mm</TD><TD ALIGN=CENTER>".$batterie."</TD></TR>";
}
}
echo "</TABLE></CENTER>";
?>
