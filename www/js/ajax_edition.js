//
// activation et désactivation du mode édition
//

var mode_edition = false; // au chargement le mode édition est désactivé
var nb_init = 0; // cas particulier du premier clic sur le mode édition

$(document).on('click','#mode_edition', function () {  // on ajoute un événement sur le bouton mode_edition
  if (mode_edition===false) {  // cas où on n'était pas encore en mode édition
    mode_edition = true; // on passe en mode edition
    gEnableAutoRefresh = false;
    affiche_sousbandeau(false); // on masque le sous-bandeau pour permettre d'accéder à toute la page
    sousbandeau=false;
    nb_init ++;
  } else {
    mode_edition = false; // on sort du mode edition
    gEnableAutoRefresh = true;
  }
  menu_edition(mode_edition, nb_init); // on active ou désactive le mode édition du menu
  elements_edition(mode_edition, nb_init); // on active ou désactive le mode édition des elements des vues
});


///////////////////////////////////////////////////////////
// Mode Edition du MENU ///////////////////////////////////
///////////////////////////////////////////////////////////

function ajoute_edition_controles(elt)
{
  elt.append('<div style="position:absolute;top:-8px;left:8px;" class="edit_item_menu controle_edit_menu"> <img width="26" height="26" src = "./img/edit3.png"/></div>');
  elt.append('<div style="position:absolute;top:-8px;right:8px;" class="delete_item_menu controle_edit_menu"> <img width="26" height="26" src = "./img/delete3.png"/></div>');
}

// fonction qui active ou désactive le mode édition du menu
function menu_edition(actif, nb_init) {
  if (actif == true) { // si on doit l'activer
    if (nb_init < 2) { // première activation seulement
      $("#list-menu").sortable({ // on rend les item du menu déplaçables
        placeholder: 'fantome',     // style appliqué à la case vide quand on bouge une élément
        cancel: "#menu_ajouter, #vues_ajouter", // Interdiction de bouger les boutons d'ajout
        update: function () {     // quand on déplace en élément, on enregistre les positions par ajax
          var ordre = $('#list-menu').sortable('serialize');  //  récupération des données à mémoriser
          $.post('./fonctions/ajax_menu.php?requete=ordre', ordre);  // appel du fichier qui enregistre dans la base
        }
      });
      $("#list-menu").disableSelection();  // évite de sélectionner le contenu pendant le glissé
    }
    
    // On rajoute les boutons Edit/Delete
    $("#list-menu").children().each(function(n) {
      switch($(this).attr("id")) {
        case "menu_ajouter":
        case "vues_ajouter":
          break;
        default:
          ajoute_edition_controles($(this));
          break;
      }
    });
    
    $("#list-menu").sortable('enable'); // on réactive le glissé si on était précédemment sorti du mode édition (je n'ai pas réussi à le mettre dans les options précédentes, ça ne marchait pas)
    $('.menu_editable').removeClass('menu_editable').addClass('menu_active'); // on modifie l'aspect des item du menu pour signaler qu'ils sont déplaçables
    
    if (nb_init < 2) { // première activation seulement
      
      // on rend les item insensible au click
      $(document).on('click', ".menu_active > a", function (event) {
        event.preventDefault();
      });
      
      // Gestion du bouton delete
      $(document).on('click', ".delete_item_menu", function (event) {
        var id = $(this).parents('div').attr('id').replace('menu_','');
        askConfirmDeletion2(function() {
          $.ajax({
            type: "POST",
            url: "./fonctions/ajax_menu.php?requete=del",
            data: {id_menu:id},
            success : function(contenu,etat){
              // On fait disparaitre l'élément du menu
              $("#menu_" + id).remove();
            }
          });
        });
      });
      
      // Gestion du bouton edit
      $(document).on('click', ".edit_item_menu", function (event) { // on rend les item modifiables au click
        var id = $(this).parents('div').attr('id').replace('menu_','');
        $.ajax({
          type: "POST",
          url: "./fonctions/ajax_menu.php?requete=modifier",
          data: {id_menu:id}, // on récupère le code html (généré par php pour les menus déroulants) du formulaire
          success : function(contenu,etat){
            $('#dialog_menu_modifier').html(contenu); // on ajoute le formulaire à notre page
            
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
            
            // Affiche la boite de dialogue
            $("#dialog_menu_modifier").dialog("open");
          }
        });
      });
    }
    $('#menu_ajouter').css('display','inline-block'); // on montre le bouton permettant d'ajouter des item
    $('#vues_ajouter').css('display','inline-block'); // on montre le bouton permettant d'ajouter des vues
  }
  else
  {
    $("#list-menu").sortable('disable'); // on désactive le glissé
    $('.menu_active').removeClass('menu_active').addClass('menu_editable'); // on remet le style normal des item du menu
    $('#menu_ajouter').hide(); // on cache le bouton permettant d'ajouter des éléments de menu
    $('#vues_ajouter').hide(); // on cache le bouton permettant d'ajouter des vues
    
    // On supprime les boutons Edit/Delete
    $(".controle_edit_menu").remove();
  }
}

