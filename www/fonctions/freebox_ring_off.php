<?php
if(isset($_SESSION['auth']))
{
if(isset($_POST['ring_off'])) {
$do = "ring_off";
include('./pages/freebox-cmd.php');
}
?>
<form method="post" action="./index.php?page=freebox">
<input type="submit" name="ring_off" value="RING OFF"></input>
</form>
<?
}
?>
