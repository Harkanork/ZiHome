<?
function generateDynInfo($vue, $parentDiv, $soleil)
{
  global $link;
  global $zibase;

?>
  <script>
    <?
    if (is_numeric($vue)) {  // Nouvelle version utilisant les "vues" 
      $queryStickers = "SELECT * FROM vues_elements where vue_id=".$vue." AND type='sticker'";
      $queryDynaTexts = "SELECT * FROM vues_elements where vue_id=".$vue." AND type='textdyn'";
      $reqStickers = mysql_query($queryStickers, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error()); 
      $reqDynaTexts = mysql_query($queryDynaTexts, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    
      // Optimisation : On ne genere les fonctions utilitaires et les tableaux de valeur que si c'est necesaire
      if (mysql_numrows($reqStickers) > 0 || mysql_numrows($reqDynaTexts) > 0) {
        ?>
        // Fonctions utilitaires
        var gTemperature = new Object();
        function temperature(nom) { return gTemperature[nom]; }
      
        var gHygrometrie = new Object();
        function hygrometrie(nom) { return gHygrometrie[nom]; }
      
        var gLuminosite = new Object();
        function luminosite(nom)  { return gLuminosite[nom]; }
      
        var gVitesseVent = new Object();
        function vitesseVent(nom) { return gVitesseVent[nom]; }
      
        var gDirectionVent = new Object();
        function directionVent(nom) { return gDirectionVent[nom]; }
      
        var gActionneur = new Object();
        function actionneur(nom) { return gActionneur[nom]; }
      
        var gConsoElec = new Object();
        function consoElec(nom) { return gConsoElec[nom]; }
      
        var gCapteur = new Object();
        function capteur(nom) { return gCapteur[nom]; }
      
        var gVariable = new Object();
        function variable(id) { return gVariable[id]; }
      
        var gSoleil = "";
        function nuit() { return !jour(); }
        function jour() { return gSoleil; } 
      
        <?
        if ($soleil == "nuit") {
          echo "gSoleil = false;";
        } else {
          echo "gSoleil = true;";
        }
        ?>
      
        <?
        // Construction des tableaux issus des capteurs de temperature
        $query = "SELECT * FROM peripheriques WHERE periph = 'temperature'";
        $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        while ($periph = mysql_fetch_assoc($req))
        {
          $query0 = "SELECT * FROM `temperature_".$periph['nom']."` ORDER BY `date` DESC LIMIT 1";
          $req0 = mysql_query($query0, $link);
          if ($req0 && mysql_numrows($req0) > 0)
          {
            $value0 = mysql_fetch_assoc($req0);
            echo 'gTemperature["' . $periph['nom'] . '"] = ' . $value0['temp'] . ';';
            echo 'gHygrometrie["' . $periph['nom'] . '"] = ' . $value0['hygro'] . ';';
          } 
        }
        
        // Construction des tableaux issues des capteurs de vent
        $query = "SELECT * FROM peripheriques WHERE periph = 'vent'";
        $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        while ($periph = mysql_fetch_assoc($req))
        {
          $query0 = "SELECT * FROM `vent_".$periph['nom']."` ORDER BY `date` DESC LIMIT 1";
          $req0 = mysql_query($query0, $link);
          if ($req0 && mysql_numrows($req0) > 0)
          {
            $value0 = mysql_fetch_assoc($req0);
            echo 'gDirectionVent["' . $periph['nom'] . '"] = "' . $value0['direction'] . '";';
            echo 'gVitesseVent["' . $periph['nom'] . '"] = ' . $value0['vitesse'] . ';';
          } 
        }
      
        // Construction des tableaux issues des capteurs de consommation electrique
        $query = "SELECT * FROM peripheriques WHERE periph = 'conso'";
        $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        while ($periph = mysql_fetch_assoc($req))
        {
          $query0 = "SELECT * FROM `conso_".$periph['nom']."` ORDER BY `date` DESC LIMIT 1";
          $req0 = mysql_query($query0, $link);
          if ($req0 && mysql_numrows($req0) > 0)
          {
            $value0 = mysql_fetch_assoc($req0);
            echo 'gConsoElec["' . $periph['nom'] . '"] = "' . $value0['conso'] . '";';
          } 
        }
      
        // Construction des tableaux issues des capteurs de luminosite
        $query = "SELECT * FROM peripheriques WHERE periph = 'luminosite'";
        $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        while ($periph = mysql_fetch_assoc($req))
        {
          $query0 = "SELECT * FROM `luminosite_".$periph['nom']."` ORDER BY `date` DESC LIMIT 1";
          $req0 = mysql_query($query0, $link);
          if ($req0 && mysql_numrows($req0) > 0)
          {
            $value0 = mysql_fetch_assoc($req0);
            echo 'gLuminosite["' . $periph['nom'] . '"] = "' . $value0['lum'] . '";';
          } 
        }
      
        // Construction des tableaux issues des actionneurs
        $query = "SELECT * FROM peripheriques WHERE periph = 'actioneur'";
        $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        while ($periph = mysql_fetch_assoc($req))
        {
          if ($periph['protocol'] == 6) 
          {
              $protocol = true;
          } 
          else 
          {
              $protocol = false;
          }
          echo 'gActionneur["' . $periph['nom'] . '"] = ' . $zibase->getState($periph['id'], $protocol) . ';';
        }
     
        // Construction des tableaux issues des capteurs
        $query = "SELECT * FROM peripheriques WHERE periph = 'capteur'";
        $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        while ($periph = mysql_fetch_assoc($req))
        {
          if ($periph['protocol'] == 6) 
          {
              $protocol = true;
          } 
          else 
          {
              $protocol = false;
          }
          if($protocol == true) 
          {
            echo 'gCapteur["' . $periph['nom'] . '"] = ' . $zibase->getState(substr($periph['id'], 1), $protocol) . ';';
          }
          else
          {
            echo 'gCapteur["' . $periph['nom'] . '"] = ' . $zibase->getState($periph['id'], $protocol) . ';';
          }
        }
      
        // Construction des tableaux issues des variables
        for ($i = 0; $i < 60; $i++) {
          echo 'gVariable[' . $i . '] = ' . $zibase->getVariable($i) . ';';
        }
      

      
        
      }
      ?>
      </script>
      <?

    } else { // ancienne version de la fonction, mode plan
        $queryStickers = "SELECT * FROM stickers where page='".$vue."'";
        $queryDynaTexts = "SELECT * FROM dynaText where page='".$vue."'";
    
    $reqStickers = mysql_query($queryStickers, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error()); 
    $reqDynaTexts = mysql_query($queryDynaTexts, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    
    // Optimisation : On ne genere les fonctions utilitaires et les tableaux de valeur uniquement si c'est necesaire
    if (mysql_numrows($reqStickers) > 0 || mysql_numrows($reqDynaTexts) > 0)
    {
      ?>
      // Fonctions utilitaires
      var gTemperature = new Object();
      function temperature(nom)
      {
        return gTemperature[nom]; 
      }
      
      var gHygrometrie = new Object();
      function hygrometrie(nom)
      {
        return gHygrometrie[nom]; 
      }
      
      var gLuminosite = new Object();
      function luminosite(nom)
      {
        return gLuminosite[nom]; 
      }
      
      var gVitesseVent = new Object();
      function vitesseVent(nom)
      {
        return gVitesseVent[nom]; 
      }
      
      var gDirectionVent = new Object();
      function directionVent(nom)
      {
        return gDirectionVent[nom]; 
      }
      
      var gActionneur = new Object();
      function actionneur(nom)
      {
        return gActionneur[nom]; 
      }
      
      var gConsoElec = new Object();
      function consoElec(nom)
      {
        return gConsoElec[nom]; 
      }
      
      var gCapteur = new Object();
      function capteur(nom)
      {
        return gCapteur[nom]; 
      }
      
      var gVariable = new Object();
      function variable(id)
      {
        return gVariable[id]; 
      }
      
      var gSoleil = "";
      function nuit()
      {
        return !jour();
      }
      
      function jour()
      {
        return gSoleil;
      } 
      
      <?
      
      if ($soleil == "nuit") 
      {
        echo "gSoleil = false;";
      } 
      else 
      {
        echo "gSoleil = true;";
      }
      ?>
      
      <?
      // Construction des tableaux issues des capteurs de temperature
      $query = "SELECT * FROM peripheriques WHERE periph = 'temperature'";
      $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
      while ($periph = mysql_fetch_assoc($req))
      {
        $query0 = "SELECT * FROM `temperature_".$periph['nom']."` ORDER BY `date` DESC LIMIT 1";
        $req0 = mysql_query($query0, $link);
        if ($req0 && mysql_numrows($req0) > 0)
        {
          $value0 = mysql_fetch_assoc($req0);
          echo 'gTemperature["' . $periph['nom'] . '"] = ' . $value0['temp'] . ';';
          echo 'gHygrometrie["' . $periph['nom'] . '"] = ' . $value0['hygro'] . ';';
        } 
      }
      ?>
      
      <?
      // Construction des tableaux issues des capteurs de vent
      $query = "SELECT * FROM peripheriques WHERE periph = 'vent'";
      $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
      while ($periph = mysql_fetch_assoc($req))
      {
        $query0 = "SELECT * FROM `vent_".$periph['nom']."` ORDER BY `date` DESC LIMIT 1";
        $req0 = mysql_query($query0, $link);
        if ($req0 && mysql_numrows($req0) > 0)
        {
          $value0 = mysql_fetch_assoc($req0);
          echo 'gDirectionVent["' . $periph['nom'] . '"] = "' . $value0['direction'] . '";';
          echo 'gVitesseVent["' . $periph['nom'] . '"] = ' . $value0['vitesse'] . ';';
        } 
      }
      ?>
      
      <?
      // Construction des tableaux issues des capteurs de consommation electrique
      $query = "SELECT * FROM peripheriques WHERE periph = 'conso'";
      $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
      while ($periph = mysql_fetch_assoc($req))
      {
        $query0 = "SELECT * FROM `conso_".$periph['nom']."` ORDER BY `date` DESC LIMIT 1";
        $req0 = mysql_query($query0, $link);
        if ($req0 && mysql_numrows($req0) > 0)
        {
          $value0 = mysql_fetch_assoc($req0);
          echo 'gConsoElec["' . $periph['nom'] . '"] = "' . $value0['conso'] . '";';
        } 
      }
      ?>
      
      <?
      // Construction des tableaux issues des capteurs de luminosite
      $query = "SELECT * FROM peripheriques WHERE periph = 'luminosite'";
      $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
      while ($periph = mysql_fetch_assoc($req))
      {
        $query0 = "SELECT * FROM `luminosite_".$periph['nom']."` ORDER BY `date` DESC LIMIT 1";
        $req0 = mysql_query($query0, $link);
        if ($req0 && mysql_numrows($req0) > 0)
        {
          $value0 = mysql_fetch_assoc($req0);
          echo 'gLuminosite["' . $periph['nom'] . '"] = "' . $value0['lum'] . '";';
        } 
      }
      ?>
      
      <?
      // Construction des tableaux issues des actionneurs
      $query = "SELECT * FROM peripheriques WHERE periph = 'actioneur'";
      $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
      while ($periph = mysql_fetch_assoc($req))
      {
        if ($periph['protocol'] == 6) 
        {
            $protocol = true;
        } 
        else 
        {
            $protocol = false;
        }
        echo 'gActionneur["' . $periph['nom'] . '"] = ' . $zibase->getState($periph['id'], $protocol) . ';';
      }
      ?>
      
      <?
      // Construction des tableaux issues des actionneurs
      $query = "SELECT * FROM peripheriques WHERE periph = 'capteur'";
      $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
      while ($periph = mysql_fetch_assoc($req))
      {
        if ($periph['protocol'] == 6) 
        {
            $protocol = true;
        } 
        else 
        {
            $protocol = false;
        }
        if($protocol == true) 
        {
          echo 'gCapteur["' . $periph['nom'] . '"] = ' . $zibase->getState(substr($periph['id'], 1), $protocol) . ';';
        }
        else
        {
          echo 'gCapteur["' . $periph['nom'] . '"] = ' . $zibase->getState($periph['id'], $protocol) . ';';
        }
      }
      ?>
      
      <?
      // Construction des tableaux issues des variables
      for ($i = 0; $i < 60; $i++)
      {
        echo 'gVariable[' . $i . '] = ' . $zibase->getVariable($i) . ';';
      }


    }
    ?>
  </script>
<?
 }
}
?>