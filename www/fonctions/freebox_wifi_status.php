<?php
if(isset($_SESSION['auth']))
{
$do = "wifi_status";
include('./pages/freebox-cmd.php');
}
?>
