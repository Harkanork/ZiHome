<?
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin') {
if(isset($_GET['supp-auto'])) {
include("./pages/connexion.php");
$query = "DELETE FROM `auto-logon` WHERE `id`='".$_GET['supp-auto']."'";
mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
mysql_close();
}
if(isset($_POST['Ajouter'])) {
$ipAddress=$_SERVER['REMOTE_ADDR'];
$macAddr=false;
exec('/usr/sbin/arp -n '.$ipAddress,$arp);
foreach($arp as $line)
{
   $cols=preg_split('/\s+/', trim($line));
   if ($cols[0]==$ipAddress)
   {
       $macAddr=$cols[2];
   }
}
include("./pages/connexion.php");
$query = "INSERT INTO `auto-logon` (pseudo, macaddress, description) VALUES ('".$_SESSION['auth']."', '".$macAddr."', '".$_POST['description']."')";
mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
mysql_close();
}
if(isset($_POST['submit']))
{
$message = NULL;
if (empty($_POST['login']))
{ $message .= '<p>Merci de saisir un login valide.</p>'; }
if (empty($_POST['pass']))
{ $message .= '<p>Merci de saisir un mot de passe valide.</p>'; }
if (empty($_POST['pass2']))
{ $message .= '<p>Merci de saisir un mot de passe valide.</p>'; }
if ($_POST['pass'] != $_POST['pass2'])
{ $message .= '<p>les 2 mots de passe sont diff&eacute;rents.</p>'; }
include("./pages/connexion.php");
$query = "SELECT * FROM `users` WHERE pseudo = '".$_POST['login']."' ";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_assoc($req))
{ $message .= "Login deja utilis&eacute;"; }
mysql_close();
if ($message == NULL)
{
include("./pages/connexion.php");
$query = "INSERT INTO users (pseudo, pass, niveau, css, accueil) VALUES ('".$_POST['login']."', SHA1('".$_POST['pass']."'), '".$_POST['droit']."', '".$_POST['style']."', '".$_POST['accueil']."')";
mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
mysql_close();
} else {
echo $message;
//echo "<meta http-equiv=\"refresh\" content=\"10; url=$PHP_SELF\">";
}
} 
echo "<BR><center><H1>Veuillez saisir les informations pour creer un compte.</H1><BR><BR>
<FORM method=\"POST\" action=\"./index.php?page=administration&detail=gerer_users\">
<table align=\"center\"><TR><TD>Login: </TD><TD><input type=\"text\" name=\"login\" size=\"12\" maxlength=\"40\"></input></TD></TR>
<TR><TD>Mot de passe: </TD><TD><input type=\"password\" name=\"pass\" size=\"12\" maxlength=\"40\"></input></TD></TR>
<TR><TD>Confirmation: </TD><TD><input type=\"password\" name=\"pass2\" size=\"12\" maxlength=\"40\"></input></TD></TR>
<TR><TD>Droits: </TD><TD>
<select name=\"droit\">
<option value=\"admin\" selected>Administrateur</option>
<option value=\"utilisateur\">Utilisateur</option>
</select>
</TD></TR>
<TR><TD>Style CSS</TD><TD>
<select name=\"style\">
<option value=\"\" selected>Default</option>";
include("./pages/connexion.php");
$query = "SELECT * FROM `css`";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_assoc($req))
{
echo "<option value=\"".$data['value']."\">".$data['value']."</option>";
}
echo "</TD></TR>
<TR><TD>Page d accueil</TD><TD>
<select name=\"accueil\">
<option value=\"\" selected>Default</option>";
include("./pages/connexion.php");
$query = "SELECT * FROM `accueil`";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_assoc($req))
{
echo "<option value=\"".$data['value']."\">".$data['value']."</option>";
}
echo "</TD></TR>
<TR><TD>&nbsp;</TD></TR>
<TR><TD><input type=\"submit\" name=\"submit\" value=\"Valider\" class=\"input\"></input></TD></TR></table>
</FORM></center><BR><BR>";
if(isset($_GET['id']))
{
$id = $_GET['id'];
if(isset($_POST['valider']))
{
$query = null;
if(!(empty($_POST['login'])))
{ $query .= "`pseudo`= '".$_POST['login']."', "; }
if(!(empty($_POST['password'])) && !(empty($_POST['confirmpassword'])) && $_POST['password'] == $_POST['confirmpassword'])
{ $query .= "`pass` = SHA1('".$_POST['password']."'), "; }
$query = "UPDATE `users` SET ".$query."`niveau`= '".$_POST['droit']."', `css` = '".$_POST['style']."', `accueil` = '".$_POST['accueil']."' WHERE `id`='".$id."'";
include("./pages/connexion.php");
mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
mysql_close();
}
if(isset($_POST['supprimer']))
{
include("./pages/connexion.php");
$query = "DELETE FROM `users` WHERE `id`='".$id."'";
mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
mysql_close();
echo "<CENTER>compte supprim&eacute; avec succ&egrave;s</CENTER>";
echo "<meta http-equiv=\"refresh\" content=\"0; url=./index.php?page=administration&detail=gerer_users\">";
}
include("./pages/connexion.php");
$query = "SELECT * FROM `users` WHERE `id` = '".$id."'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$data = mysql_fetch_assoc($req);
echo "<CENTER><FORM method=\"POST\" action=\"./index.php?page=administration&detail=gerer_users&id=".$id."\">
<TABLE CELLSPACING=\"0\" CELLPADDING=\"5\" BORDER=\"1\">
<TR><TD>Login</TD><TD>".$data['pseudo']."</TD><TD>";
echo "<input type=\"text\" name=\"login\" size=\"12\" maxlength=\"40\"></input>";
echo "</TD></TR>
<TR><TD colspan=2>Nouveau mot de passe</TD><TD><input type=\"password\" name=\"password\" size=\"12\" maxlength=\"40\"></input></TD></TR>
<TR><TD colspan=2>Confirmer le mot de passe</TD><TD><input type=\"password\" name=\"confirmpassword\" size=\"12\" maxlength=\"40\"></input></TD></TR>
<TR><TD colspan=2>Droits</TD><TD>
<select name=\"droit\">
<option value=\"admin\"";
if($data['niveau'] == "admin") { echo " selected"; }
echo ">Administrateur</option>
<option value=\"utilisateur\"";
if($data['niveau'] == "utilisateur") { echo " selected"; }
echo ">Utilisateur</option>
</select>
</TD></TR>
<TR><TD>Style CSS</TD><TD>
<select name=\"style\">
<option value=\"\"";
if($data['css'] == "") { echo " selected"; }
echo ">Default</option>";
$query2 = "SELECT * FROM `css`";
$req2 = mysql_query($query2, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data2 = mysql_fetch_assoc($req2))
{
echo "<option value=\"".$data2['value']."\"";
if($data['css'] == $data2['value']) { echo " selected"; }
echo ">".$data2['value']."</option>";
}
echo "</TD></TR>
<TR><TD>Page d Accueil</TD><TD>
<select name=\"accueil\">
<option value=\"\"";
if($data['accueil'] == "") { echo " selected"; }
echo ">Default</option>";
$query2 = "SELECT * FROM `accueil`";
$req2 = mysql_query($query2, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data2 = mysql_fetch_assoc($req2))
{
echo "<option value=\"".$data2['value']."\"";
if($data['accueil'] == $data2['value']) { echo " selected"; }
echo ">".$data2['value']."</option>";
}
echo "</TD></TR>
</TABLE>
<input type=\"submit\" name=\"valider\" value=\"Valider\" class=\"input\"></input>";
echo "<input type=\"submit\" name=\"supprimer\" value=\"Supprimer\" class=\"input\"></input></br>";
echo "</FORM></CENTER>";
}
echo "<br><br><CENTER><TABLE CELLSPACING=\"0\" CELLPADDING=\"5\" BORDER=\"1\"><TR><TD>login</TD><TD>editer</TD></TR>";
include("./pages/connexion.php");
$query = "SELECT * FROM `users`";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_assoc($req))
{
echo "<TR><TD>".$data['pseudo']."</TD><TD><A HREF=\"./index.php?page=administration&detail=gerer_users&id=".$data['id']."\">Editer</A></TD></TR>";
}
echo "</TABLE></CENTER>";
mysql_close();
echo "<br>";
echo "<br><br><CENTER><TABLE CELLSPACING=\"0\" CELLPADDING=\"5\" BORDER=\"1\"><TR><TD>login</TD><TD>Description</TD><TD>Supprimer</TD></TR>";
include("./pages/connexion.php");
$query = "SELECT * FROM `auto-logon`";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_assoc($req))
{
echo "<TR><TD>".$data['pseudo']."</TD><TD>".$data['description']."</TD><TD><A HREF=\"./index.php?page=administration&detail=gerer_users&supp-auto=".$data['id']."\">Supprimer</A></TD></TR>";
}
echo "</TABLE></CENTER>";
mysql_close();
echo "<br>";
echo "<CENTER>Ajouter une connexion automatique pour ce peripherique. (uniquement sur le reseau local)<br><FORM method=\"POST\" action=\"./index.php?page=administration&detail=gerer_users\">
Description : <input type=\"text\" name=\"description\" size=\"12\" maxlength=\"40\"></input>
<input type=\"submit\" name=\"Ajouter\" value=\"Ajouter\"></input>
</form></center>";
} else {
echo "<center>acc&egrave;s non authoris&eacute;</center>";
}
?>
