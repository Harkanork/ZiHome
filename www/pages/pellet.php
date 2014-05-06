<?
if(isset($_GET['add'])) {
  $query0 = "INSERT INTO `pellet` (date) VALUES (now())";
  mysql_query($query0, $link);
} else {
include("./fonctions/pellet_tableau_periph.php");
include("./fonctions/pellet_graph_mois.php");
include("./fonctions/pellet_graph_annee.php");
}
?>
<script src="./js/highcharts.js"></script>
<script src="./config/conf_highcharts.js"></script>
