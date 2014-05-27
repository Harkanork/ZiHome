<title>Actionneurs</title>
<?php
function duree($time) {
if($time < 60) { return $time."s"; }
else if($time < 3600) { return intval($time/60)."m ".($time - (intval($time/60) * 60))."s"; }
else if($time < 86400) { return intval($time/3600)."h ".intval(($time - (intval($time/3600) * 3600))/60)."m ".($time - (intval($time/60) * 60))."s"; }
else { return intval($time/86400)."j ".intval(($time - (intval($time/86400) * 86400))/3600)."h ".intval(($time - (intval($time/3600) * 3600))/60)."m ".($time - (intval($time/60) * 60))."s"; }
}
include("./lib/zibase.php");
$zibase = new ZiBase($ipzibase);
include("./fonctions/actionneurs_tableau_global.php");
include("./fonctions/capteurs_tableau_global.php");
?>
<script type="text/javascript">
$(document).ready(function() {
  $("#global").tabs();
});
</script>
<div id="global">
<ul style="width:100%;">
<?
$query = "SELECT * FROM peripheriques WHERE periph = 'actioneur' OR periph = 'capteur' ORDER BY ordre";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
?>
<li><a href="#onglet-<? echo $data['id']; ?>"><? echo $data['nom']; ?></a></li>
<?
}
?>
</ul>
<?
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($periph = mysql_fetch_assoc($req))
{
?>
<div id="onglet-<? echo $periph['id']; ?>" style="width:100%;">
<?
$width = "100%";
$height = "400px";
if(isset($_SESSION['auth'])) 
{
  if($periph['periph'] == 'actioneur')
  {
    include("./fonctions/actioneur.php");
  }
}
include("./fonctions/actionneur_tableau_periph.php");
include("./fonctions/actionneur_graph_mois.php");
include("./fonctions/actionneur_graph_annee.php");
?>
</div>
<?php } ?>
</div>
<script src="./js/highcharts.js"></script>
<script src="./config/conf_highcharts.js"></script>

