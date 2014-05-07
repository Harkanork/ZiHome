<?php
include("conf_scripts.php");
include("utils.php");

$zibase = new ZiBase($ipzibase);
$sensorlist=$zibase->getProbeList($idzibase,$tokenzibase);
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
  if($sensorlist[$i]['type'] == 'rain') {
    $info = "";
    $info = $zibase->getSensorInfo($sensorlist[$i]['id']);
    updateProbe($sensorlist[$i], $info, $link, 'pluie');
    $query = "CREATE TABLE IF NOT EXISTS `pluie_".$sensorlist[$i]['name']."` (`date` datetime NOT NULL, `direction` varchar(255) NOT NULL, `vitesse` float NOT NULL, PRIMARY KEY(`date`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    mysql_query($query, $link);
  }
  if($sensorlist[$i]['type'] == 'light') {
    $info = "";
    $info = $zibase->getSensorInfo($sensorlist[$i]['id']);
    updateProbe($sensorlist[$i], $info, $link, 'luminosite');
	$query = "CREATE TABLE IF NOT EXISTS `luminosite_".$sensorlist[$i]['name']."` (`date` datetime NOT NULL, `lum` float NOT NULL, PRIMARY KEY (`date`)) ENGINE=InnoDB DEFAULT C
HARSET=latin1;";
    mysql_query($query, $link);
  }
  if($sensorlist[$i]['type'] == 'wind') {
    $info = "";
    $info = $zibase->getSensorInfo($sensorlist[$i]['id']);
    updateProbe($sensorlist[$i], $info, $link, 'vent');
    $query = "CREATE TABLE IF NOT EXISTS `vent_".$sensorlist[$i]['name']."` (`date` datetime NOT NULL, `direction` varchar(255) NOT NULL, `vitesse` float NOT NULL, PRIMARY KEY(`date`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    mysql_query($query, $link);
  }
  if($sensorlist[$i]['type'] == 'temperature') {
    $info = "";
    $info = $zibase->getSensorInfo($sensorlist[$i]['id']);
    updateProbe($sensorlist[$i], $info, $link, 'temperature');
    $query = "CREATE TABLE IF NOT EXISTS `temperature_".$sensorlist[$i]['name']."` (`date` datetime NOT NULL, `temp` float NOT NULL, `hygro` float NOT NULL, PRIMARY KEY (`date`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    mysql_query($query, $link);
  }
  if($sensorlist[$i]['type'] == 'power') {
    $info = "";
    $info = $zibase->getSensorInfo($sensorlist[$i]['id']);
    updateProbe($sensorlist[$i], $info, $link, 'conso');
    $query = "CREATE TABLE IF NOT EXISTS `conso_".$sensorlist[$i]['name']."` (`date` datetime NOT NULL, `conso` float NOT NULL, `conso_total` float NOT NULL, PRIMARY KEY (`date`))ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    mysql_query($query, $link);
  }

  $i++;
}

$actionlist=$zibase->getActuatorList($idzibase,$tokenzibase);
$actionnb = count($actionlist);
$i = 0;
while($i < $actionnb) {
  $info = "";
  $info = $zibase->getSensorInfo($actionlist[$i]['id']);
  updateProbe($actionlist[$i], $info, $link, 'capteur');
  $query = "CREATE TABLE IF NOT EXISTS `periph_".$actionlist[$i]['name']."` (`date` datetime NOT NULL, `actif` TINYINT(1) NOT NULL, PRIMARY KEY (`date`)) ENGINE=InnoDB DEFAULT CHARSET=latin1";
  mysql_query($query, $link);
  $i++;
}

$actionlist=$zibase->getSensorList($idzibase,$tokenzibase);
$actionnb = count($actionlist);
$i = 0;
while($i < $actionnb) {
  $info = "";
  $info = $zibase->getSensorInfo($actionlist[$i]['id']);
  updateProbe($actionlist[$i], $info, $link, 'actioneur');
  $query = "CREATE TABLE IF NOT EXISTS `periph_".$actionlist[$i]['name']."` (`date` datetime NOT NULL, `actif` TINYINT(1) NOT NULL, PRIMARY KEY (`date`)) ENGINE=InnoDB DEFAULT CHARSET=latin1";
  mysql_query($query, $link);
  $i++;
}
?>
