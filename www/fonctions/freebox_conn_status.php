<?
if(isset($_SESSION['auth']))
{
$xml = simplexml_load_string($xmlfreebox);
?>
<html>
<head>
	<style>
	</style>
	<link href="../js/demo_table.css" content="text/css" rel="stylesheet">
	<script src="../js/jquery-1.10.2.min.js" language="javascript" type="text/javascript"></script>
	<script src="../js/jquery.dataTables.js" language="javascript" type="text/javascript"></script>
	<script src="../js/FixedHeader.js" language="javascript" type="text/javascript"></script>
	<script type="text/javascript" language="javascript" >
		$(document).ready( function () {
			var oTable = $('#conn').dataTable({
					"bScrollCollapse": false,
					"bPaginate": false,
					"bFilter": false,
					"bSort": false,
					"bInfo": false,
					"bAutoWidth": false,
					"bJQueryUI": true
				});
			new FixedHeader( oTable );
		} );
	</script>
</head>

<body>
<?php
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
				$img='<img src="/img/ok.png" />Up';
				break;
			case 'down':
				$img='<img src="/img/nok.png" />Down';
				break;
			default:
				$img='-';
				break;
			}
			echo("	<tr>");
			echo("		<td style='text-align:center;'>".$img."</td>");
			echo("		<td style='text-align:center;'>".$tmp->rate_down."</td>");
			echo("		<td style='text-align:center;'>".$tmp->rate_up."</td>");
			echo("		<td style='text-align:center;'>".$tmp->bandwidth_up."</td>");
			echo("		<td style='text-align:center;'>".$tmp->bandwidth_down."</td>");
			echo("	</tr>");
		// }
	}
}
echo("</tbody>");
echo("</table>");
echo("		<td style='text-align:right'> IPV6 = ".$tmp->ipv6."</td></br>");
echo("		<td style='text-align:right'> IPV4 = ".$tmp->ipv4."</td>");
}
?>
</body>
</html>
