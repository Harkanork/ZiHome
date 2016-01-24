<?
if (isset($_GET['requete'])) {   // ne renvoie quelque chose que si on charge la page dans le cadre d'une requete ajax
	
  include("../config/conf_zibase.php");
  include("../config/variables.php");
  
  $link = mysql_connect($hote,$login,$plogin);
  if (!$link) {
    die('Non connect&eacute; : ' . mysql_error());
  }
  $db_selected = mysql_select_db($base,$link);
  if (!$db_selected) {
    die ('Impossible d\'utiliser la base : ' . mysql_error());
  }

  $requete=$_GET['requete'];
  switch($requete) {

    case "maj" :
      $db=$_POST['db'];
      $champ=$_POST['champ'];
      $id=$_POST['id'];
      $value=$_POST['value'];
      $query="UPDATE `".$db."` SET `".$champ."`='".$value."' WHERE `id`='".$id."';";
      $req=mysql_query($query);
      break;

  }

}



?>