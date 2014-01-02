<? 
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin')
{
?>
<center><div id="sous-menu">
<li><A HREF="./index.php?page=administration&detail=gerer_pieces">Gerer les pieces</A></li>
<li><A HREF="./index.php?page=administration&detail=affecter_sonde">Affecter une temperature</A></li>
<?
include("./pages/connexion.php");
$query = "SELECT * FROM modules WHERE libelle = 'vent' AND actif = '1'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
?>
<li><A HREF="./index.php?page=administration&detail=affecter_vent">Affecter un anemometre</A></li>
<?
}
?>
<li><A HREF="./index.php?page=administration&detail=affecter_actioneur">Affecter un Actioneur</A></li>
<li><A HREF="./index.php?page=administration&detail=affecter_conso_elec">Affecter une conso-elec</A></li>
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
<li><A HREF="./index.php?page=administration&detail=accueil">Page Accueil</A></li>
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
