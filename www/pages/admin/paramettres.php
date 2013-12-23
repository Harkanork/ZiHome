<?
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin')
{
if(isset($_POST['valider'])){
include("./pages/connexion.php");
$query = "UPDATE paramettres SET value = '".$_POST['value']."' WHERE id = '".$_POST['id']."'";
mysql_query($query, $link);
}
?>
<div id="action-actionneur">
<center>
<br>
<table border="0" align="center">
<tr class="nom">
<td>
Nom
</td>
<td>
Valeur
</td>
<td></td></tr>
<?
include("./pages/connexion.php");
$query = "SELECT * FROM paramettres WHERE libelle != 'icones'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{

?>
<tr>
<FORM method="post" action="./index.php?page=administration&detail=paramettres">
<input type="hidden" name="id" value="<? echo $data['id']; ?>">
<td class="name">
<? echo $data['libelle']; ?></td><td>
<select name="value"><?
$query1 = "SELECT * FROM ".$data['libelle'];
$req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data1 = mysql_fetch_assoc($req1))
{
if($data1['value'] == $data['value'])
{
echo "<option value=\"".$data1['value']."\" selected>".$data1['value']."</option>";
} else {
echo "<option value=\"".$data1['value']."\">".$data1['value']."</option>";
}
}
?>
</select></td><td><input type="submit" name="valider" value="Valider"></td></FORM></tr>
<?
}
?>
</table></center></div>
<?
}
?>
