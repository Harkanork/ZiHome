<? //<div id ="body">
?>
<center><div id="sous-menu">
<li><A HREF="./index.php?page=administration&detail=gerer_pieces">Gerer les pieces</A></li>
<li><A HREF="./index.php?page=administration&detail=affecter_sonde">Affecter une temperature</A></li>
<li><A HREF="./index.php?page=administration&detail=affecter_actioneur">Affecter un Actioneur</A></li>
<li><A HREF="./index.php?page=administration&detail=affecter_conso_elec">Affecter une conso-elec</A></li>
<li><A HREF="./index.php?page=administration&detail=gerer_users">Gerer les utilisarteurs</A></li>
<li><A HREF="./index.php?page=administration&detail=gerer_modules">Gerer les modules</A></li>
</div>
<div id="action">
<?
if(isset($_GET['detail'])){
include("./pages/".$_GET['detail'].".php");
} else {
include("./pages/gerer_pieces.php");
}
?>
</div>
</center>
<? //</div>
?>
