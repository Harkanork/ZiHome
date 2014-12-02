<title>Consommation Electrique</title>
<br>
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
$query = "SELECT * FROM peripheriques WHERE periph = 'conso' ORDER BY ordre";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
if($data['libelle'] == ""){
$nom = $data['nom'];
} else {
$nom = $data['libelle'];
}
?>
<li><a href="#onglet-<? echo $data['id']; ?>"><? echo $nom; ?></a></li>
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
include("./fonctions/conso_elec_graph_puissance.php");
?>
<br/>
<?
include("./fonctions/conso_elec_graph_conso_cout.php");
?>
</div>
<?php } ?>
</div>
<script src="./js/highstock.js"></script>
<script src="./config/conf_highstock.js"></script> 
<script src="./js/modules/exporting.js"></script> 


