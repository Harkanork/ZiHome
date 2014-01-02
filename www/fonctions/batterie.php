<?php
echo "<CENTER><TABLE><TR><TD>Sonde</TD><TD>Batterie</TD><TD>Date Batterie</TD></TR>";
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
$batterie = "Ok";
} else {
$batterie = "<FONT COLOR='red'>Remplacer</FONT>";
}
if($periph['libelle'] == ""){
$nom = $periph['nom'];
} else {
$nom = $periph['libelle'];
}
echo "<TR><TD>".$nom."</TD><TD ALIGN=CENTER>".$batterie."</TD><TD>".$periph['date_chgt_batterie']."</TD></TR>";
}
?>
</TABLE></CENTER>
