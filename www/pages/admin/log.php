<?
include("./lib/date_francais.php");
if(isset($_SESSION['auth'])) {
	if (isset($_GET['del'])) {
		$query = "DELETE FROM log WHERE `id`='".$_GET['del']."' LIMIT 1";
  		$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
	}
	?>
	<center>
  	<br>
  	<table border="0">
    	<tr class="title" bgcolor="#6a6a6a">
      		<TH>Date</TH><TH>Type</TH><TH>Contenu</TH><TH>Supprimer</TH>
      	</tr>
      	<?
      	$query = "SELECT * FROM log WHERE 1=1 ORDER BY `date` DESC";
  		$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
 		while ($data = mysql_fetch_assoc($req)) {
			?>
			<tr class="contenu">
				<td><? echo date_francais($data['date']) ?></td>
				<td><? echo $data['type'] ?></td>
				<td><? echo $data['log'] ?></td>
				<td><a href="./index.php?page=administration&detail=log&del=<? echo $data['id'] ?>">X</a></td>
			</tr>
			<?
		}
		?>
	</table>
	<?
}
?>