<title>Temperature</title>
<?php
include("./fonctions/temperature_tableau_global.php");
?>
<br>
<script type="text/javascript">
$(document).ready(function() {
  $("#global").tabs();
});
</script>
<div id="global">
<ul style="width:100%;">
<?
$query = "SELECT * FROM peripheriques WHERE periph = 'temperature'";
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
$width = "98%";
$height = "400px";
include("./fonctions/temperature_graph_jour.php");
include("./fonctions/temperature_graph_mois.php");
include("./fonctions/temperature_graph_annee.php");
?>
</div>
<?php } ?>
</div>
<script src="./js/highcharts.js"></script>
<script src="./js/highcharts-more.js"></script>
