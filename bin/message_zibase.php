<?
include("/var/www/pages/conf_zibase.php");
include("/var/www/lib/zibase.php");
$zibase = new ZiBase($ipzibase);
$zibase->registerListener($ipserver);
$socket = socket_create(AF_INET, SOCK_DGRAM, 0);
socket_bind($socket, "0.0.0.0" , 49999);
$link = mysql_connect($hote,$login,$plogin);
if (!$link) {
   die('Non connect&eacute; : ' . mysql_error());
}
$db_selected = mysql_select_db($base,$link);
if (!$db_selected) {
   die ('Impossible d\'utiliser la base : ' . mysql_error());
}
while (true) {
socket_recvfrom($socket, $data, 512, 0, $remote_ip, $remote_port);
$zbData = new ZbResponse($data);
$query = "INSERT INTO message_zibase (date, message) VALUES (now(), '".$zbData->message."')";
mysql_query($query, $link);
}
?>
