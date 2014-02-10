<title>Pluie</title>
<div id="global">
<?
include("./fonctions/pluie_tableau_global.php");
$query = "SELECT * FROM peripheriques WHERE periph = 'pluie'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($periph = mysql_fetch_assoc($req))
{
$width = "100%";
$height = "400px";

include("./fonctions/pluie_graph_global.php");
include("./fonctions/pluie_graph_mois.php");
include("./fonctions/pluie_graph_annee.php");
}
?>
</div>
<script src="./js/highcharts.js"></script>
<script src="./config/conf_highcharts.js"></script>
