<?
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin') {
  function get_distance_m($lat1, $lng1, $lat2, $lng2) {
    $earth_radius = 6378137;   // Terre = sphere de 6378km de rayon
    $rlo1 = deg2rad($lng1);
    $rla1 = deg2rad($lat1);
    $rlo2 = deg2rad($lng2);
    $rla2 = deg2rad($lat2);
    $dlo = ($rlo2 - $rlo1) / 2;
    $dla = ($rla2 - $rla1) / 2;
    $a = (sin($dla) * sin($dla)) + cos($rla1) * cos($rla2) * (sin($dlo) * sin($dlo));
    $d = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return ($earth_radius * $d);
  }
  function get_iPhone_location($periphname, $user, $pass) {
    $ch = curl_init();
    $header[] = 'Content-Type: application/json; charset=utf-8';
    $header[] = 'X-Apple-Find-Api-Ver: 2.0';
    $header[] = 'X-Apple-Authscheme: UserIdGuest';
    $header[] = 'X-Apple-Realm-Support: 1.0';
    $header[] = 'User-agent: Find iPhone/1.3 MeKit (iPad: iPhone OS/4.2.1)';
    $header[] = 'X-Client-Name: iPad';
    $header[] = 'X-Client-UUID: 0cf3dc501ff812adb0b202baed4f37274b210853';
    $header[] = 'Accept-Language: en-us';
    $header[] = 'Connection: keep-alive';
    curl_setopt($ch, CURLOPT_URL, 'https://fmipmobile.icloud.com/fmipservice/device/'.$user.'/initClient');
    curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_HEADER, TRUE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Find iPhone/1.3 MeKit (iPad: iPhone OS/4.2.1)');
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $value = curl_exec($ch);
    curl_close($ch);
    $lines = explode("\n",$value);
    foreach($lines as $line) {
      if(substr($line,0,17) == "X-Apple-MMe-Host:") {
        $server = substr($line,18,-1);
      }
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://".$server."/fmipservice/device/".$user."/initClient");
    curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Find iPhone/1.3 MeKit (iPad: iPhone OS/4.2.1)');
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $value = curl_exec($ch);
    curl_close($ch);
    $json = json_decode($value);
    $valuearray = (array)$json;
    foreach($valuearray['content'] as $periph) {
      $periphvalue = (array)$periph;
      if($periphvalue['name'] == $periphname) {
        $location = (array)$periphvalue['location'];
        return $location;
      }
    }
  }
  if(isset($_POST['site'])) {
    include("./pages/connexion.php");
    if(isset($_POST['site_valider'])) {
      if($_POST['pos_actuelle'] == "1"){
        $query0 = "SELECT * FROM iphone WHERE id = '".$_POST['id_iphone']."'";
        $req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        while ($data = mysql_fetch_assoc($req0))
        {
          $location = get_iPhone_location($data['periph_name'], $data['user'], $data['pass']);
        }
        $query = "INSERT INTO `iphone_distances` (id_iphone, sonde, latitude, longitude) VALUES ('".$_POST['id_iphone']."', '".$_POST['sonde']."', '".$location['latitude']."', '".$location['longitude']."')";
      } else {
        $query = "INSERT INTO `iphone_distances` (id_iphone, sonde, latitude, longitude) VALUES ('".$_POST['id_iphone']."', '".$_POST['sonde']."', '".$_POST['latitude']."', '".$_POST['longitude']."')";
      }
      mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
      mysql_close();
    }
    else if(isset($_POST['site_modifier'])) {
      if($_POST['pos_actuelle'] == "1"){
        $query0 = "SELECT * FROM iphone WHERE id = '".$_POST['id_iphone']."'";
        $req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        while ($data = mysql_fetch_assoc($req0))
        {
          $location = get_iPhone_location($data['periph_name'], $data['user'], $data['pass']);
        }
        $query = "UPDATE iphone_distances SET sonde = '".$_POST['sonde']."', `latitude` = '".$location['latitude']."', `longitude` = '".$location['longitude']."' WHERE id = '".$_POST['id']."'";
        //echo $query;
      } else {
        $query = "UPDATE iphone_distances SET sonde = '".$_POST['sonde']."', `latitude` = '".$_POST['latitude']."', `longitude` = '".$_POST['longitude']."' WHERE id = '".$_POST['id']."'";
      }
      mysql_query($query, $link);
    }
    else if(isset($_POST['site_supprimer'])) {
      $query = "DELETE FROM iphone_distances WHERE id = '".$_POST['id']."'";
      mysql_query($query, $link);
    }
    echo '<div id="action-tableau">';
    echo '<CENTER>';
    echo '<br>';
    echo '<TABLE border=0><TR class="title" bgcolor="#6a6a6a"><TD>Sonde</TD><TD>Latitude</TD><TD>Longitude</TD><TD>Position actuelle</TD><TD></TD><TD></TD></TR>';
    $query = "SELECT * FROM iphone_distances WHERE id_iphone = '".$_POST['id_iphone']."'";
    $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while ($data = mysql_fetch_assoc($req))
    {
      echo "<TR class=\"contenu\">";
        echo "<FORM method=POST action=\"./index.php?page=administration&detail=iphone\">";
        echo "<TD><input type=text name=sonde value=\"".$data['sonde']."\"></input></TD>";
        echo "<TD><input type=text name=latitude value=\"".$data['latitude']."\"></input></TD>";
        echo "<TD><input type=texte name=longitude value=\"".$data['longitude']."\"></input></TD>";
        echo "<TD><input type=checkbox name=pos_actuelle value=1></input></TD>";
        echo "<TD>";
          echo "<input type=hidden name=id value=".$data['id']."></input>";
          echo "<input type=hidden name=site value=".$_POST['site']."></input>";
          echo "<input type=hidden name=id_iphone value=".$_POST['id_iphone']."></input>";
          echo "<input type=submit name=site_modifier value=Valider></input>";
        echo "</TD>";
        echo "<TD><input type=submit name=site_supprimer value=Supprimer></input></TD>";
        echo "</FORM>";
      echo "</TR>";
    }
    echo "</TABLE></CENTER></div>";
    ?>
    <p align=center>
    <TABLE>
      <FORM method=POST action="./index.php?page=administration&detail=iphone">
        <tr>
          <td>Sonde :</td><td><input type=text name=sonde></input></td>
        </tr>
        <tr>
          <td>Latitude :</td><td><input type=text name=latitude></input></td>
        </tr>
        <tr>
          <td>Longitude :</td><td><input type=text name=longitude></input></td>
        </tr>
        <tr>
          <td>Position actuelle :</td><td><input type="checkbox" name="pos_actuelle" value="1"></input></td>
        </tr>
        <tr> 
          <td colspan=2 align=center>
            <input type=hidden name=site value=<? echo $_POST['site']; ?>>
            <input type=hidden name=id_iphone value=<? echo $_POST['id_iphone']; ?>>
            <input type=submit name=site_valider value=Ajouter></input>
          </td>
        </tr>
      </FORM>
    </table>
    </p>
    <?
  } else {
    include("./pages/connexion.php");
    if (isset($_POST['Ajouter'])) {
      $query = "INSERT INTO `iphone` (periph_name, user, pass) VALUES ('".$_POST['periph_name']."', '".$_POST['user']."', '".$_POST['pass']."')";
      mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    }
    else if (isset($_POST['Valider'])) {
      $query = "UPDATE iphone SET periph_name = '".$_POST['periph_name']."', `user` = '".$_POST['user']."', `pass` = '".$_POST['pass']."' WHERE id = '".$_POST['id']."'";
      mysql_query($query, $link);
    }
    else if (isset($_POST['Supprimer'])) {
      $query = "DELETE FROM iphone WHERE id = '".$_POST['id']."'";
      mysql_query($query, $link);
    }
    echo '<div id="action-tableau">';
    echo '<CENTER>';
    echo '<br>';
    echo '<TABLE border=0><TR class="title" bgcolor="#6a6a6a"><TD>Nom du p&eacute;riph&eacute;rique</TD><TD>Utilisateur</TD><TD>Mot de passe</TD><TD>Coordonn&eacute;es</TD><TD></TD><TD></TD></TR>';
    $query = "SELECT * FROM iphone";
    $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while ($data = mysql_fetch_assoc($req))
    {
      echo "<TR class=\"contenu\">";
      echo "<FORM method=POST action=\"./index.php?page=administration&detail=iphone\">";
      echo "<TD><input type=text name=periph_name value=\"".$data['periph_name']."\"></input></TD>";
      echo "<TD><input type=text name=user value=\"".$data['user']."\"></input></TD>";
      echo "<TD><input type=password name=pass value=\"".$data['pass']."\"></input></TD>";
      echo "<input type=hidden name=id value=".$data['id']."></input>";
      echo "<input type=hidden name=id_iphone value=".$data['id']."></input>";
      echo "<TD><input type=submit name=site value=Editer></input></TD>";
      echo "<TD><input type=submit name=Valider value=Valider></input></TD>";
      echo "<TD><input type=submit name=Supprimer value=Supprimer></input></TD>";
      echo "</FORM>";
      echo "</TR>";
    }
    echo "</TABLE></CENTER></div>";
    ?>
    <p align=center>
    <TABLE>
      <FORM method=POST action="./index.php?page=administration&detail=iphone">
        <tr>
          <td>Nom du p&eacute;riph&eacute;rique :</td><td><input type=text name=periph_name></input></td>
        </tr>
        <tr>
          <td>Utilisateur Icloud :</td><td><input type=text name=user></input></td>
        </tr>
        <tr>
          <td>Mot de passe Icloud :</td><td><input type=password name=pass></input></td>
        </tr>
        <tr><td colspan=2 align=center><input type=submit name=Ajouter value=Ajouter></input></td></tr>
      </FORM>
    </table>
    </p>
  <?
  }
}
?>
