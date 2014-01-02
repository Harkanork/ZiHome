<div id="global" style="position:relative;padding: 15px;margin: 15px;">
<?
include("./pages/connexion.php");
if(isset($_SESSION['auth'])) {
$query3 = "SELECT * FROM page_accueil WHERE user = '".$_SESSION['auth']."'";
} else {
$query3 = "SELECT * FROM page_accueil WHERE user = 'default'";
}
$req3 = mysql_query($query3, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$data = mysql_fetch_array($req3);
if(empty($data)){
$query3 = "SELECT * FROM page_accueil WHERE user = 'default'";
$req3 = mysql_query($query3, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$data = mysql_fetch_array($req3);
}
while ($data3 = mysql_fetch_assoc($req3))
{
$width = $data3['width'];
$height = $data3['height'];
?>
<div style="background-color: #fff;background-size:<? echo $data3['width']; ?>px <? echo $data3['height']; ?>px;background-repeat:no-repeat;width: <? echo $data3['width']; ?>px;height: <? echo $data3['height']; ?>px;top: <? echo $data3['top']; ?>px;left: <? echo $data3['left']; ?>px;border: solid <? echo $data3['border']; ?>px #CCC;position: absolute;z-index: <? echo $data3['id']; ?>;color: black;font-size: 20px;<? echo $data3['option']; ?>;">
<? 
$query = "SELECT * FROM peripheriques WHERE id = '".$data3['peripherique']."'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data1 = mysql_fetch_assoc($req))
{
$periph = $data1;
}
$query = "SELECT * FROM scenarios WHERE id = '".$data3['peripherique']."'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data1 = mysql_fetch_assoc($req))
{
$periph = $data1;
}
include("./fonctions/".$data3['url'].".php"); 
?>

</div>
<?
}
?>
</div>
<script src="./js/highcharts.js"></script>
<script src="./js/highcharts-more.js"></script>
<script src="./js/modules/data.js"></script>
<script src="./js/modules/exporting.js"></script>
