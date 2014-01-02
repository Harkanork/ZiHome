<title>Consommation Electrique</title>
<?php
include("./fonctions/conso_elec_tableau_global.php");
?>
<script type="text/javascript">
$(document).ready(function() {
  $("#global").tabs();
});
</script>
<div id="global">
<ul style="width:100%;">
<?
$query = "SELECT * FROM peripheriques WHERE periph = 'conso'";
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

include("./fonctions/conso_elec_tableau_periph.php");
include("./fonctions/conso_elec_graph_journee.php");
include("./fonctions/conso_elec_graph_mois.php");
include("./fonctions/conso_elec_graph_annee.php");
?>
</div>
<?php } ?>
</div>
<script src="./js/highcharts.js"></script>