// événement sur le bouton ajouter du menu = on affiche le formulaire d'ajout
$(document).on('click','#menu_ajouter', function() {
  $.ajax({
    type: "POST",
    url: "./fonctions/ajax_menu.php?requete=formulaire", // on récupère le code html (généré par php pour les menus déroulants) du formulaire
    success : function(contenu, etat){
      $('#dialog_menu_ajouter').html(contenu); // on ajoute le formulaire à notre page
      
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
      
      // Affiche la boite de dialogue
      $("#dialog_menu_ajouter").dialog("open");
    }
  }); 
});

// Fonction qui permet d'insérer un nouvel element dans le menu
function insere_element_menu(id, page, icone, libelle)
{
  $('<div id="menu_' + id + '" class="menu_editable" style="position:relative;left:0px;"></div>').insertBefore( "#menu_ajouter" );
  rempli_element_menu(id, page, icone, libelle);
}

// Fonction qui permet d'insérer un nouvel element dans le menu
function rempli_element_menu(id, page, icone, libelle)
{
  $("#menu_" + id).html('<A HREF="' + page + '"><img src = "./img/' + icone + '"/><span>' + libelle + '</span></a>');
}

//////////////////////////
// Ajout d'une vue
//////////////////////////

// événement sur le bouton ajouter du menu = on affiche le formulaire d'ajout
$(document).on('click','#vues_ajouter', function() {
  $.ajax({
    type: "POST",
    url: "./fonctions/ajax_vues.php?requete=nouvelle_vue_form", // on récupère le code html (généré par php pour les menus déroulants) du formulaire
    success : function(contenu, etat){
      $('#dialog_vues_ajouter').html(contenu); // on ajoute le formulaire à notre page
            
      // Affiche la boite de dialogue
      $("#dialog_vues_ajouter").dialog("open");
    }
  }); 
});

// fonction qui permet de générer le formulaire d'ajout des vues
$(function() {
        $( "#dialog_vues_ajouter" ).dialog({
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
            buttons: {
                "Valider": function() {
                    var bouton = $( this );
                    var libelle=$('#libelle').val();
                    $("#waiting").fadeIn();
                    $.ajax({
                        type: "POST",
                        url: "./fonctions/ajax_vues.php?requete=nouvelle_vue", // on sauvegarde les modifications
                        data: {libelle:libelle},
                        success : function(contenu){
                            // prevoir ici le refresh pour afficher le nouvel élément
                            bouton.dialog( "close" );
                            $("#waiting").delay(300).fadeOut();
                        }
                    });
                },
                "Annuler": function() {
                    // Fermeture de la boite de la dialogue
                    $( this ).dialog( "close" );
                }
            }
        });
    });

//////////////////////////
// Gestion de l'affichage dynamique
//////////////////////////

