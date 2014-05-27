<title>Vent</title>
<?php
include("./fonctions/vent_tableau_global.php");
$query = "SELECT * FROM peripheriques WHERE periph = 'vent' ORDER BY ordre";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($periph = mysql_fetch_assoc($req))
{
$width = "100%";
$height = "400px";
include("./fonctions/vent_graph_jour.php");
$width = "1200px";
$height = "800px";
include("./fonctions/vent_graph_rosedesvents.php");
}
?>
<script src="./js/highcharts.js"></script>
<script src="./js/highcharts-more.js"></script>
<script src="./js/modules/data.js"></script>
<script src="./js/modules/exporting.js"></script>
<script src="./config/conf_highcharts.js"></script>
