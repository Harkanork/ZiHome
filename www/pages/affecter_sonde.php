<?
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin')
{
?><div id="action-actionneur">
<center>
<br>
<table border="0" align="center">
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
Icone
</td>
<td>Batterie</td><td>Libelle</td><td></td>
</tr>
<tr>
<?
if(isset($_POST['id'])){
include("./pages/connexion.php");
$query = "UPDATE peripheriques SET id_plan = '".$_POST['sonde']."', `top` = '".$_POST['top']."', `left` = '".$_POST['left']."', Icone = '".$_POST['icone']."', gerer_batterie = '".$_POST['gerer_batterie']."', libelle = '".$_POST['libelle']."', date_chgt_batterie = '".$_POST['date_chgt_batterie']."' WHERE nom = '".$_POST['id']."'";
mysql_query($query, $link);
}
include("./pages/connexion.php");
$query = "SELECT * FROM peripheriques WHERE periph = 'temperature'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
?>

<tr>
<FORM method="post" action="./index.php?page=administration&detail=affecter_sonde">
<td class="name">
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
<td class="droite"><center><INPUT TYPE="text" NAME="left" VALUE="<? echo $data['left']; ?>" size=5></center></td>
<td class="bas"><center><INPUT TYPE="text" NAME="top" VALUE="<? echo $data['top']; ?>" size=5></center></td>
<td class="icone"><center><INPUT type="checkbox" name="icone" value="1"<? if($data['icone'] == "1"){ echo " checked"; } ?>></center></td>
<td><center><INPUT type="checkbox" name="gerer_batterie" value="1"<? if($data['gerer_batterie'] == "1"){ echo " checked"; } ?>><INPUT type="date" name="date_chgt_batterie" size="10" value="<? echo $data['date_chgt_batterie']; ?>"></center></td>
<td><center><INPUT type="texte" name="libelle" value="<? echo $data['libelle']; ?>"></center></td>
<INPUT TYPE="HIDDEN" NAME="id" VALUE="<? echo $data['nom']; ?>">
<td class="input"><center><INPUT TYPE="SUBMIT" NAME="VALIDER" VALUE="VALIDER"></center></td>
</FORM>
</tr>
<?
}
?>
</table></center></div>
<? } ?>
