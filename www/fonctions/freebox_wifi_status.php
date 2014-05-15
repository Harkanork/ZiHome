<?php
if(isset($_SESSION['auth']))
{
$xml = simplexml_load_string($xmlfreebox);
echo("<table id='wifi' class='display'>");
echo("<thead>");
echo("	<tr>");
echo("	</tr>");
echo("</thead>");
echo("<tbody>");

foreach ($xml->Configuration as $Configuration){
    foreach($Configuration->GetWifiConfig as $tmp){
		switch($tmp->enabled){
			case '1':
				$img='<img src="./img/wifi_ok.png" />Activé';
				break;
			case '0':
				$img='<img src="./img/wifi_nok.png" />inactif';
				break;
			default:
				$img='<img src="./img/wifi_nok.png" />inactif';
				break;
			}

		 	echo("	<tr>");
			echo("		<td>".$img."</td>");
			echo("	</tr>");
		}
}
echo("</tbody>");
echo("</table>");

}
?>
