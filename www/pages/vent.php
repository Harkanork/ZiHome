<title>Vent</title>
<?php
include("./fonctions/vent_tableau_global.php");
$query = "SELECT * FROM peripheriques WHERE periph = 'vent'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
include("./fonctions/vent_graph_jour.php");
include("./fonctions/vent_graph_rosedesvents.php");
}
?>
<script src="./js/highcharts.js"></script>
<script src="./js/highcharts-more.js"></script>
<script src="./js/modules/data.js"></script>
<script src="./js/modules/exporting.js"></script>
