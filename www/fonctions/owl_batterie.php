<?php
include("./pages/connexion.php");
$query = "SELECT * FROM owl_detail ORDER BY `date` DESC LIMIT 1";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($periph = mysql_fetch_assoc($req))
{
$batterie = $periph['battery'];
}
echo "<BR><CENTER>Batterie : ".$batterie."</CENTER>";
?>
