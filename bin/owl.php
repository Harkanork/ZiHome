<?php
/*--------------------Paramettres Cout Electrique-----------------------*/

$coutfixe                   = '1.7368';
$coutHC                     = '0.1002';
$coutHP                     = '0.1467';
$heuresCreuses[0]['debut'] 	= '01:30:00';
$heuresCreuses[0]['fin'] 	= '08:00:00';
$heuresCreuses[1]['debut'] 	= '12:30:00';
$heuresCreuses[1]['fin'] 	= '14:00:00';

/*--------------------fin des Paramettres Cout Electrique---------------*/

/*--------------------Paramettres OWL-----------------------------------*/

$port = 22600;
$addressIP = '224.192.32.19';
$iplocal = '192.168.1.1';       // adresse ip de la machine qui lance le script

/*--------------------Fin des paramettres OWL---------------------------*/     

/*--------------------Paramettres Zibase--------------------------------*/

include("/etc/zibase/conf_zibase.php");
//include("/var/lib/zibase/zibase.php");
//$zibase = new ZiBase("192.168.245.89");
$idsonde = '131077';

/*--------------------Fin des paramettres Zibase------------------------*/

$socketClient = socket_create(AF_INET, SOCK_DGRAM, 0);
socket_set_option($socketClient, SOL_SOCKET, SO_REUSEADDR, 1);
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
socket_bind($socketClient, $iplocal, $port);
} else {
socket_bind($socketClient, $addressIP, $port);
}
$tab_mcast = array("group" => $addressIP, "interface" => 0,);
socket_set_option($socketClient, IPPROTO_IP, MCAST_JOIN_GROUP, $tab_mcast);
socket_recvfrom($socketClient, $buf, 800, 0, $from, $fromPort);
$chaine_xml = "<xml>".$buf.'</xml>';
socket_close($socketClient);
$document_xml = json_decode(json_encode(simplexml_load_string($chaine_xml)),1);

$electricity = $document_xml['electricity'];
$chan = $electricity['chan'];
$battery0 = $electricity['battery'];
$battery = $battery0['@attributes'];
$chan1 = $chan[0];
$chan2 = $chan[1];
$chan3 = $chan[2];
/*
print_r($document_xml);
echo "chan 1 : ".$chan1['curr']."\n";
echo "chan 2 : ".$chan2['curr']."\n";
echo "chan 3 : ".$chan3['curr']."\n";
echo "chan 1 cumule : ".$chan1['day']."\n";
echo "chan 2 cumule : ".$chan2['day']."\n";
echo "chan 3 cumule : ".$chan3['day']."\n";
echo "Niveau Pile : ".$battery['level']."\n";
*/

if(!($chan1['day'] == 0 && $chan2['day'] == 0 && $chan3['day'] == 0))
{
//$zibase->sendVirtualProbeValues($idsonde, (($chan1['day'] + $chan2['day'] + $chan3['day'])/100), (($chan1['curr'] + $chan2['curr'] + $chan3['curr'])/100), $lowbat = 0, $probeType = ZbVirtualProbe::OWL);
$link = mysql_connect($hote,$login,$plogin);
if (!$link) {
   die('Non connect&eacute; : ' . mysql_error());
}
$db_selected = mysql_select_db($base,$link);
if (!$db_selected) {
   die ('Impossible d\'utiliser la base : ' . mysql_error());
}
$query = "INSERT INTO detail (date, chan1, chan2, chan3, battery, cumul) VALUES (now(), '".$chan1['curr']."', '".$chan2['curr']."', '".$chan3['curr']."', '".$battery['level']."', '".($chan1['day']+$chan2['day']+$chan3['day'])."')";
mysql_query($query, $link);
$consoTemp = 0;
foreach($heuresCreuses as $heureCreuse){
$query = "SELECT min(cumul) as min, max(cumul) as max FROM detail where date >= '".date('Y-m-d', mktime(0, 0, 0, date("m")  , date("d") , date("Y")))." ".$heureCreuse['debut']."' and date <= '".date('Y-m-d', mktime(0, 0, 0, date("m")  , date("d") , date("Y")))." ".$heureCreuse['fin']."'";
$res_query = mysql_query($query, $link);
if(mysql_numrows($res_query) > 0){
$consoTemp += mysql_result($res_query,0,"max") - mysql_result($res_query,0,"min");
}
}
$query = "INSERT INTO journalier (date, chan1, chan2, chan3, HC, cout) VALUES (curdate(), '".$chan1['day']."',  '".$chan2['day']."',  '".$chan3['day']."', '".$consoTemp."', '".($coutfixe+($consoTemp*$coutHC/1000)+(($chan1['day']+$chan2['day']+$chan3['day']-$consoTemp)*$coutHP)/1000)."')";
mysql_query($query, $link);
$query = "UPDATE journalier SET chan1 = '".$chan1['day']."',  chan2 = '".$chan2['day']."',  chan3 = '".$chan3['day']."', HC = '".$consoTemp."', cout = '".($coutfixe+($consoTemp*$coutHC/1000)+(($chan1['day']+$chan2['day']+$chan3['day']-$consoTemp)*$coutHP)/1000)."' WHERE date = curdate()";
mysql_query($query, $link);
mysql_close();
}
?>
