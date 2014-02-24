<?php
if(isset($_SESSION['auth']))
{
$do = "ring_on";
include('./pages/freebox-cmd.php');
}
?>
