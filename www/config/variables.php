<?
$link = mysql_connect($hote,$login,$plogin);
if (!$link) {
   die('Non connect&eacute; : ' . mysql_error());
}
$db_selected = mysql_select_db($base,$link);
if (!$db_selected) {
   die ('Impossible d\'utiliser la base : ' . mysql_error());
}
$query = "SELECT * FROM paramettres WHERE libelle = 'meteo ville' OR libelle = 'meteo sonde temperature' OR libelle = 'meteo sonde vent' OR libelle = 'pollution ville' OR libelle = 'idzibase' OR libelle = 'tokenzibase' OR libelle = 'ipzibase' OR libelle = 'ipserver'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
if($data['libelle'] == 'meteo ville') { $meteo_ville = $data['value']; }
if($data['libelle'] == 'meteo sonde temperature') { $meteo_sonde_temperature = $data['value']; }
if($data['libelle'] == 'meteo sonde vent') { $meteo_sonde_vent = $data['value']; }
if($data['libelle'] == 'pollution ville') { $pollution_ville = $data['value']; }
if($data['libelle'] == 'idzibase') { $idzibase = $data['value']; }
if($data['libelle'] == 'tokenzibase') { $tokenzibase = $data['value']; }
if($data['libelle'] == 'ipzibase') { $ipzibase = $data['value']; }
if($data['libelle'] == 'ipserver') { $ipserver = $data['value']; }
}
?>
