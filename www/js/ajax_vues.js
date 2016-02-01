/////////////////////////////////////////////////////
// fonctions de génération des éléments de la vue  //
/////////////////////////////////////////////////////

// fonction qui boucle sur les éléments de la vue pour les insérer, avec passage de condition
function afficher_elements(tableau_elements, condition) {
	var promises = [];
	tableau_elements.forEach(function(element) {
		var def = new $.Deferred(); 
		insere_element(element, condition).done(function() {
			def.resolve(); // récupère le retour d'état de chaque élément
		});
		promises.push(def); // compile tous les retours d'état
	});
	return $.when.apply(undefined, promises).promise(); // n'est considéré comme exécutée que lorsque chaque élément est inséré
}

// fonction qui insère chaque élément à partir des infos fournies sous forme de tableau, et avec ou sans prise en compte de la condition
function insere_element(tableau, condoupas) {
	var dfd = $.Deferred();
	var id = tableau[0];
	if ($("#elem-"+id).length) {  // si l'élément existe déjà, on le retire (mise à jour affichage après modification, déplacement)
		$("#elem-"+id).remove();
	}
	var condition = tableau[20];
	if ((condition == "") || (eval(condition)) || (!condoupas)) {
		var type=tableau[2];
		var user=tableau[3];
		var width=tableau[4];
		var height=tableau[5];
		var left=tableau[6];
		var top=tableau[7];
		var zindex=tableau[8];
		var libelle=tableau[9];
		var affich_libelle=tableau[10];
		var url=tableau[11];
		var peripherique=tableau[12];
		var font=tableau[13];
		var color=tableau[14];
		var size=tableau[15];
		var bold=tableau[16];
		var italic=tableau[17];
		var border=tableau[18];
		var option=tableau[19];
		var code="<div id=\"elem-"+id+"\" data-key=\""+id+"\" class=\"vues_elements\" style=\"width: "+width+"px;height: "+height+"px;top: "+top+"px;left: "+left+"px;border: "+border+";position: absolute;z-index: "+zindex+";color: "+color+";font-size: "+size+";"+option+";";
		switch(type) {
			case 'cadre':
				var img = "./img/plan/"+url;
				code+= "background:url('"+img+"');background-size:"+width+"px "+height+"px;background-repeat:no-repeat;\">";
				if ((showAllNames) && (affich_libelle)) {
					code += '<div style="line-height: '+height+'px;">'+libelle+'</div>';
				}
				code+="</div>"; 
				$('#global').append(code);
				dfd.resolve();
				break;

			case 'scenario' :
				code += "\" name=\""+peripherique+"\">"+libelle+"</div>";
				$('#global').append(code);
				$("#elem-"+id).addClass("bouton_scenario"); // à améliorer, mais pour l'instant on a besoin de cette classe supplémentaire pour les boutons scénarios, donc on l'ajoute à la fin après création de l'élément
				dfd.resolve();
				break;

			case 'fonction' :
				code+= "background-size:"+width+"px "+height+"px;background-repeat:no-repeat;\">";
				$.ajax({
					type: "POST",
					data: {peri:peripherique},
					url: "./modules/"+url+".php?requete",
					success : function(contenu, etat) {
						code += contenu+"</div>" ;
						$('#global').append(code);
						dfd.resolve();
					}
				}); 
				break;

			case 'pollution' :
				code+= "\">";
				$.ajax({
					type: "POST",
					url: "./fonctions/ajax_vues.php?requete=pollution",
					success : function(contenu, etat) {
						code += contenu+" style=\"position:absolute; height:"+height+"px; width:"+width+"px;\"/></div>" ;
						$('#global').append(code);
						dfd.resolve();
					}
				}); 
				break;

			case 'meteo' :
				code += "\"><img src=\"./img/meteo/"+url+"/";
				$.ajax({
					type: "POST",
					url: "./fonctions/ajax_vues.php?requete=meteo",
					success : function(contenu, etat) {
						code += contenu + ".png\" style=\"position:absolute; height:"+height+"px; width:"+width+"px;\"/></div>" ;
						$('#global').append(code);
						dfd.resolve();
					}
				}); 
				break;

			case 'textdyn' :
				if(bold==1) {bold ='bold';} else { bold='normal';}
				if(italic==1) {italic ='italic';} else { italic='normal';}
				size += "px ";
				font += " ";
				code += "\"><span style=\"color:"+color+";font-family:"+font+";font-weight:"+bold+";font-style:"+italic+";font-size:"+size+"\">"+libelle+"</span></div>";
				$('#global').append(code);
				dfd.resolve();
				break;

			case 'sticker' :
				code+= "\"><img src=\"./img/stickers/"+url+"\" ></div>";
				$('#global').append(code);
				dfd.resolve();
				break;

			default :
				code+="min-width:"+widthIcones+"px;min-height:"+heightIcones+"px;\">";
				$.ajax({
					type: "POST",
					url: "./fonctions/ajax_vues.php?requete=icone_peripherique",
					data:{peri:peripherique,logo:url,top:top,left:left},
					success : function(contenu, etat) {
						code+= contenu ;
						$('#global').append(code);
						dfd.resolve();
					}
				});
				break;
		}
	} else {
		dfd.resolve();
	}
	return dfd;
}




