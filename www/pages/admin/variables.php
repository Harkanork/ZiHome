<?
if(isset($_SESSION['auth']))
{
include("./config/conf_zibase.php");
include("./lib/zibase.php");
$zibase = new ZiBase($ipzibase);
if(isset($_POST['VALIDER'])) {
$zibase->setVariable($_POST['id'], $_POST['value']);
include("./pages/connexion.php");
$query = "UPDATE variables SET description = '".$_POST['description']."' WHERE `id` = '".$_POST['id']."'";
//echo $query;
mysql_query($query, $link);
}
include("./pages/connexion.php");
for ($i = 0; $i < 60; $i++) {
$var = $zibase->getVariable($i);
$query0 = "SELECT * FROM `variables` WHERE id = '".$i."'";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$data0 = mysql_fetch_assoc($req0)

?>
<center><p align="center"><form method="post" action="./index.php?page=administration&detail=variables">
Variable <? echo $i; ?> : <input type="text" name="value" value="<? echo $var; ?>">
Description : <input type="text" name="description" value="<? echo $data0['description']; ?>">
<input type="hidden" name="id" value="<? echo $i; ?>">
<INPUT TYPE="SUBMIT" NAME="VALIDER" VALUE="VALIDER">
</form></p></center>
<?
}
}
?>
