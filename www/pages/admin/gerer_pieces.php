<?
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin')
{
  if(isset($_POST['Supprimer'])){
    $query = "DELETE FROM `plan` WHERE `id` = '".$_POST['id']."'";
    mysql_query($query, $link);
  }
  else if(isset($_POST['Valider'])){
    $query = "UPDATE plan SET `id` = '".$_POST['id']."',  `libelle` = '".$_POST['libelle']."',  `width` = '".$_POST['width']."', `height` = '".$_POST['height']."', `left` = '".$_POST['left']."', `top` = '".$_POST['top']."', `line-height` = '".$_POST['line-height']."', `text-align` = '".$_POST['text-align']."', `border` = '".$_POST['border']."', `supplementaire` = '".$_POST['supplementaire']."', `show-libelle` = '".$_POST['show-libelle']."', `image` = '".$_POST['image']."'  WHERE `id` = '".$_POST['idsource']."'";
    mysql_query($query, $link);
  }
  else if(isset($_POST['Ajouter'])) {
    $query = "INSERT INTO plan (`libelle`, `width`, `height`, `left`, `top`, `line-height`, `text-align`, `border`, `supplementaire`, `show-libelle`, `image`) VALUES ('".$_POST['libelle']."', '".$_POST['width']."', '".$_POST['height']."', '".$_POST['left']."', '".$_POST['top']."', '".$_POST['line-height']."', '".$_POST['text-align']."', '".$_POST['border']."', '".$_POST['supplementaire']."', '".$_POST['show-libelle']."', '".$_POST['image']."')";
    mysql_query($query, $link);
  } 
  else if(isset($_POST['jour'])) {
    if(is_uploaded_file($_FILES['image']['tmp_name'])){
      move_uploaded_file($_FILES['image']['tmp_name'], "./img/plan/jour.png");
    }
  } 
  else if(isset($_POST['nuit'])) {
    if(is_uploaded_file($_FILES['image']['tmp_name'])){
      move_uploaded_file($_FILES['image']['tmp_name'], "./img/plan/nuit.png");
    }
  } 
  else if(isset($_POST['piece'])) {
    if(is_uploaded_file($_FILES['image']['tmp_name'])){
      move_uploaded_file($_FILES['image']['tmp_name'], "./img/plan/" . $_FILES['image']['name']);
    }
  }
  
  // Liste des images utilisable pour les pieces
  $RoomImages = array_diff(scandir('./img/plan/'), array('..', '.', 'jour.png', 'nuit.png', '.gitignore', '@eaDir', 'Thumbs.db'));
?>
<div id="action-tableau">
<CENTER>
<br>
<TABLE border=0><TR class="title" bgcolor="#6a6a6a"><TH>Id</TH><TH>Nom</TH><TH>Largeur</TH><TH>Hauteur</TH><TH>Droite</TH><TH>Bas</TH><TH>Afficher<br>nom</TH><TH>Taille texte</TH><TH>Alignement</TH><TH>Bordure</TH><TH>Image</TH><TH>Suppl&eacute;mentaire</TH><TH>&nbsp;</TH><TH>&nbsp;</TH></TR>
<?
  $query = "SELECT * FROM plan";
  $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while ($data = mysql_fetch_assoc($req))
  {
      echo "<TR class=\"contenu\">";
      echo '<FORM method="post" enctype="multipart/form-data" action="./index.php?page=administration&detail=gerer_pieces">';
        echo "<TD><INPUT type=text name=id value='".$data['id']."' size='3'></INPUT></TD>";
        echo "<TD><INPUT type=text name=libelle value='".$data['libelle']."'></INPUT></TD>";
        echo "<TD><INPUT type=number name=width value='".$data['width']."' style='width:60px;'></INPUT></TD>";
        echo "<TD><INPUT type=number name=height value='".$data['height']."' style='width:60px;'></INPUT></TD>";
        echo "<TD><INPUT type=number name=left value='".$data['left']."' style='width:60px;'></INPUT></TD>";
        echo "<TD><INPUT type=number name=top value='".$data['top']."' style='width:60px;'></INPUT></TD>";
        echo "<TD><INPUT type='checkbox' name='show-libelle' value='1' ";
        if ($data['show-libelle']) echo "checked";
        echo "/></TD>";
        echo "<TD><INPUT type=number name=line-height value='".$data['line-height']."' style='width:60px;'></INPUT></TD>";
        echo "<TD>";
?>
        <select name=text-align>
          <option value=center<?php if($data['text-align'] == "center"){ echo " selected"; } ?>>Centrer</option>
          <option value=right<?php if($data['text-align'] == "right"){ echo " selected"; } ?>>Droite</option>
          <option value=left<?php if($data['text-align'] == "left"){ echo " selected"; } ?>>Gauche</option>
        </select>
<?
        echo "</TD>";
        echo "<TD><INPUT type=number name=border value='".$data['border']."' style='width:60px;'></INPUT></TD>";
        echo "<TD><select name=image>";
        $ImagesText = "";
        $ImageSelected = false;
        foreach($RoomImages as $key => $Image) 
        {
          $ImagesText = $ImagesText ."<option value='" . $Image . "' ";
          if ($data['image'] == $Image)
          { 
            $ImagesText = $ImagesText . " selected";
            $ImageSelected = true;
          } 
          $ImagesText = $ImagesText . ">" . $Image ."</option>";
        }
        // Ajout de la valeur vide
        echo "<option value='' ";
          if (!$ImageSelected)
          { 
            echo " selected";
          } 
        echo "></option>";
        echo $ImagesText;
        echo "</select></TD>";
        echo "<TD><INPUT type=text name=supplementaire value='".$data['supplementaire']."'></INPUT></TD>";
        echo '<td class="input"><center><INPUT TYPE="SUBMIT" NAME="Valider" VALUE="Valider"/></center></td>';
        echo '<td class="input"><center><INPUT TYPE="SUBMIT" NAME="Supprimer" VALUE="Supprimer"/></center></td>';
        echo '<INPUT TYPE="HIDDEN" NAME="idsource" VALUE="' . $data['id'] . '">';
      echo '</FORM>';
    echo "</TR>";
  }
?>
</TABLE></CENTER></div>

<P align=center>
<TABLE class=panneau_table >
  <TR class=panneau_titre>
    <TH>Nouvelle pi&egrave;ce</TH>
  </TR>
  <TR>
    <TD class=panneau_centre>
      <CENTER>
      <TABLE>
      <FORM method="post" action="./index.php?page=administration&detail=gerer_pieces">
        <TR><TD class=panneau_libelle>Nom</TD><TD><INPUT type=text name=libelle></INPUT></TD></TR>
        <TR><TD class=panneau_libelle>Largeur (px)</TD><TD><INPUT type=number name=width></INPUT></TD></TR>
        <TR><TD class=panneau_libelle>Hauteur (px)</TD><TD><INPUT type=number name=height></INPUT></TD></TR>
        <TR><TD class=panneau_libelle>Position Droite (px)</TD><TD><INPUT type=number name=left></INPUT></TD></TR>
        <TR><TD class=panneau_libelle>Position Bas (px)</TD><TD><INPUT type=number name=top></INPUT></TD></TR>
        <TR><TD class=panneau_libelle>Afficher le nom</TD><TD><INPUT type="checkbox" name="show-libelle" value="1" checked></INPUT></TD></TR>
        <TR><TD class=panneau_libelle>Taille zone Texte (px)</TD><TD><INPUT type=number name=line-height></INPUT></TD></TR>
        <TR><TD class=panneau_libelle>Alignement</TD><TD>
        <select name=text-align>
        <option value=center>Centrer</option>
        <option value=right>Droite</option>
        <option value=left>Gauche</option>
        </select>
        </TD></TR>
        <TR><TD class=panneau_libelle>Taille bordure (px)</TD><TD><INPUT type=number name=border></INPUT></TD></TR>
        <TR><TD class=panneau_libelle>Image</TD>
          <TD><select name=image>
          <option value=''></option>
<?
          foreach($RoomImages as $key => $Image) 
          {
            echo "<option value='" . $Image . "' >" . $Image ."</option>";
          }
?>
          </select></TD>
        </TR>
        <TR><TD class=panneau_libelle>Option suppl&eacute;mentaire</TD><TD><INPUT type=text name=supplementaire></INPUT></TD></TR>
        <TR><TD colspan=2 class=panneau_boutons><INPUT type=submit name="Ajouter" value="Ajouter"></TD></TR>
      </FORM>
      </TABLE>
      </CENTER>
    </TD>
  </TR>
</TABLE>
<P align=center>
<TABLE class=panneau_table>
  <TR class=panneau_titre>
    <TH>Envoi de fichiers</TH>
  </TR>
  <TR>
    <TD class=panneau_centre>
      <CENTER>
      <TABLE width=470px>
        <FORM method="post" enctype="multipart/form-data" action="./index.php?page=administration&detail=gerer_pieces">
          <TR class=\"contenu\">
            <TD class=panneau_libelle>Plan pour pi&egrave;ce</TD>
            <TD><INPUT type=file name=image accept="image/png,image/jpeg"/></TD>
            <TD style="text-align:center"><INPUT type=submit name=piece value="Envoyer" /></TD>
          </TR>
        </FORM>
        <FORM method="post" enctype="multipart/form-data" action="./index.php?page=administration&detail=gerer_pieces">
          <TR class=\"contenu\">
            <TD class=panneau_libelle>Arri&egrave;re-plan jour</TD>
            <TD><INPUT type=file name=image accept="image/png"/></TD>
            <TD style="text-align:center"><INPUT type=submit name=jour value="Envoyer" /></TD>
          </TR>
        </FORM>
        <FORM method="post" enctype="multipart/form-data" action="./index.php?page=administration&detail=gerer_pieces">
          <TR class=\"contenu\">
            <TD class=panneau_libelle>Arri&egrave;re-plan nuit</TD>
            <TD><INPUT type=file name=image accept="image/png"/></TD>
            <TD style="text-align:center"><INPUT type=submit name=nuit value="Envoyer" /></TD></TR>
          </TR>
        </FORM>
      </TABLE>
      </CENTER>
    </TD>
  </TR>
</TABLE>
</p>
<? 
} 
?>
