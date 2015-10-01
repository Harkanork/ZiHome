//
// activation et désactivation du mode édition
//

var mode_edition = false; // au chargement le mode édition est désactivé
var nb_init = 0; // cas particulier du premier clic sur le mode édition

$(document).on('click','#mode_edition', function () {  // on ajoute un événement sur le bouton mode_edition
  if (mode_edition===false) {  // cas où on n'était pas encore en mode édition
    mode_edition = true; // on passe en mode edition
    $("#mode_edition").addClass('active'); // on modifie l'aspect du bouton pour signaler l'activation du mode édition
    $("#mode_edition").appendTo('#bouton_menu');// on déplace le bouton pour masquer le sous-menu
    affiche_sousbandeau(false); // on masque le sous-bandeau pour permettre d'accéder à toute la page
    nb_init ++;
  } else {
    mode_edition = false; // on sort du mode edition
    $("#mode_edition").removeClass('active'); // on modifie l'aspect du bouton pour signaler la désactivation du mode édition
    $("#mode_edition").appendTo('#sous-menu-zihome');// on remet le bouton dans le sous-bandeau
  }
  menu_edition(mode_edition,nb_init); // on active ou désactive le mode édition du menu
});


///////////////////////////////////////////////////////////
// Mode Edition du MENU ///////////////////////////////////
///////////////////////////////////////////////////////////


// fonction qui active ou désactive le mode édition du menu
function menu_edition(activ, nb_init) {
  if (activ==true) { // si on doit l'activer
    if (nb_init<2) { // première activation seulement
      $("#list-menu").sortable({ // on rend les item du menu déplaçables
        placeholder: 'fantome',     // style appliqué à la case vide quand on bouge une élément
          update: function () {     // quand on déplace en élément, on enregistre les positions par ajax
            var ordre = $('#list-menu').sortable('serialize');  //  récupération des données à mémoriser
            $.post('./fonctions/ajax_menu.php?requete=ordre', ordre);  // appel du fichier qui enregistre dans la base
        }
      });
      $("#list-menu").disableSelection();  // évite de sélectionner le contenu pendant le glissé
    }
    $("#list-menu").sortable('enable'); // on réactive le glissé si on était précédemment sorti du mode édition (je n'ai pas réussi à le mettre dans les options précédentes, ça ne marchait pas)
    $('.menu_editable').removeClass('menu_editable').addClass('menu_active'); // on modifie l'aspect des item du menu pour signaler qu'ils sont déplaçables
    if (nb_init<2) { // première activation seulement
      $(document).on('click', ".menu_active > a", function (event) { // on rend les item modifiables au click
        event.preventDefault();
        var id = $(this).parents('div').attr('id').replace('menu_','');
        $.ajax({
          type: "POST",
          url: "./fonctions/ajax_menu.php?requete=modifier",
          data: {id_menu:id}, // on récupère le code html (généré par php pour les menus déroulants) du formulaire
          success : function(contenu,etat){
            $('body').append(contenu); // on ajoute le formulaire à notre page
            $(document).on('click','#popup_menu_fermer', function () { // bouton fermer du popup
              location.reload();
            });
            $(document).on('change', "select[name='menu_type_select']", function() { // mettra à jour le formulaire à chaque modification du menu déroulant
              if (this.value=='module') {
                $('#interne_select').hide();
                $('#iframe_select').hide();
                $('#vues_select').hide();
                $('#module_id_select').show();
              } else if (this.value=='vue') {
                $('#interne_select').hide();
                $('#iframe_select').hide();
                $('#module_id_select').hide();
                $('#vues_select').show();
              } else if (this.value=='iframe') {
                $('#interne_select').hide();
                $('#vues_select').hide();
                $('#module_id_select').hide();
                $('#iframe_select').show();
              } else {
                $('#iframe_select').hide();
                $('#vues_select').hide();
                $('#module_id_select').hide();
                $('#interne_select').show();
              }
            });
            $("select[name='menu_type_select']").trigger("change"); // met à jour le formulaire en fonction du choix du menu déroulant
            $(document).on('click','#form_menu_modifier', function () { // lorsqu'on clique sur le bouton modifier
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
                url: "./fonctions/ajax_menu.php?requete=maj", // on récupère le code html (généré par php pour les menus déroulants) du formulaire
                data: {id_menu:form_menu_id, type:form_menu_type, iframe:form_menu_iframe, interne:form_menu_interne, module:form_menu_module, vue:form_menu_vue, libelle:form_menu_libelle, icone:form_menu_icone, auth:form_menu_auth},
                success : function(contenu){
                  location.reload();
                }
              });
            });
            $(document).on('click','#form_menu_supprimer', function () { // lorsqu'on clique sur le bouton supprimer
              var form_menu_id=$('#menu_id_modif').val();
              $.ajax({
                type: "POST",
                url: "./fonctions/ajax_menu.php?requete=del", // on récupère le code html (généré par php pour les menus déroulants) du formulaire
                data: {id_menu:form_menu_id},
                success : function(contenu){
                  location.reload();
                }
              });
            });
          }
        });
      });
    }
    $('#menu_ajouter').css('display','inline-block'); // on montre le bouton permettant d'ajouter des item
  } else {
    $("#list-menu").sortable('disable'); // on désactive le glissé
    $('.menu_active').removeClass('menu_active').addClass('menu_editable'); // on remet le style normal des item du menu
    $('#menu_ajouter').hide(); // on cache le bouton permettant d'ajouter des éléments de menu
  }
}

