<?php
/*------------Configuration----------------------*/
include("conf_scripts.php");

/*-------------ne rien changer apres ici---------*/

function get_distance_m($lat1, $lng1, $lat2, $lng2) {
  $earth_radius = 6378137;   // Terre = sphere de 6378km de rayon
  $rlo1 = deg2rad($lng1);
  $rla1 = deg2rad($lat1);
  $rlo2 = deg2rad($lng2);
  $rla2 = deg2rad($lat2);
  $dlo = ($rlo2 - $rlo1) / 2;
  $dla = ($rla2 - $rla1) / 2;
  $a = (sin($dla) * sin($dla)) + cos($rla1) * cos($rla2) * (sin($dlo) * sin($dlo
));
  $d = 2 * atan2(sqrt($a), sqrt(1 - $a));
  return ($earth_radius * $d);
}

$header[] = 'Content-Type: application/json; charset=utf-8';
$header[] = 'X-Apple-Find-Api-Ver: 2.0';
$header[] = 'X-Apple-Authscheme: UserIdGuest';
$header[] = 'X-Apple-Realm-Support: 1.0';
$header[] = 'User-agent: Find iPhone/1.3 MeKit (iPad: iPhone OS/4.2.1)';
$header[] = 'X-Client-Name: iPad';
$header[] = 'X-Client-UUID: 0cf3dc501ff812adb0b202baed4f37274b210853';
$header[] = 'Accept-Language: en-us';
$header[] = 'Connection: keep-alive';

$link = mysql_connect($hote,$login,$plogin);
if (!$link) {
   die('Non connect&eacute; : ' . mysql_error());
}
$db_selected = mysql_select_db($base,$link);
if (!$db_selected) {
   die ('Impossible d\'utiliser la base : ' . mysql_error());
}
$sleepbase = 0;
$sleepcoef = 1;
$query = "SELECT * FROM  `paramettres` WHERE libelle = 'iphone_sleep_base'";
$res_query = mysql_query($query, $link);
if(mysql_numrows($res_query) > 0){
$sleepbase = mysql_result($res_query,0,"value");
}
$query = "SELECT * FROM  `paramettres` WHERE libelle = 'iphone_sleep_coef'";
$res_query = mysql_query($query, $link);
if(mysql_numrows($res_query) > 0){
$sleepcoef = mysql_result($res_query,0,"value");
}

$zibase = new ZiBase($ipzibase);
$i = 0;
$dist = null;
$dist = array();
$query = "SELECT * FROM iphone";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
$periphname = $data['periph_name'];
$user = $data['user'];
$pass = $data['pass'];

// Créion d'une nouvelle ressource cURL
$ch = curl_init();

// Configuration de l'URL et d'autres options
curl_setopt($ch, CURLOPT_URL, 'https://fmipmobile.icloud.com/fmipservice/device/'.$user.'/initClient');
curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_HEADER, TRUE);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($ch, CURLOPT_USERAGENT, 'Find iPhone/1.3 MeKit (iPad: iPhone OS/4.2.1)');
curl_setopt($ch, CURLOPT_AUTOREFERER, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// Répétion de l'URL et affichage sur le naviguateur
$value = curl_exec($ch);

// Fermeture de la session cURL
curl_close($ch);

echo $value;
$lines = explode("\n",$value);
foreach($lines as $line) {
if(substr($line,0,17) == "X-Apple-MMe-Host:") {
$server = substr($line,18,-1);
}
if(substr($line,0,11) == "Set-Cookie:") {
$cookie  = substr($line, 12, -1);
}
}

// Créion d'une nouvelle ressource cURL
$ch = curl_init();

// Configuration de l'URL et d'autres options
curl_setopt($ch, CURLOPT_URL, "https://".$server."/fmipservice/device/".$user."/initClient");
curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($ch, CURLOPT_USERAGENT, 'Find iPhone/1.3 MeKit (iPad: iPhone OS/4.2.1)');
curl_setopt($ch, CURLOPT_AUTOREFERER, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIE, $cookie);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// Répétion de l'URL et affichage sur le naviguateur
$value = curl_exec($ch);

// Fermeture de la session cURL
curl_close($ch);

$json = json_decode($value);
$valuearray = (array)$json;
foreach($valuearray['content'] as $periph) {
$periphvalue = (array)$periph;
if($periphvalue['name'] == $periphname) {
$location = (array)$periphvalue['location'];
$longitude = $location['longitude'];
$latitude = $location['latitude'];
$query0 = "SELECT * FROM iphone_distances WHERE id_iphone = '".$data['id']."'";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data0 = mysql_fetch_assoc($req0))
{
$distancem = intval(round(get_distance_m($data0['latitude'], $data0['longitude'], $latitude, $longitude), 0));
$distancekm = intval(round(get_distance_m($data0['latitude'], $data0['longitude'], $latitude, $longitude)/1000, 0));
$zibase->sendVirtualProbeValues($data0['sonde'], $distancem, $distancekm, 0, ZbVirtualProbe::OREGON);
$dist[$i] = $distancem;
$i++;
}
}
}
}
$sleep = intval((min($dist)/$sleepcoef)+$sleepbase);
$today = getdate();
$now = $today['year']."-".$today['mon']."-".$today['mday']." ".$today['hours'].":".$today['minutes'].":".$today['seconds'];
echo $now." - distance : ".min($dist)."m - sleep : ".(intval($sleep/60))."min ".($sleep-(intval($sleep/60)*60))."sec\n";
mysql_close();
sleep($sleep);
exit();
?>
