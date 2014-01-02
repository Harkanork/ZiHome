<?
if(isset($_SESSION['auth']))
{
if($periph['libelle'] == ""){
$nom = $periph['nom'];
} else {
$nom = $periph['libelle'];
}
?>
<center><h1><? echo $nom; ?></h1></center>
<center>
<? if($periph['type'] == 'dim') {
?>
<form method="get" action="./pages/actioneur.php">
<input type="range" name="dim" value="0" max="100" min="0" step="5">
<input type="hidden" name="ordre" value="2">
<input type="hidden" name="action" value="<? echo $periph['id']; ?>">
<input type="hidden" name="protocol" value="<? echo $periph['protocol']; ?>">
<input type="submit" name="Valider" value="Valider">
</form>
<a href="./pages/actioneur.php?ordre=1&action=<? echo $periph['id']; ?>&protocol=<? echo $periph['protocol']; ?>" class="button green">ON</a>
<a href="./pages/actioneur.php?ordre=0&action=<? echo $periph['id']; ?>&protocol=<? echo $periph['protocol']; ?>" class="button red close">OFF</a>
<? } else { ?>
<a href="./pages/actioneur.php?ordre=1&action=<? echo $periph['id']; ?>&protocol=<? echo $periph['protocol']; ?>" class="button green">ON</a>
<? if($periph['type'] == 'on_off') { ?><a href="./pages/actioneur.php?ordre=0&action=<? echo $periph['id']; ?>&protocol=<? echo $periph['protocol']; ?>" class="button red close">OFF</a><? }
}
?></center><?
}
?>
