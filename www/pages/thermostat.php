<?php
if(isset($_SESSION['auth']))
{
include("./pages/conf_zibase.php");
include("./lib/zibase.php");
$zibase = new ZiBase($ipzibase);
if(isset($_POST['Modifier_vcj'])) {
$zibase->setVariable($_POST['id'],$_POST['temperature']*10);
}
if(isset($_POST['Modifier_vcn'])) {
$zibase->setVariable($_POST['id'],$_POST['temperature']*10);
}


$thermostat=$zibase->getThermostat($idzibase,$tokenzibase);
$thermostatnb = count($thermostat);
$i = 1;
while($i <= $thermostatnb) {

echo "<p align=center>".$thermostat[$i]['nom']."</p>";

echo "<p align=center>Temperature d'entree : ".(($zibase->getVariable($thermostat[$i]['ve']))/10)."&deg;</p>";
?> <FORM method="post" action="./index.php?page=thermostat"> <?
echo "<p align=center>Consigne de jour : ".(($zibase->getVariable($thermostat[$i]['vcj']))/10)."&deg; ";
?>
<INPUT TYPE="HIDDEN" NAME="id" VALUE="<? echo $thermostat[$i]['vcj']; ?>">
<INPUT TYPE="text" size="3" NAME="temperature" VALUE="<? echo (($zibase->getVariable($thermostat[$i]['vcj']))/10); ?>">
<INPUT TYPE="SUBMIT" NAME="Modifier_vcj" VALUE="Modifier">
</p></FORM>
<FORM method="post" action="./index.php?page=thermostat">
<?
echo "<p align=center>Consigne de nuit : ".(($zibase->getVariable($thermostat[$i]['vcn']))/10)."&deg; ";
?>
<INPUT TYPE="HIDDEN" NAME="id" VALUE="<? echo $thermostat[$i]['vcn']; ?>">
<INPUT TYPE="text" size="3" NAME="temperature" VALUE="<? echo (($zibase->getVariable($thermostat[$i]['vcn']))/10); ?>">
<INPUT TYPE="SUBMIT" NAME="Modifier_vcn" VALUE="Modifier">
</p></FORM>
<?
echo "<p align=center><a href=./index.php?page=calendrier&cal=".$thermostat[$i]['cal'].">Calendrier</a></p>";
echo "<p align=center>Hysteresis : ".$thermostat[$i]['h']."</p>";
echo "<p align=center>Actif : ".(($zibase->getVariable($thermostat[$i]['vs']))/10)."</p>";

$i++;
}
}
?>
