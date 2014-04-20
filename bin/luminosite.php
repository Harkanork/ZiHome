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
  if($sensorlist[$i]['type'] == 'light') {
    $info = "";
    $info = $zibase->getSensorInfo($sensorlist[$i]['id']);
    updateProbe($sensorlist[$i], $info, $link, 'luminosite');
    
    $query = "CREATE TABLE IF NOT EXISTS `luminosite_".$sensorlist[$i]['name']."` (`date` datetime NOT NULL, `lum` float NOT NULL, PRIMARY KEY (`date`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    mysql_query($query, $link);
    if(!($info == "")) {
      $query = "INSERT INTO `luminosite_".$sensorlist[$i]['name']."` (date, lum) VALUES ('".$info[0]->format("Y-m-d H:i:s")."',".($info[1]).")";
      mysql_query($query, $link);
    }
  }
  $i++;
}

?>
