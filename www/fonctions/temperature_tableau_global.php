<?php
echo "<CENTER><TABLE>";
echo "<TR><TD ALIGN=CENTER>Nom</TD><TD>&nbsp;Temperature&nbsp;</TD><TD>&nbsp;Hygrometrie&nbsp;</TD><TD>Pile Faible</TD><TD>Date - Heure</TD></TR>";
include("./pages/connexion.php");
$query = "SELECT * FROM peripheriques WHERE periph = 'temperature'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
if($data['batterie'] == 0)
{
$batterie = "Non";
} else {
$batterie = "<FONT COLOR='red'>Oui</FONT>";
}
$query0 = "SELECT * FROM `temperature_".$data['nom']."` ORDER BY `date` DESC LIMIT 1";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data0 = mysql_fetch_assoc($req0))
{
if($data['libelle'] == ""){
$nom = $data['nom'];
} else {
$nom = $data['libelle'];
}
echo "<TR><TD>".$nom."</TD><TD ALIGN=CENTER>".$data0['temp']."</TD><TD ALIGN=CENTER>".$data0['hygro']."</TD><TD ALIGN=CENTER>".$batterie."</TD><TD>".$data0['date']."</TD></TR>";
}
}
echo "</TABLE></CENTER>";
?>
