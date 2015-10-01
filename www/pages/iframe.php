<?
if (isset($_GET['iframe'])) {
	$id = $_GET['iframe'];
	$query = 'SELECT * FROM menu WHERE id='.$id;
    $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while ($iframe = mysql_fetch_assoc($req)) {
        $libelle=$iframe['libelle'];
        $url=$iframe['url'];
    }
?>
<title><? echo $libelle ?></title>
<iframe src="<? echo $url ?>" class="iframe"></iframe>
<?
}
?>