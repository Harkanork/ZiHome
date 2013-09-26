<?
if(isset($_SESSION['auth'])) {
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
$query = "INSERT INTO users (pseudo, pass) VALUES ('".$_POST['login']."', SHA1('".$_POST['pass']."'))";
mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
mysql_close();
} else {
echo $message;
//echo "<meta http-equiv=\"refresh\" content=\"10; url=$PHP_SELF\">";
}
} 
echo "<BR><center><H1>Veuillez saisir les informations pour creer un compte.</H1><BR><BR>
<FORM method=\"POST\" action=\"$PHP_SELF\">
<table align=\"center\"><TR><TD>Login: </TD><TD><input type=\"text\" name=\"login\" size=\"12\" maxlength=\"40\"></input></TD></TR>
<TR><TD>Mot de passe: </TD><TD><input type=\"password\" name=\"pass\" size=\"12\" maxlength=\"40\"></input></TD></TR>
<TR><TD>Confirmation: </TD><TD><input type=\"password\" name=\"pass2\" size=\"12\" maxlength=\"40\"></input></TD></TR>
<TR><TD>&nbsp;</TD></TR>
<TR><TD><input type=\"submit\" name=\"submit\" value=\"Valider\" class=\"input\"></input></TD></TR></table>
</FORM></center><BR><BR>";
if(isset($_GET['id']))
{
$id = $_GET['id'];
if(isset($_POST['valider']))
{
include("./pages/functions.php");
$query = null;
if(!(empty($_POST['login'])))
{ $query .= "`pseudo`= '".$_POST['login']."', "; }
if(!(empty($_POST['password'])) && !(empty($_POST['confirmpassword'])) && $_POST['password'] == $_POST['confirmpassword'])
{ $query .= "`pass` = SHA1('".$_POST['password']."'), "; }
if(!(empty($query)))
{
$query = "UPDATE `users` SET ".substr($query,0,-2)." WHERE `id`='".$id."'";
include("./pages/connexion.php");
mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
mysql_close();
}
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
} else {
echo "<center>acc&egrave;s non authoris&eacute;</center>";
}
?>
