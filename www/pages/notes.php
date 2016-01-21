<?
include("./fonctions/dialogue_confirmation.php");
?>

<title>Notes</title>
<link rel="stylesheet" href="js/themes/jquery-ui.min.css" type="text/css" media="all" />
<link rel="stylesheet" rev="stylesheet" href="styles/notes.css" />

<div id="sous-menu">
  <h1>&nbsp;</h1>
  <input type="button" value="Ajouter une note" id="btn-addNote" />
</div>
<div id="tableau"> 
</div>
<div id="waiting"></div>

<!-- Plugin qui gere le tactile -->
<script type="text/javascript" src="js/jquery.ui.touch-punch.min.js"></script>
<script type="text/javascript" src="js/notes.js"></script>

<script type="text/javascript">
  var zIndex = 0;
  var idsuiv = 0;
</script>
    
<?
  $query = "SELECT * FROM notes ORDER BY z ASC";
  $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  echo '<script type="text/javascript">';
    while ($data = mysql_fetch_assoc($req)) 
    {
      echo "addNote(" . $data['id'] . ", " . $data['x'] . ", " . $data['y'] . ", " . $data['z'] . ", " . $data['w'] . ", \"" . $data['text'] . "\");";
    }
  echo '</script>';
?>