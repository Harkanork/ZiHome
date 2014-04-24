<?
if(isset($_SESSION['auth']))
{
$xml = simplexml_load_string($xmlfreebox);
echo("<table id='phone' class='display'>");
echo("<thead>");
echo("	<tr>");
echo("		<th>number</th>");
echo("		<th>type</th>");
echo("		<th>durée</th>");
echo("		<th>date</th>");
echo("	</tr>");
echo("</thead>");
echo("<tbody>");
$i = 0;
foreach ($xml->Calls_Contacts as $Calls_Contacts){
    foreach($Calls_Contacts->GetCallsList as $id){
		 foreach($id as $tmp){
			
			switch($tmp->type){
				case 'outgoing':
					$img='<img src="/img/out.png" />Out';
					break;
				case 'accepted':
					$img='<img src="/img/in.png" />In';
					break;
				case 'missed':
					$img='<img src="/img/miss.png" />Miss';
					break;
				default:
					$img='-';
					break;
			}
			$datetime = intval($tmp->datetime);
		 	echo("	<tr bgcolor='".( ($i % 2 == 1) ? '#dddddd' : '#eeeeee' )."'>");
			echo("		<td>".$tmp->number."</td>");
			echo("		<td>".$img."</td>");
			echo("		<td style='text-align:right'>".$tmp->duration."s</td>");
			echo("		<td style='text-align:center;'>".date('Y/m/d H:i:s', $datetime)."</td>");
			echo("	</tr>");
			$i++;
		}
	}
}
echo("</tbody>");
echo("</table>");

}
?>
