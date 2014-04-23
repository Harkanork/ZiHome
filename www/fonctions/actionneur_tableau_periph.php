<?php
echo "<CENTER><TABLE>";
echo "<TR style='text-align: center'><TD><b>Nbr Activations </b></TD><TD><b>&nbsp;Nbr Activations&nbsp;</b></TD><TD><b>&nbsp;Temp Activation&nbsp;</b><TD></TR>";
$query0 = "SELECT SUM(actif) AS somme, date FROM `periph_".$periph['nom']."` WHERE DATE_FORMAT(`date`, '%Y%m%d') = DATE_FORMAT(NOW(), '%Y%m%d') GROUP BY DATE_FORMAT(`date`, '%Y%m%d') ORDER BY DATE_FORMAT(`date`, '%Y%m%d') DESC LIMIT 1";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$value0 = mysql_fetch_assoc($req0);
if(!(empty($value0))) {
$somme = $value0['somme'];
} else {
$somme = 0;
}
if(!($somme == 0)) {
$duree = 0;
$query0 = "SELECT date FROM `periph_".$periph['nom']."` WHERE actif = 1 AND  DATE_FORMAT(`date`, '%Y%m%d') = DATE_FORMAT(NOW(), '%Y%m%d') ORDER BY DATE_FORMAT(`date`, '%Y%m%d') DESC";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value0 = mysql_fetch_assoc($req0)) {
$query1 = "SELECT `date` FROM `periph_".$periph['nom']."` WHERE actif = 0 AND `date` > '".$value0['date']."' ORDER BY `date` LIMIT 1";
$req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$value1 = mysql_fetch_assoc($req1);
if($value0['date'] < $value1['date']) {
$query2 = "SELECT TIMESTAMPDIFF(SECOND, '".$value0['date']."', '".$value1['date']."') AS duree";
} else {
$query2 = "SELECT TIMESTAMPDIFF(SECOND, '".$value0['date']."', now()) AS duree";
}
$req2 = mysql_query($query2, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$value2 = mysql_fetch_assoc($req2);
$duree += $value2['duree'];
}
} else {
$duree = 0;
}
echo "<TR bgcolor='#dddddd'><TD>Aujourd'hui&nbsp;</TD><TD>".$somme."</TD><TD>".duree($duree)."</TD></TR>";

