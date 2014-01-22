<?
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin') {
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
function get_iPhone_location($periphname, $user, $pass) {
$ch = curl_init();
$header[] = 'Content-Type: application/json; charset=utf-8';
$header[] = 'X-Apple-Find-Api-Ver: 2.0';
$header[] = 'X-Apple-Authscheme: UserIdGuest';
$header[] = 'X-Apple-Realm-Support: 1.0';
$header[] = 'User-agent: Find iPhone/1.3 MeKit (iPad: iPhone OS/4.2.1)';
$header[] = 'X-Client-Name: iPad';
$header[] = 'X-Client-UUID: 0cf3dc501ff812adb0b202baed4f37274b210853';
$header[] = 'Accept-Language: en-us';
$header[] = 'Connection: keep-alive';
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
$value = curl_exec($ch);
curl_close($ch);
$lines = explode("\n",$value);
foreach($lines as $line) {
if(substr($line,0,17) == "X-Apple-MMe-Host:") {
$server = substr($line,18,-1);
}
}
$ch = curl_init();
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
$value = curl_exec($ch);
curl_close($ch);
$json = json_decode($value);
$valuearray = (array)$json;
foreach($valuearray['content'] as $periph) {
$periphvalue = (array)$periph;
if($periphvalue['name'] == $periphname) {
$location = (array)$periphvalue['location'];
return $location;
}
}
}
if(isset($_POST['site'])) {
if(isset($_POST['site_valider'])) {
include("./pages/connexion.php");
if($_POST['pos_actuelle'] == "1"){
$query0 = "SELECT * FROM iphone WHERE id = '".$_POST['id_iphone']."'";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req0))
{
$location = get_iPhone_location($data['periph_name'], $data['user'], $data['pass']);
}
$query = "INSERT INTO `iphone_distances` (id_iphone, sonde, latitude, longitude) VALUES ('".$_POST['id_iphone']."', '".$_POST['sonde']."', '".$location['latitude']."', '".$location['longitude']."')";
} else {
$query = "INSERT INTO `iphone_distances` (id_iphone, sonde, latitude, longitude) VALUES ('".$_POST['id_iphone']."', '".$_POST['sonde']."', '".$_POST['latitude']."', '".$_POST['longitude']."')";
}
mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
mysql_close();
}
if(isset($_POST['site_modifier'])) {
include("./pages/connexion.php");
if($_POST['pos_actuelle'] == "1"){
$query0 = "SELECT * FROM iphone WHERE id = '".$_POST['id_iphone']."'";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req0))
{
$location = get_iPhone_location($data['periph_name'], $data['user'], $data['pass']);
}
$query = "UPDATE iphone_distances SET sonde = '".$_POST['sonde']."', `latitude` = '".$location['latitude']."', `longitude` = '".$location['longitude']."' WHERE id = '".$_POST['id']."'";
//echo $query;
} else {
$query = "UPDATE iphone_distances SET sonde = '".$_POST['sonde']."', `latitude` = '".$_POST['latitude']."', `longitude` = '".$_POST['longitude']."' WHERE id = '".$_POST['id']."'";
}
mysql_query($query, $link);
}
if(isset($_POST['site_supprimer'])) {
include("./pages/connexion.php");
$query = "DELETE FROM iphone_distances WHERE id = '".$_POST['id']."'";
mysql_query($query, $link);
}
echo "<P><CENTER><TABLE><TR><TD>Sonde</TD><TD>Latitude</TD><TD>Longitude</TD><TD>Position Actuelle</TD><TD>Supprimer</TD><TD>Modifier</TD></TR>";
include("./pages/connexion.php");
$query = "SELECT * FROM iphone_distances WHERE id_iphone = '".$_POST['id_iphone']."'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
echo "<TR><FORM method=POST action=\"./index.php?page=administration&detail=iphone\"><TD><input type=text name=sonde value=\"".$data['sonde']."\"></input></TD><TD><input type=text name=latitude value=\"".$data['latitude']."\"></input></TD><TD><input type=texte name=longitude value=\"".$data['longitude']."\"></input></TD><TD><input type=checkbox name=pos_actuelle value=1></input></TD><TD><input type=hidden name=id value=".$data['id']."></input><input type=hidden name=site value=".$_POST['site']."></input><input type=hidden name=id_iphone value=".$_POST['id_iphone']."></input><input type=submit name=site_supprimer value=Supprimer></input></TD><TD><input type=submit name=site_modifier value=Modifier></input></TD></FORM></TR>";
}
echo "</TABLE></CENTER></P>";
?>
<FORM method=POST action="./index.php?page=administration&detail=iphone">
Sonde : <input type=text name=sonde></input>
Latitude : <input type=text name=latitude></input>
Longitude : <input type=text name=longitude></input>
Position actuelle : <input type="checkbox" name="pos_actuelle" value="1"></input>
<input type=hidden name=site value=<? echo $_POST['site']; ?>>
<input type=hidden name=id_iphone value=<? echo $_POST['id_iphone']; ?>>
<input type=submit name=site_valider value=Valider></input>
</FORM>
<?
} else {
if(isset($_POST['valider'])) {
include("./pages/connexion.php");
$query = "INSERT INTO `iphone` (periph_name, user, pass, sleep_base, sleep_coef) VALUES ('".$_POST['periph_name']."', '".$_POST['user']."', '".$_POST['pass']."', '".$_POST['sleep_base']."', '".$_POST['sleep_coef']."')";
mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
mysql_close();
}
if(isset($_POST['modifier'])) {
include("./pages/connexion.php");
$query = "UPDATE iphone SET periph_name = '".$_POST['periph_name']."', `user` = '".$_POST['user']."', `pass` = '".$_POST['pass']."', `sleep_base` = '".$_POST['sleep_base']."', `sleep_coef` = '".$_POST['sleep_coef']."' WHERE id = '".$_POST['id']."'";
mysql_query($query, $link);
}
if(isset($_POST['supprimer'])) {
include("./pages/connexion.php");
$query = "DELETE FROM iphone WHERE id = '".$_POST['id']."'";
mysql_query($query, $link);
}
echo "<P><CENTER><TABLE><TR><TD>Nom de peripherique</TD><TD>user</TD><TD>Mot de passe</TD><TD>Sleep Base</TD><TD>Sleep Coef</TD><TD>Supprimer</TD><TD>Modifier</TD><TD>Choisir Coordonnees</TD></TR>";
include("./pages/connexion.php");
$query = "SELECT * FROM iphone";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
echo "<TR><FORM method=POST action=\"./index.php?page=administration&detail=iphone\"><TD><input type=text name=periph_name value=\"".$data['periph_name']."\"></input></TD><TD><input type=text name=user value=\"".$data['user']."\"></input></TD><TD><input type=password name=pass value=\"".$data['pass']."\"></input></TD><TD><input type=text name=sleep_base value=\"".$data['sleep_base']."\"></input></TD><TD><input type=text name=sleep_coef value=\"".$data['sleep_coef']."\"></input></TD><TD><input type=hidden name=id value=".$data['id']."></input><input type=hidden name=id_iphone value=".$data['id']."></input><input type=submit name=supprimer value=Supprimer></input></TD><TD><input type=submit name=modifier value=Modifier></input></TD><TD><input type=submit name=site value=Coordonnees></input></TD></FORM></TR>";
}
echo "</TABLE></CENTER></P>";
?>
<FORM method=POST action="./index.php?page=administration&detail=iphone">
Nom de Peripherique : <input type=text name=periph_name></input>
<BR>User Icloud : <input type=text name=user></input>
<BR>Mot de passe Icloud : <input type=password name=pass></input>
<BR>Sleep Base : <input type=text name=sleep_base></input>
<BR>Sleep Coef : <input type=text name=sleep_coef></input>
<BR><input type=submit name=valider value=Valider></input>
</FORM>
<?
}
}
?>
