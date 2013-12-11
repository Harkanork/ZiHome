<?php
echo "<CENTER><TABLE><TR><TD>Sonde</TD><TD>Batterie</TD><TD>Date Batterie</TD></TR>";
include("./pages/connexion.php");
$query = "SELECT * FROM owl_detail ORDER BY `date` DESC LIMIT 1";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
if($data['battery'] == "100%") {
$batterie = $data['battery'];
} else {
$batterie = "<FONT COLOR='red'>".$data['battery']."</FONT>";
}
echo "<TR><TD>OWL CM180</TD><TD ALIGN=CENTER>".$batterie."</TD></TR>";
}
$query = "SELECT * FROM peripheriques WHERE gerer_batterie = '1'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
if($data['batterie'] == 0)
{
$batterie = "Ok";
} else {
$batterie = "<FONT COLOR='red'>Remplacer</FONT>";
}
if($data['libelle'] == ""){
$nom = $data['nom'];
} else {
$nom = $data['libelle'];
}
echo "<TR><TD>".$nom."</TD><TD ALIGN=CENTER>".$batterie."</TD><TD>".$data['date_chgt_batterie']."</TD></TR>";
}
?>
