<?
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin')
{
  include("./pages/connexion.php");
  if(isset($_POST['Supprimer'])){
    $query = "DELETE FROM stickers WHERE `id` = '".$_POST['id']."'";
    mysql_query($query, $link);
  }
  else if(isset($_POST['Modifier'])){
    $query = "UPDATE stickers SET `id` = '".$_POST['id']."', `libelle` = '".$_POST['libelle']."', `fichier` = '".$_POST['fichier']."', `left` = '".$_POST['left']."', `top` = '".$_POST['top']."', `condition` = '".$_POST['condition']."' WHERE `id` = '".$_POST['id']."'";
    mysql_query($query, $link);
  }
  else if(isset($_POST['Ajouter'])) {
    $query = "INSERT INTO stickers (`libelle`, `fichier`, `left`, `top`, `condition`) VALUES ('".$_POST['libelle']."', '".$_POST['fichier']."', '".$_POST['left']."', '".$_POST['top']."', '".$_POST['condition']."')";
    mysql_query($query, $link);
  }
?>
<div id="action-tableau">
<CENTER><TABLE border=0><TR class="title" bgcolor="#6a6a6a"><TD>Id</TD><TD>Nom</TD><TD>Fichier</TD><TD>Droite</TD><TD>Bas</TD><TD>Condition</TD><TD>&nbsp;</TD><TD>&nbsp;</TD></TR>
<?
  $query = "SELECT * FROM stickers";
  $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while ($data = mysql_fetch_assoc($req))
  {
    echo "<TR class=\"contenu\">";
      echo '<FORM method="post" action="./index.php?page=administration&detail=gerer_stickers">';
        echo '<TD><INPUT TYPE="text" NAME="id" VALUE="'.$data['id'].'" size="3"/></TD>';
        echo '<TD><INPUT TYPE="text" NAME="libelle" VALUE="'.$data['libelle'].'"/></TD>';
        echo '<TD><INPUT TYPE="text" NAME="fichier" VALUE="'.$data['fichier'].'"/></TD>';
        echo '<TD><INPUT TYPE="number" NAME="left" VALUE="'.$data['left'].'"/></TD>';
        echo '<TD><INPUT TYPE="number" NAME="top" VALUE="'.$data['top'].'"/></TD>';
        $condition = str_replace('"', '"', $data['condition']);
        
        echo '<TD><textarea NAME="condition" cols="40" rows="5">'.$condition.'</textarea></TD>';
        echo '<td class="input"><center><INPUT TYPE="SUBMIT" NAME="Modifier" VALUE="Modifier"/></center></td>';
        echo '<td class="input"><center><INPUT TYPE="SUBMIT" NAME="Supprimer" VALUE="Supprimer"/></center></td>';
      echo '</FORM>';
    echo '</TR>';
  }
?>
</TABLE></CENTER></div>

<P align=center>
<TABLE>
  <FORM method="post" action="./index.php?page=administration&detail=gerer_stickers">
    <TR><TD>Nom :</TD><TD><INPUT type=text name='libelle'></INPUT></TD></TR>
    <TR><TD>Fichier :</TD><TD><INPUT type=text name='fichier'></INPUT></TD></TR>
    <TR><TD>Position Droite :</TD><TD><INPUT type=number name='left'></INPUT></TD></TR>
    <TR><TD>Position Bas :</TD><TD><INPUT type=number name='top'></INPUT></TD></TR>
    <TR><TD>Condition :</TD><TD><INPUT type=text name='condition'></INPUT></TD></TR>
    <TR><TD colspan=2 align=center><INPUT type=submit name='Ajouter' value='Ajouter'></TD></TR>
  </FORM>
</TABLE>
</P>
<? 
} 
?>
