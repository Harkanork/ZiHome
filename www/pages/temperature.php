<title>Temp&eacuterature</title>
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
$query = "SELECT * FROM peripheriques WHERE periph = 'temperature' ORDER BY ordre";
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
  include("./fonctions/temperature_graph_jour.php");
  include("./fonctions/temperature_graph_mois.php");
  include("./fonctions/temperature_graph_annee.php");
?>
</div>
<?php } ?>
</div>
<script src="./js/highcharts.js"></script>
<script src="./js/highcharts-more.js"></script>
<script src="./js/modules/data.js"></script>
<script src="./js/modules/exporting.js"></script>
<script src="./config/conf_highcharts.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
  <?
    // Construction des liens entre les lignes et les tabs
    $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while ($periph = mysql_fetch_assoc($req))
    {
      echo "$('#TR_".$periph['id']."').click( function()";
      echo " { ";
      echo "   $(\"#global\").tabs(\"option\", \"active\", $(\"#onglet-".$periph['id']."\").index() - 1);";
      echo "   return false;";
      echo " });";
      echo "$('#TR_".$periph['id']."').css( 'cursor', 'pointer' );";
    }
  ?>
  });
</script>
