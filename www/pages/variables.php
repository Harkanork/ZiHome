<?
if(isset($_SESSION['auth']))
{
include("./pages/conf_zibase.php");
include("./lib/zibase.php");
$zibase = new ZiBase($ipzibase);
if(isset($_POST['VALIDER'])) {
$zibase->setVariable($_POST['id'], $_POST['value']);
}
for ($i = 0; $i < 60; $i++) {
$var = $zibase->getVariable($i);
?>
<center><p align="center"><form method="post" action="./index.php?page=administration&detail=variables">
Variable <? echo $i; ?> : <input type="text" name="value" value="<? echo $var; ?>">
<input type="hidden" name="id" value="<? echo $i; ?>">
<INPUT TYPE="SUBMIT" NAME="VALIDER" VALUE="VALIDER">
</form></p></center>
<?
}
}
?>
