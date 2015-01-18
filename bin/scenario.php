<?php
include("conf_scripts.php");
include("utils.php");

// recuperation de la liste des scenarios de la zibase
$zibase = new ZiBase($ipzibase);
$actionlist = $zibase->getScenarioList($idzibase,$tokenzibase);

$actionnb = count($actionlist);

$link = mysql_connect($hote,$login,$plogin);
if (!$link) {
   die('Non connect&eacute; : ' . mysql_error());
}
$db_selected = mysql_select_db($base,$link);
if (!$db_selected) {
   die ('Impossible d\'utiliser la base : ' . mysql_error());
}

// map Id => scenario
$mapId = array();
// map nom => scenario
$mapNom = array();

// recuperation de la liste des scenarios de ZiHome
$query = "SELECT * FROM scenarios";
$res_queryDB = mysql_query($query, $link);
while ($data = mysql_fetch_assoc($res_queryDB))
{
  $mapId[$data['id']] = $data;
  $mapNom[$data['nom']] = $data;
}

// recuperation des scenarios ayant change d'id
$i = 0;
while($i < $actionnb) 
{
  $nom = $actionlist[$i]['n'];
  if (array_key_exists($nom, $mapNom))
  {
    if ($mapNom[$nom]['id'] != $actionlist[$i]['id'])
    {
//      echo "Modifie id " . $mapNom[$nom]['id'] . " => " .$actionlist[$i]['id'] . "\n";
      // Modifie l'id
      $query = "UPDATE scenarios set id='" .$actionlist[$i]['id']."' where nom='".$nom."'";
      mysql_query($query, $link);
      
      // L'id n'est plus le bon
      unset($mapId[$mapNom[$nom]['id']]);
      unset($mapId[$actionlist[$i]['id']]);
    }
    
    // On fait disparaitre le scenario qui a ete traite 
    unset($mapNom[$nom]);
  }
  $i++;
}

// recuperation des scenarios ayant change de nom et rajout des nouveaux scenarios
$i = 0;
while($i < $actionnb) 
{
  $id = $actionlist[$i]['id'];
  if (array_key_exists($id, $mapId))
  {
    if ($mapId[$id]['nom'] != $actionlist[$i]['n'])
    {
//      echo "Modifie nom (" . $id . ") " . $mapId[$id]['nom'] . " => " .$actionlist[$i]['n'] . "\n";
      // Modifie le nom
      $query = "UPDATE scenarios set nom='" .$actionlist[$i]['n']."' where id='".$id."'";
      mysql_query($query, $link);
      
      // Le nom n'est plus le bon
      unset($mapNom[$mapId[$id]['nom']]);
    }
    
    // On fait disparaitre le scenario qui a ete traite 
    unset($mapId[$id]);
  }
  else
  {
    // rajoute le nouveau scenario
//    echo "Nouveau " . $actionlist[$i]['n'] . "\n";
    $query = "INSERT INTO scenarios (nom, id, logo) VALUES ('".$actionlist[$i]['n']."', '".$actionlist[$i]['id']."', '".$actionlist[$i]['icon']."')";
    mysql_query($query, $link);
  }
  $i++;
}

// Supression des scenarios qui sont dans la base et que l'on n'a pas trouve sur la ZiBase
foreach($mapId as $key => $value) 
{
//  echo "Supprimer " . $value['id'] . "\n";
  $query = "DELETE FROM scenarios where id='".$value['id']."'";
  mysql_query($query, $link);
}

// Supression des scenarios qui sont dans la base et que l'on n'a pas trouve sur la ZiBase
foreach($mapNom as $key => $value) 
{
//  echo "Supprimer " . $value['nom'] . "\n";
  $query = "DELETE FROM scenarios where nom='".$value['nom']."'";
  mysql_query($query, $link);
}

?>
