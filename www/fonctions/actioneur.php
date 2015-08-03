<?
  if(isset($_SESSION['auth']))
  {
    if ($periph['libelle'] == "")
    {
      $nom = $periph['nom'];
    } 
    else 
    {
      $nom = $periph['libelle'];
    }
    ?>
    <center><h1><? echo $nom; ?></h1></center>
    <center>
    <? 
    if ($periph['type'] == 'rgb') 
    {
      ?>
      <script src="js/evol.colorpicker.js" type="text/javascript" charset="utf-8"></script>
      <link href="js/themes/evol.colorpicker.css" rel="stylesheet" type="text/css" />
      
      <div id="ColorPicker-<? echo $periph['id']; ?>" style="display:inline"></div></td>
       
      <div id="Color-<? echo $periph['id']; ?>" style="height:40px;width:100px;border:1px ridge black;">
        <form method="get" action="./pages/actioneur.php">
          <input type="hidden" id="RGB-<? echo $periph['id']; ?>" name="rgb" value="3">
          <input type="hidden" name="action" value="<? echo $periph['id']; ?>">
          <input type="hidden" name="protocol" value="<? echo $periph['protocol']; ?>">
          <input type="submit" name="Valider" value="Appliquer" style="height:20px;width:80px; margin-top:10px;">
        </form>
      </div>       
      <br>  

      <a href="./pages/actioneur.php?ordre=1&action=<? echo $periph['id']; ?>&protocol=<? echo $periph['protocol']; ?>" class="button green">ON</a>
      <a href="./pages/actioneur.php?ordre=0&action=<? echo $periph['id']; ?>&protocol=<? echo $periph['protocol']; ?>" class="button red close">OFF</a>
      <script>
        $('#ColorPicker-<? echo $periph['id']; ?>')
          .colorpicker(
          {
            color : '#31859b', 
            defaultPalette : 'web',
            history: false,
            displayIndicator : false,          
          })
          .on('change.color', function(evt, color)
          {
			     $('#Color-<? echo $periph['id']; ?>').css('background-color', color);
			     $('#RGB-<? echo $periph['id']; ?>').val(color);
		      });
        $('#actionneur-<? echo $periph['id']; ?>').height(380);
      </script>
      <? 
    } 
    else if ($periph['type'] == 'dim') 
    {
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
      <? 
    } 
    else 
    { 
      ?>
      <a href="./pages/actioneur.php?ordre=1&action=<? echo $periph['id']; ?>&protocol=<? echo $periph['protocol']; ?>" class="button green">ON</a>
      <? if($periph['type'] == 'on_off') { ?><a href="./pages/actioneur.php?ordre=0&action=<? echo $periph['id']; ?>&protocol=<? echo $periph['protocol']; ?>" class="button red close">OFF</a><? }
    }
    ?>
    </center>
    <?
  }
?>
