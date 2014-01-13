<?
if(isset($_SESSION['auth']))
{
include("./pages/connexion.php");
$query = "SELECT * FROM video";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($periph = mysql_fetch_assoc($req))
{
$width = "400";
$height = "300";
include("./fonctions/video.php");
}
}
?>
