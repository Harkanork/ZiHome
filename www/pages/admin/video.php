<?
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin') {
  if(isset($_POST['Ajouter'])) {
    $query = "INSERT INTO `video` (ordre, libelle, adresse, adresse_internet, id_plan, width, fps, delai) VALUES ('99','".$_POST['libelle']."', '".$_POST['adresse']."', '".$_POST['adresse_internet']."', '".$_POST['id_plan']."', '".$_POST['width']."', '".$_POST['fps']."', '".$_POST['delai']."')";
    mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    mysql_close();
  }
  else if(isset($_POST['Modif'])) {
    $query_modif = "SELECT * FROM video";
    $req_modif = mysql_query($query_modif, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while ($data_modif = mysql_fetch_assoc($req_modif)) {
      if (isset($_POST['suppr_'.$data_modif['id']])) {
        $query_delete="DELETE FROM video WHERE `id` = '".$_POST['suppr_'.$data_modif['id']]."'";
        mysql_query($query_delete, $link);
      } else {
        $query_update = "UPDATE video SET `ordre`= '".$_POST['ordre_'.$data_modif['id']]."', `libelle` = '".$_POST['libelle_'.$data_modif['id']]."', `id_plan` = '".$_POST['id_plan_'.$data_modif['id']]."', `adresse` = '".$_POST['adresse_'.$data_modif['id']]."', `adresse_internet` = '".$_POST['adresse_internet_'.$data_modif['id']]."', `width` = '".$_POST['width_'.$data_modif['id']]."', `fps` = '".$_POST['fps_'.$data_modif['id']]."', `delai` = '".$_POST['delai_'.$data_modif['id']]."' WHERE id = '".$data_modif['id']."'";
        mysql_query($query_update, $link);
      }
    }
  }
?>
  <div id="action-tableau">
    <form method="post" action="./index.php?page=administration&detail=video">
      <TABLE border=0 class="tableau-admin">
        <TR class="title" bgcolor="#6a6a6a">
          <TH>Libell&eacute;</TH><TH>Adresse locale</TH><TH>Adresse Internet</TH><TH>Pi&egrave;ce</TH><TH>Largeur</TH><TH>Durée entre deux images (millisecondes)</TH><TH>Délai rechargement après échec (secondes)</TH><TH>Ordre d'affichage</TH><TH>Supprimer ?</TH>
        </TR>
<?
          $query = "SELECT * FROM video ORDER BY `ordre` ASC";
          $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
          $i=1;
          while ($data = mysql_fetch_assoc($req))
          {
            echo "<TR class=\"contenu\">";
            echo "<TD><input type=text name=libelle_".$data['id']." value=\"".$data['libelle']."\" size=20></input></TD>";
            echo "<TD><input type=text name=adresse_".$data['id']." value=\"".$data['adresse']."\" size=20></input></TD>";
            echo "<TD><input type=text name=adresse_internet_".$data['id']." value=\"".$data['adresse_internet']."\" size=20></input></TD>";
            echo "<TD>";
            ?>
            <select name="id_plan_<? echo $data['id'];?>">
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
            echo "<TD><input type=text name=width_".$data['id']." value=\"".$data['width']."\" size=4></input></TD>";
            echo "<TD><input type=text name=fps_".$data['id']." value=\"".$data['fps']."\" size=3></input></TD>";
            echo "<TD><input type=text name=delai_".$data['id']." value=\"".$data['delai']."\" size=3></input></TD>";
            echo "<TD><input type=text name=ordre_".$data['id']." value=\"".$i."\" size=2></input></TD>";
            echo "<TD><div class=\"checkbox_delete\"><input type=checkbox name=suppr_".$data['id']." value=".$data['id']." id=".$data['id']."><label for=".$data['id']."></label></div></TD>";
            echo "</TR>";
            $i++;
          }
?>
          <TR class="contenu"><TD colspan=9><INPUT TYPE="SUBMIT" NAME="Modif" VALUE="Enregistrer les modifications"/></TD></TR>
        </TABLE>
      </form>
  
    <TABLE class=panneau_table >
      <TR class=panneau_titre>
        <TH>Ajouter une cam&eacute;ra</TH>
      </TR>
      <TR>
        <TD class=panneau_centre>
          <CENTER>
            <TABLE>
              <FORM method=POST action="./index.php?page=administration&detail=video">
                 <tr>
                  <td class=panneau_libelle>Libell&eacute;</td><td style="text-align:left"><input type=text name=libelle size=60></input></td>
                </tr>
                <tr>
                  <td class=panneau_libelle>Adresse locale</td><td style="text-align:left"><input type=text name=adresse size=50></input></td>
                </tr>
                <tr>
                  <td class=panneau_libelle>Adresse distante</td><td style="text-align:left"><input type=text name=adresse_internet size=50></input></td>
                </tr>
                <tr>
                  <td class=panneau_libelle>Pi&egrave;ce</td>
                  <td style="text-align:left">
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
                <tr>
                  <td class=panneau_libelle>Largeur</td><td style="text-align:left"><input type=text size=4 name=width></input></td>
                </tr> 
                <tr>
                  <td class=panneau_libelle>Durée entre deux images (millisecondes)</td><td style="text-align:left"><input type=text size=3 name=fps></input></td>
                </tr>
                <tr>
                  <td class=panneau_libelle>Delai rechargement après échec (secondes)</td><td style="text-align:left"><input type=text size=3 name=delai></input></td>
                </tr>
                <tr><td colspan=2 class=panneau_boutons><input type=submit name=Ajouter value=Ajouter></input></td></tr>
              </FORM>
            </table>
          </CENTER>
        </TD>
      </TR>
    </TABLE>
  </div>
<?
}
?>