// événement sur le bouton ajouter du menu = on affiche le formulaire d'ajout
$(document).on('click','#menu_ajouter', function() {
  $.ajax({
    type: "POST",
    url: "./fonctions/ajax_menu.php?requete=formulaire", // on récupère le code html (généré par php pour les menus déroulants) du formulaire
    success : function(contenu,etat){
      $('body').append(contenu); // on ajoute le formulaire à notre page
      $(document).on('click','#popup_menu_fermer', function () { // bouton fermer du popup
        location.reload();
      });
      $(document).on('change', "select[name='menu_type_select']", function() {
        if (this.value=='module') {
          $('#interne_select').hide();
          $('#iframe_select').hide();
          $('#vues_select').hide();
          $('#module_id_select').show();
        } else if (this.value=='vue') {
          $('#interne_select').hide();
          $('#iframe_select').hide();
          $('#module_id_select').hide();
          $('#vues_select').show();
        } else if (this.value=='iframe') {
          $('#interne_select').hide();
          $('#vues_select').hide();
          $('#module_id_select').hide();
          $('#iframe_select').show();
        } else {
          $('#iframe_select').hide();
          $('#vues_select').hide();
          $('#module_id_select').hide();
          $('#interne_select').show();
        }
      });
      $(document).on('click','#form_menu_valider', function () { // lorsqu'on clique sur le bouton valider
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
          url: "./fonctions/ajax_menu.php?requete=ajout", // on récupère le code html (généré par php pour les menus déroulants) du formulaire
          data: {type:form_menu_type, iframe:form_menu_iframe, interne:form_menu_interne, module:form_menu_module, vue:form_menu_vue, libelle:form_menu_libelle, icone:form_menu_icone, auth:form_menu_auth},
          success : function(contenu){
            location.reload();
          }
        });
      });
    }
  }); 
});


//////////////////////////
// Gestion de l'affichage dynamique
//////////////////////////

// fonction qui déroule/rentre le sous-bandeau du menu zihome (onnexion/admin/édition)
function affiche_sousbandeau(booleen) {
  if (booleen==true) {
    $('#sous-menu-zihome').slideDown(200, function() {
      $('#bouton_menu').addClass('active');
    });
  } else if ($('#sous-menu-zihome').is(':visible')) {
    $('#sous-menu-zihome').slideUp(200, function() {
      $('#bouton_menu').removeClass('active');
    });
  }
}

// gestion de l'affichage du sous-bandeau du menu zihome (onnexion/admin/édition)
$(document).ready(function() {  // se lance une fois que toute la page est chargée
  
  // affiche le sous-bandeau si nécessaire : par défaut il est visible, sauf si on a choisi de désactiver ce bandeau ou qu'une page le désactive (pour afficher un sous-menu par exemple)
  // sousbandeau est une variable définie dans index.php
  affiche_sousbandeau(sousbandeau);

  // change l'affichage du sous-bandeau au clic sur le bouton
  $(document).on('click','#bouton_menu', function() {
    if (sousbandeau == true) {  // s'il était affiché, on le masque
      affiche_sousbandeau(false);
      sousbandeau=false;
    } else {  // s'il était masqué, on l'affiche
      affiche_sousbandeau(true);
      sousbandeau=true;
    }
  })
});

// affichage dynamique du sous-menu (affiché dans le flux pour éviter les superpositions, puis passe en position:fixed quand on scroll)
$(document).ready(function() {
  if ($('#sous-menu').length) {
    $(window).scroll(function() {
      if ($(window).scrollTop() > 0) {
        $('#sous-menu').addClass("floatable");
      } else {
        $('#sous-menu').removeClass("floatable");
      }
    });
  }
});






