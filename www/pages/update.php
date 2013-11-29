<?
include("./pages/connexion.php");
$query = "CREATE TABLE IF NOT EXISTS `peripheriques` ( `periph` varchar(255) CHARACTER SET latin1 NOT NULL,  `nom` varchar(255) COLLATE utf8_general_mysql500_ci NOT NULL,  `id` varchar(255) CHARACTER SET latin1 NOT NULL,  `type` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT 'on_off',  `logo` varchar(255) CHARACTER SET latin1 NOT NULL,  `protocol` varchar(255) CHARACTER SET latin1 NOT NULL,  `batterie` int(11) NOT NULL,  `id_plan` int(11) NOT NULL DEFAULT '-1',  `left` int(11) NOT NULL DEFAULT '0',  `top` int(11) NOT NULL DEFAULT '0',  `icone` int(11) NOT NULL DEFAULT '0',  PRIMARY KEY (`nom`)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci";
mysql_query($query, $link);
$query = "RENAME TABLE `detail` TO `owl_detail`";
mysql_query($query, $link);
$query = "RENAME TABLE `journalier` TO `owl_journalier`";
mysql_query($query, $link);
$query = "SELECT * FROM `conso_electrique`";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_assoc($req))
{
$query1 = "RENAME TABLE `".$data['nom']."` TO `conso_".$data['nom']."`";
mysql_query($query1, $link);
}
$query = "SELECT * FROM `sonde_temperature`";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_assoc($req))
{
$query1 = "RENAME TABLE `".$data['nom']."` TO `temperature_".$data['nom']."`";
mysql_query($query1, $link);
}
$query = "SELECT * FROM `sonde_vent`";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_assoc($req))
{
$query1 = "RENAME TABLE `".$data['nom']."` TO `vent_".$data['nom']."`";
mysql_query($query1, $link);
}
$query = "DROP TABLE `capteurs`";
mysql_query($query, $link);
$query = "DROP TABLE `sonde_temperature`";
mysql_query($query, $link);
$query = "DROP TABLE `sonde_vent`";
mysql_query($query, $link);
$query = "DROP TABLE `actioneurs`";
mysql_query($query, $link);
$query = "DROP TABLE `conso_electrique`";
mysql_query($query, $link);
echo "Mise a jour effectuee avec succes";
?>
