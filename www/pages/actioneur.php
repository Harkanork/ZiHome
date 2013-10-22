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
include("./conf_zibase.php");
include("../lib/zibase.php");
$zibase = new ZiBase($ipzibase);
$zibase->sendCommand($_GET['action'], $_GET['ordre'], $_GET['protocol'], $_GET['dim']);
}
?>
