<?
if(isset($_SESSION['auth']))
{
if(isset($_POST['id'])){
include("./pages/connexion.php");
$query = "UPDATE sonde_vent SET id_plan = '".$_POST['sonde']."' WHERE nom = '".$_POST['id']."'";
mysql_query($query, $link);
}
include("./pages/connexion.php");
$query = "SELECT * FROM sonde_vent";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
?>
<FORM method="post" action="./index.php?page=administration&detail=affecter_vent">
<? echo $data['nom']; ?> : <select name="sonde">
<?
$query3 = "SELECT * FROM `plan` ORDER BY `libelle`";
$req3 = mysql_query($query3, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data3 = mysql_fetch_assoc($req3))
{ ?>
<option value="<? echo $data3['id']; ?>"<? if($data3['id'] ==  $data['id_plan']){ echo " selected"; } ?>><? echo $data3['libelle']; ?></option>
<? } ?>
</select>
<INPUT TYPE="HIDDEN" NAME="id" VALUE="<? echo $data['nom']; ?>">
<INPUT TYPE="SUBMIT" NAME="VALIDER" VALUE="VALIDER">
</FORM>


<?
}
}
?>
