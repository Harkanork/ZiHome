<?php
include("/var/www/pages/conf_zibase.php");
include("/var/www/lib/zibase.php");
$zibase = new ZiBase($ipzibase);
$sensorlist=$zibase->getSensorList($idzibase,$tokenzibase);

$sensornb = count($sensorlist);
$link = mysql_connect($hote,$login,$plogin);
if (!$link) {
   die('Non connect&eacute; : ' . mysql_error());
}
$db_selected = mysql_select_db($base,$link);
if (!$db_selected) {
   die ('Impossible d\'utiliser la base : ' . mysql_error());
}

$i = 0;
while($i < $sensornb) {
if($sensorlist[$i]['t'] == 'power') {
$info = "";
$info = $zibase->getSensorInfo($sensorlist[$i]['c']);
$query = "INSERT INTO conso_electrique (nom, id, logo, batterie) VALUES ('".$sensorlist[$i]['n']."', '".$sensorlist[$i]['c']."',  '".$sensorlist[$i]['i']."', '".$info[3]."')";
mysql_query($query, $link);
$query = "UPDATE conso_electrique SET id = '".$sensorlist[$i]['c']."',  logo = '".$sensorlist[$i]['i']."', batterie = '".$info[3]."' WHERE nom = '".$sensorlist[$i]['n']."'";
mysql_query($query, $link);
$query = "CREATE TABLE IF NOT EXISTS `".$sensorlist[$i]['n']."` (`date` datetime NOT NULL, `conso` float NOT NULL, `conso_total` float NOT NULL, PRIMARY KEY (`date`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
mysql_query($query, $link);
if(!($info == "")) {
$query = "INSERT INTO `".$sensorlist[$i]['n']."` (date, conso, conso_total) VALUES ('".$info[0]->format("Y-m-d H:i:s")."',".($info[2]*10).",".($info[1]*100).")";
mysql_query($query, $link);
}
}
$i++;
}

?>
