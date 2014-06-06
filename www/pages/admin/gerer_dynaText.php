<?
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin')
{
  if(isset($_POST['Supprimer'])){
    $query = "DELETE FROM dynaText WHERE `id` = '".$_POST['id']."'";
    mysql_query($query, $link);
  }
  else if(isset($_POST['Valider'])){
    $query = "UPDATE dynaText SET `id` = '".$_POST['id']."', `page` = '".$_POST['page']."', `libelle` = '".$_POST['libelle']."', `font` = '".$_POST['font']."', `color` = '".$_POST['color']."', `size` = '".$_POST['size']."', `bold` = '".$_POST['bold']."', `italic` = '".$_POST['italic']."', `left` = '".$_POST['left']."', `top` = '".$_POST['top']."', `condition` = '".$_POST['condition']."' WHERE `id` = '".$_POST['idsource']."'";
    mysql_query($query, $link);
  }
  else if(isset($_POST['Ajouter'])) {
    $query = "INSERT INTO dynaText (`libelle`, `page`, `font`, `color`, `size`, `bold`, `italic`, `left`, `top`, `condition`) VALUES ('".$_POST['libelle']."', '".$_POST['page']."', '".$_POST['font']."', '".$_POST['color']."', '".$_POST['size']."', '".$_POST['bold']."', '".$_POST['italic']."', '".$_POST['left']."', '".$_POST['top']."', '".$_POST['condition']."')";
    mysql_query($query, $link);
  }
?>
<script type="text/javascript" src="./js/FontSelector.js"></script>
<div id="action-tableau">
<CENTER>
<br>
<TABLE border=0><TR class="title" bgcolor="#6a6a6a"><TD>Id</TD><TD>Libell&eacute;</TD><TD>Page</TD><TD>Police</TD><TD>Couleur</TD><TD>Taille</TD><TD>Gras</TD><TD>Italique</TD><TD>Droite</TD><TD>Bas</TD><TD>Condition</TD><TD>&nbsp;</TD><TD>&nbsp;</TD></TR>
<?
  $query = "SELECT * FROM dynaText";
  $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while ($data = mysql_fetch_assoc($req))
  {
    echo "<TR class=\"contenu\">";
      echo '<FORM method="post" action="./index.php?page=administration&detail=gerer_dynaText">';
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
        echo '<TD><select NAME="font" id="font'.$data['id'].'" /></TD>';
        echo '<script>';
        echo 'var options = new Object();';
        echo 'options.value = "' . $data['font'] . '";';
        echo '$("select[id=\'font'.$data['id'].'\']").fontSelector(options);';
        echo '</script>';
        echo '<TD><INPUT TYPE="color" NAME="color" VALUE="'.$data['color'].'"/></TD>';
        echo '<TD><INPUT TYPE="number" min="0" NAME="size" VALUE="'.$data['size'].'" style="width:60px;"/></TD>';
        echo '<td><center><INPUT type="checkbox" name="bold" value="1"';
        if ($data['bold'] == "1")
        { 
          echo " checked"; 
        }
        echo '/></center></td>';
        echo '<td><center><INPUT type="checkbox" name="italic" value="1"';
        if ($data['italic'] == "1")
        { 
          echo " checked"; 
        }
        echo '/></center></td>';
        echo '<TD><INPUT TYPE="number" NAME="left" VALUE="'.$data['left'].'" style="width:60px;"/></TD>';
        echo '<TD><INPUT TYPE="number" NAME="top" VALUE="'.$data['top'].'" style="width:60px;"/></TD>';
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
<TABLE>
  <FORM method="post" action="./index.php?page=administration&detail=gerer_dynaText">
    <TR><TD>Libell&eacute; :</TD><TD><INPUT type=text name='libelle'></INPUT></TD></TR>
    <TR><TD>Page :</TD><TD>
      <select name='page'>
      <option value=plan>Plan</option>
      <option value=accueil>Accueil</option>
      </select>
    </TD></TR>
    <TR><TD>Police :</TD><TD><select name='font' id='NewDynaText'></select></TD></TR>
    <TR><TD>Couleur :</TD><TD><INPUT type=color name='color'></INPUT></TD></TR>
    <TR><TD>Taille :</TD><TD><INPUT type=number min="0" name='size' value='20'></INPUT></TD></TR>
    <TR><TD>Gras :</TD><TD><INPUT type="checkbox" name="bold" value="1"></INPUT></TD></TR>
    <TR><TD>Italique :</TD><TD><INPUT type="checkbox" name="italic" value="1"></INPUT></TD></TR>
    <TR><TD>Position Droite :</TD><TD><INPUT type=number name='left'></INPUT></TD></TR>
    <TR><TD>Position Bas :</TD><TD><INPUT type=number name='top'></INPUT></TD></TR>
    <TR><TD>Condition :</TD><TD><INPUT type=text name='condition'></INPUT></TD></TR>
    <TR><TD colspan=2 align=center><INPUT type=submit name='Ajouter' value='Ajouter'></TD></TR>
  </FORM>
</TABLE>
</P>
<script>
var options = new Object();
$("select[id='NewDynaText']").fontSelector(options);
</script>
<? 
} 
?>