// fonction qui déroule/rentre le sous-bandeau du menu zihome (onnexion/admin/édition)
function affiche_sousbandeau(booleen) {
  if (booleen==true) {
    $('#bouton_menu').addClass('active');
    $('#sous-menu-zihome').slideDown(200);
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
    
    if (mode_edition)
    {
      // on sort du mode edition
      mode_edition = false;
      gEnableAutoRefresh = true;
      menu_edition(mode_edition, nb_init); // on active ou désactive le mode édition du menu
      elements_edition(mode_edition, nb_init); // on active ou désactive le mode édition de la vue
    }
    else
    {
      if (sousbandeau == true) {  // s'il était affiché, on le masque
        affiche_sousbandeau(false);
        sousbandeau=false;
      } else {  // s'il était masqué, on l'affiche
        affiche_sousbandeau(true);
        sousbandeau=true;
      }
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


///////////////////////////////////////////////////////////
// Mode Edition des elements des vues /////////////////////
///////////////////////////////////////////////////////////

function ajoute_edition_controles_elements(elt)
{
  elt.append('<div class="edit_item_elements controle_edit_elements"> <img width="26" height="26" src = "./img/edit3.png"/></div>');
  elt.append('<div class="delete_item_elements controle_edit_elements"> <img width="26" height="26" src = "./img/delete3.png"/></div>');
}

$.drag_edit = $.fn.drag_edit = function() {
  return $(this).draggable({ // on rend les éléments déplaçables
            grid: grid_array,
            containment: "#global",
            snap: false,
            start: function () {
//              $(this).zindexmax(".vues_elements"); // on le place au premier plan
            },
            stop: function () {     // quand on déplace en élément, on enregistre les positions par ajax
              if (grid_array!=false) {// on l'aligne sur la grille s'il ne l'était pas (si option d'accrochage)
                y = grid_value*Math.floor(parseInt($(this).position().top)/grid_value); 
                x = grid_value*Math.floor(parseInt($(this).position().left)/grid_value);
                $(this).css({top:y+'px', left:x+'px'});
              } else {
                y = parseInt($(this).position().top); 
                x = parseInt($(this).position().left);
              }
              
              id = $(this).attr('data-key');
              zindex=$(this).zIndex();
              $("#waiting").fadeIn();
              $.ajax({
                type: "POST",
                url: "./fonctions/ajax_vues.php?requete=position",
                data: {id:id,x:x,y:y,zindex:zindex},
                success : function(){
                  verification_zindex(vue); // réordonne pour éviter que les cadres ne passent devant les autres éléments
                  $("#waiting").delay(300).fadeOut();
                }
              });
            }
          })
}
$.redim_edit = $.fn.redim_edit = function() {
  return $(this).resizable({
            grid:[10,10],
            handles: "n, e, w, s, se",
            "zIndex": $(this).zIndex()+1,
            alsoResize: $(this).find("span"),
            stop: function() {
              w = $(this).width();
              h = $(this).height();
              y = parseInt($(this).position().top);
              x = parseInt($(this).position().left);
              id = $(this).attr('data-key');
              $("#waiting").fadeIn();
              $.ajax({
                type: "POST",
                url: "./fonctions/ajax_vues.php?requete=redim",
                data: {id:id,w:w,h:h,x:x,y:y},
                success: function() {
                  $("#waiting").delay(300).fadeOut();
                }
              });
            }
          });
}

function activation_ajout() {
  $.ajax({
    type: "POST",
    url: "./fonctions/ajax_vues.php?requete=formulaire", // on récupère le code html (généré par php pour les menus déroulants) du formulaire
    success : function(contenu, etat){
      $('#dialog_elements_ajouter').html(contenu); // on ajoute le formulaire à notre page
      
      $("select[name='elements_type']").on('change', function() {  // on modifie le formulaire en fonction du type d'élement choisi
        var type = $("select[name='elements_type']").val();
        switch(type) {
          case "fonction":
            $('#width').val(500);
            $('#height').val(200);
            $('*[data-display="list_scenarios"]').remove();
            $('*[data-display="list_stickers"]').remove();
            $('*[data-display="list_meteo"]').remove();
            $('*[data-display="list_peri"]').remove();
            $('*[data-display="icone"]').fadeOut();
            $('*[data-display="etiquette"]').fadeOut();
            $.ajax({
              type: "POST",
              url: "./fonctions/ajax_db.php?requete=select_modules",
              success : function(contenu, etat) {
                // si la requete a renvoyé une liste, on ajoute le menu déroulant des modules à la suite
                $("select[name='elements_type']").after(contenu); 
                // on récupère le choix du module (celui affiché par défaut ou à chaque changement) pour le mettre dans le champ masqué "element_url"
                $("input[name='element_url']").val($("select[id='list_modules']").val()); 
                $("select[id='list_modules']").on('change', function() { 
                  $('*[data-display="list_peri"]').remove(); 
                  $("input[name='element_url']").val($("select[id='list_modules']").val());
                  // on récupère les infos du module choisi pour savoir quels périphériques on affiche
                  var module = $("select[id='list_modules']").val();
                  var type="Global";
                  if (module.substr(-6)!="global") {
                    var tab_type=module.split("-");
                    type=tab_type[0].substr(0,tab_type[0].length-1);
                    if (type=="Actionneurs") { type="actioneur"}
                    $.ajax({   // on ajoute la liste déroulante des périphériques et l'action quand on y touche 
                      type: "POST",
                      url: "./fonctions/ajax_db.php?requete=select_peri",
                      data: {type:type},
                      success : function(contenu, etat) {
                        // si la requete a renvoyé une liste, on ajoute le menu déroulant des modules à la suite
                        $('*[data-display="list_modules"]').after(contenu); 
                        // on récupère le choix du peri (celui affiché par défaut ou à chaque changement) pour le mettre dans le champ masqué "peripheriques"
                        $("input[id='peripherique']").val($("select[id='list_peri']").val()); 
                        $("select[id='list_peri']").on('change', function() {  
                          $("input[id='peripherique']").val($("select[id='list_peri']").val());
                        });
                      }
                    });
                  }
                });
              }
            });
            $("select[id='list_modules']").trigger('change',"Actionneurs - Tableau_global.php"); // première initialisation avec module actionneurs
            break;

          case "actioneur" :
          case "capteur":
          case "conso":
          case "temperature":
          case "eau":
          case "vent":
          case "pluie":
          case "luminosite":
            $('#width').val(50);
            $('#height').val(50);
            $('*[data-display="list_modules"]').remove();
            $('*[data-display="list_scenarios"]').remove();
            $('*[data-display="list_stickers"]').remove();
            $('*[data-display="list_meteo"]').remove();
            $('*[data-display="icone"]').fadeIn();
            $('*[data-display="etiquette"]').fadeIn();
            $.ajax({   // on ajoute la liste déroulante des périphériques et l'action quand on y touche - à améliorer par la suite pour ne retenir que les périphériques pertinents selon les modules
              type: "POST",
              url: "./fonctions/ajax_db.php?requete=select_peri",
              success : function(contenu, etat) {
                // si la requete a renvoyé une liste, on ajoute le menu déroulant des modules à la suite
                $("select[name='elements_type']").after(contenu); 
                // on récupère le choix du peri (celui affiché par défaut ou à chaque changement) pour le mettre dans le champ masqué "peripheriques"
                $("input[id='peripherique']").val($("select[id='list_peri']").val()); 
                $("select[id='list_peri']").on('change', function() {  
                  $("input[id='peripherique']").val($("select[id='list_peri']").val());
                });
              }
            });
            $(document).on('click', "[name='list_icone']", function() {
                      $.ajax({
                        type: "POST",
                        url: "./fonctions/ajax_vues.php?requete=icones",
                        success: function(contenu,etat) {
                          $("#list_icone").html(contenu);
                          $(".list_icone").on('click', function() {
                            var url=$(this).attr('data-key').replace(icone+'c_','');
                            $("[name='list_icone']").attr('src','./img/icones/'+icone+'c_'+url);
                            $("[id=url]").val(url);
                            $("#list_icone").dialog("close");
                          });
                          $("#list_icone").dialog("open");
                        }
                      });
                    });
            break;

          case "scenario":
            $('#width').val(150);
            $('#height').val(30);
            $('*[data-display="icone"]').fadeOut();
            $('*[data-display="etiquette"]').fadeIn();
            $('*[data-display="list_modules"]').remove();
            $('*[data-display="list_peri"]').remove();
            $('*[data-display="list_stickers"]').remove();
            $('*[data-display="list_meteo"]').remove();
            $('#color').val('#ffffff');
            $.ajax({
              type: "POST",
              url: "./fonctions/ajax_db.php?requete=select_scenarios",
              success : function(contenu, etat) {
                // si la requete a renvoyé une liste, on ajoute le menu déroulant des modules à la suite
                $("select[name='elements_type']").after(contenu); 
                // on récupère le choix du scénario (celui affiché par défaut ou à chaque changement) pour le mettre dans le champ masqué "peripherique" et en libelle par défaut
                $("input[id='peripherique']").val($("select[id='list_scenarios']").val()); 
                $("input[id='libelle']").val($("select[id='list_scenarios']").val()); 
                $("select[id='list_scenarios']").on('change', function() {  
                  $("input[id='peripherique']").val($("select[id='list_scenarios']").val());
                  $("input[id='libelle']").val($("select[id='list_scenarios']").val()); 
                });
              }
            });
            break;

          case "textdyn":
            $('#color').val('#000000');
            $('#width').val(150);
            $('#height').val(30);
            $('*[data-display="etiquette"]').fadeIn();
            $('*[data-display="icone"]').fadeOut();
            $('*[data-display="list_modules"]').remove();
            $('*[data-display="list_scenarios"]').remove();
            $('*[data-display="list_peri"]').remove();
            $('*[data-display="list_stickers"]').remove();
            $('*[data-display="list_meteo"]').remove();
            break;

          case "sticker":
            $('#width').val(50);
            $('#height').val(50);
            $('*[data-display="icone"]').fadeOut();
            $('*[data-display="etiquette"]').fadeOut();
            $('*[data-display="list_modules"]').remove();
            $('*[data-display="list_scenarios"]').remove();
            $('*[data-display="list_peri"]').remove();
            $('*[data-display="list_meteo"]').remove();
            $('*[data-display="style_avance"]').fadeOut();
            $.ajax({
              type: "POST",
              url: "./fonctions/ajax_db.php?requete=select_stickers",
              success : function(contenu, etat) {
                // si la requete a renvoyé une liste, on ajoute le menu déroulant des modules à la suite
                $("select[name='elements_type']").after(contenu); 
                // on récupère le choix du sticker (celui affiché par défaut ou à chaque changement) pour le mettre dans le champ masqué "url"
                $("input[name='element_url']").val($("select[id='list_stickers']").val()); 
                $("select[id='list_stickers']").on('change', function() {  
                  $("input[name='element_url']").val($("select[id='list_stickers']").val());
                });
              }
            });
            break;

          case "meteo":
            $('#width').val(50);
            $('#height').val(50);
            $('*[data-display="icone"]').fadeOut();
            $('*[data-display="etiquette"]').fadeOut();
            $('*[data-display="list_modules"]').remove();
            $('*[data-display="list_scenarios"]').remove();
            $('*[data-display="list_peri"]').remove();
            $('*[data-display="list_stickers"]').remove();
            $('*[data-display="style_avance"]').fadeOut();
            $.ajax({
              type: "POST",
              url: "./fonctions/ajax_db.php?requete=select_meteo",
              success : function(contenu, etat) {
                // si la requete a renvoyé une liste, on ajoute le menu déroulant des modules à la suite
                $("select[name='elements_type']").after(contenu); 
                // on récupère le choix du sticker (celui affiché par défaut ou à chaque changement) pour le mettre dans le champ masqué "url"
                $("input[name='element_url']").val($("select[id='list_meteo']").val()); 
                $("select[id='list_meteo']").on('change', function() {  
                  $("input[name='element_url']").val($("select[id='list_meteo']").val());
                });
              }
            });
            break;
          case "pollution":
            $('#width').val(50);
            $('#height').val(50);
            $('*[data-display="icone"]').fadeOut();
            $('*[data-display="etiquette"]').fadeOut();
            $('*[data-display="list_modules"]').remove();
            $('*[data-display="list_scenarios"]').remove();
            $('*[data-display="list_peri"]').remove();
            $('*[data-display="list_stickers"]').remove();
            $('*[data-display="list_meteo"]').remove();
            $('*[data-display="style_avance"]').fadeOut();
            break;
        }
        $('*[data-display="style_avance"]').fadeIn();

      });
      
      $("select[name='elements_type']").trigger('change',"scenario"); // première initialisation avec mode module par défaut

      $("input[id='style_avance']").on('click', function(){
        if ($(this).prop("checked") == true) {
          $('*[data-display="position"]').fadeIn();
                $('*[data-display="police"]').fadeIn();
                $('*[data-display="css"]').fadeIn();
                $('*[data-display="condition"]').fadeIn();
                 //$('*[data-display="visible"]').fadeIn();
          } else {
                $('*[data-display="position"]').fadeOut();
                $('*[data-display="police"]').fadeOut();
                $('*[data-display="css"]').fadeOut();
                $('*[data-display="condition"]').fadeOut();
                 //$('*[data-display="visible"]').fadeIn();
          }
        });

      // Affiche la boite de dialogue
      $("#dialog_elements_ajouter").dialog("open");
    }
  }); 
}

// fonction qui active ou désactive le mode édition des elements
function elements_edition(actif, nb_init) {
  if (actif == true) { // si on doit l'activer

    afficher_elements(tableau_elements, false).done(function () {  // on attend que tout soit bien affiché avant de faire la suite
      
      // On ajoute les boutons Edit/Delete
      $("#global .vues_elements").each(function(n) {
        ajoute_edition_controles_elements($(this));
      });
      
      // on ajoute une classe si on veut ultérieurement modifier l'aspect
      $("#global .vues_elements").addClass('vues_elements_editables');
      
      // on désactive la réaction au clic (sinon on lance les scénarios en cliquant sur le bouton éditer...)
      retirer_comportement_elements();
      $("#global").disableSelection();  // évite de sélectionner le contenu pendant le glissé

      // on ajoute la possibilité de déplacer ou redimensionner 
        $("#global .vues_elements").each(function(n) {
          $(this).drag_edit().redim_edit();
        });

        // Possibilité d'ajouter des éléments en cliquant sur le fond
        $(document).on('click','#fond_vue', function() {
          activation_ajout();
        });
        $("#fond_vue").css('cursor', 'crosshair');
        $("#fond_vue").css('background-image','linear-gradient(transparent '+(grid_value-1)+'px, rgba(220,220,200,.6) '+grid_value+'px, transparent '+grid_value+'px), linear-gradient(90deg, transparent '+(grid_value-1)+'px, rgba(220,220,200,.6) '+grid_value+'px, transparent '+grid_value+'px)');
        $("#fond_vue").css('background-size','100% '+grid_value+'px, '+grid_value+'px 100%');
            
        // Gestion du bouton delete
        $(document).on('click', ".delete_item_elements", function (event) {
          var id = $(this).parents('div').attr('data-key');
          askConfirmDeletion2(function() {
            $("#waiting").fadeIn();
            $.ajax({
              type: "POST",
              url: "./fonctions/ajax_vues.php?requete=del",
              data: {id:id},
              success : function(contenu){
                // On fait disparaitre l'élément 
                $("#elem-" + id).remove();
                $("#waiting").delay(300).fadeOut();
              }
            });
          });
        });
        
        // Gestion du bouton edit
        $(document).on('click', ".edit_item_elements", function (event) { // on rend les item modifiables au click
          var id = $(this).parents('div').attr('data-key');
          $.ajax({
            type: "POST",
            url: "./fonctions/ajax_vues.php?requete=modifier",
            data: {id:id}, // on récupère le code html (généré par php pour les menus déroulants) du formulaire
            success : function(contenu,etat){
              $('#dialog_elements_modifier').html(contenu); // on ajoute le formulaire à notre page
                    $(document).on('click', "[name='list_icone']", function() {
                      $.ajax({
                        type: "POST",
                        url: "./fonctions/ajax_vues.php?requete=icones",
                        success: function(contenu,etat) {
                          $("#list_icone").html(contenu);
                          $(".list_icone").on('click', function() {
                            var url=$(this).attr('data-key').replace(icone+'c_','');
                            $("[name='list_icone']").attr('src','./img/icones/'+icone+'c_'+url);
                            $("[id=url]").val(url);
                            $("#list_icone").dialog("close");
                          });
                          $("#list_icone").dialog("open");
                        }
                      });
                    });
              // Affiche la boite de dialogue
              $("#dialog_elements_modifier").dialog("open");
            }
          });
        });

    }); 

    
  }  else  { // si on sort du mode édition

    $("#global .vues_elements").draggable('destroy').resizable('destroy'); // on désactive le glissé 
    $("#global .vues_elements").removeClass('vues_elements_editables').removeClass('ui-state-disabled'); // on remet le style normal des elements
    $(document).off('click','#fond_vue'); // on désactive l'ajout au clic sur le fond
    $("#fond_vue").css('cursor', 'pointer');
    $("#fond_vue").css('background-image','none');

    // on réactive le comportement des éléments au clic
    ajouter_comportement_elements();
    
    // On supprime les boutons Edit/Delete
    $(document).off('click', ".delete_item_elements");
    $(document).off('click', ".edit_item_elements");
    $(".controle_edit_elements").remove();

    // on rafraichit l'affichage en prenant en compte les conditions d'affichage
    afficher_elements(tableau_elements,true); 
  }
}







// fonction qui permet de générer le formulaire de modification des éléments
$(function() {
        $( "#dialog_elements_modifier" ).dialog({
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
            buttons: {
                "Valider": function() {
                    var bouton = $( this );
                    var id=$('#elements_id_modif').val();
                    var libelle=$('#libelle').val();
                    var user=$('#user').val();
                    var width=$('#width').val();
                    var height=$('#height').val();
                    var left=$('#left').val();
                    var top=$('#top').val();
                    var url=$('#url').val();
                    var peripherique=$('#peripherique').val();
                    var option=$('#option').val();
                    var font=$('#font').val();
                    var color=$('#color').val();
                    var size=$('#size').val();
                    if ($('#bold').prop('checked')==true) { bold=1} else {bold=0}
                    if ($('#italic').prop('checked')==true) { italic=1} else {italic=0}
                    var border=$('#border').val();
                    var condition=$('#condition').val();
                    var affich_libelle=0;
                    if ($('#affich_libelle').prop('checked')==true) { affich_libelle=1}
                    $("#waiting").fadeIn();
                    $.ajax({
                        type: "POST",
                        url: "./fonctions/ajax_vues.php?requete=maj", // on sauvegarde les modifications
                        data: {id:id, libelle:libelle, user:user, width:width, height:height, left:left, top:top, url:url, peripherique:peripherique, option:option, font:font, border:border, color:color, size:size, bold:bold, italic:italic, condition:condition, affich_libelle:affich_libelle},
                        success : function(contenu){
                            console.log(contenu);
                            var tableau = $.parseJSON(contenu);
                            insere_element(tableau,false).done(function() {
                              ajoute_edition_controles_elements($("#elem-" + tableau[0]));
                              bouton.dialog( "close" );
                              $("#waiting").delay(300).fadeOut();
                            });
                            
                        }
                    });
                },
                "Annuler": function() {
                    // Fermeture de la boite de la dialogue
                    $( this ).dialog( "close" );
                }
            }
        });
    });

// fonction qui permet d'afficher les icones
$(function() {
  $("#list_icone").dialog({
    resizable: false,
    height:300,
    width:500,
    autoOpen: false,
    modal: true,
    closeText: "",
    open: function (event, ui) {
      $('.ui-dialog').css('z-index',999999);
      $('.ui-widget-overlay').css('z-index',999998);
    },
    buttons: {
      "Annuler": function() {
        // Fermeture de la boite de la dialogue
        $( this ).dialog( "close" );
      }
    }
  });
});

// fonction qui permet de générer le formulaire d'ajout des éléments
$(function() {
        $( "#dialog_elements_ajouter" ).dialog({
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
            buttons: {
                "Valider": function() {
                    var bouton = $( this );
                    var type=$('#type').val();
                    var libelle=$('#libelle').val();
                    var user=$('#user').val();
                    var width=$('#width').val();
                    var height=$('#height').val();
                    var left=$('#left').val();
                    var top=$('#top').val();
                    var url=$('#url').val();
                    var peripherique=$('#peripherique').val();
                    var option=$('#option').val();
                    var font=$('#font').val();
                    var color=$('#color').val();
                    var size=$('#size').val();
                    if ($('#bold').prop('checked')==true) { bold=1} else {bold=0}
                    if ($('#italic').prop('checked')==true) { italic=1} else {italic=0}
                    var border=$('#border').val();
                    var condition=$('#condition').val();
                    var affich_libelle=0;
                    if ($('#affich_libelle').prop('checked')==true) { affich_libelle=1}
                    $("#waiting").fadeIn();
                    $.ajax({
                        type: "POST",
                        url: "./fonctions/ajax_vues.php?requete=ajouter", // on sauvegarde les modifications
                        data: {vue:vue, type:type, libelle:libelle, user:user, width:width, height:height, left:left, top:top, url:url, peripherique:peripherique, option:option, font:font, border:border, color:color, size:size, bold:bold, italic:italic, condition:condition, affich_libelle:affich_libelle},
                        success : function(contenu){
                            var tableau = $.parseJSON(contenu);
                            insere_element(tableau,false).done(function() {
                              ajoute_edition_controles_elements($("#elem-" + tableau[0]));
                              $("#elem-" + tableau[0]).drag_edit();
                              $("#elem-" + tableau[0]).redim_edit();
                              bouton.dialog( "close" );
                              $("#waiting").delay(300).fadeOut();
                            });

                        }
                    });
                },
                "Annuler": function() {
                    // Fermeture de la boite de la dialogue
                    $( this ).dialog( "close" );
                }
            }
        });
    });


      $('#dialog_elements_ajouter').on('dialogclose', function() { // annule les effets précédents lorsqu'on ferme le formulaire, pour ne pas les cumuler si on utilise plusieurs fois le formulaire
        $("select[name='elements_type']").off('change');
      });


      