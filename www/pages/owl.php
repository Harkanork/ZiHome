<title>Consommation Electrique</title>
<?php
echo "<CENTER><TABLE>";
echo "<TR><TD>";
include("./fonctions/owl_tableau_global.php");
include("./fonctions/owl_batterie.php");
echo "</TD></TR></TABLE>";
echo "<CENTER><A HREF=\"./index.php?page=owl&delai=heure\">Heure</A> , <A HREF=\"./index.php?page=owl&delai=jour\">Jour</A></CENTER>";
include("./fonctions/owl_phases_graph.php");
include("./fonctions/owl_global.php");
include("./fonctions/owl_global_month.php");
?>
<script src="./js/highcharts.js"></script>
