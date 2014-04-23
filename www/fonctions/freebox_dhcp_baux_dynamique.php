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
			var oTable = $('#dhcp_dynamic').dataTable({
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
			echo("	<tr>");
			echo("		<td style='text-align:center;'>".$tmp->hostname."</td>");
			echo("		<td style='text-align:center;'>".$tmp->ip."</td>");
			echo("		<td style='text-align:right'>".$tmp->mac."</td>");
			echo("	</tr>");
		}
	}
}
echo("</tbody>");
echo("</table>");
}
?>
</body>
</html>
