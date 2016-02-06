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
  
    case "select_modules" :
      $modules = preg_grep("/\.(php)$/", scandir('../modules/'));
      echo "<TR class=\"elements_form_TR\" data-display=\"list_modules\"><TD>Module</TD><TD><select id=\"list_modules\" >";
      foreach($modules as $module){
          $module = basename($module,".php");
          echo "<option value=\"".$module."\">".$module."</option>";
      }
      echo "</TD></TR>";
      break;

    case "select_stickers" :
      $stickers = preg_grep("/\.(png|gif|jpeg|jpg)$/", scandir('../img/stickers/'));
      echo "<TR class=\"elements_form_TR\" data-display=\"list_stickers\"><TD>Image</TD><TD><select id=\"list_stickers\" >";
      foreach($stickers as $sticker){
          echo "<option value=\"".$sticker."\">".$sticker."</option>";
      }
      echo "</TD></TR>";
      break;

    case "select_meteo" :
      $meteos = scandir('../img/meteo/');
      echo "<TR class=\"elements_form_TR\" data-display=\"list_meteo\"><TD>Style</TD><TD><select id=\"list_meteo\" >";
      foreach($meteos as $meteo){
          if (($meteo<>".") OR ($meteo<>"..")) {
            echo "<option value=\"".$meteo."\">".$meteo."</option>";
          }
      }
      echo "</TD></TR>";
      break;

    case "select_scenarios" :
      echo "<TR class=\"elements_form_TR\" data-display=\"list_scenarios\"><TD>Scénario</TD><TD><select id=\"list_scenarios\" >";
      $query="SELECT * FROM `scenarios` WHERE 1=1;";
      $req=mysql_query($query);
      while ($data1 = mysql_fetch_assoc($req)){
        $libelle=$data1['libelle'];
        $nom=$data1['nom'];
        if ($libelle=="") { $libelle=$nom; }
        echo "<option value=\"".$nom."\">".$libelle."</option>";
      }
      echo "</TD></TR>";
      break;

    case "select_peri" :
      $condition = "1=1";
      if (isset($_POST['type'])) {
        $type=$_POST['type'];
        if ($type<>"Global") {
          $condition= "`periph`='".$type."'";
        }
      }
      echo "<TR class=\"elements_form_TR\" data-display=\"list_peri\"><TD>Périphérique</TD><TD><select id=\"list_peri\" >";
      $query="SELECT * FROM `peripheriques` WHERE ".$condition.";";
      $req=mysql_query($query);
      while ($data1 = mysql_fetch_assoc($req)){
        $libelle=$data1['libelle'];
        $nom=$data1['nom'];
        $id=$data1['id'];
        if ($libelle=="") { $libelle=$nom; }
        echo "<option value=\"".$id."\">".$libelle."</option>";
      }
      echo "</TD></TR>";
      break;
  }

}



?>