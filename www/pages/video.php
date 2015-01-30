
<title>Vid&eacute;o</title>

<div id="fond_video">
<?
if(isset($_SESSION['auth'])) {
	$query = "SELECT * FROM video";
	$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
	while ($periph = mysql_fetch_assoc($req)) {
		$width = $periph['width'];
		$libelle = $periph['libelle'];
		$fps = $periph['fps'];
		$delai_tentative=$periph['delai'];
		$adloc=$periph['adresse'];
		$adweb=$periph['adresse_internet'];
		include("./fonctions/video.php");
	}
}
?>
</div>
