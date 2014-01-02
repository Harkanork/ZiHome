<?
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin')
{
include("./pages/connexion.php");
if(isset($_POST['rapatrier'])){
$query = "DELETE FROM `page_accueil` WHERE user = '".$_SESSION['auth']."'";
mysql_query($query, $link);
$query = "SELECT * FROM page_accueil WHERE user = '".$_POST['user']."'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
$query0 = "INSERT INTO page_accueil (`libelle`, `user`, `width`, `height`, `left`, `top`, `border`, `url`, `peripherique`, `option`) VALUES ('".$data['libelle']."', '".$_SESSION['auth']."', '".$data['width']."', '".$data['height']."', '".$data['left']."', '".$data['top']."', '".$data['border']."', '".$data['url']."', '".$data['peripherique']."', '".$data['option']."')";
mysql_query($query0, $link);
}
}
if(isset($_POST['Migrer'])){
$query = "DELETE FROM `page_accueil` WHERE user = '".$_POST['user']."'";
mysql_query($query, $link);
$query = "SELECT * FROM page_accueil WHERE user = '".$_SESSION['auth']."'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
$query0 = "INSERT INTO page_accueil (`libelle`, `user`, `width`, `height`, `left`, `top`, `border`, `url`, `peripherique`, `option`) VALUES ('".$data['libelle']."', '".$_POST['user']."', '".$data['width']."', '".$data['height']."', '".$data['left']."', '".$data['top']."', '".$data['border']."', '".$data['url']."', '".$data['peripherique']."', '".$data['option']."')";
mysql_query($query0, $link);
}
}
if(isset($_GET['supprimer'])){
$query = "DELETE FROM `page_accueil` WHERE `id` = ".$_GET['supprimer'];
mysql_query($query, $link);
}
if(isset($_POST['Modifier'])){
$url = explode("-",$_POST['module']);
$query = "UPDATE page_accueil SET `libelle` = '".$_POST['libelle']."',`width` = '".$_POST['width']."', `height` = '".$_POST['height']."', `left` = '".$_POST['left']."', `top` = '".$_POST['top']."', `border` = '".$_POST['border']."', `url` = '".$url[0]."', `peripherique` = '".$url[1]."', `option` = '".$_POST[‘option’]."' WHERE `id` = '".$_POST['id']."'";
mysql_query($query, $link);
}
if(isset($_POST['Valider'])) {
$url = explode("-",$_POST['module']);
$query = "INSERT INTO page_accueil (`libelle`, `user`, `width`, `height`, `left`, `top`, `border`, `url`, `peripherique`, `option`) VALUES ('".$_POST['libelle']."', '".$_SESSION['auth']."', '".$_POST['width']."', '".$_POST['height']."', '".$_POST['left']."', '".$_POST['top']."', '".$_POST['border']."', '".$url[0]."', '".$url[1]."', '".$_POST['option']."')";
mysql_query($query, $link);
}
?>
<div id="action-tableau">
<CENTER><TABLE border=0><TR class="title" bgcolor="#6a6a6a"><TD>Largeur</TD><TD>Hauteur</TD><TD>Droite</TD><TD>Bas</TD><TD>Bordure</TD><TD>url</TD><TD>peripherique</TD><TD>option</TD><TD>&nbsp;</TD><TD>&nbsp;</TD></TR>
<?
$query = "SELECT * FROM page_accueil WHERE user = '".$_SESSION['auth']."'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
echo "<TR class=\"contenu\"><TD>".$data['width']."</TD><TD>".$data['height']."</TD><TD>".$data['left']."</TD><TD>".$data['top']."</TD><TD>".$data['border']."</TD><TD>".$data['url']."</TD><TD>".$data['peripherique']."</TD><TD>".$data['option']."</TD><TD><A HREF=\"./index.php?page=administration&detail=accueil&piece=".$data['id']."\">Modifier</A></TD><TD><A HREF=\"./index.php?page=administration&detail=accueil&supprimer=".$data['id']."\">Supprimer</A></TD></TR>";
}
?>
</TABLE></CENTER></div>
<?
if(isset($_GET['piece'])){
$query1 = "SELECT * FROM page_accueil WHERE id = '".$_GET['piece']."'";
$req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data1 = mysql_fetch_assoc($req1))
{
?>
<P align=center>
<TABLE>
<FORM method="post" action="./index.php?page=administration&detail=accueil">
<TR><TD>Nom :</TD><TD><INPUT type=text name=libelle value="<? echo $data1['libelle']; ?>"></INPUT></TD></TR>
<TR><TD>Largeur :</TD><TD><INPUT type=text name=width value="<? echo $data1['width']; ?>"></INPUT></TD></TR>
<TR><TD>Hauteur :</TD><TD><INPUT type=text name=height value="<? echo $data1['height']; ?>"></INPUT></TD></TR>
<TR><TD>Position Droite :</TD><TD><INPUT type=text name=left value="<? echo $data1['left']; ?>"></INPUT></TD></TR>
<TR><TD>Position Bas :</TD><TD><INPUT type=text name=top value="<? echo $data1['top']; ?>"></INPUT></TD></TR>
<TR><TD>Taille bordure :</TD><TD><INPUT type=text name=border value="<? echo $data1['border']; ?>"></INPUT></TD></TR>
<TR><TD>module :</TD><TD>
<select name=module>
<?
include("./pages/connexion.php");
$query = "SELECT * FROM modules_accueil ORDER BY libelle";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
if($data['type'] == "") {
echo "<option value=\"".$data['url']."\"";
if($data['url'] == $data1['url']) { echo " selected"; }
echo ">".$data['libelle']."</option>";
} else if($data['type'] == "scenario") {
$query0 = "SELECT * FROM scenarios";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data0 = mysql_fetch_assoc($req0))
{
echo "<option value=\"".$data['url']."-".$data0['id']."\"";
if($data['url']."-".$data0['id'] == $data1['url']."-".$data1['peripherique']) { echo " selected"; }
echo ">".$data['libelle']." ".$data0['nom']."</option>";
}
} else {
$query0 = "SELECT * FROM peripheriques WHERE periph = '".$data['type']."'";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data0 = mysql_fetch_assoc($req0))
{
echo "<option value=\"".$data['url']."-".$data0['id']."\"";
if($data['url']."-".$data0['id'] == $data1['url']."-".$data1['peripherique']) { echo " selected"; }
echo ">".$data['libelle']." ".$data0['nom']."</option>";
}
}
}
?>
</select>
</TD></TR>
<TR><TD colspan=2 align=center><INPUT type=hidden name=id value="<? echo $data1['id']; ?>">
<INPUT type=submit name=Modifier value=Modifier></TD></TR>
</FORM>
</TABLE>
</P>
<?
}
} else {
?>
<P align=center>
<FORM method="post" action="./index.php?page=administration&detail=accueil">
Migrer le profil vers un utilisateur (attention, la migration ecrase le profil existant)<br>
<select name=user>
<option value=default>Default</option>
<?
include("./pages/connexion.php");
$query = "SELECT * FROM users WHERE pseudo != '".$_SESSION['auth']."'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
echo "<option value=\"".$data['pseudo']."\">".$data['pseudo']."</option>";
}
?>
</select>
<INPUT type=submit name=Migrer value=Migrer>
</FORM>
</p>
<P align=center>
<FORM method="post" action="./index.php?page=administration&detail=accueil">
Rapatrier le profil d'un utilisateur (attention, la migration ecrase le profil existant)<br>
<select name=user>
<option value=default>Default</option>
<?
include("./pages/connexion.php");
$query = "SELECT * FROM users WHERE pseudo != '".$_SESSION['auth']."'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
echo "<option value=\"".$data['pseudo']."\">".$data['pseudo']."</option>";
}
?>
</select>
<INPUT type=submit name=rapatrier value=Rapatrier>
</FORM>
</p>
<br>
<P align=center>
<TABLE>
<FORM method="post" action="./index.php?page=administration&detail=accueil">
<TR><TD>Nom :</TD><TD><INPUT type=text name=libelle></INPUT></TD></TR>
<TR><TD>Largeur :</TD><TD><INPUT type=text name=width></INPUT></TD></TR>
<TR><TD>Hauteur :</TD><TD><INPUT type=text name=height></INPUT></TD></TR>
<TR><TD>Position Droite :</TD><TD><INPUT type=text name=left></INPUT></TD></TR>
<TR><TD>Position Bas :</TD><TD><INPUT type=text name=top></INPUT></TD></TR>
<TR><TD>Taille bordure :</TD><TD><INPUT type=text name=border></INPUT></TD></TR>
<TR><TD>module :</TD><TD>
<select name=module>
<?
include("./pages/connexion.php");
$query = "SELECT * FROM modules_accueil ORDER BY libelle";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
if($data['type'] == "") {
echo "<option value=\"".$data['url']."\">".$data['libelle']."</option>";
} else if($data['type'] == "scenario") {
$query0 = "SELECT * FROM scenarios";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data0 = mysql_fetch_assoc($req0))
{
echo "<option value=\"".$data['url']."-".$data0['id']."\">".$data['libelle']." ".$data0['nom']."</option>";
}
} else {
$query0 = "SELECT * FROM peripheriques WHERE periph = '".$data['type']."'";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data0 = mysql_fetch_assoc($req0))
{
echo "<option value=\"".$data['url']."-".$data0['id']."\">".$data['libelle']." ".$data0['nom']."</option>";
}
}
}
?>
</select>
</TD></TR>
<TR><TD colspan=2 align=center><INPUT type=submit name=Valider value=Valider></TD></TR>
</FORM>
</TABLE>
</P>
<? 
}
}
?>
