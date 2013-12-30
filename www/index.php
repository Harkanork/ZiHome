<?
session_start();
include("./pages/head.php");
include("./pages/menu.php");
if(isset($_GET['page'])){
include("./pages/".$_GET['page'].".php");
} else {
if(isset($_GET['include'])){
include("./pages/connexion.php");
$query = "SELECT * FROM `insertion` WHERE `id` = '".$_GET['include']."'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$data = mysql_fetch_assoc($req);
include($data['url']);
} else {
if(isset($_SESSION['auth'])) {
include("./pages/connexion.php");
$query = "SELECT * FROM users WHERE pseudo = '".$_SESSION['auth']."'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
$accueil = $data['accueil'];
}
}
if(!(isset($accueil)) || (isset($accueil) && $accueil == "")) {
include("./pages/connexion.php");
$query = "SELECT * FROM paramettres WHERE libelle = 'accueil'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
$accueil = $data['value'];
}
if(!(isset($accueil))) {
$accueil = 'plan';
}
}
include("./pages/".$accueil.".php");
}
}
?>
