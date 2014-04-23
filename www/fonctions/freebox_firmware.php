<?
if(isset($_SESSION['auth']))
{
$xml = simplexml_load_string($xmlfreebox);
?>
<html>
<head>
	<style>
	</style>
	<link href="./js/demo_table.css" content="text/css" rel="stylesheet">
	<script src="./js/jquery-1.10.2.min.js" language="javascript" type="text/javascript"></script>
	<script src="./js/jquery.dataTables.js" language="javascript" type="text/javascript"></script>
	<script src="./js/FixedHeader.js" language="javascript" type="text/javascript"></script>
	<script type="text/javascript" language="javascript" >
		$(document).ready( function () {
			var oTable = $('#firmware').dataTable({
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
//		  foreach($id as $tmp){
		 	echo("	<tr>");
			echo("		<td style='text-align:center;'>".$tmp->firmware_version."</td>");
			echo("		<td style='text-align:center;'>".$tmp->uptime."</td>");
			echo("		<td style='text-align:center;'>".$tmp->mac."</td>");
			echo("		<td style='text-align:center;'>".$tmp->fan_rpm." Rpm</td>");
			echo("		<td style='text-align:center;'>".$tmp->temp_sw."°C</td>");
			echo("	</tr>");
//		 }
	}
}
echo("</tbody>");
echo("</table>");
}
?>
</body>
</html>
