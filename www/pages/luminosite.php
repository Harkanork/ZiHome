<title>luminosite</title>
<?php
include("./fonctions/luminosite_tableau_global.php");
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
$query = "SELECT * FROM peripheriques WHERE periph = 'luminosite' ORDER BY ordre";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
  if ($data['libelle'] == ""){
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
  $width = "98%";
  $height = "400px";
  include("./fonctions/luminosite_graph_jour.php");
  include("./fonctions/luminosite_graph_mois.php");
  include("./fonctions/luminosite_graph_annee.php");
?>
</div>
<?php } ?>
</div>
<script src="./js/highcharts.js"></script>
<script src="./js/highcharts-more.js"></script>
<script src="./config/conf_highcharts.js"></script>
