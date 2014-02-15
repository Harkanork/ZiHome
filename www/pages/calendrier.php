<?php
if(isset($_SESSION['auth']))
{
include("./config/conf_zibase.php");
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
for ($i = 1; $i <= 17; $i++) {
$calendrier=$zibase->getCalendar($i);
echo "<center><h2>Calendrier Numero ".$i."</h2></center>";
?>
<center><p align="center"><form method="post" action="./index.php?page=calendrier">
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
<INPUT TYPE="HIDDEN" NAME="id" VALUE="<? echo $i; ?>">
<br>
<INPUT TYPE="SUBMIT" NAME="Valider" VALUE="Valider">
</form></p></center>
<?
}
}
?>
