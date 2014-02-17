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
  function get_android_location($apikey, $MobileNetworkCode, $carrier, $cellId, $locationAreaCode) {
    $ch = curl_init();
    $header[] = 'Content-Type: application/json';
    $file = '{
    "homeMobileCountryCode": 208,
    "homeMobileNetworkCode": '.$MobileNetworkCode.',
    "radioType": "gsm",
    "carrier": "'.$carrier.'",
    "cellTowers": [
    {
    "cellId": '.$cellId.',
    "locationAreaCode": '.$locationAreaCode.',
    "mobileCountryCode": 208,
    "mobileNetworkCode": '.$MobileNetworkCode.'
    }
    ]
    }';
    curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/geolocation/v1/geolocate?key='.$apikey);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $file);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $value = curl_exec($ch);
    curl_close($ch);
    $json = json_decode($value);
    $valuearray = (array)$json;
    $location = (array)$valuearray['location'];
    return $location;
  }
  if(isset($_POST['site'])) {
    include("./pages/connexion.php");
    if(isset($_POST['site_valider'])) {
      if($_POST['pos_actuelle'] == "1"){
        $query0 = "SELECT * FROM android WHERE id = '".$_POST['id_android']."'";
        $req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        while ($data = mysql_fetch_assoc($req0))
        {
          $location = get_android_location($data['apikey'], $data['MobileNetworkCode'], $data['carrier'], $data['cellId'], $data['locationAreaCode']);
        }
        $query = "INSERT INTO `android_distances` (id_android, sonde, latitude, longitude) VALUES ('".$_POST['id_android']."', '".$_POST['sonde']."', '".$location['lat']."', '".$location['lng']."')";
      } else {
        $query = "INSERT INTO `android_distances` (id_android, sonde, latitude, longitude) VALUES ('".$_POST['id_android']."', '".$_POST['sonde']."', '".$_POST['latitude']."', '".$_POST['longitude']."')";
      }
      mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
      mysql_close();
    }
    else if(isset($_POST['site_modifier'])) {
      if($_POST['pos_actuelle'] == "1"){
        $query0 = "SELECT * FROM android WHERE id = '".$_POST['id_android']."'";
        $req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        while ($data = mysql_fetch_assoc($req0))
        {
          $location = get_android_location($data['apikey'], $data['MobileNetworkCode'], $data['carrier'], $data['cellId'], $data['locationAreaCode']);
        }
        $query = "UPDATE android_distances SET sonde = '".$_POST['sonde']."', `latitude` = '".$location['lat']."', `longitude` = '".$location['lng']."' WHERE id = '".$_POST['id']."'";
        //echo $query;
      } else {
        $query = "UPDATE android_distances SET sonde = '".$_POST['sonde']."', `latitude` = '".$_POST['latitude']."', `longitude` = '".$_POST['longitude']."' WHERE id = '".$_POST['id']."'";
      }
      mysql_query($query, $link);
    }
    else if(isset($_POST['site_supprimer'])) {
      $query = "DELETE FROM android_distances WHERE id = '".$_POST['id']."'";
      mysql_query($query, $link);
    }
    echo '<div id="action-tableau">';
    echo '<CENTER>';
    echo '<br>';
    echo '<TABLE border=0><TR class="title" bgcolor="#6a6a6a"><TD>Sonde</TD><TD>Latitude</TD><TD>Longitude</TD><TD>Position actuelle</TD><TD></TD><TD></TD></TR>';
    $query = "SELECT * FROM android_distances WHERE id_android = '".$_POST['id_android']."'";
    $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while ($data = mysql_fetch_assoc($req))
    {
      echo "<TR class=\"contenu\">";
        echo "<FORM method=POST action=\"./index.php?page=administration&detail=android\">";
        echo "<TD><input type=text name=sonde value=\"".$data['sonde']."\"></input></TD>";
        echo "<TD><input type=text name=latitude value=\"".$data['latitude']."\"></input></TD>";
        echo "<TD><input type=texte name=longitude value=\"".$data['longitude']."\"></input></TD>";
        echo "<TD><input type=checkbox name=pos_actuelle value=1></input></TD>";
        echo "<TD>";
          echo "<input type=hidden name=id value=".$data['id']."></input>";
          echo "<input type=hidden name=site value=".$_POST['site']."></input>";
          echo "<input type=hidden name=id_android value=".$_POST['id_android']."></input>";
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
      <FORM method=POST action="./index.php?page=administration&detail=android">
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
            <input type=hidden name=id_android value=<? echo $_POST['id_android']; ?>>
            <input type=submit name=site_valider value=Ajouter></input>
          </td>
        </tr>
      </FORM>
    </table>
    </p>
    
    <?
  } else {
    include("./pages/connexion.php");
    if(isset($_POST['Ajouter'])) {
      $query = "INSERT INTO `android` (apikey, MobileNetworkCode, carrier, cellId, locationAreaCode) VALUES ('".$_POST['apikey']."', '".$_POST['MobileNetworkCode']."', '".$_POST['carrier']."', '".$_POST['cellId']."', '".$_POST['locationAreaCode']."')";
      mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    }
    else if(isset($_POST['Valider'])) {
      $query = "UPDATE android SET apikey = '".$_POST['apikey']."', `MobileNetworkCode` = '".$_POST['MobileNetworkCode']."', `carrier` = '".$_POST['carrier']."', `cellId` = '".$_POST['cellId']."', `locationAreaCode` = '".$_POST['locationAreaCode']."' WHERE id = '".$_POST['id']."'";
      mysql_query($query, $link);
    }
    else if(isset($_POST['Supprimer'])) {
      $query = "DELETE FROM android WHERE id = '".$_POST['id']."'";
      mysql_query($query, $link);
    }
    echo '<div id="action-tableau">';
    echo '<CENTER>';
    echo '<br>';
    echo '<TABLE border=0><TR class="title" bgcolor="#6a6a6a"><TD>APIkey</TD><TD>MobileNetworkCode</TD><TD>Carrier</TD><TD>cellId</TD><TD>locationAreaCode</TD><TD>Coordonn&eacute;es</TD><TD></TD><TD></TD></TR>';
    $query = "SELECT * FROM android";
    $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while ($data = mysql_fetch_assoc($req))
    {
      echo "<TR class=\"contenu\">";
        echo "<FORM method=POST action=\"./index.php?page=administration&detail=android\">";
          echo "<TD><input type=text name=apikey value=\"".$data['apikey']."\"></input></TD>";
          echo "<TD><input type=text name=MobileNetworkCode value=\"".$data['MobileNetworkCode']."\"></input></TD>";
          echo "<TD><input type=text name=carrier value=\"".$data['carrier']."\"></input></TD>";
          echo "<TD><input type=text name=cellId value=\"".$data['cellId']."\"></input></TD>";
          echo "<TD><input type=text name=locationAreaCode value=\"".$data['locationAreaCode']."\"></input></TD>";
          echo "<TD><input type=submit name=site value=Editer></input></TD>";
          echo "<TD><input type=submit name=Valider value=Valider></input></TD>";
          echo "<TD><input type=hidden name=id value=".$data['id']."></input><input type=hidden name=id_android value=".$data['id']."></input><input type=submit name=Supprimer value=Supprimer></input></TD>";
        echo "</FORM>";
      echo "</TR>";
    }
    echo "</TABLE></CENTER></div>";
    ?>
    <p align=center>
    <TABLE>
      <FORM method=POST action="./index.php?page=administration&detail=android">
        <tr>
          <td>APIkey :</td><td><input type=text name=apikey></input></td>
        </tr>
        <tr>
          <td>MobileNetworkCode :</td><td><input type=text name=MobileNetworkCode></input></td>
        </tr>
        <tr>
          <td>Carrier :</td><td><input type=text name=carrier></input></td>
        </tr>
        <tr>
          <td>cellId :</td><td><input type=text name=cellId></input></td>
        </tr>
        <tr>
          <td>locationAreaCode :</td><td><input type=text name=locationAreaCode></input></td>
        </tr>
        <tr>
          <td colspan=2 align=center><input type=submit name=Ajouter value=Ajouter></input></td>
        </tr>
      </FORM>
    </table>
    </p>
  <?
  }
}
?>
