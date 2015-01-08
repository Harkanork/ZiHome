<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="apple-touch-icon-precomposed" href="img/icon-iphone.jpg" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="translucent">
    <script type="text/javascript">
        (function(document,navigator,standalone) {
            // prevents links from apps from oppening in mobile safari
            // this javascript must be the first script in your <head>
		        if ((standalone in navigator) && navigator[standalone]) {
                var curnode, location=document.location, stop=/^(a|html)$/i;
                document.addEventListener('click', function(e) {
                    curnode=e.target;
                    while (!(stop).test(curnode.nodeName)) {
                        curnode=curnode.parentNode;
                    }
                    // Condidions to do this only on links to your own app
                    // if you want all links, use if('href' in curnode) instead.
		                if('href' in curnode && ( curnode.href.indexOf('http') || ~curnode.href.indexOf(location.host) ) && e.defaultPrevented !== true) {
                    //if('href' in curnode && ( curnode.href.indexOf('http') || ~curnode.href.indexOf(location.host) ) ) {
                        e.preventDefault();
                        location.href = curnode.href;
                    }
                },false);
            }
        })(document,window.navigator,'standalone');
    </script>
<script type="text/javascript" src="./js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="./js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="./js/jquery-ui.min.js"></script>
<script type="text/javascript" src="./js/jquery.ui.datepicker-fr.min.js"></script>
<script type="text/javascript" src="./js/modules/exporting.js"></script>
<script type="text/javascript" src="./js/modernizr.custom.js"></script>
<script type="text/javascript" src="./js/popup.js"></script>
<script>
  $(function() {
    if (!Modernizr.inputtypes['date']) {
      $.datepicker.setDefaults( $.datepicker.regional[ "fr" ] );
      $('input[type=date]').datepicker({dateFormat: 'dd-mm-yy'});
    }
    
    var tooltips = $( "[title]" ).tooltip(		
    {		
      content: function()		
      {		
        var element = $( this );		
        if ( element.is( "[title]" ) )		
        {		
          return element.attr( "title" );		
        }		
        return "";		
      }		
    });
  });
</script>
<?
$query = "SELECT * FROM paramettres WHERE libelle = 'icones'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
  $icone = $data['value'];
}
if(isset($_SESSION['css']) && $_SESSION['css'] != "")
{
  echo "<link rel=\"stylesheet\" href=\"./styles/".$_SESSION['css'].".css\" type=\"text/css\" media=\"all\">";
} 
else 
{
  $query = "SELECT * FROM paramettres WHERE libelle = 'css'";
  $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while ($data = mysql_fetch_assoc($req))
  {
    echo "<link rel=\"stylesheet\" href=\"./styles/".$data['value'].".css\" type=\"text/css\" media=\"all\">";
  }
}
if ($_GET['page']!="administration") {   // désactive le refresh dans la partie admninistration
  $query = "SELECT * FROM paramettres WHERE libelle = 'refresh'";
  $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while ($data = mysql_fetch_assoc($req))
  {
    echo "<META HTTP-EQUIV=Refresh CONTENT=\"".($data['value']*60)."\">";
  }
}
include('./lib/taille_fichier.php');
include('./lib/timestamp.php');
?>
