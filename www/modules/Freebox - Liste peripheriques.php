<?


if (isset($_GET['requete'])) { // si le script est bien appelé par ajax en precisant l'objet de la requête
  include("../config/conf_zibase.php");
  include("../config/variables.php");
  include("../lib/zibase.php");
  include_once("../lib/date_francais.php");


if(isset($_SESSION['auth']))
{
$xml = simplexml_load_string($xmlfreebox);
$i = 0;
echo("<table id='dhcp_dynamic' class='display'>");
echo("<thead>");
echo("	<tr>");
echo("		<th>Hostname</th>");
echo("		<th>Ip</th>");
echo("		<th>Mac</th>");
echo("	</tr>");
echo("</thead>");
echo("<tbody>");
foreach ($xml->Configuration as $Configuration){
    foreach($Configuration->GetDhcpDynamicLeases as $id){
		 foreach($id as $tmp){
			echo("	<tr bgcolor='".( ($i % 2 == 1) ? '#dddddd' : '#eeeeee' )."'>");
			echo("		<td style='text-align:center;'>".$tmp->hostname."</td>");
			echo("		<td style='text-align:center;'>".$tmp->ip."</td>");
			echo("		<td style='text-align:right'>".$tmp->mac."</td>");
			echo("	</tr>");
			$i++;
		}
	}
}
echo("</tbody>");
echo("</table>");
}



}
?>
