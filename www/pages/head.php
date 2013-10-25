<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" href="./styles/style.php" type="text/css" media="all">
<link rel="apple-touch-icon-precomposed" href="img/icon-iphone.jpg" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="translucent">
<script type="text/javascript" src="./js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="./js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="./js/jquery-ui.min.js"></script>
<script src="./js/modules/exporting.js"></script>
<script type="text/javascript" src="./js/popup.js"></script>
<?
include("./pages/connexion.php");
$query = "SELECT * FROM paramettres WHERE libelle = 'icones'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
$icone = $data['value'];
}
?>
