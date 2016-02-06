<? 
if (isset($_GET['requete'])) { // si le script est bien appelé par ajax en precisant l'objet de la requête
  $requete=$_GET['requete'];
  include("../config/conf_zibase.php");
  include("../config/variables.php");
  include("../lib/zibase.php");
  $zibase = new ZiBase($ipzibase);

  $link = mysql_connect($hote,$login,$plogin);
  if (!$link) {
    die('Non connect&eacute; : ' . mysql_error());
  }
  $db_selected = mysql_select_db($base,$link);
  if (!$db_selected) {
    die ('Impossible d\'utiliser la base : ' . mysql_error());
  }

  // on récupère le numéro de jeu d'icone
  $icone=1;
  $query = "SELECT * FROM paramettres WHERE libelle = 'icones'";
  $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while ($data = mysql_fetch_assoc($req))
  {
    $icone = $data['value'];
  }

  // Recuperation de la largeur des icones
    $query = "SELECT * FROM paramettres WHERE libelle = 'largeur icones'";
    $res_query = mysql_query($query, $link);
    if (mysql_numrows($res_query) > 0) {
            $data = mysql_fetch_assoc($res_query);
            $widthIcones = $data['value'];
            $labelOffsetLeft = max($widthIcones - 30, $widthIcones / 2);
    } else {
            $widthIcones = 60;
            $labelOffsetLeft = 30;
    }

    // Recuperation de la hauteur des icones
    $query = "SELECT * FROM paramettres WHERE libelle = 'hauteur icones'";
    $res_query = mysql_query($query, $link);
    if (mysql_numrows($res_query) > 0) {
            $data = mysql_fetch_assoc($res_query);
            $heightIcones = $data['value'];
    } else {
            $heightIcones = 60;
    }
    if ($heightIcones < 40) {
            $labelWidth = 30;
            $labelOffsetTop = $heightIcones - 13;
            $labelFontSize = 8;
            $labelFontOffsetTop = 1;
            $labelFontOffsetLeft = 3; 
    } else {
            $labelWidth = 50;
            $labelOffsetTop = $heightIcones - 22; 
            $labelFontSize = 12;
            $labelFontOffsetTop = 3;
            $labelFontOffsetLeft = 6;
    }
  
  // on regarde quelle est la requete pour savoir quoi récupérer et quoi faire dans la bdd
  switch($requete) {
    
    case 'position':
        $x = $_POST['x'];
        $y = $_POST['y'];
        $id = $_POST['id'];
        $zindex= $_POST['zindex'];
        mysql_query("UPDATE `vues_elements` SET `left`='".$x."', `top`='".$y."', `zindex`='".$zindex."' WHERE `id`='".$id."';", $link);
      break;

    case 'redim':
        $w = $_POST['w'];
        $h = $_POST['h'];
        $x = $_POST['x'];
        $y = $_POST['y'];
        $id = $_POST['id'];
        mysql_query("UPDATE `vues_elements` SET `left`='".$x."', `top`='".$y."', `width`='".$w."', `height`='".$h."' WHERE `id`='".$id."';", $link);
      break;

    case 'del':
        $id = $_POST['id'];
        mysql_query("DELETE FROM `vues_elements` WHERE `id`='".$id."';", $link);
      break;

    case 'modifier' :
      $id=$_POST['id'];
      $query = 'SELECT * FROM `vues_elements` WHERE id='.$id;
      $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
      while ($elements = mysql_fetch_assoc($req)) {
        $libelle=$elements['libelle'];
        $user=$elements['user'];
        $width=$elements['width'];
        $height=$elements['height'];
        $left=$elements['left'];
        $top=$elements['top'];
        $url=$elements['url'];
        $peripherique=$elements['peripherique'];
        $option=$elements['option'];
        $font=$elements['font'];
        $color=$elements['color'];
        $size=$elements['size'];
        ($elements['bold']==1)?$bold=true:$bold=false;
        ($elements['italic']==1)?$italic=true:$italic=false;
        $border=$elements['border'];
        $condition=$elements['condition'];
        ($elements['affich_libelle']==1)?$affich_libelle=true:$affich_libelle=false;
        $type=$elements['type'];
      }
      ?>
      <CENTER>
        <br>
        <TABLE class="elements_form_table">
          <TR class="elements_form_TR">
            <TD>Etiquette :<input type=text id="libelle" value="<? echo $libelle ?>"></TD>
            <TD <? if (($type=='textdyn') || ($type=='scenario')) { echo "style=\"visibility:hidden\""; } ?>><input type=checkbox id="affich_libelle" <? if ($affich_libelle) echo "checked"?>>Afficher l'étiquette ?</TD>
          </TR>
          <TR class="elements_form_TR">
            <TD>Visible par</TD>
            <TD>
              <select id="user" name="user">
                <option value='' <? if (($user=='default') OR ($user=='')) echo " selected" ?>>Tout le monde</option>
                <? if (($user<>'default') AND ($user<>'')) { ?><option value='<? echo $user ?>' selected><? echo $user ?></option><? } ?>
              </select>
            </TD>
          </TR>
          <TR class="elements_form_TR">
            <TD>Largeur <input type=number id="width" value="<? echo $width ?>" min=0></TD>
            <TD>Positionnement gauche <input type=number id="left" value="<? echo $left ?>" min=0></TD>
          </TR>
          <TR class="elements_form_TR">
            <TD>Hauteur <input type=number id= "height" value="<? echo $height ?>" min=0></TD>
            <TD>Positionnement haut <input type=number id="top" value="<? echo $top ?>" min=0></TD>
          </TR>
          <?
          switch ($type) {
            case 'actioneur':
            case 'capteur':
            case 'conso':
            case 'temperature':
            case 'eau':
            case 'vent':
            case 'pluie':
            case 'luminosite':
          ?>
          <TR class="elements_form_TR">
            <TD>Icone :</TD>
            <TD>
              <img src="./img/icones/<? echo $icone ?>g_<? echo $url ?>" height="25px" name="list_icone"></img>
            </TD>
          </TR>
          <?  break;
          } ?>
          <input type=hidden id="url" value="<? echo $url ?>">
          <? 
          if ($type=='scenario') { ?>
            <TR class="elements_form_TR">
              <TD>Périphérique</TD>
              <TD><select id="peripherique">
                <option value=""></option>
                <?
                $query = 'SELECT * FROM `scenarios` WHERE 1=1';
                $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                while ($scenarios = mysql_fetch_assoc($req)) {
                  if ($scenarios['libelle']<>'') {
                    $libelle=$scenarios['libelle'];
                  } else {
                    $libelle=$scenarios['nom'];
                  }
                  echo "<option value=\"".$scenarios['nom']."\" ";
                  if ($peripherique==$scenarios['nom']) { echo "selected";}
                  echo ">".$libelle."</option>";
                }
                ?>
                </select></TD>
            </TR>
            <?
          } else {
            ?>
            <input type=hidden id="peripherique" value="<? echo $peripherique ?>">
            <?
          } ?>
          <TR class="elements_form_TR">
            <TD>Police</TD>
            <TD><select id="font">
              <option value="Arial, Helvetica, sans-serif" <? if ($font=="Arial, Helvetica, sans-serif") {echo " selected";} ?>>Arial</option>
              <option value="Comic Sans MS, cursive, sans-serif" <? if ($font=="Comic Sans MS, cursive, sans-serif") {echo " selected";} ?>>Comic Sans MS</option>
              <option value="Times New Roman, Times, serif" <? if ($font=="Times New Roman, Times, serif") {echo " selected";} ?>>Times New Roman</option>
              <option value="Courier New, Courier, monospace" <? if ($font=="Courier New, Courier, monospace") {echo " selected";} ?>>Courier New</option>
            </select></TD>
          </TR>
          <TR class="elements_form_TR">
            <TD>Couleur : <input type=color id="color" value="<? echo $color ?>"></TD>
            <TD>Taille de police : <input type=number id="size" value="<? echo $size ?>"></TD>
          </TR>
          <TR class="elements_form_TR">
            <TD>Gras ? <input type=checkbox id="bold" <? if ($bold) echo "checked"?>></TD>
            <TD>Italique ? <input type=checkbox id="italic" <? if ($italic) echo "checked"?>></TD>
          </TR>
          <TR class="elements_form_TR">
            <TD>Bordure</TD><TD>Options css complémentaires</TD>
          </TR>
          <TR class="elements_form_TR">
            <TD><input type=text id="border" value="<? echo $border ?>"></TD><TD><input type=text id="option" value="<? echo $option ?>"></TD>
          </TR>
          <TR class="elements_form_TR">
            <TD>Condition</TD>
            <TD><input type=text id="condition" value="<? echo $condition ?>"></TD>
          </TR>
        </TABLE>
      </CENTER>
      <input type=hidden id="elements_id_modif" value="<? echo $id ?>">

      <?
      break;

    case 'maj' : // si le script est appelé pour sauvegarder des modifications  
      $id=$_POST['id'];
      $libelle=$_POST['libelle'];
      $user=$_POST['user'];
      $width=$_POST['width'];
      $height=$_POST['height'];
      $left=$_POST['left'];
      $top=$_POST['top'];
      $url=$_POST['url'];
      $peripherique=$_POST['peripherique'];
      $option=$_POST['option'];
      $font=$_POST['font'];
      $color=$_POST['color'];
      $size=$_POST['size'];
      $bold=$_POST['bold'];
      $italic=$_POST['italic'];
      $border=$_POST['border'];
      $condition=$_POST['condition'];
      $affich_libelle=$_POST['affich_libelle'];
      $req="UPDATE `vues_elements` SET `libelle`='".$libelle."',`user`='".$user."',`width`='".$width."',`height`='".$height."', `left`='".$left."', `top`='".$top."', `url`='".$url."',`peripherique`='".$peripherique."',`option`='".$option."',`font`='".$font."',`color`='".$color."',`size`='".$size."',`bold`='".$bold."',`italic`='".$italic."', `border`='".$border."', `condition`='".$condition."', `affich_libelle`='".$affich_libelle."' WHERE `id`='".$id."';";
      mysql_query($req,$link);
      
      //renvoi des données pour affichage
      $query = "SELECT * FROM `vues_elements` WHERE `id` = '".$id."'"; 
      $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
      while ($data1 = mysql_fetch_assoc($req)){
        $type=$data1['type'];
        $zindex=$data1['zindex'];
      }
      $reponse = [$id,"", $type, $user, $width, $height, $left, $top, $zindex, $libelle, $affich_libelle, $url, $peripherique, $font, $color, $size, $bold, $italic, $border, $option, $condition];
      echo json_encode($reponse);
      break;

    case 'run_scen' :
      $query = "SELECT * FROM scenarios WHERE nom = '".$_POST['nom']."'"; 
      $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
      while ($data1 = mysql_fetch_assoc($req)){
        $scen_id = $data1['id'];
      }
      if (isset($scen_id)) {
        $zibase->runScenario($scen_id);
      } 
      break;

    case 'peri_ON' :
      $id=$_POST['id'];
      $proto=$_POST['proto'];
      $zibase->sendCommand($id, 1, $proto, "");
      break;

    case 'peri_OFF' :
      $id=$_POST['id'];
      $proto=$_POST['proto'];
      $zibase->sendCommand($id, 0, $proto, "");
      break;

    case 'icones' :
      $icones = preg_grep("/^(".$icone.")+?[(c_)].+(\.png)$/", scandir('../img/icones'));
      foreach($icones as $icon){
        echo "<img class=\"list_icone\" src=\"./img/icones/".$icon."\" height=\"30px\" data-key=\"".$icon."\" alt=\"ok\"></img>";
      }
      break;

    case 'formulaire' :
      ?>
      <CENTER>
        <br>
        <TABLE class="elements_form_table">
          <TR class="elements_form_TR" data-key="list_types" >
            <TD colspan="2">
              Type d'élément : <select id="type" name="elements_type">
                <option value='scenario'>Bouton scénario</option>
                <option value='fonction'>Module</option>
                <option value='textdyn'>Texte</option>
                <option value='sticker'>Sticker</option>
                <option value='meteo'>Icone météo</option>
                <option value='pollution'>Icone pollution</option>
                <option value='actioneur'>Logo actionneur</option>
                <option value='capteur'>Logo capteur</option>
                <option value='conso'>Logo conso élec</option>
                <option value='temperature'>Logo température</option>
                <option value='eau'>Logo conso eau</option>
                <option value='vent'>Logo vent</option>
                <option value='pluie'>Logo pluviométrie</option>
                <option value='luminosite'>Logo luminosité</option>
              </select>
            </TD>
          </TR>
          <TR class="elements_form_TR" data-display="etiquette" style="display:none">
            <TD>Etiquette :<input type=text id="libelle"></TD>
            <TD><input type=checkbox id="affich_libelle">Afficher l'étiquette ?</TD>
          </TR>
          
          <TR class="elements_form_TR" data-display="icone" style="display:none">
            <TD>Icone :</TD>
            <TD>
              <img src="./img/icones/1g_logotype_LampesPlafond.png" height="25px" name="list_icone"></img>
            </TD>
          </TR>
          <input type=hidden id="url" name="element_url" value="">
          <input type=hidden id="peripherique" name="element_peri" value="">
            <TR class="elements_form_TR" data-display="scenario" style="display:none">
              <TD>Scénario :</TD>
              <TD><select id="peripherique">
                <option value=""></option>
                <?
                $query = 'SELECT * FROM `scenarios` WHERE 1=1';
                $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                while ($scenarios = mysql_fetch_assoc($req)) {
                  if ($scenarios['libelle']<>'') {
                    $libelle=$scenarios['libelle'];
                  } else {
                    $libelle=$scenarios['nom'];
                  }
                  echo "<option value=\"".$scenarios['nom']."\">".$libelle."</option>";
                }
                ?>
                </select></TD>
            </TR>
          <TR class="elements_form_TR" data-display="style_avance" style="display:none">
            <TD>Styles avancés :</TD>
            <TD><input type=checkbox id="style_avance"></TD>
          </TR>
          <TR class="elements_form_TR" data-display="police" style="display:none">
            <TD>Police</TD>
            <TD><select id="font">
              <option value="Arial, Helvetica, sans-serif">Arial</option>
              <option value="Comic Sans MS, cursive, sans-serif">Comic Sans MS</option>
              <option value="Times New Roman, Times, serif">Times New Roman</option>
              <option value="Courier New, Courier, monospace">Courier New</option>
            </select></TD>
          </TR>
          <TR class="elements_form_TR" data-display="position" style="display:none">
            <TD data-display="width">Largeur <input type=number id="width" value="50" min=0></TD>
            <TD data-display="left">Positionnement gauche <input type=number id="left" value="200" min=0></TD>
          </TR>
          <TR class="elements_form_TR" data-display="position" style="display:none">
            <TD data-display="height">Hauteur <input type=number id= "height" value="20" min=0></TD>
            <TD data-display="top">Positionnement haut <input type=number id="top" value="50" min=0></TD>
          </TR>
          <TR class="elements_form_TR" data-display="police" style="display:none">
            <TD>Couleur : <input type=color id="color" value="#000"></TD>
            <TD>Taille de police : <input type=number id="size" value="10"></TD>
          </TR>
          <TR class="elements_form_TR" data-display="police" style="display:none">
            <TD>Gras ? <input type=checkbox id="bold"></TD>
            <TD>Italique ? <input type=checkbox id="italic"></TD>
          </TR>
          <TR class="elements_form_TR" data-display="css" style="display:none">
            <TD>Bordure <input type=text id="border"></TD><TD>Options css complémentaires <input type=text id="option"></TD>
          </TR>
          <TR class="elements_form_TR" data-display="condition" style="display:none">
            <TD>Condition</TD>
            <TD><input type=text id="condition"></TD>
          </TR>
          <TR class="elements_form_TR" data-display="visible" style="display:none">
            <TD>Visible par</TD>
            <TD>
              <select id="user" name="user">
                <option value=''>Tout le monde</option>
              </select>
            </TD>
          </TR>
        </TABLE>
      </CENTER>
      <?
      break;

    case 'ajouter' : // si le script est appelé pour sauvegarder un ajout
      $vue=$_POST['vue'];
      $type=$_POST['type'];
      $libelle=$_POST['libelle'];
      $user=$_POST['user'];
      $width=$_POST['width'];
      $height=$_POST['height'];
      $left=$_POST['left'];
      $top=$_POST['top'];
      $url=$_POST['url'];
      $peripherique=$_POST['peripherique'];
      $option=$_POST['option'];
      $font=$_POST['font'];
      $color=$_POST['color'];
      $size=$_POST['size'];
      $bold=$_POST['bold'];
      $italic=$_POST['italic'];
      $border=$_POST['border'];
      $condition=$_POST['condition'];
      $affich_libelle=$_POST['affich_libelle'];
      $req="INSERT INTO `vues_elements` (`vue_id`, `type`, `libelle`, `user`, `width`, `height`, `left`, `top`, `url`, `peripherique`, `option`, `font`, `color`, `size`, `bold`, `italic`, `border`, `condition`, `affich_libelle`) VALUES ('".$vue."', '".$type."', '".$libelle."', '".$user."', '".$width."', '".$height."', '".$left."', '".$top."', '".$url."', '".$peripherique."', '".$option."', '".$font."', '".$color."', '".$size."', '".$bold."', '".$italic."', '".$border."', '".$condition."', '".$affich_libelle."');";
      mysql_query($req,$link);

      //renvoi des données pour affichage
      $id=mysql_insert_id($link);
      $query = "SELECT * FROM `vues_elements` WHERE `id` = '".$id."'"; 
      $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
      while ($data1 = mysql_fetch_assoc($req)){
        $zindex=$data1['zindex'];
      }
      $reponse = [$id,'', $type, $user, $width, $height, $left, $top, $zindex, $libelle, $affich_libelle, $url, $peripherique, $font, $color, $size, $bold, $italic, $border, $option, $condition];
      echo json_encode($reponse);
      break;

    case 'pollution' :
      $query = "SELECT * FROM pollution order by date DESC limit 1";
      $res_query = mysql_query($query, $link);
      if (mysql_numrows($res_query) > 0) {
          $pollution = mysql_fetch_assoc($res_query);
          echo '<img src="./img/pollution/Pollution' . $pollution['Indice'] . '.png" title=" <table align=\'center\'>';
          echo '<tr><td><b> Indice : </b></td><td><b>'. $pollution['Indice'] . '</b></td></tr>';
          echo '<tr><td> O3 : </td><td>'. $pollution['O3'] . '</td></tr>';
          echo '<tr><td> NO2 : </td><td>'. $pollution['NO2'] . '</td></tr>';
          echo '<tr><td> PM10 : </td><td>'. $pollution['PM10'] . '</td></tr>';
          echo '<tr><td> SO2 : </td><td>'. $pollution['SO2'] . '</td></tr></table>"';
      }
      break;

    case 'meteo' :
        $weather = simplexml_load_file("http://wxdata.weather.com/wxdata/weather/local/".$meteo_ville."?cc=*&unit=m");
        echo $weather->cc->icon;
      break;

    case 'icone_peripherique' :
      $valeur1 = "";
      $valeur2 = ""; 
      $status =true;
      $query2 = "SELECT * FROM peripheriques WHERE id = '".$_POST['peri']."'";
      $req2 = mysql_query($query2, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
      while ($peripheriques = mysql_fetch_assoc($req2)){
        switch ($peripheriques['periph']) {

          case 'actioneur':
          case 'capteur':
            ($peripheriques['protocol'] == 6)?$protocol=true:$protocol = false;
            if($protocol == true) {
              $value = $zibase->getState(substr($peripheriques['id'], 1), $protocol);
            } else {
              $value = $zibase->getState($peripheriques['id'], $protocol);
            }
            if($value <> "1") { $status =false;} 
            break;

          case 'conso' :
            $query0 = "SELECT * FROM `conso_".$peripheriques['nom']."` ORDER BY `date` DESC LIMIT 1";
            $req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
            if ($req0 && mysql_numrows($req0) > 0) {
              $data0 = mysql_fetch_assoc($req0);
              $valeur1=$data0['conso'];
              $unite1="W";
            }
            break;

          case 'temperature' :
            $query0 = "SELECT * FROM `temperature_".$peripheriques['nom']."` ORDER BY `date` DESC LIMIT 1";
            $req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
            if ($req0 && mysql_numrows($req0) > 0) {
              $data0 = mysql_fetch_assoc($req0);
              $valeur1=$data0['temp'];
              $unite1="&deg;";
              if ($peripheriques['show_value2'])
              {
                  $valeur2=$data0['hygro'];
                  $unite2="%";
              }
            }
            break;

          case 'eau' :
            // lacune !
            break;

          case 'vent' :
            $query0 = "SELECT * FROM `vent_".$peripheriques['nom']."` ORDER BY `date` DESC LIMIT 1";
            $req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
            if ($req0 && mysql_numrows($req0) > 0) {
              $data0 = mysql_fetch_assoc($req0);
              $valeur1=$data0['vitesse']/10;
              $unite1="m/s";
            }
            break;

          case 'pluie':
            $query0 = "SELECT * FROM `pluie_".$peripheriques['nom']."` ORDER BY `date` DESC LIMIT 1";
            $req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
            if ($req0 && mysql_numrows($req0) > 0) {
                $data0 = mysql_fetch_assoc($req0);
                $valeur1=$data0['pluie'];
                $unite1="mm";
            }
            break;

          case 'luminosite':
              $query0 = "SELECT * FROM `luminosite_".$peripheriques['nom']."` ORDER BY `date` DESC LIMIT 1";
              $req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
              if ($req0 && mysql_numrows($req0) > 0) {
                  $data0 = mysql_fetch_assoc($req0);
                  $valeur1=$data0['lum'];
                  $unite1="";
              }
              break;
        }
      }
      $nom="";
      if ($peripheriques['texte'])  {
          if($peripheriques['libelle'] == ""){
              $nom = $peripheriques['nom'];
          } else {
              $nom = $peripheriques['libelle'];
          }
      }
      $batterie=$peripheriques['batterie'];
      $erreur=$peripheriques['erreur'];
      
      if ($status) {
        echo "<img src=\"./img/icones/".$icone."c_".$_POST['logo']."\"";
      } else {
        if (file_exists("../img/icones/".$icone."g_".$_POST['logo'])) {
          echo "<img src=\"./img/icones/".$icone."g_".$_POST['logo']."\"";
        } else {
          echo "<img src=\"./img/icones/".$icone."c_".$_POST['logo']."\" class=\"grayscale\"";
        }
      }
      echo " style=\"width:".$widthIcones."px;height:".$heightIcones."px\"></img>";
      if ($valeur1 <> "") {
        echo "<img src=\"./img/icones/".$icone."AndroidNumberYellow.png\" width=\"".$labelWidth."\" style=\"position:absolute;top:0px;left:".$labelOffsetLeft."px;border-style:none;\">";
        echo "<span style=\"position:absolute;top:".$labelFontOffsetTop."px;left:".($labelOffsetLeft + $labelFontOffsetLeft)."px;color: black;font-size:".$labelFontSize."px;font-weight:bold;border-style:none;\">".$valeur1.$unite1."</span>";
      }
      if ($valeur2 <> "") {
        echo "<img src=\"./img/icones/".$icone."AndroidNumberOther.png\" width=\"".$labelWidth."\" style=\"position:absolute;top:".$labelOffsetTop."px;left:".$labelOffsetLeft."px;border-style:none;\">";
        echo "<span style=\"position:absolute;top:".($labelOffsetTop + $labelFontOffsetTop)."px;left:".($labelOffsetLeft + $labelFontOffsetLeft)."px;color: black;font-size:".$labelFontSize."px;font-weight:bold;border-style:none;\">".$valeur2.$unite2."</span>";
      }
      if ($batterie) {
        echo "<img src='./img/batterie_ko_highlight.png' height='".($heightIcones / 2)."px' style=\"position:absolute;top:".($heightIcones / 2)."px;left:0px;\"/>";
      }
      if ($erreur) {
        echo "<img src='./img/error.png' height='".($heightIcones / 2)."px' style=\"position:absolute;top:0px;left:0px;\"/>";
      }
      echo "</div>";
      if ($nom<>"") {
        echo "<div style=\"position:absolute;top:".($_POST['top']+$heightIcones)."px;left:".($_POST['left'] - 10)."px;width:".($widthIcones + 20)."px;padding:2px;font-size:".$labelFontSize."px;font-weight:bold;font-family:sans-serif;border-style:none;color: black;background-color:rgba(255, 255, 255, 0.7);text-align:center;z-index:300;\">".$nom."</div>";
      }
      break;

    case 'zindex':
      $query = "SELECT * FROM `vues_elements` WHERE `vue_id`='".$_POST['vue']."' AND `type`='cadre' ORDER by `zindex` ASC;";  
      $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
      $i=0;
      while ($data = mysql_fetch_assoc($req)) {
          $query2 = "UPDATE `vues_elements` SET `zindex`='".$i."' WHERE `id`='".$data['id']."';";
          mysql_query($query2, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
          $i++;
      }
      $query3 = "SELECT * FROM `vues_elements` WHERE `vue_id`='".$_POST['vue']."' AND `type`<>'cadre' ORDER by `zindex` ASC;";  
      $req3 = mysql_query($query3, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
      while ($data3 = mysql_fetch_assoc($req3)) {
          $query4 = "UPDATE `vues_elements` SET `zindex`='".$i."' WHERE `id`='".$data3['id']."';";
          mysql_query($query4, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
          $i++;
      }
      break;

    case 'nouvelle_vue_form': // requete qui demande de générer le formulaire popup pour un nouvel élément de menu
      ?>
        <CENTER>
        <br>
        <TABLE border=0 width="90%">
          <TR class="contenu">
            <TD>Libellé :</TD>
            <TD>
              <input type=text id="libelle">
            </TD>
          </TR>
        </TABLE>
      </CENTER>
      <?
      break;

    case 'nouvelle_vue': // si le script est appelé pour enregistrer les données du formulaire d'ajout
      $libelle=$_POST['libelle'];
      $req="INSERT INTO `vues` (`libelle`) VALUES ('".$libelle."');";
      mysql_query($req);
      
      break;
  }
}
?>