<?
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin') {
  if(isset($_POST['Ajouter'])) {
    $query = "INSERT INTO `video` (adresse, adresse_internet, id_plan) VALUES ('".$_POST['adresse']."', '".$_POST['adresse_internet']."', '".$_POST['id_plan']."')";
    mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    mysql_close();
  }
  else if(isset($_POST['Valider'])) {
    $query = "UPDATE video SET id_plan = '".$_POST['id_plan']."', `adresse` = '".$_POST['adresse']."', `adresse_internet` = '".$_POST['adresse_internet']."' WHERE id = '".$_POST['id']."'";
    mysql_query($query, $link);
  }
  else if(isset($_POST['Supprimer'])) {
    $query = "DELETE FROM video WHERE id = '".$_POST['id']."'";
    mysql_query($query, $link);
  }
  echo '<div id="action-tableau">';
  echo '<CENTER>';
  echo '<br>';
  echo '<TABLE border=0><TR class="title" bgcolor="#6a6a6a"><TH>Adresse locale</TH><TH>Adresse Internet</TH><TH>Pi&egrave;ce</TH><TH></TH><TH></TH></TR>';
  $query = "SELECT * FROM video";
  $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while ($data = mysql_fetch_assoc($req))
  {
    echo "<TR class=\"contenu\"><FORM method=POST action=\"./index.php?page=administration&detail=video\">";
    echo "<TD><input type=text name=adresse value=\"".$data['adresse']."\" size=50></input></TD>";
    echo "<TD><input type=text name=adresse_internet value=\"".$data['adresse_internet']."\" size=50></input></TD>";
    echo "<TD>";
    ?>
    <select name="id_plan">
    <option value="-1">ne pas afficher</option>
    <?
    $query1 = "SELECT * FROM `plan` ORDER BY `libelle`";
    $req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while($data1 = mysql_fetch_assoc($req1))
    { ?>
      <option value="<? echo $data1['id']; ?>"<? if($data1['id'] ==  $data['id_plan']){ echo " selected"; } ?>><? echo $data1['libelle']; ?></option>
    <? } ?>
    </select>
    <?
    echo "</TD>";
    echo '<td class="input"><center><INPUT TYPE="SUBMIT" NAME="Valider" VALUE="Valider"/></center></td>';
    echo '<td class="input"><center><INPUT TYPE="SUBMIT" NAME="Supprimer" VALUE="Supprimer"/></center></td>';
    echo "<input type=hidden name=id value=".$data['id']."></input>";
    echo "</FORM></TR>";
  }
  echo "</TABLE></CENTER></div>";
  ?>
  <p align=center>
  <TABLE class=panneau_table >
    <TR class=panneau_titre>
      <TH>Nouvelle cam&eacute;ra</TH>
    </TR>
    <TR>
      <TD class=panneau_centre>
        <CENTER>
          <TABLE>
            <FORM method=POST action="./index.php?page=administration&detail=video">
              <tr>
                <td class=panneau_libelle>Adresse locale</td><td><input type=text name=adresse></input></td>
              </tr>
              <tr>
                <td class=panneau_libelle>Adresse distante</td><td><input type=text name=adresse_internet></input></td>
              </tr>
              <tr>
                <td class=panneau_libelle>Pi&egrave;ce</td>
                <td>
                  <select name="id_plan">
                    <option value="-1">ne pas afficher</option>
                    <?
                    $query = "SELECT * FROM `plan` ORDER BY `libelle`";
                    $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                    while($data = mysql_fetch_assoc($req))
                    { ?>
                     <option value="<? echo $data['id']; ?>"><? echo $data['libelle']; ?></option>
                    <? } ?>
                  </select>
                </td>
              </tr>
              <tr><td colspan=2 class=panneau_boutons><input type=submit name=Ajouter value=Ajouter></input></td></tr>
            </FORM>
          </table>
        </CENTER>
      </TD>
    </TR>
  </TABLE>
  </p>
<?
}
?>
