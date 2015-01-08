<?php

error_reporting(E_ALL);

include("../config/conf_zibase.php");

$link = mysql_connect($hote,$login,$plogin);
if (!$link) {
   die('Non connect&eacute; : ' . mysql_error());
}
$db_selected = mysql_select_db($base,$link);
if (!$db_selected) {
   die ('Impossible d\'utiliser la base : ' . mysql_error());
}

if (isset($_GET['action'])) {
	$action=$_GET['action'];
	if ($action=="add") {
		$z=$_GET['z'];
		$id=$_GET['id'];
		mysql_query('INSERT INTO `notes` (`id`,`x`,`y`,`z`,`w`) VALUES ('.$id.', 200, 200, '.$z.', 200)');
	} else if ($action=="sauv") {
		if(ini_get('magic_quotes_gpc')) {
			$_GET['text']=stripslashes($_GET['text']);
		}
		$id=$_GET['id'];
		$text = mysql_real_escape_string($_GET['text']);
		mysql_query("UPDATE `notes` SET `text`='".$text."' WHERE id=".$id);
	} elseif ($action=="suppr") {
		$id = $_GET['id'];
		mysql_query("DELETE FROM `notes` WHERE `id` = ".$id);
	} elseif ($action=="deplace") {
		$id=$_GET['id'];
		$x = mysql_real_escape_string(strip_tags($_GET['x']));
		$y = mysql_real_escape_string(strip_tags($_GET['y']));
		$z = mysql_real_escape_string(strip_tags($_GET['z']));
		mysql_query("UPDATE `notes` SET `z`='".$z."', x='".$x."', y='".$y."' WHERE id=".$id);
	} elseif ($action=="redim") {
		$id=$_GET['id'];
		$w = mysql_real_escape_string(strip_tags($_GET['w']));
		$z = mysql_real_escape_string(strip_tags($_GET['z']));
		mysql_query("UPDATE `notes` SET `z`='".$z."', w='".$w."' WHERE id=".$id);
	}
}

?>