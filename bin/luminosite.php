<?php
include("conf_scripts.php");
include("utils.php");

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
  if($sensorlist[$i]['t'] == 'light') {
    $info = "";
    $info = $zibase->getSensorInfo($sensorlist[$i]['c']);
    updateSensor($sensorlist[$i], $info, $link, 'luminosite');
    
    $query = "CREATE TABLE IF NOT EXISTS `luminosite_".$sensorlist[$i]['n']."` (`date` datetime NOT NULL, `lum` float NOT NULL, PRIMARY KEY (`date`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    mysql_query($query, $link);
    if(!($info == "")) {
      $query = "INSERT INTO `luminosite_".$sensorlist[$i]['n']."` (date, lum) VALUES ('".$info[0]->format("Y-m-d H:i:s")."',".($info[1]).")";
      mysql_query($query, $link);
    }
  }
  $i++;
}

?>
