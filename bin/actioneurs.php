<?php
include("conf_scripts.php");
include("utils.php");

$zibase = new ZiBase($ipzibase);

$link = mysql_connect($hote,$login,$plogin);
if (!$link) {
   die('Non connect&eacute; : ' . mysql_error());
}
$db_selected = mysql_select_db($base,$link);
if (!$db_selected) {
   die ('Impossible d\'utiliser la base : ' . mysql_error());
}

$actionlist=$zibase->getActuatorList($idzibase,$tokenzibase);
$actionnb = count($actionlist);
$i = 0;
while($i < $actionnb) {
  $info = "";
  $info = $zibase->getSensorInfo($actionlist[$i]['id']);
  updateProbe($actionlist[$i], $info, $link, 'capteur');
  $i++;
}

$actionlist=$zibase->getSensorList($idzibase,$tokenzibase);
$actionnb = count($actionlist);
$i = 0;
while($i < $actionnb) {
  $info = "";
  $info = $zibase->getSensorInfo($actionlist[$i]['id']);
  updateProbe($actionlist[$i], $info, $link, 'actioneur');
  $i++;
}

    $query0 = "SELECT * FROM peripheriques WHERE periph = 'actioneur' OR periph = 'capteur'";
    $req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while($data0 = mysql_fetch_assoc($req0)) {
      if($data0['protocol'] == 6) {
        $protocol = true;
      } else {
        $protocol = false;
      }
        $value = $zibase->getState($data0['id'], $protocol);
        $query = "CREATE TABLE IF NOT EXISTS `periph_".$data0['nom']."` (`date` datetime NOT NULL, `actif` TINYINT(1) NOT NULL, PRIMARY KEY (`date`)) ENGINE=InnoDB DEFAULT CHARSET=latin1";
        mysql_query($query, $link);
        $query = "SELECT * FROM `periph_".$data0['nom']."` ORDER BY `date` DESC LIMIT 1";
        $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        $data = mysql_fetch_assoc($req);
        if(!($data['actif'] == $value)){
          $query0 = "INSERT INTO `periph_".$data0['nom']."` (date, actif) VALUES (now(), '".($value)."')";
          mysql_query($query0, $link);
        }
    }
?>
