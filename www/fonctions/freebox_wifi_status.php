<?php
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
			var oTable = $('#wifi').dataTable({
					"bScrollCollapse": true,
					"bPaginate": false,
					"bFilter": true,
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
echo("<table id='wifi' class='display'>");
echo("<thead>");
echo("	<tr>");
echo("	</tr>");
echo("</thead>");
echo("<tbody>");

foreach ($xml->Configuration as $Configuration){
    foreach($Configuration->GetWifiStatus as $tmp){
		 // foreach($id as $tmp){
// echo("<pre>");
// print_r($tmp);
// echo("</pre>");
		switch($tmp->active){
			case '1':
				$img='<img src="/img/wifi_ok.png" />Activé';
				break;
			case '0':
				$img='<img src="/img/wifi_nok.png" />inactif';
				break;
			default:
				$img='<img src="/img/wifi_nok.png" />inactif';
				break;
			}

		 	echo("	<tr>");
			echo("		<td>".$img."</td>");
			echo("	</tr>");
		// }
	}
}
echo("</tbody>");
echo("</table>");

}
?>
</body>
</html>
