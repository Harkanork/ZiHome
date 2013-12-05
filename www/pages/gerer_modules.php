<?
if(isset($_SESSION['auth']))
{
?>
<div id="body-action">
<br>
<div id="action-actionneur">
<center>
<table border="0" align="center">
<tr class="nom">
<td>
Nom
</td>
<td>
Action
</td>
<td>
</td>
</tr>
<tr>
<?
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
<FORM method="post" action="./index.php?page=gerer_modules">
<td width="190px" align="center">
<? echo $data['libelle']; ?>
</td>
<td>
<select name="actif">
<option value="1"<? if($data['actif'] == "1"){ echo " selected"; } ?>>Actif</option>
<option value="0"<? if($data['actif'] == "0"){ echo " selected"; } ?>>Inactif</option>
</select>
</td>
<INPUT TYPE="HIDDEN" NAME="id" VALUE="<? echo $data['id']; ?>">
<td>
<INPUT TYPE="SUBMIT" NAME="VALIDER" VALUE="VALIDER">
</td>
</FORM>
</tr>
<?
}
?>
</table>
</center>
<br></div></div>
<?
}
?>
