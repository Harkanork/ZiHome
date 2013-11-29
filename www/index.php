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
include("./pages/plan.php");
}
}
?>
