<?
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin')
{
include("./pages/connexion.php");
if(isset($_GET['supprimer'])){
$query = "DELETE FROM `plan` WHERE `id` = ".$_GET['supprimer'];
mysql_query($query, $link);
}
if(isset($_POST['Modifier'])){
$query = "UPDATE plan SET `id` = '".$_POST['id']."',  `libelle` = '".$_POST['libelle']."',  `width` = '".$_POST['width']."', `height` = '".$_POST['height']."', `left` = '".$_POST['left']."', `top` = '".$_POST['top']."', `line-height` = '".$_POST['line-height']."', `text-align` = '".$_POST['text-align']."', `border` = '".$_POST['border']."' WHERE `id` = '".$_POST['idsource']."'";
mysql_query($query, $link);
}
if(isset($_POST['Valider'])) {
$query = "INSERT INTO plan (`libelle`, `width`, `height`, `left`, `top`, `line-height`, `text-align`, `border`) VALUES ('".$_POST['libelle']."', '".$_POST['width']."', '".$_POST['height']."', '".$_POST['left']."', '".$_POST['top']."', '".$_POST['line-height']."', '".$_POST['text-align']."', '".$_POST['border']."')";
mysql_query($query, $link);
}
?>
<div id="action-tableau">
<CENTER><TABLE border=0><TR class="title" bgcolor="#6a6a6a"><TD>Id</TD><TD>Nom</TD><TD>Largeur</TD><TD>Hauteur</TD><TD>Gauche</TD><TD>Haut</TD><TD>Taille-texte</TD><TD>Alignement</TD><TD>Bordure</TD><TD>&nbsp;</TD><TD>&nbsp;</TD></TR>
<?
$query = "SELECT * FROM plan";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
echo "<TR class=\"contenu\"><TD>".$data['id']."</TD><TD>".$data['libelle']."</TD><TD>".$data['width']."</TD><TD>".$data['height']."</TD><TD>".$data['left']."</TD><TD>".$data['top']."</TD><TD>".$data['line-height']."</TD><TD>".$data['text-align']."</TD><TD>".$data['border']."</TD><TD><A HREF=\"./index.php?page=administration&detail=gerer_pieces&piece=".$data['id']."\">Modifier</A></TD><TD><A HREF=\"./index.php?page=administration&detail=gerer_pieces&supprimer=".$data['id']."\">Supprimer</A></TD></TR>";
}
?>
</TABLE></CENTER></div>
<?
if(isset($_GET['piece'])){
$query = "SELECT * FROM plan WHERE id = '".$_GET['piece']."'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
?>
<P align=center>
<TABLE>
<FORM method="post" action="./index.php?page=administration&detail=gerer_pieces">
<TR><TD>Id :</TD><TD><INPUT type=text name=id value="<? echo $data['id']; ?>"></INPUT></TD></TR>
<TR><TD>Nom :</TD><TD><INPUT type=text name=libelle value="<? echo $data['libelle']; ?>"></INPUT></TD></TR>
<TR><TD>Largeur :</TD><TD><INPUT type=text name=width value="<? echo $data['width']; ?>"></INPUT></TD></TR>
<TR><TD>Hauteur :</TD><TD><INPUT type=text name=height value="<? echo $data['height']; ?>"></INPUT></TD></TR>
<TR><TD>Position Gauche :</TD><TD><INPUT type=text name=left value="<? echo $data['left']; ?>"></INPUT></TD></TR>
<TR><TD>Position Bas :</TD><TD><INPUT type=text name=top value="<? echo $data['top']; ?>"></INPUT></TD></TR>
<TR><TD>Taille zone Texte :</TD><TD><INPUT type=text name=line-height value="<? echo $data['line-height']; ?>"></INPUT></TD></TR>
<TR><TD>Alignement :</TD><TD><INPUT type=text name=text-align value="<? echo $data['text-align']; ?>"></INPUT></TD></TR>
<TR><TD>Taille bordure :</TD><TD><INPUT type=text name=border value="<? echo $data['border']; ?>"></INPUT></TD></TR>
<INPUT type=hidden name=idsource value="<? echo $data['id']; ?>">
<TR><TD colspan=2 align=center><INPUT type=submit name=Modifier value=Modifier></TD></TR>
</FORM>
</TABLE>
</P>
<?
}
} else {
?>
<P align=center>
<TABLE>
<FORM method="post" action="./index.php?page=gerer_pieces">
<TR><TD>Nom :</TD><TD><INPUT type=text name=libelle></INPUT></TD></TR>
<TR><TD>Largeur :</TD><TD><INPUT type=text name=width></INPUT></TD></TR>
<TR><TD>Hauteur :</TD><TD><INPUT type=text name=height></INPUT></TD></TR>
<TR><TD>Position Droite :</TD><TD><INPUT type=text name=left></INPUT></TD></TR>
<TR><TD>Position Bas :</TD><TD><INPUT type=text name=top></INPUT></TD></TR>
<TR><TD>Taille zone Texte :</TD><TD><INPUT type=text name=line-height></INPUT></TD></TR>
<TR><TD>Alignement :</TD><TD><INPUT type=text name=text-align></INPUT></TD></TR>
<TR><TD>Taille bordure :</TD><TD><INPUT type=text name=border></INPUT></TD></TR>
<TR><TD colspan=2 align=center><INPUT type=submit name=Valider value=Valider></TD></TR>
</FORM>
</TABLE>
</P>
<? }} ?>
