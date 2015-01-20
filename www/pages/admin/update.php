<?
if(isset($_SESSION['auth']))
{
?>
<div id="body-action">
  <br>
  La version <? echo $version_server; ?> de ZiHome est disponible.<br>
  La liste des nouveaut&eacute;s est accessible <a href="https://code.google.com/p/interface-utilisateur-domotique-zibase/wiki/PageChangeLog#<? echo $version_server; ?>">ici</a>.<br><br>
  
  <form method="get" action="https://interface-utilisateur-domotique-zibase.googlecode.com/archive/V<? echo $version_server; ?>.zip">
    <INPUT TYPE="SUBMIT" VALUE="T&eacute;l&eacute;charger">
  </form>
</div>
<?
}
?>
