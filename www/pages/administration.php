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
<li><A HREF="./index.php?page=administration&detail=affecter_vent">Affecter un anemometre</A></li>
<?
}
if($data['libelle'] == 'pluie') {
?>
<li><A HREF="./index.php?page=administration&detail=affecter_precipitation">Affecter une Precipitation</A></li>
<?
}
if($data['libelle'] == 'conso_elec') {
?>
<li><A HREF="./index.php?page=administration&detail=affecter_conso_elec">Affecter une conso-elec</A></li>
<?
}
if($data['libelle'] == 'temperature') {
?>
<li><A HREF="./index.php?page=administration&detail=affecter_sonde">Affecter une temperature</A></li>
<?
}
if($data['libelle'] == 'plan') {
?>
<li><A HREF="./index.php?page=administration&detail=gerer_pieces">Gerer les pieces</A></li>
<?
}
if($data['libelle'] == 'accueil') {
?>
<li><A HREF="./index.php?page=administration&detail=accueil">Page Accueil</A></li>
<?
}
if($data['libelle'] == 'video') {
?>
<li><A HREF="./index.php?page=administration&detail=video">Cameras</A></li>
<?
}
}
?>
<li><A HREF="./index.php?page=administration&detail=affecter_actioneur">Affecter un Actioneur</A></li>
<li><A HREF="./index.php?page=administration&detail=affecter_capteur">Affecter un Capteur</A></li>
<li><A HREF="./index.php?page=administration&detail=affecter_scenario">Affecter un Scenario</A></li>
<li><A HREF="./index.php?page=administration&detail=gerer_users">Gerer les utilisateurs</A></li>
<li><A HREF="./index.php?page=administration&detail=gerer_modules">Gerer les modules</A></li>
<li><A HREF="./index.php?page=administration&detail=gerer_protocol">Gerer les protocoles</A></li>
<li><A HREF="./index.php?page=administration&detail=messages">Messages Zibase</A></li>
<li><A HREF="./index.php?page=administration&detail=variables">Variables</A></li>
<li><A HREF="./index.php?page=administration&detail=icones">Icones</A></li>
<li><A HREF="./index.php?page=administration&detail=insertion">Insertion de page</A></li>
<li><A HREF="./index.php?page=administration&detail=paramettres">Paramettres</A></li>
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
