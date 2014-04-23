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
			var oTable = $('#phone').dataTable({
					"bScrollCollapse": true,
					"bPaginate": false,
					"bFilter": false,
					"bSort": true,
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
		 	echo("	<tr>");
			echo("		<td>".$tmp->number."</td>");
			echo("		<td>".$img."</td>");
			echo("		<td style='text-align:right'>".$tmp->duration."s</td>");
			echo("		<td style='text-align:center;'>".date('Y/m/d H:i:s', $datetime)."</td>");
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
