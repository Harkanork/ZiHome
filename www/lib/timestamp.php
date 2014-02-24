<?

function convertire_seconde($duree) {								
$jour=intval($duree / 86400);
$heures=intval(($duree - ($jour * 86400)) / 3600);
$minutes=intval(($duree - (($jour * 86400) + ($heures * 3600))) / 60);
$secondes=intval($duree - (($jour * 86400) + ($heures * 3600) + ($minutes * 60)));
return $jour." jour, ".$heures.":".$minutes.":".$secondes;
}

?>
