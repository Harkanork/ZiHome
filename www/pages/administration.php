<? 
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin')
{
?>
<link rel="stylesheet" href="./js/themes/jquery.ui.core.min.css">
<link rel="stylesheet" href="./js/themes/jquery.ui.theme.min.css">
<link rel="stylesheet" href="./js/themes/jquery.ui.datepicker.min.css">
<center>
<div id="sous-menu">
  <?
  include("./pages/connexion.php");
  $query = "SELECT * FROM modules WHERE actif = '1'";
  $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while ($data = mysql_fetch_assoc($req))
  {
    if($data['libelle'] == 'vent') {
      ?>
      <A HREF="./index.php?page=administration&detail=affecter_vent"><li>Affecter un an&eacute;mom&egrave;tre</li></A>
      <?
    }
    if($data['libelle'] == 'pluie') {
      ?>
      <A HREF="./index.php?page=administration&detail=affecter_precipitation"><li>Affecter une pr&eacute;cipitation</li></A>
      <?
    }
    if($data['libelle'] == 'conso_elec') {
      ?>
      <A HREF="./index.php?page=administration&detail=affecter_conso_elec"><li>Affecter une conso-elec</li></A>
      <?
    }
    if($data['libelle'] == 'temperature') {
      ?>
      <A HREF="./index.php?page=administration&detail=affecter_sonde"><li>Affecter une temp&eacute;rature</li></A>
      <?
    }
    if($data['libelle'] == 'luminosite') {
      ?>
      <A HREF="./index.php?page=administration&detail=affecter_luminosite"><li>Affecter une luminosit&eacute;</li></A>
      <?
    }    
    if($data['libelle'] == 'plan') {
      ?>
      <A HREF="./index.php?page=administration&detail=gerer_pieces"><li>G&eacute;rer les pi&egrave;ces</li></A>
      <A HREF="./index.php?page=administration&detail=gerer_stickers"><li>G&eacute;rer les stickers</li></A>
      <?
    }
    if($data['libelle'] == 'accueil') {
      ?>
      <A HREF="./index.php?page=administration&detail=accueil"><li>Page Accueil</li></A>
      <?
    }
    if($data['libelle'] == 'video') {
      ?>
      <A HREF="./index.php?page=administration&detail=video"><li>Cam&eacute;ras</li></A>
      <?
    }
    if($data['libelle'] == 'iphone') {
      ?>
      <A HREF="./index.php?page=administration&detail=iphone"><li>iPhone</li></A>
      <?
    }
    if($data['libelle'] == 'android') {
      ?>
      <A HREF="./index.php?page=administration&detail=android"><li>Android</li></A>
      <?
    }
  }
  ?>
  <A HREF="./index.php?page=administration&detail=affecter_actioneur"><li>Affecter un actioneur</li></A>
  <A HREF="./index.php?page=administration&detail=affecter_capteur"><li>Affecter un capteur</li></A>
  <A HREF="./index.php?page=administration&detail=affecter_scenario"><li>Affecter un sc&eacute;nario</li></A>
  <A HREF="./index.php?page=administration&detail=gerer_users"><li>G&eacute;rer les utilisateurs</li></A>
  <A HREF="./index.php?page=administration&detail=gerer_modules"><li>G&eacute;rer les modules</li></A>
  <A HREF="./index.php?page=administration&detail=gerer_protocol"><li>G&eacute;rer les protocoles</li></A>
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
