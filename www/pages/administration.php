<? 
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin')
{
?>
<center><div id="sous-menu">
<?
include("./pages/connexion.php");
$query = "SELECT * FROM modules WHERE actif = '1'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
if($data['libelle'] == 'vent') {
?>
<li><A HREF="./index.php?page=administration&detail=affecter_vent">Affecter un an&eacute;mom&egrave;tre</A></li>
<?
}
if($data['libelle'] == 'pluie') {
?>
<li><A HREF="./index.php?page=administration&detail=affecter_precipitation">Affecter une pr&eacute;cipitation</A></li>
<?
}
if($data['libelle'] == 'conso_elec') {
?>
<li><A HREF="./index.php?page=administration&detail=affecter_conso_elec">Affecter une conso-elec</A></li>
<?
}
if($data['libelle'] == 'temperature') {
?>
<li><A HREF="./index.php?page=administration&detail=affecter_sonde">Affecter une temp&eacute;rature</A></li>
<?
}
if($data['libelle'] == 'plan') {
?>
<li><A HREF="./index.php?page=administration&detail=gerer_pieces">G&eacute;rer les pi&egrave;ces</A></li>
<li><A HREF="./index.php?page=administration&detail=gerer_stickers">G&eacute;rer les stickers</A></li>
<?
}
if($data['libelle'] == 'accueil') {
?>
<li><A HREF="./index.php?page=administration&detail=accueil">Page Accueil</A></li>
<?
}
if($data['libelle'] == 'video') {
?>
<li><A HREF="./index.php?page=administration&detail=video">Cam&eacute;ras</A></li>
<?
}
if($data['libelle'] == 'iphone') {
?>
<li><A HREF="./index.php?page=administration&detail=iphone">iPhone</A></li>
<?
}
if($data['libelle'] == 'android') {
?>
<li><A HREF="./index.php?page=administration&detail=android">Android</A></li>
<?
}
}
?>
<li><A HREF="./index.php?page=administration&detail=affecter_actioneur">Affecter un actioneur</A></li>
<li><A HREF="./index.php?page=administration&detail=affecter_capteur">Affecter un capteur</A></li>
<li><A HREF="./index.php?page=administration&detail=affecter_scenario">Affecter un sc&eacute;nario</A></li>
<li><A HREF="./index.php?page=administration&detail=gerer_users">G&eacute;rer les utilisateurs</A></li>
<li><A HREF="./index.php?page=administration&detail=gerer_modules">G&eacute;rer les modules</A></li>
<li><A HREF="./index.php?page=administration&detail=gerer_protocol">G&eacute;rer les protocoles</A></li>
<li><A HREF="./index.php?page=administration&detail=messages">Messages Zibase</A></li>
<li><A HREF="./index.php?page=administration&detail=variables">Variables</A></li>
<li><A HREF="./index.php?page=administration&detail=insertion">Insertion de page</A></li>
<li><A HREF="./index.php?page=administration&detail=paramettres">Param&egrave;tres</A></li>
</div>
<div id="action">
<?
if(isset($_GET['detail'])){
include("./pages/admin/".$_GET['detail'].".php");
} else {
include("./pages/admin/gerer_pieces.php");
}
?>
</div>
</center>
<?
}
?>
