<?
if(isset($_SESSION['auth']))
{
if(isset($_POST['reboot'])) {
$do = "reboot";
include('./pages/freebox-cmd.php');
}
?>
<form method="post" action="./index.php?page=freebox">
<input type="submit" name="reboot" value="Reboot"></input>
</form>
<?
}
?>
