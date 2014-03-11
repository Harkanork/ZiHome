<?php
if(isset($_SESSION['auth']))
{
if(isset($_POST['wifi_off'])) {
$do = "wifi_off";
include('./pages/freebox-cmd.php');
}
?>
<form method="post" action="./index.php?page=freebox">
<input type="submit" name="wifi_off" value="WIFI OFF"></input>
</form>
<?
}
?>
