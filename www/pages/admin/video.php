<?
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin') {
if(isset($_POST['valider'])) {
include("./pages/connexion.php");
$query = "INSERT INTO `video` (adresse, id_plan) VALUES ('".$_POST['adresse']."', '".$_POST['id_plan']."')";
mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
mysql_close();
}
if(isset($_POST['modifier'])) {
include("./pages/connexion.php");
$query = "UPDATE video SET id_plan = '".$_POST['id_plan']."', `adresse` = '".$_POST['adresse']."' WHERE id = '".$_POST['id']."'";
mysql_query($query, $link);
}
if(isset($_POST['supprimer'])) {
include("./pages/connexion.php");
$query = "DELETE FROM video WHERE id = '".$_POST['id']."'";
mysql_query($query, $link);
}
echo "<P><CENTER><TABLE><TR><TD>Adresse</TD><TD>Piece</TD><TD>Supprimer</TD><TD>Modifier</TD></TR>";
include("./pages/connexion.php");
$query = "SELECT * FROM video";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
echo "<TR><FORM method=POST action=\"./index.php?page=administration&detail=video\"><TD><input type=text name=adresse value=\"".$data['adresse']."\"></input></TD><TD>"
?>
<select name="id_plan">
<option value="-1">ne pas afficher</option>
<?
include("./pages/connexion.php");
$query1 = "SELECT * FROM `plan` ORDER BY `libelle`";
$req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data1 = mysql_fetch_assoc($req1))
{ ?>
<option value="<? echo $data1['id']; ?>"<? if($data1['id'] ==  $data['id_plan']){ echo " selected"; } ?>><? echo $data1['libelle']; ?></option>
<? } ?>
</select>
<?
echo "</TD><TD><input type=hidden name=id value=".$data['id']."></input><input type=submit name=supprimer value=Supprimer></input></TD><TD><input type=submit name=modifier value=Modifier></input></TD></FORM></TR>";
}
echo "</TABLE></CENTER></P>";
?>
<FORM method=POST action="./index.php?page=administration&detail=video">
adresse : <input type=text name=adresse></input>
piece plan : <select name="id_plan">
<option value="-1">ne pas afficher</option>
<?
include("./pages/connexion.php");
$query = "SELECT * FROM `plan` ORDER BY `libelle`";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_assoc($req))
{ ?>
<option value="<? echo $data['id']; ?>"><? echo $data['libelle']; ?></option>
<? } ?>
</select>
<input type=submit name=valider value=Valider></input>
</FORM>
<?
}
?>