//////////////////////////////////////////////////////////////
// fonctions utilitaires pour le comportement des éléments  //
//////////////////////////////////////////////////////////////


// fonction qui ajoute le comportement aux boutons 
function ajouter_comportement_elements() {
	$(document).on('click','.bouton_scenario', function() {
		var nom = $(this).attr('name');
		$("#waiting").fadeIn();
		$.ajax({
			type: "POST",
			url: "./fonctions/ajax_vues.php?requete=run_scen",
			data:{nom:nom},
			success: function() {
				$("#waiting").delay(300).fadeOut();
			}
		}); 
	});
	$(document).on('click','.bouton_ON', function() {
		var id = $(this).attr('data-id');
		var proto = $(this).attr('data-proto');
		$("#waiting").fadeIn();
		$.ajax({
			type: "POST",
			url: "./fonctions/ajax_vues.php?requete=peri_ON",
			data:{id:id,proto:proto},
			success: function() {
				$("#waiting").delay(300).fadeOut();
			}
		});
	});
	$(document).on('click','.bouton_OFF', function() {
		var id = $(this).attr('data-id');
		var proto = $(this).attr('data-proto');
		$("#waiting").fadeIn();
		$.ajax({
			type: "POST",
			url: "./fonctions/ajax_vues.php?requete=peri_OFF",
			data:{id:id,proto:proto},
			success: function() {
				$("#waiting").delay(300).fadeOut();
			}
		});
	});
}

// par défaut au lancement on active le comportement des boutons
$(document).ready(ajouter_comportement_elements());


// fonction qui retire le comportement des boutons (pour passer en mode édition sans risquer de déclencher des scénarios, allumer des actionneurs pendant l'édition)
function retirer_comportement_elements() {
	$(document).off('click','.bouton_scenario');
}

/////////////////////////////////////////////
// fonctions utilitaires pour l'affichage  //
/////////////////////////////////////////////

// fonction qui calcule le z-index max des éléments du DOM et permet aussi de remonter un élément au premier plan
// $.zindexmax() renvoie le z-index max de la page actuelle
// $.zindexmax(critere) renvoie le zindex max des éléments qui ont le critère en question
// $("#id_element").zindexmax() remonte cet élément au premier plan (zindexmax + 1)
$.zindexmax = $.fn.zindexmax = function(critere) {
	if( typeof(critere) == 'undefined' ){
		var critere="*";
	}
	var zmax = 0;
	$(critere).each(function() {
		var cur = $(this).zIndex();
		zmax = cur > zmax ? cur : zmax;
	});
	if (!this.jquery)
		return zmax;

	return this.each(function() {
		$(this).css("z-index", (zmax+1));
	});
}
function verification_zindex(vue) {
	$.ajax({
		type: "POST",
		url: "./fonctions/ajax_vues.php?requete=zindex",
		data: {vue:vue}
	}); 
}

