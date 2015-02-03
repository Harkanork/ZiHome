<title>Consommation Eau</title>
<br>
<script type="text/javascript">
$(document).ready(function() {
  $("#global").tabs();
});
</script>
<div id="global">
<ul style="width:100%;">
<?
$query = "SELECT * FROM peripheriques WHERE periph = 'eau' ORDER BY ordre";
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

include("./fonctions/conso_eau_tableau_periph.php");
$graphInterval = 16;
include("./fonctions/conso_eau_graph.php");
?>
</div>
<?php } ?>
</div>
<script src="./js/highstock.js"></script>
<script src="./config/conf_highstock.js"></script> 
<script src="./js/modules/exporting.js"></script> 


