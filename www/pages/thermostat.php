<?php
if(isset($_SESSION['auth']))
{
include("./lib/zibase.php");
$zibase = new ZiBase($ipzibase);
if(isset($_POST['Valider'])) {
$cal = new ZbCalendar();
for ($j = 0; $j < 24; $j++) {
if($_POST[$j] == 'on'){
$val = 1;
} else {
$val = 0;
}
$cal->hour[$j] = $val;
}
if($_POST['lundi'] == 'on'){
$lundi = 1;
} else {
$lundi = 0;
}
if($_POST['mardi'] == 'on'){
$mardi = 1;
} else {
$mardi = 0;
}
if($_POST['mercredi'] == 'on'){
$mercredi = 1;
} else {
$mercredi = 0;
}
if($_POST['jeudi'] == 'on'){
$jeudi = 1;
} else {
$jeudi = 0;
}
if($_POST['vendredi'] == 'on'){
$vendredi = 1;
} else {
$vendredi = 0;
}
if($_POST['samedi'] == 'on'){
$samedi = 1;
} else {
$samedi = 0;
}
if($_POST['dimanche'] == 'on'){
$dimanche = 1;
} else {
$dimanche = 0;
}
$cal->day['lundi'] = $lundi;
$cal->day['mardi'] = $mardi;
$cal->day['mercredi'] = $mercredi;
$cal->day['jeudi'] = $jeudi;
$cal->day['vendredi'] = $vendredi;
$cal->day['samedi'] = $samedi;
$cal->day['dimanche'] = $dimanche;
$zibase->setCalendar($_POST['id'],$cal);
}
if(isset($_POST['Modifier_vcj'])) {
$zibase->setVariable($_POST['id'],$_POST['temperature']*10);
}
if(isset($_POST['Modifier_vcn'])) {
$zibase->setVariable($_POST['id'],$_POST['temperature']*10);
}
if(isset($_POST['Modifier_mode'])) {
$zibase->setVariable($_POST['id'],$_POST['mode']);
}

$thermostat=$zibase->getThermostat($idzibase,$tokenzibase);
$thermostatnb = count($thermostat);
$i = 1;
while($i <= $thermostatnb) {

echo "<p align=center>".$thermostat[$i]['0']."</p>";

echo "<p align=center>Temperature d'entree : ".(($zibase->getVariable($thermostat[$i]['3']))/10)."&deg;</p>";
?> <FORM method="post" action="./index.php?page=thermostat"> <?
echo "<p align=center>Consigne de jour : ".(($zibase->getVariable($thermostat[$i]['4']))/10)."&deg; ";
?>
<INPUT TYPE="HIDDEN" NAME="id" VALUE="<? echo $thermostat[$i]['4']; ?>">
<INPUT TYPE="text" size="3" NAME="temperature" VALUE="<? echo (($zibase->getVariable($thermostat[$i]['4']))/10); ?>">
<INPUT TYPE="SUBMIT" NAME="Modifier_vcj" VALUE="Valider">
</p></FORM>
<FORM method="post" action="./index.php?page=thermostat">
<?
echo "<p align=center>Consigne de nuit : ".(($zibase->getVariable($thermostat[$i]['6']))/10)."&deg; ";
?>
<INPUT TYPE="HIDDEN" NAME="id" VALUE="<? echo $thermostat[$i]['6']; ?>">
<INPUT TYPE="text" size="3" NAME="temperature" VALUE="<? echo (($zibase->getVariable($thermostat[$i]['6']))/10); ?>">
<INPUT TYPE="SUBMIT" NAME="Modifier_vcn" VALUE="Valider">
</p></FORM>
<?
echo "<p align=center>Hysteresis : ".$thermostat[$i]['8']."</p>";
echo "<p align=center>Actif : ".(($zibase->getVariable($thermostat[$i]['10']))/10)."</p>";
echo "<center><p align=center>Mode : <br>";
?>
<FORM method="post" action="./index.php?page=thermostat">
<input type="radio" name="mode" value="0"<? if($zibase->getVariable($thermostat[$i]['5']) == "0") { echo " checked"; } ?>>Auto | 
<input type="radio" name="mode" value="16"<? if($zibase->getVariable($thermostat[$i]['5']) == "16") { echo " checked"; } ?>>Jour | 
<input type="radio" name="mode" value="32"<? if($zibase->getVariable($thermostat[$i]['5']) == "32") { echo " checked"; } ?>>Jour temporaire | 
<input type="radio" name="mode" value="6"<? if($zibase->getVariable($thermostat[$i]['5']) == "6") { echo " checked"; } ?>>Hor gel | 
<input type="radio" name="mode" value="48"<? if($zibase->getVariable($thermostat[$i]['5']) == "48") { echo " checked"; } ?>>Nuit | 
<input type="radio" name="mode" value="64"<? if($zibase->getVariable($thermostat[$i]['5']) == "64") { echo " checked"; } ?>>Nuit temporaire | 
<input type="radio" name="mode" value="5"<? if($zibase->getVariable($thermostat[$i]['5']) == "5") { echo " checked"; } ?>>Stop
<INPUT TYPE="HIDDEN" NAME="id" VALUE="<? echo $thermostat[$i]['5']; ?>">
<INPUT TYPE="SUBMIT" NAME="Modifier_mode" VALUE="Valider">
</FORM></p></center>
<?
for ($k = 0; $k < 3; $k++) {
$calendrier=$zibase->getCalendar($thermostat[$i]['7']+$k);
echo "<center>Calendrier Numero ".($thermostat[$i]['7']+$k)."</center>";
?>
<center><p align="center"><form method="post" action="./index.php?page=thermostat">
<?
for ($j = 0; $j < 24; $j++) {
if($j > 0 && $j <> 13) { echo " | "; }
if($j == 13) { echo "<br>"; }
?>
<? echo $j; ?>h <input type=checkbox name=<? echo $j; if($calendrier->hour[$j] == 1) { ?> Checked<? } ?>>
<? } ?>
<BR>
Lundi <input type=checkbox name=lundi<? if($calendrier->day['lundi'] == 1) { ?> Checked<? } ?>>
 | Mardi <input type=checkbox name=mardi<? if($calendrier->day['mardi'] == 1) { ?> Checked<? } ?>>
 | Mercredi <input type=checkbox name=mercredi<? if($calendrier->day['mercredi'] == 1) { ?> Checked<? } ?>>
 | Jeudi <input type=checkbox name=jeudi<? if($calendrier->day['jeudi'] == 1) { ?> Checked<? } ?>>
 | Vendredi <input type=checkbox name=vendredi<? if($calendrier->day['vendredi'] == 1) { ?> Checked<? } ?>>
 | Samedi <input type=checkbox name=samedi<? if($calendrier->day['samedi'] == 1) { ?> Checked<? } ?>>
 | Dimanche <input type=checkbox name=dimanche<? if($calendrier->day['dimanche'] == 1) { ?> Checked<? } ?>>
<INPUT TYPE="HIDDEN" NAME="id" VALUE="<? echo $thermostat[$i]['7']+$k; ?>">
<br>
<INPUT TYPE="SUBMIT" NAME="Valider" VALUE="Valider">
</form></p></center>
<?
}
$i++;
}
}
?>
