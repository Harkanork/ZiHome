<?
if(isset($_SESSION['auth']))
{
?>
<div id="body-action">
<br>
<div id="action-actionneur">
<center>
<table border="0" width="700px" align="center">
<tr class="nom">
<td>
Nom
</td>
<td>
Droite
</td>
<td>
Bas
</td>
<td>
</td>
</tr>
<?
if(isset($_POST['id'])){
include("./pages/connexion.php");
$query = "UPDATE scenarios SET id_plan = '".$_POST['sonde']."', `top` = '".$_POST['top']."', `left` = '".$_POST['left']."' WHERE nom = '".$_POST['id']."'";
mysql_query($query, $link);
}
include("./pages/connexion.php");
$query = "SELECT * FROM scenarios";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
?>
<FORM method="post" action="./index.php?page=affecter_scenario">
<tr><td class="name">
<? echo $data['nom']; ?> : <select name="sonde">
<option value="-1">ne pas afficher</option>
<?
$query3 = "SELECT * FROM `plan` ORDER BY `libelle`";
$req3 = mysql_query($query3, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data3 = mysql_fetch_assoc($req3))
{ ?>
<option value="<? echo $data3['id']; ?>"<? if($data3['id'] ==  $data['id_plan']){ echo " selected"; } ?>><? echo $data3['libelle']; ?></option>
<? } ?>
</select>
</td>
<td class="droite">
<INPUT TYPE="text" NAME="left" VALUE="<? echo $data['left']; ?>" size=5>
</td>
<td class="bas">
<INPUT TYPE="text" NAME="top" VALUE="<? echo $data['top']; ?>" size=5>
</td>
<INPUT TYPE="HIDDEN" NAME="id" VALUE="<? echo $data['nom']; ?>">
<td class="input">
<INPUT TYPE="SUBMIT" NAME="VALIDER" VALUE="VALIDER">
</td>
</tr></FORM>
<?
}
?>
</table>
</center></div></div>
<?
}
?>
