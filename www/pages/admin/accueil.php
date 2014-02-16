<?
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin')
{
  include("./pages/connexion.php");
  if(isset($_POST['rapatrier'])){
    $query = "DELETE FROM `page_accueil` WHERE user = '".$_SESSION['auth']."'";
    mysql_query($query, $link);
    $query = "SELECT * FROM page_accueil WHERE user = '".$_POST['user']."'";
    $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while ($data = mysql_fetch_assoc($req))
    {
      $query0 = "INSERT INTO page_accueil (`libelle`, `user`, `width`, `height`, `left`, `top`, `border`, `url`, `peripherique`, `option`) VALUES ('".$data['libelle']."', '".$_SESSION['auth']."', '".$data['width']."', '".$data['height']."', '".$data['left']."', '".$data['top']."', '".$data['border']."', '".$data['url']."', '".$data['peripherique']."', '".$data['option']."')";
      mysql_query($query0, $link);
    }
  }
  else if(isset($_POST['Migrer'])){
    $query = "DELETE FROM `page_accueil` WHERE user = '".$_POST['user']."'";
    mysql_query($query, $link);
    $query = "SELECT * FROM page_accueil WHERE user = '".$_SESSION['auth']."'";
    $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while ($data = mysql_fetch_assoc($req))
    {
      $query0 = "INSERT INTO page_accueil (`libelle`, `user`, `width`, `height`, `left`, `top`, `border`, `url`, `peripherique`, `option`) VALUES ('".$data['libelle']."', '".$_POST['user']."', '".$data['width']."', '".$data['height']."', '".$data['left']."', '".$data['top']."', '".$data['border']."', '".$data['url']."', '".$data['peripherique']."', '".$data['option']."')";
      mysql_query($query0, $link);
    }
  }
  else if(isset($_POST['Supprimer'])){
    $query = "DELETE FROM `page_accueil` WHERE `id` = ".$_POST['id'];
    mysql_query($query, $link);
  }
  else if(isset($_POST['Valider'])){
    $url = explode("-",$_POST['module']);
    $query = "UPDATE page_accueil SET `libelle` = '".$_POST['libelle']."',`width` = '".$_POST['width']."', `height` = '".$_POST['height']."', `left` = '".$_POST['left']."', `top` = '".$_POST['top']."', `border` = '".$_POST['border']."', `url` = '".$url[0]."', `peripherique` = '".$url[1]."', `option` = '".$_POST['option']."' WHERE `id` = '".$_POST['id']."'";
    mysql_query($query, $link);
  }
  else if(isset($_POST['Ajouter'])) {
    $url = explode("-",$_POST['module']);
    $query = "INSERT INTO page_accueil (`libelle`, `user`, `width`, `height`, `left`, `top`, `border`, `url`, `peripherique`, `option`) VALUES ('".$_POST['libelle']."', '".$_SESSION['auth']."', '".$_POST['width']."', '".$_POST['height']."', '".$_POST['left']."', '".$_POST['top']."', '".$_POST['border']."', '".$url[0]."', '".$url[1]."', '".$_POST['option']."')";
    mysql_query($query, $link);
  }
  ?>
  <div id="action-tableau">
  <br><CENTER><TABLE border=0><TR class="title" bgcolor="#6a6a6a"><TD>Nom</TD><TD>Largeur</TD><TD>Hauteur</TD><TD>Droite</TD><TD>Bas</TD><TD>Bordure</TD><TD>Module</TD><TD>Options</TD><TD>&nbsp;</TD><TD>&nbsp;</TD></TR>
    <?
    $query = "SELECT * FROM page_accueil WHERE user = '".$_SESSION['auth']."'";
    $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while ($data = mysql_fetch_assoc($req))
    {
      echo "<TR class=\"contenu\">";
      echo '<FORM method="post" action="./index.php?page=administration&detail=accueil">';
      echo '<INPUT type=hidden name=id value="'. $data['id'] . '"/>';
        echo "<TD><INPUT type=text name=libelle value='".$data['libelle']."'/></TD>";
        echo "<TD><INPUT type=number style='width:60px;' name=width value='".$data['width']."'/></TD>";
        echo "<TD><INPUT type=number style='width:60px;' name=height value='".$data['height']."'/></TD>";
        echo "<TD><INPUT type=number style='width:60px;' name=left value='".$data['left']."'/></TD>";
        echo "<TD><INPUT type=number style='width:60px;' name=top value='".$data['top']."'/></TD>";
        echo "<TD><INPUT type=number style='width:60px;' name=border value='".$data['border']."'/></TD>";
        echo "<TD>";
          echo "<select name=module>";
          $query2 = "SELECT * FROM modules_accueil ORDER BY libelle";
          $req2 = mysql_query($query2, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
          while ($data2 = mysql_fetch_assoc($req2))
          {
            if ($data2['type'] == "") 
            {
              echo "<option value=\"".$data2['url']."\"";
              if ($data['url'] == $data2['url']) { echo " selected"; }
              echo ">".$data2['libelle']."</option>";
            } 
            else if ($data2['type'] == "scenario") 
            {
              $query0 = "SELECT * FROM scenarios";
              $req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
              while ($data0 = mysql_fetch_assoc($req0))
              {
                echo "<option value=\"".$data2['url']."-".$data0['id']."\"";
                if($data2['url']."-".$data0['id'] == $data['url']."-".$data['peripherique']) { echo " selected"; }
                echo ">".$data2['libelle']." ".$data0['nom']."</option>";
              }
            } 
            else 
            {
              $query0 = "SELECT * FROM peripheriques WHERE periph = '".$data2['type']."'";
              $req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
              while ($data0 = mysql_fetch_assoc($req0))
              {
                echo "<option value=\"".$data2['url']."-".$data0['id']."\"";
                if($data2['url']."-".$data0['id'] == $data['url']."-".$data['peripherique']) { echo " selected"; }
                echo ">".$data2['libelle']." ".$data0['nom']."</option>";
              }
            }
          }
          echo "</select>";
        echo "</TD>";
        echo "<TD><INPUT type=text name=option value='".$data['option']."'/></TD>";
        echo '<td class="input"><center><INPUT TYPE="SUBMIT" NAME="Valider" VALUE="Valider"/></center></td>';
        echo '<td class="input"><center><INPUT TYPE="SUBMIT" NAME="Supprimer" VALUE="Supprimer"/></center></td>';
      echo '</FORM>';
      echo "</TR>";
    }
    ?>
  </TABLE></CENTER></div>

  <P align=center>
  <FORM method="post" action="./index.php?page=administration&detail=accueil">
    Migrer le profil vers un utilisateur (attention, la migration &eacute;crase le profil existant)<br>
    <select name=user>
    <option value=default>Default</option>
    <?
    include("./pages/connexion.php");
    $query = "SELECT * FROM users WHERE pseudo != '".$_SESSION['auth']."'";
    $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while ($data = mysql_fetch_assoc($req))
    {
      echo "<option value=\"".$data['pseudo']."\">".$data['pseudo']."</option>";
    }
    ?>
    </select>
    <INPUT type=submit name=Migrer value=Migrer>
  </FORM>
  </p>
  <P align=center>
  <FORM method="post" action="./index.php?page=administration&detail=accueil">
    Rapatrier le profil d'un utilisateur (attention, la migration &eacute;crase le profil existant)<br>
    <select name=user>
      <option value=default>Default</option>
      <?
      include("./pages/connexion.php");
      $query = "SELECT * FROM users WHERE pseudo != '".$_SESSION['auth']."'";
      $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
      while ($data = mysql_fetch_assoc($req))
      {
        echo "<option value=\"".$data['pseudo']."\">".$data['pseudo']."</option>";
      }
      ?>
    </select>
    <INPUT type=submit name=rapatrier value=Rapatrier>
  </FORM>
  </p>
  <P align=center>
  <TABLE>
    <FORM method="post" action="./index.php?page=administration&detail=accueil">
    <TR><TD>Nom :</TD><TD><INPUT type=text name=libelle></INPUT></TD></TR>
    <TR><TD>Largeur :</TD><TD><INPUT type=number name=width></INPUT></TD></TR>
    <TR><TD>Hauteur :</TD><TD><INPUT type=number name=height></INPUT></TD></TR>
    <TR><TD>Position Droite :</TD><TD><INPUT type=number name=left></INPUT></TD></TR>
    <TR><TD>Position Bas :</TD><TD><INPUT type=number name=top></INPUT></TD></TR>
    <TR><TD>Taille bordure :</TD><TD><INPUT type=number name=border></INPUT></TD></TR>
    <TR><TD>Module :</TD><TD>
      <select name=module>
      <?
      include("./pages/connexion.php");
      $query = "SELECT * FROM modules_accueil ORDER BY libelle";
      $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
      while ($data = mysql_fetch_assoc($req))
      {
        if($data['type'] == "") {
          echo "<option value=\"".$data['url']."\">".$data['libelle']."</option>";
        } else if($data['type'] == "scenario") {
          $query0 = "SELECT * FROM scenarios";
          $req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
          while ($data0 = mysql_fetch_assoc($req0))
          {
            echo "<option value=\"".$data['url']."-".$data0['id']."\">".$data['libelle']." ".$data0['nom']."</option>";
          }
        } else {
          $query0 = "SELECT * FROM peripheriques WHERE periph = '".$data['type']."'";
          $req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
          while ($data0 = mysql_fetch_assoc($req0))
          {
            echo "<option value=\"".$data['url']."-".$data0['id']."\">".$data['libelle']." ".$data0['nom']."</option>";
          }
        }
      }
      ?>
      </select>
      </TD>
    </TR>
    <TR><TD>Options :</TD><TD><INPUT type=text name=option></INPUT></TD></TR>
    <TR><TD colspan=2 align=center><INPUT type=submit name=Ajouter value=Ajouter></TD></TR>
  </FORM>
  </TABLE>
  </P>
  <? 
}
?>
