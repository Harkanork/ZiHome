<?
/*------------Configuration----------------------*/
include("/var/www/config/conf_zibase.php");
include("/var/www/lib/zibase.php");

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

$header[] = 'Content-Type: application/json';

while (true) {
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
$query = "SELECT * FROM  `paramettres` WHERE libelle = 'android_sleep_base'";
$res_query = mysql_query($query, $link);
if(mysql_numrows($res_query) > 0){
$sleepbase = mysql_result($res_query,0,"value");
}
$query = "SELECT * FROM  `paramettres` WHERE libelle = 'android_sleep_coef'";
$res_query = mysql_query($query, $link);
if(mysql_numrows($res_query) > 0){
$sleepcoef = mysql_result($res_query,0,"value");
}

$zibase = new ZiBase($ipzibase);
$i = 0;
$dist = null;
$dist = array();
$query = "SELECT * FROM android";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
$apikey =  $data['apikey'];

$file = '{
"homeMobileCountryCode": 208,
"homeMobileNetworkCode": '.$data['MobileNetworkCode'].',
"radioType": "gsm",
"carrier": "'.$data['carrier'].'",
"cellTowers": [
{
"cellId": '.$data['cellId'].',
"locationAreaCode": '.$data['locationAreaCode'].',
"mobileCountryCode": 208,
"mobileNetworkCode": '.$data['MobileNetworkCode'].'
}
]
}';

// Créion d'une nouvelle ressource cURL
$ch = curl_init();

// Configuration de l'URL et d'autres options
curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/geolocation/v1/geolocate?key='.$apikey);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($ch, CURLOPT_AUTOREFERER, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $file);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// Répétion de l'URL et affichage sur le naviguateur
$value = curl_exec($ch);

// Fermeture de la session cURL
curl_close($ch);

$json = json_decode($value);
$valuearray = (array)$json;
$location = (array)$valuearray['location'];
$longitude = $location['lng'];
$latitude = $location['lat'];
echo "latitude : ".$latitude."\n";
echo "longitude : ".$longitude."\n";
$query0 = "SELECT * FROM android_distances WHERE id_android = '".$data['id']."'";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data0 = mysql_fetch_assoc($req0))
{
$distancem = intval(round(get_distance_m($data0['latitude'], $data0['longitude'], $latitude, $longitude), 0));
$distancekm = intval(round(get_distance_m($data0['latitude'], $data0['longitude'], $latitude, $longitude)/1000, 0));
$zibase->sendVirtualProbeValues($data0['sonde'], $distancem, $distancekm, 0, ZbVirtualProbe::OREGON);
$dist[$i] = $distancem;
$i++;
}
$sleep = intval((min($dist)/$sleepcoef)+$sleepbase);
$today = getdate();
$now = $today['year']."-".$today['mon']."-".$today['mday']." ".$today['hours'].":".$today['minutes'].":".$today['seconds'];
//echo $now." - distance : ".min($dist)."m - sleep : ".(intval($sleep/60))."min ".($sleep-(intval($sleep/60)*60))."sec\n";
sleep($sleep);
mysql_close();
}
}
?>
