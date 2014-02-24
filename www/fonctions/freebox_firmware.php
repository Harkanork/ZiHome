<?php
if(isset($_SESSION['auth']))
{
$do = "firmware";
include('./pages/freebox-cmd.php');
}
?>
