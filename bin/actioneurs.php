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
  if($actionlist[$i]['t'] == 'receiverXDom' || $actionlist[$i]['t'] == 'transmitter') {
    $query = "SELECT * FROM peripheriques WHERE nom = '".$actionlist[$i]['n']."'";
    $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while($data = mysql_fetch_assoc($req)) {
      if($data['protocol'] == 6) {
        $protocol = true;
      } else {
        $protocol = false;
      }
        $value = $zibase->getState($data['id'], $protocol);
      }
    $query = "CREATE TABLE IF NOT EXISTS `periph_".$actionlist[$i]['n']."` (`date` datetime NOT NULL, `actif` TINYINT(1) NOT NULL, PRIMARY KEY (`date`)) ENGINE=InnoDB DEFAULT CHARSET=latin1";
    mysql_query($query, $link);
    $query = "SELECT * FROM `periph_".$actionlist[$i]['n']."` ORDER BY `date` DESC LIMIT 1";
    $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    $data = mysql_fetch_assoc($req);
      if(!($data['actif'] == $value)){
        $query0 = "INSERT INTO `periph_".$actionlist[$i]['n']."` (date, actif) VALUES (now(), '".($value)."')";
        mysql_query($query0, $link);
      }
  }
  $i++;
}

?>
