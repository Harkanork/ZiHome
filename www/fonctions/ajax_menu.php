<? 
if (isset($_GET['requete'])) { // si le script est bien appelé par ajax en precisant l'objet de la requête
  $requete=$_GET['requete'];
  include("../config/conf_zibase.php");

  $link = mysql_connect($hote,$login,$plogin);
  if (!$link) {
    die('Non connect&eacute; : ' . mysql_error());
  }
  $db_selected = mysql_select_db($base,$link);
  if (!$db_selected) {
    die ('Impossible d\'utiliser la base : ' . mysql_error());
  }
  
  // on regarde quelle est la requete pour savoir quoi récupérer et quoi faire dans la bdd
  switch($requete) {
    
    case 'ordre': // requete issue du script qui enregistre les changements d'ordre dans le menu : on enregistre le nouvel ordre dans la bdd
      foreach ($_POST['menu'] as $ordre => $id_menu) {
        mysql_query('UPDATE menu SET ordre='.$ordre.' WHERE id='.$id_menu, $link);
      }
      break;
    
    case 'formulaire': // requete qui demande de générer le formulaire popup pour un nouvel élément de menu
      ?>
        <CENTER>
        <br>
        <TABLE border=0 width="90%">
          <TR class="contenu">
            <TD width="140px">Type de lien</TD>
            <TD>
              <select id="form_menu_type" name="menu_type_select">
                <option value="module">Module ZiHome</option>
                <option value="vue">Vue personnalisée</option>
                <option value="interne">Page interne</option>
                <option value="iframe">Page externe</option>
              </select></TD>
          </TR>
          <TR class="contenu" id="iframe_select" style="display:none">
            <TD>Emplacement :</TD>
            <TD><input type=text id="form_menu_iframe" value="http://"></TD>
          </TR>
          <TR class="contenu" id="interne_select" style="display:none">
            <TD>Emplacement :</TD>
            <TD><input type=text id="form_menu_interne" value="./pages/fichier.php"></TD>
          </TR>
          <TR class="contenu" id="module_id_select">
            <TD>Module :</TD>
            <TD>
              <select id="form_menu_module">
                <?
                $query = 'SELECT id,libelle FROM modules WHERE actif=1 ORDER BY libelle ASC';
                $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                while ($module = mysql_fetch_assoc($req)) {
                  echo '<option value='.$module['id'].'>'.$module['libelle'].'</option>';
                }
                ?>
              </select>
            </TD>
          </TR>
          <TR class="contenu" id="vues_select" style="display:none">
            <TD>Vue :</TD>
            <TD>
              <select id="form_menu_vue">
                <?
                $query2 = 'SELECT id,libelle FROM vues';
                $req2 = mysql_query($query2, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                while ($vue = mysql_fetch_assoc($req2)) {
                  echo '<option value='.$vue['id'].'>'.$vue['libelle'].'</option>';
                }
                ?>
              </select></TD>
          </TR>
          <TR class="contenu">
            <TD>Libellé :</TD>
            <TD>
              <input type=text id="form_menu_libelle">
            </TD>
          </TR>
          <TR class="contenu">
            <TD>Icone :</TD>
            <TD>
              <select id="form_menu_icone">
                <?
                $icones = preg_grep("/^(icon)+?.+(\.png)$/", scandir('../img/'));// on récupère tous les fichiers png dont le nom commence par icon
                foreach($icones as $icone){
                  echo "<option value='" . $icone . "'>".$icone."</option>";
                }
                ?>
              </select>
            </TD>
          </TR>
          <TR class="contenu">
            <TD>Visible par :</TD>
            <TD>
              <select id="form_menu_auth" name="auth">
                <option value=0>Tout le monde</option>
                <option value=1>Enregistrés uniquement</option>
              </select>
            </TD>
          </TR>
        </TABLE>
      </CENTER>
      <?
      break;
    
    case 'ajout': // si le script est appelé pour enregistrer les données du formulaire d'ajout
      $type=$_POST['type'];
      $module=$_POST['module'];
      $libelle=$_POST['libelle'];
      $icone=$_POST['icone'];
      $auth=$_POST['auth'];
      $url="";
      switch($type) {
        case "iframe" :
          $url=$_POST['iframe'];
          $module="";
          break;
        case "interne" :
          $url=$_POST['interne'];
          $module="";
          break;
        case "vue" :
          $module=$_POST['vue'];
          break;
      }
      $req="INSERT INTO `menu` (`type`, `module_id`, `libelle`, `icone`, `auth`, `ordre`, `url`) VALUES ('".$type."', '".$module."', '".$libelle."', '".$icone."', '".$auth."', '99', '".$url."');";
      mysql_query($req);
      
      // Renvoie les informations du nouvel élément
      $reponse = array();
      $reponse['id'] = mysql_insert_id($link);
      
      // Détermine l'adresse de la page
      $page  = "";
      switch($type) {
        case "module" :
          $query2 = 'SELECT * FROM modules WHERE id=' . $module;
          $req2 = mysql_query($query2, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
          while ($module = mysql_fetch_assoc($req2)) {
            $page = "./index.php?page=" . $module['url'];
          }
          break;
        case "iframe":
          $page = "./index.php?iframe=" . $reponse['id'];
          break;
        case "interne":
          $page = "./index.php?interne=" . $reponse['id'];
          break;
        case "vue" :
          $page = "./index.php?vue=" . $module;
          break;
      }
      $reponse['page'] = $page;
      
      // Encode l'information en json
      echo json_encode($reponse);
      
      break;
    
    case 'modifier' : // si le script est appelé pour générer le formulaire de modification/suppression    
      $id=$_POST['id_menu'];
      $query = 'SELECT * FROM menu WHERE id='.$id;
      $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
      while ($menu = mysql_fetch_assoc($req)) {
        $libelle=$menu['libelle'];
        $type=$menu['type'];
        $url=$menu['url'];
        $module_id=$menu['module_id'];
        $libelle=$menu['libelle'];
        $icon=$menu['icone'];
        $menu_auth=$menu['auth'];
      }
      ?>
      <CENTER>
        <br>
        <TABLE border=0 width="90%">
          <TR class="contenu">
            <TD width="140px">Type de lien</TD>
            <TD>
              <select id="form_menu_type" name="menu_type_select">
                <option value="module" <? if ($type=="module") { echo " selected";}; ?>>Module ZiHome</option>
                <option value="vue" <? if ($type=="vue") { echo " selected";}; ?>>Vue personnalisée</option>
                <option value="interne" <? if ($type=="interne") { echo " selected";}; ?>>Page interne</option>
                <option value="iframe" <? if ($type=="iframe") { echo " selected";}; ?>>Page externe</option>
              </select>
            </TD>
          </TR>
          <TR class="contenu" id="iframe_select" style="display:none">
            <TD>Emplacement</TD>
            <TD>
              <input type=text id="form_menu_iframe" value="<? if ($type=="iframe") { echo $url; } else { echo "http://"; } ?>">
            </TD>
          </TR>
          <TR class="contenu" id="interne_select" style="display:none">
            <TD>Emplacement</TD>
            <TD>
              <input type=text id="form_menu_interne" value="<? if ($type=="interne") { echo $url; } else { echo "./pages/fichier.php"; } ?>">
            </TD>
          </TR>
          <TR class="contenu" id="module_id_select">
            <TD>Module</TD>
            <TD>
              <select id="form_menu_module">
                <?
                $query1 = 'SELECT id,libelle FROM modules WHERE actif=1 ORDER BY libelle ASC';
                $req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                while ($module = mysql_fetch_assoc($req1)) {
                  $selected="";
                  if ($module_id==$module['id']) { $selected=" selected" ; };
                  echo '<option value='.$module['id'].$selected.'>'.$module['libelle'].'</option>';
                }
                ?>
              </select>
            </TD>
          </TR>
          <TR class="contenu" id="vues_select" style="display:none">
            <TD>Vue</TD>
            <TD>
              <select id="form_menu_vue">
              <?
                $query2 = 'SELECT id,libelle FROM vues';
                $req2 = mysql_query($query2, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                while ($vue = mysql_fetch_assoc($req2)) {
                  $selected="";
                  if ($module_id==$vue['id']) { $selected=" selected" ; };
                  echo '<option value='.$vue['id'].$selected.'>'.$vue['libelle'].'</option>';
                }
                ?>
              </select>
            </TD>
          </TR>
          <TR class="contenu">
            <TD>Libellé</TD>
            <TD>
              <input type=text id="form_menu_libelle" value="<? echo $libelle ?>">
            </TD>
          </TR>
          <TR class="contenu">
            <TD>Icone</TD>
            <TD>
              <select id="form_menu_icone">
                <?
                $icones = preg_grep("/^(icon)+?.+(\.png)$/", scandir('../img/'));// on récupère tous les fichiers png dont le nom commence par icon
                foreach($icones as $icone){
                  $selected="";
                  if ($icon==$icone) { $selected=" selected" ; };
                  echo "<option value='" . $icone ."'".$selected.">".$icone."</option>";
                }
                ?>
              </select>
            </TD>
          </TR>
          <TR class="contenu">
            <TD>Visible par</TD>
            <TD>
              <select id="form_menu_auth" name="auth">
                <option value=0 <? if ($menu_auth==0) echo " selected" ?>>Tout le monde</option>
                <option value=1 <? if ($menu_auth==1) echo " selected" ?>>Enregistrés uniquement</option>
              </select>
            </TD>
          </TR>
        </TABLE>
      </CENTER>
      <input type=hidden id="menu_id_modif" value="<? echo $id ?>">
      <?
      break;
    
    case 'maj' : // si le script est appelé pour sauvegarder des modifications d'un élément de menu  
      $id=$_POST['id_menu'];
      $type=$_POST['type'];
      $module=$_POST['module'];
      $url="";
      switch($type) {
        case "iframe" :
          $url=$_POST['iframe'];
          $module="";
          break;
        case "interne" :
          $url=$_POST['interne'];
          $module="";
          break;
        case "vue" :
          $module=$_POST['vue'];
          break;
      }
      $libelle=$_POST['libelle'];
      $icone=$_POST['icone'];
      $auth=$_POST['auth'];
      $req="UPDATE `menu` SET `type`='".$type."', `module_id`='".$module."',`url`='".$url."',`libelle`='".$libelle."',`icone`='".$icone."',`auth`='".$auth."' WHERE `id`='".$id."';";
      mysql_query($req);
      
      // Renvoie les informations du nouvel élément
      $reponse = array();
      $reponse['id'] = $id;
      
      // Détermine l'adresse de la page
      $page  = "";
      switch($type) {
        case "module" :
          $query2 = 'SELECT * FROM modules WHERE id=' . $module;
          $req2 = mysql_query($query2, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
          while ($module = mysql_fetch_assoc($req2)) {
            $page = "./index.php?page=" . $module['url'];
          }
          break;
        case "iframe":
          $page = "./index.php?iframe=" . $id;
          break;
        case "interne":
          $page = "./index.php?interne=" . $id;
          break;
        case "vue" :
          $page = "./index.php?vue=" . $module;
          break;
      }
      $reponse['page'] = $page;
      
      // Encode l'information en json
      echo json_encode($reponse);
      break;
    
    case 'del' : // si le script est appelé pour supprimer un élément de menu  
      $id=$_POST['id_menu'];
      $req="DELETE FROM `menu` WHERE `id`='".$id."';";
      mysql_query($req);
      break;
    
  }
}
?>