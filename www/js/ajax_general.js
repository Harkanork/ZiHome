// fonction qui enregistre les modifications réalisées dans les champs de formulaire ayant le mot-clé data-ajax

$(document).on('change',"[data-ajax]", function() {
  var ajax = $(this).data("ajax");
  var db = $(this).data("db");
  var type = $(this).data("type");
  var champ = $(this).data("champ");
  var id = $(this).data("id");
  if (type=="text"||type=="select") {
    var value=$(this).val();
  }
  $("#waiting").fadeIn();
  $.ajax({
    type: "POST",
    url: "./fonctions/ajax_general.php?requete="+ajax,
    data: {db:db,champ:champ,id:id,value:value},
    success : function(){
      $("#waiting").delay(300).fadeOut();
    }
  });
});