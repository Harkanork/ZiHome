<?
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin')
{
if(isset($_POST['submit']))
{
include("./pages/connexion.php");
$query = "INSERT INTO insertion (url, icone) VALUES ('".$_POST['url']."', '".$_POST['icone']."')";
mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
mysql_close();
}
echo "<BR><center><H1>URL a inclure</H1><BR><BR>
<FORM method=\"POST\" action=\"./index.php?page=administration&detail=insertion\">
<table align=\"center\"><TR><TD>url: </TD><TD><input type=\"text\" name=\"url\" size=\"12\"></input></TD></TR>
<TR><TD>Icone: </TD><TD>
<select name=\"icone\">
<option value=\"icon_account.png\" selected>Compte</option>
<option value=\"icon_chambre.png\">Chambre</option>
<option value=\"icon_edit.png\">Edit</option>
<option value=\"icon-sdb-h.png\">Salle de bain</option>
<option value=\"icon_temp.png\">Temperature</option>
<option value=\"icon_apps.png\">Applications</option>
<option value=\"icon_config.png\">Configuration</option>
<option value=\"icon_elec.png\">Electricite</option>
<option value=\"icon_gallery.png\">Gallerie</option>
<option value=\"icon_pile.png\">Pile</option>
<option value=\"icon_settings.png\">Parametres</option>
<option value=\"icon_vent.png\">Vent</option>
<option value=\"icon_calendrier.png\">Calendrier</option>
<option value=\"icon-cuisine.png\">Cuisine</option>
<option value=\"icon_home.png\">Maison</option>
<option value=\"icon_salon.png\">Salon</option>
<option value=\"icon_shopping.png\">Shopping</option>
</select>
</TD></TR>
<TR><TD>&nbsp;</TD></TR>
<TR><TD><input type=\"submit\" name=\"submit\" value=\"Valider\" class=\"input\"></input></TD></TR></table>
</FORM></center><BR><BR>";
if(isset($_GET['id']))
{
if(isset($_POST['supprimer']))
{
include("./pages/connexion.php");
$query = "DELETE FROM `insertion` WHERE `id`='".$_GET['id']."'";
mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
mysql_close();
echo "<meta http-equiv=\"refresh\" content=\"0; url=./index.php?page=administration&detail=insertion\">";
}
if(isset($_POST['valider']))
{
$query = null;
if(!(empty($_POST['url'])))
{ $query .= "`url`= '".$_POST['url']."', "; }
$query = "UPDATE `insertion` SET ".$query."`icone`= '".$_POST['icone']."' WHERE `id`='".$_GET['id']."'";
include("./pages/connexion.php");
mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
mysql_close();
}
include("./pages/connexion.php");
$query = "SELECT * FROM `insertion` WHERE `id` = '".$id."'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$data = mysql_fetch_assoc($req);
echo "<CENTER><FORM method=\"POST\" action=\"./index.php?page=administration&detail=insertion&id=".$_GET['id']."\">
<TABLE CELLSPACING=\"0\" CELLPADDING=\"5\" BORDER=\"1\">
<TR><TD>URL</TD><TD>".$data['url']."</TD><TD>";
echo "<input type=\"text\" name=\"url\" size=\"12\"></input>";
echo "</TD></TR>
<TR><TD colspan=2>Icone</TD><TD>
<select name=\"icone\">
<option value=\"icon_account.png\" selected>Compte</option>
<option value=\"icon_chambre.png\">Chambre</option>
<option value=\"icon_edit.png\">Edit</option>
<option value=\"icon-sdb-h.png\">Salle de bain</option>
<option value=\"icon_temp.png\">Temperature</option>
<option value=\"icon_apps.png\">Applications</option>
<option value=\"icon_config.png\">Configuration</option>
<option value=\"icon_elec.png\">Electricite</option>
<option value=\"icon_gallery.png\">Gallerie</option>
<option value=\"icon_pile.png\">Pile</option>
<option value=\"icon_settings.png\">Parametres</option>
<option value=\"icon_vent.png\">Vent</option>
<option value=\"icon_calendrier.png\">Calendrier</option>
<option value=\"icon-cuisine.png\">Cuisine</option>
<option value=\"icon_home.png\">Maison</option>
<option value=\"icon_salon.png\">Salon</option>
<option value=\"icon_shopping.png\">Shopping</option>
</select>
</TD></TR></TABLE>
<input type=\"submit\" name=\"valider\" value=\"Valider\" class=\"input\"></input>";
echo "<input type=\"submit\" name=\"supprimer\" value=\"Supprimer\" class=\"input\"></input></br>";
echo "</FORM></CENTER>";
}
echo "<br><br><CENTER><TABLE CELLSPACING=\"0\" CELLPADDING=\"5\" BORDER=\"1\"><TR><TD>URL</TD><TD>editer</TD></TR>";
include("./pages/connexion.php");
$query = "SELECT * FROM `insertion`";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_assoc($req))
{
echo "<TR><TD>".$data['url']."</TD><TD><A HREF=\"./index.php?page=administration&detail=insertion&id=".$data['id']."\">Editer</A></TD></TR>";
}
echo "</TABLE></CENTER>";
mysql_close();
echo "<br>";
echo "<br><br><CENTER><TABLE CELLSPACING=\"0\" CELLPADDING=\"5\" BORDER=\"1\"><TR><TD>login</TD><TD>Description</TD><TD>Supprimer</TD></TR>";
}
?>
