<div class="metro_nav">
<ul>
<li class="log">
<?
include("./pages/logon.php");
?>
</li>
<?
include("./pages/connexion.php");
$query = "SELECT * FROM modules";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
if($data['libelle'] == "conso_elec" && $data['actif'] == 1) {
?>
<li><A HREF="./index.php?page=conso_elec"><img src = "./img/icon_elec.png"/><span>Conso-Elec</span></a></li>
<?
}
if($data['libelle'] == "temperature" && $data['actif'] == 1) {
?>
<li><A HREF="./index.php?page=temperature"><img src = "./img/icon_temp.png"/><span>Temperature</span></a></li>
<?
}
if($data['libelle'] == "owl" && $data['actif'] == 1) {
?>
<li><A HREF="./index.php?page=owl"><img src = "./img/icon_elec.png"/><span>OWL</span></a></li>
<?
}
if($data['libelle'] == "batterie" && $data['actif'] == 1) {
?>
<li><A HREF="./index.php?page=batterie"><img src = "./img/icon_pile.png"/><span>Batteries</span></a></li>
<?
}
if($data['libelle'] == "plan" && $data['actif'] == 1) {
?>
<li><a href = "./index.php?page=plan"><img src = "./img/icon_home.png"/><span>Plan</span></a></li>
<?
}
if($data['libelle'] == "thermostat" && $data['actif'] == 1 && isset($_SESSION['auth'])) {
?>
<li><a href = "./index.php?page=thermostat"><img src = "./img/icon_temp.png"/><span>Thermostat</span></a></li>
<?
}
if($data['libelle'] == "calendrier" && $data['actif'] == 1 && isset($_SESSION['auth'])) {
?>
<li><a href = "./index.php?page=calendrier"><img src = "./img/icon_calendrier.png"/><span>Calendrier</span></a></li>
<?
}
if($data['libelle'] == "vent" && $data['actif'] == 1) {
?>
<li><a href = "./index.php?page=vent"><img src = "./img/icon_vent.png"/><span>Vent</span></a></li>
<?
}
if($data['libelle'] == "accueil" && $data['actif'] == 1) {
?>
<li><a href = "./index.php?page=accueil"><img src = "./img/icon_home.png"/><span>Accueil</span></a></li>
<?
}
}
include("./pages/connexion.php");
$query = "SELECT * FROM `insertion`";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_assoc($req))
{
?><li><a href = "./index.php?include=<? echo $data['id']; ?>"><img src = "./img/<? echo $data['icone']; ?>"/><span></span></a></li><?
}
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin')
{
?>
<li class="menu-configuration"><A HREF="./index.php?page=administration"><img src="./img/icon_config.png"><span>Administration</span></a></li>

<?
}
?>
</ul>
</div>
