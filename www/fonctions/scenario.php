<?
if(isset($_SESSION['auth']))
{
?>
<center><h1><? echo $periph['nom']; ?></h1></center>
<center>
<a href="./pages/scenario.php?action=<? echo $periph['id']; ?>" class="button green">RUN</a>
</center></div>
<?
}
?>
