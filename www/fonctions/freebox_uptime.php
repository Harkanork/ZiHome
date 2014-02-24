<?php
if(isset($_SESSION['auth']))
{
$do = "uptime";
include('./pages/freebox-cmd.php');
}
?>
