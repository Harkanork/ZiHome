<?
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin')
{
  if(isset($_POST['Supprimer'])){
    $query = "DELETE FROM stickers WHERE `id` = '".$_POST['id']."'";
    mysql_query($query, $link);
  }
  else if(isset($_POST['Valider'])){
    $query = "UPDATE stickers SET `id` = '".$_POST['id']."', `page` = '".$_POST['page']."', `libelle` = '".$_POST['libelle']."', `fichier` = '".$_POST['fichier']."', `left` = '".$_POST['left']."', `top` = '".$_POST['top']."', `width` = '".$_POST['width']."', `height` = '".$_POST['height']."', `condition` = '".$_POST['condition']."' WHERE `id` = '".$_POST['idsource']."'";
    mysql_query($query, $link);
  }
  else if(isset($_POST['Ajouter'])) {
    $query = "INSERT INTO stickers (`libelle`, `page`, `fichier`, `left`, `top`, `width`, `height`, `condition`) VALUES ('".$_POST['libelle']."', '".$_POST['page']."', '".$_POST['fichier']."', '".$_POST['left']."', '".$_POST['top']."', '".$_POST['width']."', '".$_POST['height']."', '".$_POST['condition']."')";
    mysql_query($query, $link);
  }
  else if(isset($_POST['sticker'])) {
    if(is_uploaded_file($_FILES['image']['tmp_name'])){
      move_uploaded_file($_FILES['image']['tmp_name'], "./img/stickers/".$_FILES['image']['name']);
    }
  }
  
  // Liste des images utilisable pour les stickers
  $StickerImages = array_diff(scandir('./img/stickers/'), array('..', '.', '.gitignore', '@eaDir', 'Thumbs.db'));

?>
<div id="action-tableau">
<CENTER>
<br>
<TABLE border=0><TR class="title" bgcolor="#6a6a6a"><TH>Id</TH><TH>Nom</TH><TH>Page</TH><TH>Fichier</TH><TH>Droite</TH><TH>Bas</TH><TH style="width:10px">Largeur</TH><TH>Hauteur</TH><TH>Condition</TH><TH>&nbsp;</TH><TH>&nbsp;</TH></TR>
<?
  $query = "SELECT * FROM stickers";
  $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while ($data = mysql_fetch_assoc($req))
  {
    echo "<TR class=\"contenu\">";
      echo '<FORM method="post" enctype="multipart/form-data" action="./index.php?page=administration&detail=gerer_stickers">';
        echo '<TD><INPUT TYPE="text" NAME="id" VALUE="'.$data['id'].'" size="3"/></TD>';
        echo '<TD><INPUT TYPE="text" NAME="libelle" VALUE="'.$data['libelle'].'"/></TD>';
        echo "<TD>";
?>
        <select name='page'>
          <option value=plan<?php if($data['page'] == "plan"){ echo " selected"; } ?>>Plan</option>
          <option value=accueil<?php if($data['page'] == "accueil"){ echo " selected"; } ?>>Accueil</option>
        </select>
<?
        echo "</TD>";
        echo '<TD><select NAME="fichier">';
          $ImagesText = "";
          $ImageSelected = false;
          foreach($StickerImages as $key => $Image) 
          {
            $ImagesText = $ImagesText ."<option value='" . $Image . "' ";
            if ($data['fichier'] == $Image)
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
        echo '</select></TD>';
        echo '<TD><INPUT TYPE="number" NAME="left" VALUE="'.$data['left'].'" style="width:60px;"/></TD>';
        echo '<TD><INPUT TYPE="number" NAME="top" VALUE="'.$data['top'].'" style="width:60px;"/></TD>';
        echo '<TD><INPUT TYPE="number" min="0" NAME="width" VALUE="'.$data['width'].'" style="width:60px;"/></TD>';
        echo '<TD><INPUT TYPE="number" min="0" NAME="height" VALUE="'.$data['height'].'" style="width:60px;"/></TD>';
        $condition = $data['condition'];
        echo '<TD><textarea NAME="condition" cols="40" rows="5">'.$condition.'</textarea></TD>';
        echo '<td class="input"><center><INPUT TYPE="SUBMIT" NAME="Valider" VALUE="Valider"/></center></td>';
        echo '<td class="input"><center><INPUT TYPE="SUBMIT" NAME="Supprimer" VALUE="Supprimer"/></center></td>';
        echo '<INPUT TYPE="HIDDEN" NAME="idsource" VALUE="' . $data['id'] . '">';
      echo '</FORM>';
    echo '</TR>';
  }
?>
</TABLE></CENTER></div>

<P align=center>
<TABLE class=panneau_table >
  <TR class=panneau_titre>
    <TH>Nouveau sticker</TH>
  </TR>
  <TR>
    <TD class=panneau_centre>
      <CENTER>
        <TABLE>
          <FORM method="post" enctype="multipart/form-data" action="./index.php?page=administration&detail=gerer_stickers">
            <TR><TD class=panneau_libelle>Nom</TD><TD><INPUT type=text name='libelle'></INPUT></TD></TR>
            <TR><TD class=panneau_libelle>Page</TD><TD>
              <select name='page'>
              <option value=plan>Plan</option>
              <option value=accueil>Accueil</option>
              </select>
            </TD></TR>
            <TR><TD class=panneau_libelle>Nom du Fichier</TD><TD><select name=fichier>
              <option value=''></option>
<?
                foreach($StickerImages as $key => $Image) 
                {
                  echo "<option value='" . $Image . "' >" . $Image ."</option>";
                }
?>
              </select></TD>
            </TR>
            <TR><TD class=panneau_libelle>Position Droite</TD><TD><INPUT type=number name='left'></INPUT></TD></TR>
            <TR><TD class=panneau_libelle>Position Bas</TD><TD><INPUT type=number name='top'></INPUT></TD></TR>
            <TR><TD class=panneau_libelle>Largeur</TD><TD><INPUT type=number name='width'></INPUT></TD></TR>
            <TR><TD class=panneau_libelle>Hauteur</TD><TD><INPUT type=number name='height'></INPUT></TD></TR>
            <TR><TD class=panneau_libelle>Condition</TD><TD><INPUT type=text name='condition'></INPUT></TD></TR>
            <TR><TD colspan=2 class=panneau_boutons><INPUT type=submit name='Ajouter' value='Ajouter'></TD></TR>
          </FORM>
        </TABLE>
      </CENTER>
    </TD>
  </TR>
</TABLE>
</P>
<P align=center>
<TABLE class=panneau_table>
  <TR class=panneau_titre>
    <TH>Envoi de fichiers</TH>
  </TR>
  <TR>
    <TD class=panneau_centre>
      <CENTER>
      <TABLE width=470px>
        <FORM method="post" enctype="multipart/form-data" action="./index.php?page=administration&detail=gerer_stickers">
          <TR class=\"contenu\">
            <TD class=panneau_libelle>Sticker</TD>
            <TD><INPUT type=file name=image accept="image/png,image/jpeg"/></TD>
            <TD style="text-align:center"><INPUT type=submit name=sticker value="Envoyer" /></TD>
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
