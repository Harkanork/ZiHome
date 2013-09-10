<?
session_start();
include("./pages/head.php");
include("./pages/logon.php");
?>
<P ALIGN=CENTER><A HREF="./index.php?page=conso_elec">Consomation electrique</A></P>
<P ALIGN=CENTER><A HREF="./index.php?page=temperature">Temperature</A></P>
<P ALIGN=CENTER><A HREF="./index.php?page=batterie">Niveau Batteries</A></P>
<P ALIGN=CENTER><A HREF="./index.php?page=plan">Plan</A></P>
<?
if(isset($_SESSION['auth']))
{
?>
<P ALIGN=CENTER><A HREF="./index.php?page=gerer_pieces">Gerer les pieces du plan</A></P>
<P ALIGN=CENTER><A HREF="./index.php?page=affecter_sonde">Affecter une sonde de temperature a une piece du plan</A></P>
<P ALIGN=CENTER><A HREF="./index.php?page=affecter_actioneur">Affecter un Actioneur a une piece du plan</A></P>
<P ALIGN=CENTER><A HREF="./index.php?page=affecter_conso_elec">Affecter une sonde de consomation electrique a une piece du plan</A></P>
<?
}
if(isset($_GET['page'])){
include("./pages/".$_GET['page'].".php");
} else {
include("./pages/plan.php");
}
?>
