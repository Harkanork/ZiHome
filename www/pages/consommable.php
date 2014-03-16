<?
if(isset($_SESSION['auth'])) {
include("./config/conf_zibase.php");
if(isset($_POST['valider'])) {
$query = "INSERT INTO consommable (`date`, `quantite`, `prix`, `type`) VALUES ('".date("Y-m-d", strtotime($_POST['date']))."', '".$_POST['quantite']."', '".$_POST['prix']."', '".$_POST['type']."')";
mysql_query($query, $link);
}
$query = "SELECT * FROM consommable ORDER BY `date` DESC LIMIT 20";
echo "<center><br><table><tr class=\"title\" bgcolor=\"#6a6a6a\"><td>Operation</td><td>Date</td><td>Prix</td><td>Quantite</td></tr>";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req)) {
echo "<tr class=\"contenu\"><td>".$data['type']."</td><td>".$data['date']."</td><td>".$data['prix']."</td><td>".$data['quantite']."</td></tr>";
}
echo "</table><br><br>";
$query = "SELECT SUM(quantite) as acheter FROM consommable WHERE type = 'Acheter' LIMIT 1";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{ $acheter = $data['acheter']; }
$query = "SELECT SUM(quantite) as deplacer FROM consommable WHERE type = 'Deplacer' LIMIT 1";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{ $deplacer = $data['deplacer']; }
$query = "SELECT SUM(quantite) as consommer FROM consommable WHERE type = 'Consommer' LIMIT 1";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{ $consommer = $data['consommer']; }
$fournisseur = $acheter - $deplacer;
$maison = $deplacer - $consommer;
echo "Stock Fournisseur : ".$fournisseur."<br>";
echo "Stock Maison : ".$maison."<br><br>";
?>
<form method="post" action="./index.php?page=consommable">
<select name="type">
<option name="C" value="Consommer" selected>Consommer</option>
<option name="D" value="Deplacer">Deplacer</option>
<option name="A" value="Acheter">Acheter</option>
</select>
Quantite : <input type="number" name="quantite"></input>
Date : <input type="date" name="date"></input>
Prix : <input type="number" name="prix"></input>
<input type="submit" name="valider" value="Valider"></input>
</form></center>
<?
}
?>
