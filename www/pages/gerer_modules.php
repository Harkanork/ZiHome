<?
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin')
{
if(isset($_POST['id'])){
include("./pages/connexion.php");
$query = "UPDATE modules SET actif = '".$_POST['actif']."' WHERE id = '".$_POST['id']."'";
mysql_query($query, $link);
}
include("./pages/connexion.php");
$query = "SELECT * FROM modules";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
?>
<FORM method="post" action="./index.php?page=administration&detail=gerer_modules">
<? echo $data['libelle']; ?> : 
<select name="actif">
<option value="1"<? if($data['actif'] == "1"){ echo " selected"; } ?>>Actif</option>
<option value="0"<? if($data['actif'] == "0"){ echo " selected"; } ?>>Inactif</option>
</select>
<INPUT TYPE="HIDDEN" NAME="id" VALUE="<? echo $data['id']; ?>">
<INPUT TYPE="SUBMIT" NAME="VALIDER" VALUE="VALIDER">
</FORM>
<?
}
}
?>
