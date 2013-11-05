<?
include("/var/www/pages/conf_zibase.php");
include("/var/www/lib/zibase.php");
$zibase = new ZiBase($ipzibase);
$link = mysql_connect($hote,$login,$plogin);
if (!$link) {
   die('Non connect&eacute; : ' . mysql_error());
}
$db_selected = mysql_select_db($base,$link);
if (!$db_selected) {
   die ('Impossible d\'utiliser la base : ' . mysql_error());
}
$query = "SELECT * FROM message_zibase WHERE date > DATE_SUB(NOW(), INTERVAL 5 MINUTE)";
$res_query = mysql_query($query, $link);
if(!(mysql_numrows($res_query) > 0)){
$zibase->registerListener($ipserver);
}
?>
