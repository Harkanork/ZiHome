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
  if($deg>=191.25 && $deg<213.75){ $result="SSO"; }
  if($deg>=213.75 && $deg<236.25){ $result="SO"; }
  if($deg>=236.25 && $deg<258.75){ $result="OSO"; }
  if($deg>=258.75 && $deg<281.25){ $result="O"; }
  if($deg>=281.25 && $deg<303.75){ $result="ONO"; }
  if($deg>=303.75 && $deg<326.25){ $result="NO"; }
  if($deg>=326.25 && $deg<348.75){ $result="NNO"; }
  return $result;
}

$zibase = new ZiBase($ipzibase);

$link = mysql_connect($hote,$login,$plogin);
if (!$link) {
   die('Non connect&eacute; : ' . mysql_error());
}
$db_selected = mysql_select_db($base,$link);
if (!$db_selected) {
   die ('Impossible d\'utiliser la base : ' . mysql_error());
}

$query0 = "SELECT * FROM peripheriques";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data0 = mysql_fetch_assoc($req0)) {
  if($data0['protocol'] == 6) {
    $protocol = true;
  } else {
    $protocol = false;
  }

  if($data0['periph'] == 'actioneur' || $data0['periph'] == 'capteur')
  {
    $value = $zibase->getState($data0['id'], $protocol);
    $query = "SELECT * FROM `periph_".$data0['nom']."` ORDER BY `date` DESC LIMIT 1";
    $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    $data = mysql_fetch_assoc($req);
    if(!($data['actif'] == $value)){
      $query0 = "INSERT INTO `periph_".$data0['nom']."` (date, actif) VALUES (now(), '".($value)."')";
      mysql_query($query0, $link);
    }
  }
  else if($data0['periph'] == 'conso')
  {
    $info = "";
    $info = $zibase->getSensorInfo($data0['id']);
    if(!($info == "")) {
      if(strlen($data0['id']) < 6) {
        $query = "INSERT INTO `conso_".$data0['nom']."` (date, conso, conso_total) VALUES ('".$info[0]->format("Y-m-d H:i:s")."',".($info[2]*10).",".($info[1]*100).")";
      } else {
        $query = "INSERT INTO `conso_".$data0['nom']."` (date, conso, conso_total) VALUES ('".$info[0]->format("Y-m-d H:i:s")."',".($info[2]*100).",".($info[1]*100).")";
      }
      mysql_query($query, $link);
    }
  }
  else if($data0['periph'] == 'temperature')
  {
    $info = "";
    $info = $zibase->getSensorInfo($data0['id']);
    if(!($info == "")) 
    {
      $query = "INSERT INTO `temperature_".$data0['nom']."` (date, temp, hygro) VALUES ('".$info[0]->format("Y-m-d H:i:s")."',".($info[1]/10).",".$info[2].")";
      mysql_query($query, $link);
    }
  }
  else if($data0['periph'] == 'vent')
  {
    $info = "";
    $info = $zibase->getSensorInfo($data0['id']);
    if(!($info == "")) 
    {
      $query = "INSERT INTO `vent_".$data0['nom']."` (date, vitesse, direction) VALUES ('".$info[0]->format("Y-m-d H:i:s")."',".$info[1].",'". ventPointCardinaux($info[2]*3)."')";
      mysql_query($query, $link);
    }
  }
  else if($data0['periph'] == 'luminosite')
  {
    $info = "";
    $info = $zibase->getSensorInfo($data0['id']);
    if(!($info == "")) 
    {
      $query = "INSERT INTO `luminosite_".$data0['nom']."` (date, lum) VALUES ('".$info[0]->format("Y-m-d H:i:s")."',".($info[1]).")";
      mysql_query($query, $link);
    }
  }
  else if($data0['periph'] == 'pluie')
  {
    $info = "";
    $info = $zibase->getSensorInfo($data0['id']);
    if(!($info == "")) 
    {
      $query = "INSERT INTO `pluie_".$data0['nom']."` (date, cumul, pluie) VALUES ('".$info[0]->format("Y-m-d H:i:s")."',".($info[1]).",".$info[2].")";
      mysql_query($query, $link);
    }
  }  
}
?>
