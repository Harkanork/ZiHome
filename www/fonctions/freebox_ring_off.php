<?php
if(isset($_SESSION['auth']))
{
$do = "ring_off";
include('./pages/freebox-cmd.php');
}
?>
