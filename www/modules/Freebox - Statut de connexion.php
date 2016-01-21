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
echo("<table id='conn' class='display'>");
echo("<thead>");
echo("	<tr>");
echo("		<th>Etat</th>");
echo("		<th>Rate down</th>");
echo("		<th>Rate up</th>");
echo("		<th>Bandwidth up</th>");
echo("		<th>Bandwidth down</th>");
echo("	</tr>");
echo("</thead>");
echo("<tbody>");
foreach ($xml->Configuration as $Configuration){
    foreach($Configuration->GetConnnectionStatus as $tmp){
		 // foreach($id as $tmp){
		 switch($tmp->state){
			case 'up':
				$img='<img src="./img/ok.png" />Up';
				break;
			case 'down':
				$img='<img src="./img/nok.png" />Down';
				break;
			default:
				$img='-';
				break;
			}
			echo("	<tr bgcolor='".( ($i % 2 == 1) ? '#dddddd' : '#eeeeee' )."'>");
			echo("		<td style='text-align:center;'>".$img."</td>");
			echo("		<td style='text-align:center;'>".$tmp->rate_down."</td>");
			echo("		<td style='text-align:center;'>".$tmp->rate_up."</td>");
			echo("		<td style='text-align:center;'>".$tmp->bandwidth_up."</td>");
			echo("		<td style='text-align:center;'>".$tmp->bandwidth_down."</td>");
			echo("	</tr>");
			$i++;
		// }
	}
}
echo("</tbody>");
echo("</table>");
echo("		<td style='text-align:right'> IPV6 = ".$tmp->ipv6."</td></br>");
echo("		<td style='text-align:right'> IPV4 = ".$tmp->ipv4."</td>");
}



}
?>
