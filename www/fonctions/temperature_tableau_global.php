<?php
echo "<CENTER><TABLE>";
echo "<TR><TD ALIGN=CENTER>Nom</TD><TD>&nbsp;Temperature&nbsp;</TD><TD>&nbsp;Hygrometrie&nbsp;</TD><TD>Pile Faible</TD><TD>Date - Heure</TD></TR>";
include("./pages/connexion.php");
$query = "SELECT * FROM peripheriques WHERE periph = 'temperature'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($periph = mysql_fetch_assoc($req))
{
if($periph['batterie'] == 0)
{
$batterie = "Non";
} else {
$batterie = "<FONT COLOR='red'>Oui</FONT>";
}
$query0 = "SELECT * FROM `temperature_".$periph['nom']."` ORDER BY `date` DESC LIMIT 1";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($value0 = mysql_fetch_assoc($req0))
{
if($periph['libelle'] == ""){
$nom = $periph['nom'];
} else {
$nom = $periph['libelle'];
}
echo "<TR><TD>".$nom."</TD><TD ALIGN=CENTER>".$value0['temp']."</TD><TD ALIGN=CENTER>".$value0['hygro']."</TD><TD ALIGN=CENTER>".$batterie."</TD><TD>".$value0['date']."</TD></TR>";
}
}
echo "</TABLE></CENTER>";
?>
