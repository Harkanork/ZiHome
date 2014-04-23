<?php
if(isset($_SESSION['auth']))
{
//echo 'ON RECUPERE LE XML';
require_once('./lib/freebox.php');

// Liste de caractères interdits dans un fichier XML
$char_interdit_xml = array("!","\"","#","$","%","&","'","(",")","*","+",",","/",";","<","=",">","?","@","[","\\","]","^","`","{","|","}","~");

// Instantation de la classe PHP Freebox pour l'authentification (obligatoire)
$freebox = new apifreebox($config);
$xmlfreebox = $freebox->config_to_XML();

  echo "<div align=center style=\"margin: 30px;\">";
  include('./fonctions/freebox_firmware.php');
  echo "</div><div align=center style=\"margin: 30px;\">Status de connexion :<br>";
  include('./fonctions/freebox_conn_status.php');
  echo "<div align=center style=\"margin: 30px;\">Status du WIFI :<br>";
  include('./fonctions/freebox_wifi_status.php');
  echo "</div><div align=center style=\"margin: 30px;\">Activer le WIFI :<br>";
  include('./fonctions/freebox_wifi_on.php');
  echo "</div><div align=center style=\"margin: 30px;\">Arrêter le WIFI :<br>";
  include('./fonctions/freebox_wifi_off.php');
  echo "</div><div align=center style=\"margin: 30px;\">Baux DHCP :<br>";
  include('./fonctions/freebox_dhcp_baux_dynamique.php');
  echo "</div><div align=center style=\"margin: 30px;\">Liste des appels :<br>";
  include('./fonctions/freebox_call.php');
  // echo "</div><div align=center style=\"margin: 30px;\">Redémarrer la Freebox :<br>";
  // include('./fonctions/freebox_reboot.php');
  // echo "</div><div align=center style=\"margin: 30px;\">Faire sonner le téléphone :<br>";
  // include('./fonctions/freebox_ring_on.php');
  // echo "</div><div align=center style=\"margin: 30px;\">Stopper la sonnerie du téléphone :<br>";
  // include('./fonctions/freebox_ring_off.php');

}
?>
