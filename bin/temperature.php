<?php
include("/var/www/config/conf_zibase.php");
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
if($sensorlist[$i]['t'] == 'temperature') {
$info = "";
$info = $zibase->getSensorInfo($sensorlist[$i]['c']);
$query = "INSERT INTO peripheriques (periph, nom, id, logo, batterie) VALUES ('temperature', '".$sensorlist[$i]['n']."', '".$sensorlist[$i]['c']."',  '".$sensorlist[$i]['i']."', '".$info[3]."')";
mysql_query($query, $link);
$alerte_batterie = "0000-00-00 00:00:00";
if($info[3] == 1) {
$query = "SELECT * FROM peripheriques WHERE alerte_batterie = '0000-00-00 00:00:00' AND  nom = '".$sensorlist[$i]['n']."'";
$res_query = mysql_query($query, $link);
if(mysql_numrows($res_query) > 0){
$today = getdate();
$alerte_batterie = $today['year']."-".$today['mon']."-".$today['mday']." ".$today['hours'].":".$today['minutes'].":".$today['seconds'];
}
}
$query = "UPDATE peripheriques SET periph = 'temperature', id = '".$sensorlist[$i]['c']."',  logo = '".$sensorlist[$i]['i']."', batterie = '".$info[3]."', alerte_batterie = '".$alerte_batterie."' WHERE nom = '".$sensorlist[$i]['n']."'";
mysql_query($query, $link);
$query = "CREATE TABLE IF NOT EXISTS `temperature_".$sensorlist[$i]['n']."` (`date` datetime NOT NULL, `temp` float NOT NULL, `hygro` float NOT NULL, PRIMARY KEY (`date`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
mysql_query($query, $link);
if(!($info == "")) {
$query = "INSERT INTO `temperature_".$sensorlist[$i]['n']."` (date, temp, hygro) VALUES ('".$info[0]->format("Y-m-d H:i:s")."',".($info[1]/10).",".$info[2].")";
mysql_query($query, $link);
}
}
$i++;
}

?>
