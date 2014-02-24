<?php
if(isset($_SESSION['auth']))
{
$do = "conn_config";
include('./pages/freebox-cmd.php');
}
?>
