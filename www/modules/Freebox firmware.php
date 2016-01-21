<?

if (isset($_GET['requete'])) { // si le script est bien appelé par ajax en precisant l'objet de la requête
  include("../config/conf_zibase.php");
  include("../config/variables.php");
  include("../lib/zibase.php");
  include_once("../lib/date_francais.php");
  


if(isset($_SESSION['auth']))
{
$xml = simplexml_load_string($xmlfreebox);
echo("<table id='firmware' class='display'>");
echo("<thead>");
echo("	<tr>");
echo("		<th>Firmware_version</th>");
echo("		<th>Uptime</th>");
echo("		<th>Mac</th>");
echo("		<th>Ventilateur</th>");
echo("		<th>Température</th>");
echo("	</tr>");
echo("</thead>");
echo("<tbody>");
foreach ($xml->System as $System){
    foreach($System->GetSystemStatus as $tmp){
		 	echo("	<tr bgcolor='#eeeeee'>");
			echo("		<td style='text-align:center;'>".$tmp->firmware_version."</td>");
			echo("		<td style='text-align:center;'>".$tmp->uptime."</td>");
			echo("		<td style='text-align:center;'>".$tmp->mac."</td>");
			echo("		<td style='text-align:center;'>".$tmp->fan_rpm." Rpm</td>");
			echo("		<td style='text-align:center;'>".$tmp->temp_sw."°C</td>");
			echo("	</tr>");
	}
}
echo("</tbody>");
echo("</table>");
}


}
?>
