<?php
if (isset($_GET['requete'])) { // si le script est bien appelé par ajax en precisant l'objet de la requête
  include("../config/conf_zibase.php");
  include("../config/variables.php");
  include("../lib/zibase.php");
  include_once("../lib/date_francais.php");
  




if(isset($_SESSION['auth']))
{
$do = "uptime";
include('../pages/freebox-cmd.php');
}




}
?>
