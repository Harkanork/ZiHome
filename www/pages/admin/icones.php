<?
if(isset($_SESSION['auth']))
{
include("./pages/connexion.php");
if(isset($_POST['VALIDER'])){
$query = "UPDATE paramettres SET value = '".$_POST['icones']."' WHERE libelle = 'icones'";
mysql_query($query, $link);
}
$query = "SELECT * FROM paramettres WHERE libelle = 'icones'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
$icones1 = $data['value'];
}
$array = array( 1, 2, 4, 5, 6, 7, 8, 9 ); 
  echo '<p align=center><form method="post" action="./index.php?page=administration&detail=icones">';
  echo '<table border="0" cellpadding="0" cellspacing="2">';
foreach($array as $icones) {
    echo '<tr>';
    echo '<td><input type="radio" name="icones" value="'.$icones.'"';
    if($icones1 == $icones) { 
      echo " checked"; 
}
    echo '/></td>';
    echo '<td><img width="100" height="100" src="./img/icones/StyleIconPreview'.$icones.'.png"/></td>';
    echo '</tr>';
  }
  // Le bouton Valider est dans le tableau pour le centrer sous les images
  echo '<tr>';
  echo '<td></td><td align="center"><INPUT TYPE="SUBMIT" NAME="VALIDER" VALUE="VALIDER"/></form></td>';
  echo '</tr>';
  echo '</table></p>';
}
?>
