<?
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin') {
?>
<h1>Gestion des protocoles</h1>
<table>
<?
if(isset($_POST['id'])){
include("./pages/connexion.php");
$query = "UPDATE protocol SET actif = '".$_POST['actif']."' WHERE id = '".$_POST['id']."'";
mysql_query($query, $link);
}
include("./pages/connexion.php");
$query = "SELECT * FROM protocol";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
?>
<tr>
<FORM method="post" action="./index.php?page=administration&detail=gerer_protocol">
<td class="name">
<? echo $data['nom']; ?> :
</td>
<td>
<select name="actif">
<option value="1"<? if($data['actif'] == "1"){ echo " selected"; } ?>>Actif</option>
<option value="0"<? if($data['actif'] == "0"){ echo " selected"; } ?>>Inactif</option>
</select>
</td>
<td>
<INPUT TYPE="HIDDEN" NAME="id" VALUE="<? echo $data['id']; ?>">
<INPUT TYPE="SUBMIT" NAME="Valider" VALUE="Valider">
</td>
</FORM>
</tr>
<?
}
?>
</table>
<? 
} 
?>
