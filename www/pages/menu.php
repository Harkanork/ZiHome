<script src="./js/ajax_edition.js"></script>
<div class="bandeau">
      <div class="menu-configuration">
      <div id="bouton_menu">
        <img src="./img/icon_zihome.png">
      </div>
    </div>
  <div id="list-menu">
    <?
    $query = "SELECT * FROM menu ORDER BY ordre";
    $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while ($data = mysql_fetch_assoc($req))
    {
      $afficher=false;
      if (($data['auth']==0) OR (isset($_SESSION['auth']))) {
        switch($data['type']) {
          case "module" :
            $query2 = 'SELECT * FROM modules WHERE id='.$data['module_id'];
            $req2 = mysql_query($query2, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
            while ($module = mysql_fetch_assoc($req2)) {
              $page="./index.php?page=".$module['url'];
              $afficher=true;
            }
            break;
          case "iframe":
            $page="./index.php?iframe=".$data['id'];
            $afficher=true;
            break;
          case "interne":
            $page="./index.php?interne=".$data['id'];
            $afficher=true;
            break;
          case "vue" :
            $page="./index.php?vue=".$data['module_id'];
            $afficher=true;
            break;
        }
      }
      if ($afficher) {
        echo '<div id="menu_'.$data['id'].'" class="menu_editable"><A HREF="'.$page.'"><img src = "./img/'.$data['icone'].'"/><span>'.$data['libelle'].'</span></a></div>';
      }   
    }
    if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin') {
      echo '<div id="menu_ajouter" class="menu_editable"><a><img src = "./img/icon_ajout.png"/><span>Ajouter</span></a></div>';
    }
    ?>
  </div>
</div>
<div id="sous-menu-zihome">
  <div id="div_logon"><? include("./pages/logon.php"); ?></div>
  <?
    if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin')
    {
      ?>
      <div id="bouton_administration">Administration</div>
      <div id="mode_edition">Edition du menu</div>
      <?
    }
    ?>
</div>
<script>
  // on ajoute un événement sur le bouton administration
  $(document).on('click','#bouton_administration', function () 
  {
    window.location.href = "./index.php?page=administration";
  });
</script>

