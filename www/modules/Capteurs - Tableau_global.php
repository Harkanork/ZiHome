<?php
if (isset($_GET['requete'])) { // si le script est bien appelé par ajax en precisant l'objet de la requête

  include("../config/conf_zibase.php");
  include("../config/variables.php");
  include("../lib/zibase.php");
  $zibase = new ZiBase($ipzibase);
  include_once("../lib/date_francais.php");
  
  $link = mysql_connect($hote,$login,$plogin);
  if (!$link) {
    die('Non connect&eacute; : ' . mysql_error());
  }
  $db_selected = mysql_select_db($base,$link);
  if (!$db_selected) {
    die ('Impossible d\'utiliser la base : ' . mysql_error());
  }


  
  $link = mysql_connect($hote,$login,$plogin);
  if (!$link) {
    die('Non connect&eacute; : ' . mysql_error());
  }
  $db_selected = mysql_select_db($base,$link);
  if (!$db_selected) {
    die ('Impossible d\'utiliser la base : ' . mysql_error());
  }

  $i=0;
  echo "<CENTER><TABLE width=300px>";
  echo "<TR class=tab-titre><TD></TD><TD>Capteur</TD><TD>Actif</TD></TR>";
  $query = "SELECT * FROM peripheriques WHERE periph = 'capteur'";
  $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while ($periph = mysql_fetch_assoc($req))
  {
    if($periph['protocol'] == 6) {
      $protocol = true;
    } else {
      $protocol = false;
    }
    $stateactif = $zibase->getState($periph['id'], $protocol);
    if($periph['batterie'] == 0)
    {
      $batterie = "";
    } else {
      $batterie = "<img src='./img/batterie_ko.png' style='height:20px'/>";
    }
    if ($periph['libelle'] == "") {
      $nom = $periph['nom'];
    } else {
      $nom = $periph['libelle'];
    }
    echo "<TR class=tab-ligne bgcolor='".( ($i % 2 == 1) ? '#dddddd' : '#eeeeee' )."' id='TR_".$periph['id']."'>";
    echo "  <TD>".$batterie."</TD>";
    echo "  <TD><span style='vertical-align:3px'>".$nom."</span></TD>";
    echo "  <TD ALIGN=CENTER>".$stateactif."</TD>";
    echo "</TR>";
    $i = $i + 1;
  }
  echo "</TABLE></CENTER>";
}
  ?>
