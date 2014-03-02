<?
if(isset($_SESSION['auth']))
{
  include("./pages/connexion.php");
  ?>
  <p align=center><form method=post action="./index.php?page=administration&detail=messages">Annee : <select name=annee>
  <?
  $query = "SELECT DATE_FORMAT(`date`, '%Y') AS date  FROM `message_zibase` GROUP BY DATE_FORMAT(`date`, '%Y')";
  $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while ($data = mysql_fetch_assoc($req))
  {
    ?><option value="<? echo $data['date']; ?>"<? if(isset($_POST['Valider'])){ if($_POST['annee'] == $data['date']){ ?> selected<? }} ?>><? echo $data['date']; ?></option><?
  }
  ?></select> Mois : <select name=mois>
  <?
  $query = "SELECT DATE_FORMAT(`date`, '%m') AS date  FROM `message_zibase` GROUP BY DATE_FORMAT(`date`, '%m')";
  $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while ($data = mysql_fetch_assoc($req))
  {
    ?><option value="<? echo $data['date']; ?>"<? if(isset($_POST['Valider'])){ if($_POST['mois'] == $data['date']){ ?> selected<? }} ?>><? echo $data['date']; ?></option><?
  }
  ?></select> Jour : <select name=jour>
  <?
  $query = "SELECT DATE_FORMAT(`date`, '%d') AS date  FROM `message_zibase` GROUP BY DATE_FORMAT(`date`, '%d')";
  $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while ($data = mysql_fetch_assoc($req))
  {
    ?><option value="<? echo $data['date']; ?>"<? if(isset($_POST['Valider'])){ if($_POST['jour'] == $data['date']){ ?> selected<? }} ?>><? echo $data['date']; ?></option><?
  }
  ?></select> Heure : <select name=heure>
  <?
  $query = "SELECT DATE_FORMAT(`date`, '%H') AS date  FROM `message_zibase` GROUP BY DATE_FORMAT(`date`, '%H')";
  $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while ($data = mysql_fetch_assoc($req))
  {
    ?><option value="<? echo $data['date']; ?>"<? if(isset($_POST['Valider'])){ if($_POST['heure'] == $data['date']){ ?> selected<? }} ?>><? echo $data['date']; ?></option><?
  }
  ?></select><input type=submit value=Valider name=Valider></form></p>
  <p align=center><form method=post action="./index.php?page=administration&detail=messages">
  <input type=texte name=texte>
  <input type=submit value=Rechercher name=Rechercher></form></p>
  <p align=left>
  <?
  if(isset($_POST['Valider'])) {
    $query = "SELECT * FROM message_zibase WHERE `date` LIKE '".$_POST['annee']."-".$_POST['mois']."-".$_POST['jour']." ".$_POST['heure']."%' ORDER BY id DESC";
  } else if(isset($_POST['Rechercher'])){
    $query = "SELECT * FROM message_zibase WHERE message LIKE '%".$_POST['texte']."%' ORDER BY id DESC LIMIT 100";
  } else {
  $query = "SELECT * FROM message_zibase ORDER BY id DESC LIMIT 100";
  }
  $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while ($data = mysql_fetch_assoc($req))
  {
    echo "<span style='font-weight:bold;'>".$data['date']."</span> : ".$data['message']."<br>";
  }
  ?></p><?
}
?>
