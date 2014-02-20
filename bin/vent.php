<?php
include("conf_scripts.php");
include("utils.php");

function ventPointCardinaux($deg) {
  if($deg<11.25 || $deg>348.75){ $result="N"; }
  if($deg>=11.25 && $deg<33.75){ $result="NNE"; }
  if($deg>=33.75 && $deg<56.25){ $result="NE"; }
  if($deg>=56.25 && $deg<78.75){ $result="ENE"; }
  if($deg>=78.75 && $deg<101.25){ $result="E"; }
  if($deg>=101.25 && $deg<123.75){ $result="ESE"; }
  if($deg>=123.75 && $deg<146.25){ $result="SE"; }
  if($deg>=146.25 && $deg<168.75){ $result="SSE"; }
  if($deg>=168.75 && $deg<191.25){ $result="S"; }
  if($deg>=191.25 && $deg<213.75){ $result="SSW"; }
  if($deg>=213.75 && $deg<236.25){ $result="SW"; }
  if($deg>=236.25 && $deg<258.75){ $result="WSW"; }
  if($deg>=258.75 && $deg<281.25){ $result="W"; }
  if($deg>=281.25 && $deg<303.75){ $result="WNW"; }
  if($deg>=303.75 && $deg<326.25){ $result="NW"; }
  if($deg>=326.25 && $deg<348.75){ $result="NNW"; }
  return $result;
}

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
  if($sensorlist[$i]['t'] == 'wind') {
    $info = "";
    $info = $zibase->getSensorInfo($sensorlist[$i]['c']);
    updateSensor($sensorlist[$i], $info, $link, 'vent');
    
    $query = "CREATE TABLE IF NOT EXISTS `vent_".$sensorlist[$i]['n']."` (`date` datetime NOT NULL, `direction` varchar(255) NOT NULL, `vitesse` float NOT NULL, PRIMARY KEY (`date`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    mysql_query($query, $link);
    if(!($info == "")) {
      $query = "INSERT INTO `vent_".$sensorlist[$i]['n']."` (date, vitesse, direction) VALUES ('".$info[0]->format("Y-m-d H:i:s")."',".$info[1].",'". ventPointCardinaux($info[2])."')";
      mysql_query($query, $link);
    }
  }
  $i++;
}

?>
