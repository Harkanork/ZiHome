
<link rel="stylesheet" href="./js/themes/jquery.ui.core.min.css">
<link rel="stylesheet" href="./js/themes/jquery.ui.theme.min.css">
<link rel="stylesheet" href="./js/themes/jquery.ui.datepicker.min.css">
<link rel="stylesheet" href="./js/themes/jquery.ui.dialog.min.css">

<?
include("./fonctions/dialogue_confirmation.php");
?>

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
        echo '<div id="menu_'.$data['id'].'" class="menu_editable" style="position:relative;left:0px;"><A HREF="'.$page.'"><img src = "./img/'.$data['icone'].'"/><span>'.$data['libelle'].'</span></a></div>';
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

<div id="dialog_menu_modifier" title="Modification" style="display:none;">
</div>

<script>
  $(function() 
  {
    $( "#dialog_menu_modifier" ).dialog(
    {
      resizable: false,
      height:360,
      width:500,
      autoOpen: false,
      modal: true,
      closeText: "",
      open: function (event, ui) {
        $('.ui-dialog').css('z-index',999999);
        $('.ui-widget-overlay').css('z-index',999998);
      },
      buttons: 
      {
        "Valider": function() 
        {
          var form_menu_id=$('#menu_id_modif').val();
          var form_menu_type=$('#form_menu_type').val();
          var form_menu_iframe=$('#form_menu_iframe').val();
          var form_menu_interne=$('#form_menu_interne').val();
          var form_menu_module=$('#form_menu_module').val();
          var form_menu_vue=$('#form_menu_vue').val();
          var form_menu_libelle=$('#form_menu_libelle').val();
          var form_menu_icone=$('#form_menu_icone').val();
          var form_menu_auth=$('#form_menu_auth').val();
          $.ajax({
            type: "POST",
            url: "./fonctions/ajax_menu.php?requete=maj", // on sauvegarde les modifications
            data: {id_menu:form_menu_id, type:form_menu_type, iframe:form_menu_iframe, interne:form_menu_interne, module:form_menu_module, vue:form_menu_vue, libelle:form_menu_libelle, icone:form_menu_icone, auth:form_menu_auth},
            success : function(contenu){
              location.reload();
            }
          });
        },
        "Annuler": function() 
        {
          $( this ).dialog( "close" );
        }
      }
    });
  });
  
  // on ajoute un événement sur le bouton administration
  $(document).on('click','#bouton_administration', function () 
  {
    window.location.href = "./index.php?page=administration";
  });
</script>

