<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" href="./styles/style.css" type="text/css" media="all">
<link rel="stylesheet" href="./styles/administration.css" type="text/css" media="all">
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
<script src="./js/modules/exporting.js"></script>
<script type="text/javascript" src="./js/popup.js"></script>
<?
include("./pages/connexion.php");
$query = "SELECT * FROM paramettres WHERE libelle = 'icones'";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
$icone = $data['value'];
}
?>