$query0 = "SELECT SUM(actif) AS somme, date FROM `periph_".$periph['nom']."` WHERE DATE_FORMAT(`date`, '%Y%m%d') = DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -1 DAY), '%Y%m%d') GROUP BY DATE_FORMAT(`date`, '%Y%m%d') ORDER BY DATE_FORMAT(`date`, '%Y%m%d') DESC LIMIT 1";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$value0 = mysql_fetch_assoc($req0);
if(!(empty($value0))) {
$somme = $value0['somme'];
} else {
$somme = 0;
}
if(!($somme == 0)) {
$duree = 0;
$query0 = "SELECT date FROM `periph_".$periph['nom']."` WHERE actif = 1 AND  DATE_FORMAT(`date`, '%Y%m%d') = DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -1 DAY), '%Y%m%d') ORDER BY DATE_FORMAT(`date`, '%Y%m%d') DESC";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value0 = mysql_fetch_assoc($req0)) {
$query1 = "SELECT `date` FROM `periph_".$periph['nom']."` WHERE actif = 0 AND `date` > '".$value0['date']."' ORDER BY `date` LIMIT 1";
$req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$value1 = mysql_fetch_assoc($req1);
$query2 = "SELECT TIMESTAMPDIFF(SECOND, '".$value0['date']."', '".$value1['date']."') AS duree";
$req2 = mysql_query($query2, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$value2 = mysql_fetch_assoc($req2);
$duree += $value2['duree'];
}
} else {
$duree = 0;
}
echo "<TR bgcolor='#eeeeee'><TD>Hier&nbsp;</TD><TD>".$somme."</TD><TD>".duree($duree)."</TD></TR>";
$query0 = "SELECT SUM(actif) AS somme, date FROM `periph_".$periph['nom']."` WHERE date < curdate() AND date > DATE_SUB(curdate(), INTERVAL 7 DAY)";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$value0 = mysql_fetch_assoc($req0);
if(!($value0['somme'] == NULL)) {
$somme = $value0['somme'];
} else {
$somme = 0;
}
if(!($somme == 0)) {
$duree = 0;
$query0 = "SELECT date FROM `periph_".$periph['nom']."` WHERE actif = 1 AND date < curdate() AND DATE_FORMAT(`date`, '%Y%m%d') > DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -7 DAY), '%Y%m%d') ORDER BY DATE_FORMAT(`date`, '%Y%m%d') DESC";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value0 = mysql_fetch_assoc($req0)) {
$query1 = "SELECT `date` FROM `periph_".$periph['nom']."` WHERE actif = 0 AND `date` > '".$value0['date']."' ORDER BY `date` LIMIT 1";
$req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$value1 = mysql_fetch_assoc($req1);
$query2 = "SELECT TIMESTAMPDIFF(SECOND, '".$value0['date']."', '".$value1['date']."') AS duree";
$req2 = mysql_query($query2, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$value2 = mysql_fetch_assoc($req2);
$duree += $value2['duree'];
}
} else {
$duree = 0;
}
echo "<TR bgcolor='#dddddd'><TD>7 Jours&nbsp;</TD><TD>".$somme."</TD><TD>".duree($duree)."</TD></TR>";
$query0 = "SELECT SUM(actif) AS somme, date FROM `periph_".$periph['nom']."` WHERE date < curdate() AND date > DATE_SUB(curdate(), INTERVAL 1 MONTH)";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$value0 = mysql_fetch_assoc($req0);
if(!($value0['somme'] == NULL)) {
$somme = $value0['somme'];
} else {
$somme = 0;
}
if(!($somme == 0)) {
$duree = 0;
$query0 = "SELECT date FROM `periph_".$periph['nom']."` WHERE actif = 1 AND date < curdate() AND DATE_FORMAT(`date`, '%Y%m%d') > DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -1 MONTH), '%Y%m%d') ORDER BY DATE_FORMAT(`date`, '%Y%m%d') DESC";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value0 = mysql_fetch_assoc($req0)) {
$query1 = "SELECT `date` FROM `periph_".$periph['nom']."` WHERE actif = 0 AND `date` > '".$value0['date']."' ORDER BY `date` LIMIT 1";
$req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$value1 = mysql_fetch_assoc($req1);
$query2 = "SELECT TIMESTAMPDIFF(SECOND, '".$value0['date']."', '".$value1['date']."') AS duree";
$req2 = mysql_query($query2, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$value2 = mysql_fetch_assoc($req2);
$duree += $value2['duree'];
}
} else {
$duree = 0;
}
echo "<TR bgcolor='#eeeeee'><TD>1 Mois&nbsp;</TD><TD>".$somme."</TD><TD>".duree($duree)."</TD></TR>";
$query0 = "SELECT SUM(actif) AS somme, date FROM `periph_".$periph['nom']."` WHERE date < curdate() AND date > DATE_SUB(curdate(), INTERVAL 1 YEAR)";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$value0 = mysql_fetch_assoc($req0);
if(!($value0['somme'] == NULL)) {
$somme = $value0['somme'];
} else {
$somme = 0;
}
if(!($somme == 0)) {
$duree = 0;
$query0 = "SELECT date FROM `periph_".$periph['nom']."` WHERE actif = 1 AND date < curdate() AND DATE_FORMAT(`date`, '%Y%m%d') > DATE_FORMAT(DATE_ADD(NOW(), INTERVAL -1 YEAR), '%Y%m%d') ORDER BY DATE_FORMAT(`date`, '%Y%m%d') DESC";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value0 = mysql_fetch_assoc($req0)) {
$query1 = "SELECT `date` FROM `periph_".$periph['nom']."` WHERE actif = 0 AND `date` > '".$value0['date']."' ORDER BY `date` LIMIT 1";
$req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$value1 = mysql_fetch_assoc($req1);
$query2 = "SELECT TIMESTAMPDIFF(SECOND, '".$value0['date']."', '".$value1['date']."') AS duree";
$req2 = mysql_query($query2, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$value2 = mysql_fetch_assoc($req2);
$duree += $value2['duree'];
}
} else {
$duree = 0;
}
echo "<TR bgcolor='#dddddd'><TD>1 An&nbsp;</TD><TD>".$somme."</TD><TD>".duree($duree)."</TD></TR>";
echo "</TABLE></CENTER>";
?>
