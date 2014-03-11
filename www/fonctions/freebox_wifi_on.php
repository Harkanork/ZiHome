<?php
if(isset($_SESSION['auth']))
{
if(isset($_POST['wifi_on'])) {
$do = "wifi_on";
include('./pages/freebox-cmd.php');
}
?>
<form method="post" action="./index.php?page=freebox">
<input type="submit" name="wifi_on" value="WIFI ON"></input>
</form>
<?
}
?>
