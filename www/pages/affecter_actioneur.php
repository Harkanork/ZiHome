<?
if(isset($_SESSION['auth']))
{
if(isset($_POST['id'])){
include("./pages/connexion.php");
$query = "UPDATE actioneurs SET id_plan = '".$_POST['sonde']."', type = '".$_POST['type']."', protocol = '".$_POST['protocol']."', `top` = '".$_POST['top']."', `left` = '".$_POST['left']."', Icone = '".$_POST['icone']."' WHERE nom = '".$_POST['id']."'";
mysql_query($query, $link);
}
include("./pages/connexion.php");
$query = "SELECT * FROM actioneurs";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
?>
<p><FORM method="post" action="./index.php?page=administration&detail=affecter_actioneur">
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
<select name="type">
<option value="on"<? if($data['type'] == "on"){ echo " selected"; } ?>>On</option>
<option value="on_off"<? if($data['type'] == "on_off"){ echo " selected"; } ?>>On - Off</option>
<option value="dim"<? if($data['type'] == "dim"){ echo " selected"; } ?>>Dimable</option>
</select> 
Protocol : <select name="protocol">
<?
$query1 = "SELECT * FROM protocol WHERE actif = 1 ORDER BY `nom`";
$req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data1 = mysql_fetch_assoc($req1)) {
?>
<option value="<? echo $data1['zcode']; ?>"<? if($data1['zcode'] ==  $data['protocol']){ echo " selected"; } ?>><? echo $data1['nom']; ?></option>
<? } ?>
</select>
Droite:<INPUT TYPE="text" NAME="left" VALUE="<? echo $data['left']; ?>" size=5> 
bas:<INPUT TYPE="text" NAME="top" VALUE="<? echo $data['top']; ?>" size=5>
Icone <INPUT type="checkbox" name="icone" value="1"<? if($data['icone'] == "1"){ echo " checked"; } ?>>
<INPUT TYPE="HIDDEN" NAME="id" VALUE="<? echo $data['nom']; ?>">
<INPUT TYPE="SUBMIT" NAME="VALIDER" VALUE="VALIDER">
</FORM></p>
<?
}
}
?>
