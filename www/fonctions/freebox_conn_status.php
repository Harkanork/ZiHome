<?php
if(isset($_SESSION['auth']))
{
$do = "conn_status";
include('./pages/freebox-cmd.php');
}
?>
