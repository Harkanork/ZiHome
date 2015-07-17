<?
if(isset($_SESSION['auth']))
{
?>
<div id="body-action">
  <br>
  La version <? echo $version_server; ?> de ZiHome est disponible.<br>
  La liste des nouveaut&eacute;s est accessible <a href="https://github.com/Harkanork/ZiHome/wiki/PageChangeLog#<? echo str_replace(".", "", $version_server); ?>">ici</a>.<br><br>
  
  <form method="get" action="https://github.com/Harkanork/ZiHome/archive/V<? echo $version_server; ?>.zip">
    <INPUT TYPE="SUBMIT" VALUE="T&eacute;l&eacute;charger">
  </form>
</div>
<?
}
?>
