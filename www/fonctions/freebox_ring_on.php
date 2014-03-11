<?php
if(isset($_SESSION['auth']))
{
if(isset($_POST['ring_on'])) {
$do = "ring_on";
include('./pages/freebox-cmd.php');
}
?>
<form method="post" action="./index.php?page=freebox">
<input type="submit" name="ring_on" value="RING ON"></input>
</form>
<?
}
?>
