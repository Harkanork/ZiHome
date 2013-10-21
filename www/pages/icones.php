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
echo "<p align=center><form method=\"post\" action=\"./index.php?page=administration&detail=icones\">";
foreach($array as $icones) {
?><input type="radio" name="icones" value="<? echo $icones ?>"<? if($icones1 == $icones) { echo " checked"; } ?>><?
echo "<img src=./img/icones/".$icones."c_logotype_temperature.png><BR>";

}
echo "<INPUT TYPE=\"SUBMIT\" NAME=\"VALIDER\" VALUE=\"VALIDER\"></form></p>";
}
?>
