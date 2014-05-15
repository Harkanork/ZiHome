<?
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin')
{
  if(isset($_POST['Supprimer'])){
    $query = "DELETE FROM `plan` WHERE `id` = '".$_POST['id']."'";
    mysql_query($query, $link);
  }
  else if(isset($_POST['Valider'])){
    $query = "UPDATE plan SET `id` = '".$_POST['id']."',  `libelle` = '".$_POST['libelle']."',  `width` = '".$_POST['width']."', `height` = '".$_POST['height']."', `left` = '".$_POST['left']."', `top` = '".$_POST['top']."', `line-height` = '".$_POST['line-height']."', `text-align` = '".$_POST['text-align']."', `border` = '".$_POST['border']."', `supplementaire` = '".$_POST['supplementaire']."', `show-libelle` = '".$_POST['show-libelle']."' WHERE `id` = '".$_POST['idsource']."'";
    mysql_query($query, $link);
    if(is_uploaded_file($_FILES['image']['tmp_name'])){
      move_uploaded_file($_FILES['image']['tmp_name'], "./img/plan/".$_POST['id'].".jpg");
    }
  }
  else if(isset($_POST['Ajouter'])) {
    $query = "INSERT INTO plan (`libelle`, `width`, `height`, `left`, `top`, `line-height`, `text-align`, `border`, `supplementaire`, `show-libelle`) VALUES ('".$_POST['libelle']."', '".$_POST['width']."', '".$_POST['height']."', '".$_POST['left']."', '".$_POST['top']."', '".$_POST['line-height']."', '".$_POST['text-align']."', '".$_POST['border']."', '".$_POST['supplementaire']."', '".$_POST['show-libelle']."')";
    mysql_query($query, $link);
  }
?>
<div id="action-tableau">
<CENTER>
<br>
<TABLE border=0><TR class="title" bgcolor="#6a6a6a"><TD>Id</TD><TD>Nom</TD><TD>Largeur</TD><TD>Hauteur</TD><TD>Droite</TD><TD>Bas</TD><TD>Afficher<br>nom</TD><TD>Taille texte</TD><TD>Alignement</TD><TD>Bordure</TD><TD>Suppl&eacute;mentaire</TD><TD>Image</TD><TD>&nbsp;</TD><TD>&nbsp;</TD></TR>
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
        echo "<TD><INPUT type=text name=supplementaire value='".$data['supplementaire']."'></INPUT></TD>";
	echo "<TD><INPUT type=file name=image></INPUT></TD>";
        echo '<td class="input"><center><INPUT TYPE="SUBMIT" NAME="Valider" VALUE="Valider"/></center></td>';
        echo '<td class="input"><center><INPUT TYPE="SUBMIT" NAME="Supprimer" VALUE="Supprimer"/></center></td>';
        echo '<INPUT TYPE="HIDDEN" NAME="idsource" VALUE="' . $data['id'] . '">';
      echo '</FORM>';
    echo "</TR>";
  }
?>
</TABLE></CENTER></div>

<P align=center>
<TABLE>
<FORM method="post" action="./index.php?page=administration&detail=gerer_pieces">
  <TR><TD>Nom :</TD><TD><INPUT type=text name=libelle></INPUT></TD></TR>
  <TR><TD>Largeur :</TD><TD><INPUT type=number name=width></INPUT></TD></TR>
  <TR><TD>Hauteur :</TD><TD><INPUT type=number name=height></INPUT></TD></TR>
  <TR><TD>Position Droite :</TD><TD><INPUT type=number name=left></INPUT></TD></TR>
  <TR><TD>Position Bas :</TD><TD><INPUT type=number name=top></INPUT></TD></TR>
  <TR><TD>Afficher le nom :</TD><TD><INPUT type="checkbox" name="show-libelle" value="1" checked></INPUT></TD></TR>
  <TR><TD>Taille zone Texte :</TD><TD><INPUT type=number name=line-height></INPUT></TD></TR>
  <TR><TD>Alignement :</TD><TD>
  <select name=text-align>
  <option value=center>Centrer</option>
  <option value=right>Droite</option>
  <option value=left>Gauche</option>
  </select>
  </TD></TR>
  <TR><TD>Taille bordure :</TD><TD><INPUT type=number name=border></INPUT></TD></TR>
  <TR><TD>Option suppl&eacute;mentaire :</TD><TD><INPUT type=text name=supplementaire></INPUT></TD></TR>
  <TR><TD colspan=2 align=center><INPUT type=submit name="Ajouter" value="Ajouter"></TD></TR>
</FORM>
</TABLE>
</P>
<? 
} 
?>
