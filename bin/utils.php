<?php

/**
 * Analyse les changements d'etat de la batterie
 * @param $pSqlInfo l'etat du capteur dans la base de donnee
 * @param $pZibaseInfo l'etat du capteur dans la zibase
 * @return la liste des parametres a mettre a jour
 */
function updateBattery($pSqlInfo, $pZibaseInfo)
{
  $query = array();
  
  $update_alerte_batterie = false;
  $update_date_chgt_batterie = false;
  
  if ($pZibaseInfo[3] != '' && $pSqlInfo['batterie'] != $pZibaseInfo[3])
  {
    // L'etat des batteries a change
    if ($pZibaseInfo[3] == 1)
    {
      // Les piles sont usees
      // Mise a jour de la date uniquement si necessaire
      if ($pSqlInfo['alerte_batterie'] == "0000-00-00 00:00:00") 
      {
        $today = getdate();
        $alerte_batterie = $today['year']."-".$today['mon']."-".$today['mday']." ".$today['hours'].":".$today['minutes'].":".$today['seconds'];
        $update_alerte_batterie = true;
      }
    }
    else
    {
      // Les piles ont ete changee
      $alerte_batterie = "0000-00-00 00:00:00";
      $update_alerte_batterie = true;
      $today = getdate();
      $date_chgt_batterie = $today['year']."-".$today['mon']."-".$today['mday'];
      $update_date_chgt_batterie = true;
    }
    
    array_push($query, " batterie = '".$pZibaseInfo[3]."' ");
  }
  
  if ($update_alerte_batterie)
  {
    array_push($query, " alerte_batterie = '".$alerte_batterie."' ");
  }
  if ($update_date_chgt_batterie)
  {
    array_push($query, " date_chgt_batterie = '".$date_chgt_batterie."' ");
  } 
  
  return $query;
}

/**
 * Cree ou met a jour un capteur
 * @param $pSensorInfo descriptif du capteur venant de la zibase
 * @param $pZibaseInfo l'etat du capteur dans la zibase
 * @param $pLink lien vers la base de donnee
 * @param $pType type du capteur
 */
function updateSensor($pSensorInfo, $pZibaseInfo, $pLink, $pType)
{
  $queryDB = "SELECT * FROM peripheriques WHERE nom = '".$pSensorInfo['n']."'";
  $res_queryDB = mysql_query($queryDB, $pLink);
  if (mysql_numrows($res_queryDB) > 0)
  {
    // Le capteur existe deja en base
    $data = mysql_fetch_assoc($res_queryDB);
    
    // Construit la liste des attributs a mettre a jour
    $updatedValues = array();
    if ($pSensorInfo['c'] != $data['id'])
    {
      array_push($updatedValues, " id = '".$pSensorInfo['c']."' ");
    }
    if ($pSensorInfo['i'] != $data['logo'])
    {
      array_push($updatedValues, " logo = '".$pSensorInfo['i']."' ");
    }
    // analyse des attributs lies a la batterie
    $updatedValues = array_merge($updatedValues, updateBattery($data, $pZibaseInfo));
    
    // Envoie de la requete uniquement si necessaire
    if (count($updatedValues) > 0)
    {
      $query = "UPDATE peripheriques SET ";
      $query = $query . implode(", ", $updatedValues);
      $query = $query . " WHERE nom = '".$pSensorInfo['n']."'";
      // echo $query . "\n";
      mysql_query($query, $pLink);
    }
  }
  else
  {
    // Nouveau capteur
    $query = "INSERT INTO peripheriques (periph, nom, id) VALUES ('".$pType."', '".$pSensorInfo['n']."', '".$pSensorInfo['c']."')";
    mysql_query($query, $pLink);
    
    // Appel a nouveau la fonction pour mettre a jour les autres champs
    updateSensor($pSensorInfo, $pZibaseInfo, $pLink, $pType);
  }
}

/**
 * Cree ou met a jour une sonde
 * @param $pSensorInfo descriptif du capteur venant de la zibase
 * @param $pZibaseInfo l'etat du capteur dans la zibase
 * @param $pLink lien vers la base de donnee
 * @param $pType type du capteur
 */
function updateProbe($pSensorInfo, $pZibaseInfo, $pLink, $pType)
{
  $queryDB = "SELECT * FROM peripheriques WHERE nom = '".$pSensorInfo['name']."'";
  $res_queryDB = mysql_query($queryDB, $pLink);
  if (mysql_numrows($res_queryDB) > 0)
  {
    // Le capteur existe deja en base
    $data = mysql_fetch_assoc($res_queryDB);

    // Construit la liste des attributs a mettre a jour
    $updatedValues = array();
    if ($pSensorInfo['id'] != $data['id'])
    {
      array_push($updatedValues, " id = '".$pSensorInfo['id']."' ");
    }
    if ($pSensorInfo['icon'] != $data['logo'])
    {
      array_push($updatedValues, " logo = '".$pSensorInfo['icon']."' ");
    }
    if(isset($pSensorInfo['protocol']))
    {
      if ($pSensorInfo['protocol'] != $data['protocol'])
      {
        array_push($updatedValues, " protocol = '".$pSensorInfo['protocol']."' ");
      }
    }
    // analyse des attributs lies a la batterie
    $updatedValues = array_merge($updatedValues, updateBattery($data, $pZibaseInfo));

    // Envoie de la requete uniquement si necessaire
    if (count($updatedValues) > 0)
    {
      $query = "UPDATE peripheriques SET ";
      $query = $query . implode(", ", $updatedValues);
      $query = $query . " WHERE nom = '".$pSensorInfo['name']."'";
      // echo $query . "\n";
      mysql_query($query, $pLink);
    }
  }
  else
  {
    // Nouveau capteur
    $query = "INSERT INTO peripheriques (periph, nom, id) VALUES ('".$pType."', '".$pSensorInfo['name']."', '".$pSensorInfo['id']."')";
    mysql_query($query, $pLink);

    // Appel a nouveau la fonction pour mettre a jour les autres champs
    updateProbe($pSensorInfo, $pZibaseInfo, $pLink, $pType);
  }
}

?>
