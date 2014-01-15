<?php
require_once("/var/www/lib/zibase.php");
include("/var/www/config/conf_zibase.php");
$zibase = new ZiBase($ipzibase);

//Au prealable rechercher sa ville sur weather.com et relever la valeur dans l'adresse qui ressemmble a FRXX1879:1:FR
//Declarer une sonde Virtuelle THx128 avec un identifiant OSxxxxxxx
//Declarer une sonde Virtuelle WGR800 avec un identifiant OSxxxxxxx


//Url a parser
$weather = simplexml_load_file("http://wxdata.weather.com/wxdata/weather/local/".$meteo_ville."?cc=*&unit=m"); 

// Temperature exterieure et humidité$zibase->sendVirtualProbeValues($meteo_sonde_temperature,$weather->cc->tmp*10,$weather->cc->hmid,0); 
//123456788 : identifiant radio de la sonde sans OS devant, tmp*10 : il faut multiplier la tempéture par 10 car la zibase attend l.information au dixiè de degré// Vent 
$zibase->sendVirtualProbeValues($meteo_sonde_vent,$weather->cc->wind->s*0.51,$weather->cc->wind->d,0);
//Coefficient de conversion = 0.28 (la vitesse est exprimésur weather.com en m/s et sur zibase en km/h)
?>
