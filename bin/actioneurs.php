<?php
include("/var/www/pages/conf_zibase.php");
include("/var/www/lib/zibase.php");
$zibase = new ZiBase($ipzibase);
$actionlist=$zibase->getSensorList($idzibase,$tokenzibase);

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
if($actionlist[$i]['t'] == 'transmitter') {
$query = "INSERT INTO peripheriques (periph, nom, id, logo) VALUES ('capteur', '".$actionlist[$i]['n']."', '".$actionlist[$i]['c']."',  '".$actionlist[$i]['i']."')";
mysql_query($query, $link);
}
if($actionlist[$i]['t'] == 'receiverXDom') {
$query = "INSERT INTO peripheriques (periph, nom, id, logo) VALUES ('actioneur', '".$actionlist[$i]['n']."', '".$actionlist[$i]['c']."',  '".$actionlist[$i]['i']."')";
mysql_query($query, $link);
}
$i++;
}

?>
