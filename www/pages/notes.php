	  <title>Notes</title>
	  <link rel="stylesheet" rev="stylesheet" href="styles/notes.css">
	  <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.3/themes/base/jquery-ui.css" type="text/css" media="all" />
<script type="text/javascript">
</script>


	  <header>
	  	<h1>&nbsp;</h1>
	    <input type="button" value="Ajouter une note" id="btn-addNote" />
	  </header>
		<div id="tableau">
<?
$query = "SELECT * FROM notes ORDER BY z ASC";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$z=0;
$id=0;
while ($data = mysql_fetch_assoc($req)) {
	$note = '<div class="postick" style="left:'.$data['x'].'px; top:'.$data['y'].'px; width:'.$data['w'].'px; z-index:'.$data['z'].';position:absolute;" data-key="'.$data['id'].'" >';
	$note.='<div class="toolbar"><span class="delete" data-key="'.$data['id'].'">x</span></div>';
	$note.='<div contenteditable="true" class="editable">'.$data['text'].'</div></div>';
	echo $note;
	if ($data['id'] > $id) {
		$id=$data['id'];
	}
	if ($data['z'] > $z) {
		$z=$data['z'];
	}
}
?> 
		</div>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
	  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js"></script>
	  <script type="text/javascript" src="js/notes.js"></script>
	  <script type="text/javascript">
	  var zIndex = <? echo $z+1; ?>;
	  var idsuiv = <? echo $id+1 ?>;
    
</script>
