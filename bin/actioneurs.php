<?php
include("/var/www/config/conf_zibase.php");
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
  $info = "";
  $info = $zibase->getSensorInfo($actionlist[$i]['c']);
  if($actionlist[$i]['t'] == 'transmitter') {
    $query = "INSERT INTO peripheriques (periph, nom, id, logo) VALUES ('capteur', '".$actionlist[$i]['n']."', '".$actionlist[$i]['c']."',  '".$actionlist[$i]['i']."')";
    mysql_query($query, $link);
    $alerte_batterie = "0000-00-00 00:00:00";
    if($info[3] == 1) {
      $query = "SELECT * FROM peripheriques WHERE alerte_batterie = '0000-00-00 00:00:00' AND  nom = '".$actionlist[$i]['n']."'";
      $res_query = mysql_query($query, $link);
      if(mysql_numrows($res_query) > 0){
        $today = getdate();
        $alerte_batterie = $today['year']."-".$today['mon']."-".$today['mday']." ".$today['hours'].":".$today['minutes'].":".$today['seconds'];
      }
    }
    $query = "UPDATE peripheriques SET periph = 'capteur', id = '".$actionlist[$i]['c']."',  logo = '".$actionlist[$i]['i']."', batterie = '".$info[3]."', alerte_batterie = '".$alerte_batterie."' WHERE nom = '".$actionlist[$i]['n']."'";
    mysql_query($query, $link);
  }
  if($actionlist[$i]['t'] == 'receiverXDom') {
    $query = "INSERT INTO peripheriques (periph, nom, id, logo) VALUES ('actioneur', '".$actionlist[$i]['n']."', '".$actionlist[$i]['c']."',  '".$actionlist[$i]['i']."')";
    mysql_query($query, $link);
    $alerte_batterie = "0000-00-00 00:00:00";
    if($info[3] == 1) {
      $query = "SELECT * FROM peripheriques WHERE alerte_batterie = '0000-00-00 00:00:00' AND  nom = '".$actionlist[$i]['n']."'";
      $res_query = mysql_query($query, $link);
      if(mysql_numrows($res_query) > 0){
        $today = getdate();
        $alerte_batterie = $today['year']."-".$today['mon']."-".$today['mday']." ".$today['hours'].":".$today['minutes'].":".$today['seconds'];
      }
    }
    $query = "UPDATE peripheriques SET periph = 'actioneur', id = '".$actionlist[$i]['c']."',  logo = '".$actionlist[$i]['i']."', batterie = '".$info[3]."', alerte_batterie = '".$alerte_batterie."' WHERE nom = '".$actionlist[$i]['n']."'";
    mysql_query($query, $link);
  }
  $i++;
}

?>
