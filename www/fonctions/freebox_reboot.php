<?
if(isset($_SESSION['auth']))
{
$do = "reboot";
include('./pages/freebox-cmd.php');
}
?>
