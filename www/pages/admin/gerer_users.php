<?
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin') {
  
  include('./lib/mac_address.php');
  
  // Auto connect
  if(isset($_GET['supp-auto'])) {
    $query = "DELETE FROM `auto-logon` WHERE `id`='".$_GET['supp-auto']."'";
    mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  }
  else if(isset($_POST['add-auto'])) {
    $query = "INSERT INTO `auto-logon` (pseudo, macaddress, description) VALUES ('".$_SESSION['auth']."', '".$macAddr."', '".$_POST['description']."')";
    mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  }
  // Add user
  else if(isset($_POST['add-user']))
  {
    $message = NULL;
    if (empty($_POST['login']))
    { 
      $message .= '<p>Merci de saisir un login valide.</p>'; 
    }
    else if (empty($_POST['pass']))
    { 
      $message .= '<p>Merci de saisir un mot de passe valide.</p>'; 
    }
    else if (empty($_POST['pass2']))
    { 
      $message .= '<p>Merci de saisir un mot de passe valide.</p>'; 
    }
    else if ($_POST['pass'] != $_POST['pass2'])
    { 
      $message .= '<p>Les 2 mots de passe sont diff&eacute;rents.</p>'; 
    }
    $query = "SELECT * FROM `users` WHERE pseudo = '".$_POST['login']."' ";
    $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while($data = mysql_fetch_assoc($req))
    { 
      $message .= "<p>Login d&eacute;j&agrave; utilis&eacute;.</p>"; 
    }
    if ($message == NULL)
    {
      $query = "INSERT INTO users (pseudo, pass, niveau, css, accueil) VALUES ('".$_POST['login']."', SHA1('".$_POST['pass']."'), '".$_POST['droit']."', '".$_POST['style']."', '".$_POST['accueil']."')";
      mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    } else {
      echo "<h2><span style='font-weight:bold;color:red;'>" . $message . "</span></h2>";
    }
  } 
  else if (isset($_GET['id']))
  {
    $id = $_GET['id'];
    if (isset($_POST['update-user']))
    {
      $query = null;
      if (!(empty($_POST['login'])))
      { 
        $query .= "`pseudo`= '".$_POST['login']."', "; 
      }
      $message = NULL;
      if (!(empty($_POST['password'])))
      { 
        if ($_POST['password'] != $_POST['confirmpassword'])
        {
          $message .= 'Les 2 mots de passe sont diff&eacute;rents.'; 
        }
        else
        { 
          $query .= "`pass` = SHA1('".$_POST['password']."'), "; 
        }
      }
      if ($message == NULL)
      {
        $query = "UPDATE `users` SET ".$query."`niveau`= '".$_POST['droit']."', `css` = '".$_POST['style']."', `accueil` = '".$_POST['accueil']."' WHERE `id`='".$id."'";
        mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
      } else {
        echo "<h2><span style='font-weight:bold;color:red;'>" . $message . "</span></h2>";
      }
    }
    else if (isset($_GET['del-user']))
    {
      $query = "DELETE FROM `users` WHERE `id`='".$id."'";
      mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    }
  }
  ?>
  <div id="action-tableau">
  <CENTER>
  <br>
  <TABLE border=0><TR class="title" bgcolor="#6a6a6a"><TH>Login</TH><TH>Mot de passe</TH><TH>Confirmation</TH><TH>Droits</TH><TH>Style</TH><TH>Page d'accueil</TH><TH></TH><TH></TH></TH>
  <?
  $query = "SELECT * FROM `users`";
  $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while($data = mysql_fetch_assoc($req))
  {
    echo "<TR class=\"contenu\"><FORM method=\"POST\" action=\"./index.php?page=administration&detail=gerer_users&id=".$data['id']."\">";
    echo "<TD>";
    echo "<input type=\"text\" name=\"login\" size=\"12\" maxlength=\"40\" value=\"".$data['pseudo']."\"></input>";
    echo "</TD>";
    echo "<TD><input type=\"password\" name=\"password\" size=\"12\" maxlength=\"40\"></input></TD>
          <TD><input type=\"password\" name=\"confirmpassword\" size=\"12\" maxlength=\"40\"></input></TD>
          <TD>
            <select name=\"droit\">
            <option value=\"admin\"";
            if ($data['niveau'] == "admin") { echo " selected"; }
            echo ">Administrateur</option>
              <option value=\"utilisateur\"";
            if ($data['niveau'] == "utilisateur") { echo " selected"; }
            echo ">Utilisateur</option>
            </select>
          </TD>
          <TD>
            <select name=\"style\">
            <option value=\"\"";
            if($data['css'] == "") { echo " selected"; }
            echo ">Default</option>";
            $query2 = "SELECT * FROM `css`";
            $req2 = mysql_query($query2, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
            while($data2 = mysql_fetch_assoc($req2))
            {
              echo "<option value=\"".$data2['value']."\"";
              if($data['css'] == $data2['value']) { echo " selected"; }
              echo ">".$data2['value']."</option>";
            }
    echo "</TD>
          <TD>
            <select name=\"accueil\">
            <option value=\"\"";
            if($data['accueil'] == "") { echo " selected"; }
            echo ">Default</option>";
            $query2 = "SELECT * FROM `accueil`";
            $req2 = mysql_query($query2, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
            while($data2 = mysql_fetch_assoc($req2))
            {
              echo "<option value=\"".$data2['value']."\"";
              if($data['accueil'] == $data2['value']) { echo " selected"; }
              echo ">".$data2['value']."</option>";
            }
          ?>
          </TD>
          <TD><input type="submit" name="update-user" value="Valider" class="input"></input></TD>
          </FORM>
          <td class="input">
            <center>
              <button onclick='javascript:askConfirmDeletion("./index.php?page=administration&detail=gerer_users&del-user=del-user&id=<? echo $data['id']; ?>")'>Supprimer</button>
            </center>
          </td>
        </TR>
        <?
/*      ";
    echo "<input type=\"submit\" name=\"supprimer\" value=\"Supprimer\" class=\"input\"></input></br>";
    echo "</FORM>
        echo "<TD><A HREF=\"./index.php?page=administration&detail=gerer_users&id=".$data['id']."\">Editer</A></TD></TR>";
*/
  }
  ?>
      </TABLE>
    </CENTER>
  </div>
  
  <P align=center>
  <?
  echo "
  <TABLE class=panneau_table >
    <TR class=panneau_titre>
      <TH>Nouvel utilisateur</TH>
    </TR>
    <TR>
      <TD class=panneau_centre>
      <CENTER>
        <FORM method=\"POST\" action=\"./index.php?page=administration&detail=gerer_users\">
        <table align=\"center\">
          <TR><TD class=panneau_libelle>Login</TD><TD><input type=\"text\" name=\"login\" size=\"12\" maxlength=\"40\"></input></TD></TR>
          <TR><TD class=panneau_libelle>Mot de passe</TD><TD><input type=\"password\" name=\"pass\" size=\"12\" maxlength=\"40\"></input></TD></TR>
          <TR><TD class=panneau_libelle>Confirmation</TD><TD><input type=\"password\" name=\"pass2\" size=\"12\" maxlength=\"40\"></input></TD></TR>
          <TR><TD class=panneau_libelle>Droits</TD><TD>
            <select name=\"droit\">
              <option value=\"admin\" selected>Administrateur</option>
              <option value=\"utilisateur\">Utilisateur</option>
            </select>
          </TD></TR>
          <TR>
            <TD class=panneau_libelle>Style CSS</TD>
            <TD>
              <select name=\"style\">
                <option value=\"\" selected>Default</option>";
                $query = "SELECT * FROM `css`";
                $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                while($data = mysql_fetch_assoc($req))
                {
                  echo "<option value=\"".$data['value']."\">".$data['value']."</option>";
                }
              echo "</select>";
            echo "</TD></TR>
          <TR>
            <TD class=panneau_libelle>Page d'accueil</TD>
            <TD>
              <select name=\"accueil\">
                <option value=\"\" selected>Default</option>";
                $query = "SELECT * FROM `accueil`";
                $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                while($data = mysql_fetch_assoc($req))
                {
                  echo "<option value=\"".$data['value']."\">".$data['value']."</option>";
                }
              echo "</select>";
            echo "</TD>
          </TR>
          <TR><TD colspan=2 class=panneau_boutons><center><input type=\"submit\" name=\"add-user\" value=\"Ajouter\" class=\"input\"></input></center></TD></TR>
        </table>
        </FORM>
      </center>
      </TD>
    </TR>
  </TABLE>
  </p>";
  echo "<br>";
  echo "Connexion automatique depuis les p&eacute;riph&eacute;riques suivants (uniquement sur le r&eacute;seau local).";
  ?>
  <div id="action-tableau">
  <CENTER>
  <br>
  <TABLE border=0><TR class="title" bgcolor="#6a6a6a"><TH>Login</TH><TH>Mac adresse</TH><TH>Description</TH><TH></TH></TR>
  <?
  $query = "SELECT * FROM `auto-logon`";
  $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while($data = mysql_fetch_assoc($req))
  {
    echo "<TR class=\"contenu\">
            <TD align=center>".$data['pseudo']."</TD>
            <TD align=center>".$data['macaddress']."</TD>
            <TD align=center>".$data['description']."</TD>
            <TD align=center><button onclick='javascript:askConfirmDeletion(\"./index.php?page=administration&detail=gerer_users&supp-auto=".$data['id']."\")'>Supprimer</button></TD>
          </TR>";
          
  }
  ?>
  </TABLE></CENTER></div>
  <P align=center>
  <TABLE class=panneau_table >
    <TR class=panneau_titre>
      <TH>Nouvelle connexion automatique depuis l'appareil courant</TH>
    </TR>
    <TR>
      <TD class=panneau_centre>
        <CENTER>
        <FORM method="POST" action="./index.php?page=administration&detail=gerer_users">
          <table>
            <tr><td class=panneau_libelle>Login</td><td class=panneau_libelle><? echo $_SESSION['auth'];?></td></tr>
            <tr><td class=panneau_libelle>Mac adresse</td><td class=panneau_libelle><? echo $macAddr; ?></td></tr>
            <tr><td class=panneau_libelle>Description</td><td><input type="text" name="description" size="12" maxlength="40"/></td></tr>
            <tr><td colspan=2 class=panneau_boutons><input type="submit" name="add-auto" value="Ajouter"/></td></tr>
          </table>
        </form>
        </center>
      </TD>
    </TR>
  </TABLE>
  </P>
<?
} else {
  echo "<center>acc&egrave;s non authoris&eacute;</center>";
}
?>
