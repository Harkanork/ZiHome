<?php
include("conf_scripts.php");
include("utils.php");

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
  $info = "";
  $info = $zibase->getSensorInfo($actionlist[$i]['c']);
  if($actionlist[$i]['t'] == 'transmitter') {
    updateSensor($actionlist[$i], $info, $link, 'capteur');
  }
  else if($actionlist[$i]['t'] == 'receiverXDom') {
    updateSensor($actionlist[$i], $info, $link, 'actioneur');
  }
  $i++;
}

?>
