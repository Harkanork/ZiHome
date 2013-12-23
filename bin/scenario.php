<?php
include("/var/www/config/conf_zibase.php");
include("/var/www/lib/zibase.php");
$zibase = new ZiBase($ipzibase);
$actionlist=$zibase->getScenarioList($idzibase,$tokenzibase);

$actionnb = count($actionlist);

$link = mysql_connect($hote,$login,$plogin);
if (!$link) {
   die('Non connect&eacute; : ' . mysql_error());
}
$db_selected = mysql_select_db($base,$link);
if (!$db_selected) {
   die ('Impossible d\'utiliser la base : ' . mysql_error());
}

$i = 0;
while($i < $actionnb) {
$query = "INSERT INTO scenarios (nom, id, logo) VALUES ('".$actionlist[$i]['n']."', '".$actionlist[$i]['id']."',  '".$actionlist[$i]['icon']."')";
mysql_query($query, $link);
$i++;
}

?>
