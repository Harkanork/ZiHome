<?
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin')
{
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
G&eacute;rer les piles
</td>
<td>
Date changement Batterie :
</td>
<td>Libelle</td><td></td>
</tr>
<?

if(isset($_POST['id'])){
include("./pages/connexion.php");
$query = "UPDATE peripheriques SET id_plan = '".$_POST['sonde']."', gerer_batterie = '".$_POST['gerer_batterie']."', libelle = '".$_POST['libelle']."', date_chgt_batterie = '".$_POST['date_chgt_batterie']."' WHERE nom = '".$_POST['id']."'";
mysql_query($query, $link);
}
include("./pages/connexion.php");
$query = "SELECT * FROM peripheriques WHERE periph = 'conso'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
?>
<tr>
<FORM method="post" action="./index.php?page=administration&detail=affecter_conso_elec">
<td>
<? echo $data['nom']; ?> : <select name="sonde">
<option value="-1">ne pas afficher</option></td>
<?
$query3 = "SELECT * FROM `plan` ORDER BY `libelle`";
$req3 = mysql_query($query3, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data3 = mysql_fetch_assoc($req3))
{ ?>
<option value="<? echo $data3['id']; ?>"<? if($data3['id'] ==  $data['id_plan']){ echo " selected"; } ?>><? echo $data3['libelle']; ?></option>
<? } ?>
</select>
<td>
<center>
<INPUT type="checkbox" name="gerer_batterie" value="1"<? if($data['gerer_batterie'] == "1"){ echo " checked"; } ?>>
</center>
</td>
<td>
<center>
 <INPUT type="date" name="date_chgt_batterie" value="<? echo $data['date_chgt_batterie']; ?>">
 </center>
 </td>
 <td>
 <center>
<INPUT type="texte" name="libelle" value="<? echo $data['libelle']; ?>">
</center>
</td>
<INPUT TYPE="HIDDEN" NAME="id" VALUE="<? echo $data['nom']; ?>">
<td>
<center>
<INPUT TYPE="SUBMIT" NAME="VALIDER" VALUE="VALIDER">
</center>
</td>
</tr>
</FORM>
</table>
<?
}
}
?>

</center>
</div>