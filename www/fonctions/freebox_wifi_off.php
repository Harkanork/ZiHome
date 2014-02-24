<?php
if(isset($_SESSION['auth']))
{
$do = "wifi_off";
include('./pages/freebox-cmd.php');
}
?>
