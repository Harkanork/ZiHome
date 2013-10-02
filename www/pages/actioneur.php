<?
session_start();
if(isset($_SESSION['auth']))
{
?>
<SCRIPT LANGUAGE="JavaScript"/>
function redirect() {
        window.location="javascript:history.go(-1)"
}
setTimeout("redirect()",0); // delai en millisecondes
</SCRIPT>
<?php
include("/var/www/pages/conf_zibase.php");
include("/var/www/lib/zibase.php");
$zibase = new ZiBase("192.168.245.89");
$zibase->sendCommand($_GET['action'], $_GET['ordre'], $_GET['protocol'], $_GET['dim']);
}
?>
