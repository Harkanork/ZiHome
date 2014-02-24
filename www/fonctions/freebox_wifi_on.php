<?php
if(isset($_SESSION['auth']))
{
$do = "wifi_on";
include('./pages/freebox-cmd.php');
}
?>
