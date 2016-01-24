<? 
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin')
{
  include("./lib/versions.php");
?>
<link rel="stylesheet" href="./js/themes/jquery.ui.core.min.css">
<link rel="stylesheet" href="./js/themes/jquery.ui.theme.min.css">
<link rel="stylesheet" href="./js/themes/jquery.ui.datepicker.min.css">
<link rel="stylesheet" href="./js/themes/jquery.ui.dialog.min.css">
<link rel="stylesheet" href="./styles/administration.css" type="text/css" media="all">

<?
include("./fonctions/dialogue_confirmation.php");
?>

<center>
<div id="sous-menu">
  <div><A HREF="./index.php?page=administration&detail=paramettres">Param&egrave;tres</A></div>
  <div><A HREF="./index.php?page=administration&detail=gerer_modules">G&eacute;rer les modules</A></div>
  <div><A HREF="./index.php?page=administration&detail=gerer_users">G&eacute;rer les utilisateurs</A></div>
  <div><A HREF="./index.php?page=administration&detail=gerer_vues">G&eacute;rer les vues</A></div>
  <div><A HREF="./index.php?page=administration&detail=affecter_sonde">G&eacute;rer les sondes</A></div>
  <div><A HREF="./index.php?page=administration&detail=affecter_actioneur">Affecter un actioneur</A></div>
  <div><A HREF="./index.php?page=administration&detail=affecter_capteur">Affecter un capteur</A></div>
  <div><A HREF="./index.php?page=administration&detail=affecter_scenario">Affecter un sc&eacute;nario</A></div>
  <?
  // Affiche les pages d'administration des differents modules
  $query = "SELECT * FROM modules WHERE actif = '1'";
  $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while ($data = mysql_fetch_assoc($req))
  {
    if($data['url'] == 'plan') {
      ?>
      <div><A HREF="./index.php?page=administration&detail=gerer_pieces">G&eacute;rer les pi&egrave;ces</A></div>
      <div><A HREF="./index.php?page=administration&detail=gerer_stickers">G&eacute;rer les stickers</A></div>
      <div><A HREF="./index.php?page=administration&detail=gerer_dynaText">G&eacute;rer les textes dynamiques</A></div>
      <?
    }
    else if($data['url'] == 'accueil') {
      ?>
      <div><A HREF="./index.php?page=administration&detail=accueil">Page Accueil</A></div>
      <?
    }
    else if($data['url'] == 'video') {
      ?>
      <div><A HREF="./index.php?page=administration&detail=video">Cam&eacute;ras</A></div>
      <?
    }
    else if($data['url'] == 'iphone') {
      ?>
      <div><A HREF="./index.php?page=administration&detail=iphone">iPhone</A></div>
      <?
    }
    else if($data['url'] == 'android') {
      ?>
      <div><A HREF="./index.php?page=administration&detail=android">Android</A></div>
      <?
    }
    else if($data['url'] == 'conso_elec') {
      ?>
      <div><A HREF="./index.php?page=administration&detail=verif_conso">V&eacute;rification donn&eacute;es conso</A></div>
      <?
    }
  }
  ?> 
  
<? /*  <A HREF="./index.php?page=administration&detail=gerer_protocol">G&eacute;rer les protocoles</A> */ ?>
  <div><A HREF="./index.php?page=administration&detail=messages">Messages Zibase</A></div>
  <div><A HREF="./index.php?page=administration&detail=variables">Variables</A></div>
  <div><A HREF="./index.php?page=administration&detail=log">Log</A></div>
  <?
  // Verification des mises a jour
  if ($version_local < $version_server) {
    echo "<div><A HREF='./index.php?page=administration&detail=update'><li class=update>Nouvelle version disponible</A></div>";
  }
  ?>
  <span style="font-size: 10px; float:right;">
  <?
    echo "v " . $version_local;
    if ($version_dev == "true")
    {
      echo " (dev)";
    }
  ?>
  </span>
</div>
<div id="admin">
  <div id="waiting"></div>
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
