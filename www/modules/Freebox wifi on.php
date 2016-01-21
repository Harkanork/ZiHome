<?php
if (isset($_GET['requete'])) { // si le script est bien appelé par ajax en precisant l'objet de la requête
  include("../config/conf_zibase.php");
  include("../config/variables.php");
  include("../lib/zibase.php");
  include_once("../lib/date_francais.php");





if(isset($_SESSION['auth']))
{
if(isset($_POST['wifi_on'])) {
$do = "wifi_on";
include('../pages/freebox-cmd.php');
echo "<meta http-equiv=\"refresh\" content=\"0; url=../index.php?page=".$_GET['page']."\">";
}
?>
<form method="post" action="../index.php?page=freebox">
<input type="submit" name="wifi_on" value="WIFI ON"></input>
</form>
<?
}


}
?>
