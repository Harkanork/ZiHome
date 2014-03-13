<?php
if(isset($_SESSION['auth']))
{
$do = "dhcp_baux_dynamique";
include('./pages/freebox-cmd.php');
}
?>
