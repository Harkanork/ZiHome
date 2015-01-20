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
  <?
  // Verification des mises a jour
  if ($version_local < $version_server)
  {
    echo "<A HREF='./index.php?page=administration&detail=update'><li class=update>Nouvelle version disponible</li></A>";
  }
  
  // Affiche les pages d'administration des differents modules
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
    else if($data['libelle'] == 'conso_elec') {
      ?>
      <A HREF="./index.php?page=administration&detail=verif_conso"><li>V&eacute;rification donn&eacute;es conso</li></A>
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
  <br>
  <span style="font-size: 10px;">
  <?
    echo "v " . $version_local;
    if ($version_dev == "true")
    {
      echo " (dev)";
    }
  ?>
  </span>
  <br>
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
