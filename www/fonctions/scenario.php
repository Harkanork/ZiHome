<?
if(isset($_SESSION['auth']))
{
?>
<center>
  <?
    if(empty($periph['libelle'])){
      $nom = $periph['nom'];
    } else {
      $nom = $periph['libelle'];
    }
  ?>
  <input type="button" name="<? echo $nom; ?>" value="<? echo $nom; ?>" onclick="self.location.href='./pages/scenario.php?action=<? echo $periph['id']; ?>'" style="background-color:#000; color:#fff; border-color:#000; font-weight:bold; padding:10px;cursor:pointer;" onclick> 
</center>
<?
}
?>
