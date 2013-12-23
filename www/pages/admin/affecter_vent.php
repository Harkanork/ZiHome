<?
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin')
{
if(isset($_POST['id'])){
include("./pages/connexion.php");
$query = "UPDATE peripheriques SET id_plan = '".$_POST['sonde']."', gerer_batterie = '".$_POST['gerer_batterie']."', libelle = '".$_POST['libelle']."', date_chgt_batterie = '".$_POST['date_chgt_batterie']."' WHERE nom = '".$_POST['id']."'";
mysql_query($query, $link);
}
include("./pages/connexion.php");
$query = "SELECT * FROM peripheriques WHERE periph = 'vent'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
?>
<FORM method="post" action="./index.php?page=administration&detail=affecter_vent">
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
Gerer Batterie :  <INPUT type="checkbox" name="gerer_batterie" value="1"<? if($data['gerer_batterie'] == "1"){ echo " checked"; } ?>>
Date changement Batterie : <INPUT type="date" name="date_chgt_batterie" value="<? echo $data['date_chgt_batterie']; ?>">
Libelle : <INPUT type="texte" name="libelle" value="<? echo $data['libelle']; ?>">
<INPUT TYPE="HIDDEN" NAME="id" VALUE="<? echo $data['nom']; ?>">
<INPUT TYPE="SUBMIT" NAME="VALIDER" VALUE="VALIDER">
</FORM>
<?
}
}
?>
