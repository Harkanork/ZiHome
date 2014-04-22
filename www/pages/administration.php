<? 
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin')
{
?>
<link rel="stylesheet" href="./js/themes/jquery.ui.core.min.css">
<link rel="stylesheet" href="./js/themes/jquery.ui.theme.min.css">
<link rel="stylesheet" href="./js/themes/jquery.ui.datepicker.min.css">
<link rel="stylesheet" href="./js/themes/jquery.ui.dialog.min.css">
<link rel="stylesheet" href="./styles/administration.css" type="text/css" media="all">

<script>
var gAskConfirmURL;

function askConfirmDeletion(pURL) {
  gAskConfirmURL = pURL;
  $("#dialog-confirm").dialog("open");
}

$(function() 
{
  $( "#dialog-confirm" ).dialog(
  {
    resizable: false,
    height:160,
    width:400,
    autoOpen: false,
    modal: true,
    buttons: 
    {
      "Oui": function() 
      {
        $( this ).dialog( "close" );
        window.location.href = gAskConfirmURL;
      },
      "Non": function() 
      {
        $( this ).dialog( "close" );
      }
    }
  });
});
</script>
<div id="dialog-confirm" title="Confirmation" style="display:none;">
Confirmez-vous la suppression?
</div>

<center>
<div id="sous-menu">
  <?
  include("./pages/connexion.php");
  $query = "SELECT * FROM modules WHERE actif = '1'";
  $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while ($data = mysql_fetch_assoc($req))
  {
    if($data['libelle'] == 'plan') {
      ?>
      <A HREF="./index.php?page=administration&detail=gerer_pieces"><li>G&eacute;rer les pi&egrave;ces</li></A>
      <A HREF="./index.php?page=administration&detail=gerer_stickers"><li>G&eacute;rer les stickers</li></A>
      <A HREF="./index.php?page=administration&detail=gerer_dynaText"><li>G&eacute;rer les textes dynamiques</li></A>
      <?
    }
    else if($data['libelle'] == 'accueil') {
      ?>
      <A HREF="./index.php?page=administration&detail=accueil"><li>Page Accueil</li></A>
      <?
    }
    else if($data['libelle'] == 'video') {
      ?>
      <A HREF="./index.php?page=administration&detail=video"><li>Cam&eacute;ras</li></A>
      <?
    }
    else if($data['libelle'] == 'iphone') {
      ?>
      <A HREF="./index.php?page=administration&detail=iphone"><li>iPhone</li></A>
      <?
    }
    else if($data['libelle'] == 'android') {
      ?>
      <A HREF="./index.php?page=administration&detail=android"><li>Android</li></A>
      <?
    }
  }
  ?>
  <A HREF="./index.php?page=administration&detail=affecter_sonde"><li>G&eacute;rer les sondes</li></A>
  <A HREF="./index.php?page=administration&detail=affecter_actioneur"><li>Affecter un actioneur</li></A>
  <A HREF="./index.php?page=administration&detail=affecter_capteur"><li>Affecter un capteur</li></A>
  <A HREF="./index.php?page=administration&detail=affecter_scenario"><li>Affecter un sc&eacute;nario</li></A>
  <A HREF="./index.php?page=administration&detail=gerer_users"><li>G&eacute;rer les utilisateurs</li></A>
  <A HREF="./index.php?page=administration&detail=gerer_modules"><li>G&eacute;rer les modules</li></A>
<? /*  <A HREF="./index.php?page=administration&detail=gerer_protocol"><li>G&eacute;rer les protocoles</li></A> */ ?>
  <A HREF="./index.php?page=administration&detail=messages"><li>Messages Zibase</li></A>
  <A HREF="./index.php?page=administration&detail=variables"><li>Variables</li></A>
  <A HREF="./index.php?page=administration&detail=insertion"><li>Insertion de page</li></A>
  <A HREF="./index.php?page=administration&detail=paramettres"><li>Param&egrave;tres</li></A>
</div>
<div id="action">
  <?
  if(isset($_GET['detail'])){
    include("./pages/admin/".$_GET['detail'].".php");
  } else {
    include("./pages/admin/gerer_pieces.php");
  }
  ?>
</div>
</center>
<?
}
?>
