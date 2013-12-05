<div id="body-action">
<br>
<div id="action-actionneur">
<table border="0">
<tr class="nom">
<td>
<center>
Nom
</center>
</td>
<td>
<center>
Action
</center>
</td>
<td>
<center>
Protocol
</center>
</td>
<td>
<center>
Droite
</center>
</td>
<td>
<center>
Bas
</center>
</td>
<td>
<center>
Icone
</center>
</td>
<td>
</td>
</tr>
<tr>
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
<tr>
<FORM method="post" action="./index.php?page=affecter_actioneur">
<td class="name">
<? echo $data['nom']; ?> : <select name="sonde">
<?
$query3 = "SELECT * FROM `plan` ORDER BY `libelle`";
$req3 = mysql_query($query3, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data3 = mysql_fetch_assoc($req3))
{ ?>
<option value="<? echo $data3['id']; ?>"<? if($data3['id'] ==  $data['id_plan']){ echo " selected"; } ?>><? echo $data3['libelle']; ?></option>
<? } ?>
</select>
</td>
<td class="action-select">
<select name="type">
<option value="on"<? if($data['type'] == "on"){ echo " selected"; } ?>>On</option>
<option value="on_off"<? if($data['type'] == "on_off"){ echo " selected"; } ?>>On - Off</option>
<option value="dim"<? if($data['type'] == "dim"){ echo " selected"; } ?>>Dimable</option>
</select> 
</td>
<td class="protocol-select">
<select name="protocol">
<?
$query1 = "SELECT * FROM protocol WHERE actif = 1 ORDER BY `nom`";
$req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data1 = mysql_fetch_assoc($req1)) {
?>
<option value="<? echo $data1['zcode']; ?>"<? if($data1['zcode'] ==  $data['protocol']){ echo " selected"; } ?>><? echo $data1['nom']; ?></option>
<? } ?>
</select>
</td>
<td class="droite"><!--Droite:--><INPUT TYPE="text" NAME="left" VALUE="<? echo $data['left']; ?>" size=5></td> 
<td class="bas"><!--bas:--><INPUT TYPE="text" NAME="top" VALUE="<? echo $data['top']; ?>" size=5></td>
<td class="icone"><center><INPUT type="checkbox" name="icone" value="1"<? if($data['icone'] == "1"){ echo " checked"; } ?>></center></td>
<INPUT TYPE="HIDDEN" NAME="id" VALUE="<? echo $data['nom']; ?>">
<td class="input"><center><INPUT TYPE="SUBMIT" NAME="VALIDER" VALUE="VALIDER"></center></td>
</FORM>
<?
}
}
?>
</table>
  </div>
  