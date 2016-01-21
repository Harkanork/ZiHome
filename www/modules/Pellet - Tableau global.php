<?php
if (isset($_GET['requete'])) { // si le script est bien appelé par ajax en precisant l'objet de la requête
  include("../config/conf_zibase.php");
  include("../config/variables.php");
  include("../lib/zibase.php");
  include_once("../lib/date_francais.php");
  
  $link = mysql_connect($hote,$login,$plogin);
  if (!$link) {
    die('Non connect&eacute; : ' . mysql_error());
  }
  $db_selected = mysql_select_db($base,$link);
  if (!$db_selected) {
    die ('Impossible d\'utiliser la base : ' . mysql_error());
  }

	$query = "SELECT * FROM paramettres WHERE libelle = 'pellet'";
	$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
	while ($data = mysql_fetch_assoc($req))
	{
	  $pellet = $data['value'];
	}
	echo "<CENTER><TABLE>";
	echo "<TR style='text-align: center'><TD><b>Nbr Activations </b></TD><TD><b>&nbsp;Nbr Activations&nbsp;</b></TD></TR>";
	$query0 = "SELECT COUNT(date) AS somme, date FROM `pellet` WHERE DATE_FORMAT(`date`, '%Y%m%d') = DATE_FORMAT(NOW(), '%Y%m%d') GROUP BY DATE_FORMAT(`date`, '%Y%m%d') ORDER BY DATE_FORMAT(`date`, '%Y%m%d') DESC LIMIT 1";
	$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
	$value0 = mysql_fetch_assoc($req0);
	if(!(empty($value0))) {
	$somme = $value0['somme']*$pellet;
	} else {
	$somme = 0;
	}
	echo "<TR bgcolor='#dddddd'><TD>Aujourd'hui&nbsp;</TD><TD>".$somme."</TD></TR>";

	$query0 = "SELECT COUNT(date) AS somme, date FROM `pellet` WHERE DATE_FORMAT(`date`, '%Y%m%d') = DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -1 DAY), '%Y%m%d') GROUP BY DATE_FORMAT(`date`, '%Y%m%d') ORDER BY DATE_FORMAT(`date`, '%Y%m%d') DESC LIMIT 1";
	$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
	$value0 = mysql_fetch_assoc($req0);
	if(!(empty($value0))) {
	$somme = $value0['somme']*$pellet;
	} else {
	$somme = 0;
	}
	echo "<TR bgcolor='#eeeeee'><TD>Hier&nbsp;</TD><TD>".$somme."</TD></TR>";
	$query0 = "SELECT COUNT(date) AS somme, date FROM `pellet` WHERE date < curdate() AND date > DATE_SUB(curdate(), INTERVAL 7 DAY)";
	$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
	$value0 = mysql_fetch_assoc($req0);
	if(!($value0['somme'] == NULL)) {
	$somme = $value0['somme']*$pellet;
	} else {
	$somme = 0;
	}
	echo "<TR bgcolor='#dddddd'><TD>7 Jours&nbsp;</TD><TD>".$somme."</TD></TR>";
	$query0 = "SELECT COUNT(date) AS somme, date FROM `pellet` WHERE date < curdate() AND date > DATE_SUB(curdate(), INTERVAL 1 MONTH)";
	$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
	$value0 = mysql_fetch_assoc($req0);
	if(!($value0['somme'] == NULL)) {
	$somme = $value0['somme']*$pellet;
	} else {
	$somme = 0;
	}
	echo "<TR bgcolor='#eeeeee'><TD>1 Mois&nbsp;</TD><TD>".$somme."</TD></TR>";
	$query0 = "SELECT COUNT(date) AS somme, date FROM `pellet` WHERE date < curdate() AND date > DATE_SUB(curdate(), INTERVAL 1 YEAR)";
	$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
	$value0 = mysql_fetch_assoc($req0);
	if(!($value0['somme'] == NULL)) {
	$somme = $value0['somme']*$pellet;
	} else {
	$somme = 0;
	}
	echo "<TR bgcolor='#dddddd'><TD>1 An&nbsp;</TD><TD>".$somme."</TD></TR>";
	echo "</TABLE></CENTER>";
}
	?>
