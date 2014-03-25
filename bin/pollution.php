<?php
include("conf_scripts.php");
include("utils.php");

// Au prealable rechercher une ville dans le fichier http://www.lcsqa.org/surveillance/indices/prevus/jour/xml

//Url a parser
$now = date('Y-m-d');
$lcsqa = simplexml_load_file("http://www.lcsqa.org/surveillance/indices/prevus/jour/xml/".$now); 

// Recuperation des donnees
$result = $lcsqa->xpath("node[agglomeration='".$pollution_ville."']"); 

if (count($result) > 0)
{
  // connexion a la base
  $link = mysql_connect($hote, $login, $plogin);
  if (!$link) 
  {
    die('Non connect&eacute; : ' . mysql_error());
  }
  
  $db_selected = mysql_select_db($base,$link);
  if (!$db_selected) {
     die ('Impossible d\'utiliser la base : ' . mysql_error());
  }
  
  $query = "SELECT * FROM pollution WHERE date = '".$now."'";
  $res = mysql_query($query, $link);
  if (mysql_numrows($res) > 0)
  {
    // Nous avons deja recu une valeur, donc, il faut juste mettre a jour
    $query = "UPDATE pollution SET Indice= '".$result[0]->valeurIndice."', O3='".$result[0]->SousIndiceO3."', NO2='".$result[0]->SousIndiceNO2."', PM10='".$result[0]->SousIndicePM10."', SO2='".$result[0]->SousIndiceSO2."' WHERE date = '".$now."'";
    mysql_query($query, $link);
  }
  else
  {
    // Insertion des valeurs
    $query = "INSERT INTO pollution (date, Indice, O3, NO2, PM10, SO2) VALUES ('".$now."', '".$result[0]->valeurIndice."', '".$result[0]->SousIndiceO3."', '".$result[0]->SousIndiceNO2."', '".$result[0]->SousIndicePM10."', '".$result[0]->SousIndiceSO2."')";
    mysql_query($query, $link);
  }
}
else
{
  echo "Pas de resultat pour '" . $pollution_ville . "'\n";
}
?>
