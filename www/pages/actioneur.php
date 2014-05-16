<?php
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
include("../config/conf_zibase.php");
include("../lib/zibase.php");
include("../config/variables.php");
$zibase = new ZiBase($ipzibase);
if(isset($_GET['dim'])) {
$zibase->sendCommand($_GET['action'], $_GET['ordre'], $_GET['protocol'], $_GET['dim']);
} else {
$zibase->sendCommand($_GET['action'], $_GET['ordre'], $_GET['protocol'], "");
}
}
?>
