<?
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin')
{
  if(isset($_POST['valider'])){
    $query = "UPDATE paramettres SET value = '".$_POST['value']."' WHERE id = '".$_POST['id']."'";
    mysql_query($query, $link);
  }
  if(isset($_POST['valider_global'])){
    $query = "SELECT * FROM paramettres WHERE libelle != 'icones' AND id != 12";
    $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while ($data = mysql_fetch_assoc($req))
    {
      $query1 = "UPDATE paramettres SET value = '".$_POST['value_'.$data['id']]."' WHERE id = '".$data['id']."'";
      mysql_query($query1, $link);
    }
  }
?>
<div id="action-tableau">
<center>
<br>
<FORM method="post" action="./index.php?page=administration&detail=paramettres">
<table border="0">
  <tr class="title" bgcolor="#6a6a6a">
    <TH>Nom</TH>
    <TH>Valeur</TH>
  </tr>
<?
  $query = "SELECT * FROM paramettres WHERE libelle != 'icones' AND id != 12";
  $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while ($data = mysql_fetch_assoc($req))
  {
?>
  <tr class="contenu">
    <td class="name" style="width:200px">
      <? echo $data['libelle']; ?>
    </td>
    <td style="text-align:left">
<?
    if ($data['type'] == 'selectbox')
    {
      $query1 = "SELECT * FROM `".$data['libelle']."`";
      // est-ce qu'il y a une table associee au parametre
      $req1 = mysql_query($query1, $link);
      echo "<select name=\"value_".$data['id']."\">";    
      while ($data1 = mysql_fetch_assoc($req1))
      {
        if($data1['value'] == $data['value'])
        {
          echo "<option value=\"".$data1['value']."\" selected>".$data1['value']."</option>";
        } else {
          echo "<option value=\"".$data1['value']."\">".$data1['value']."</option>";
        }
      }
      echo "</select>";
    }
    else if($data['type'] == 'checkbox')
    {
      echo "<INPUT type=\"".$data['type']."\" name=\"value_".$data['id']."\" value=\"true\"";
      if ($data['value'] == "true")
      {
        echo " checked ";
      }
      echo "/>";      
    }    
    else 
    {
      echo "<INPUT size=\"10\" type=\"".$data['type']."\" name=\"value_".$data['id']."\" value=\"".$data['value']."\"/>";      
    }   
       
?>
    </td>
  </tr>
<?
  }
?>
<td colspan="4" align="center" style="height: 30px;background-color: #ccc;"><INPUT TYPE="SUBMIT" NAME="valider_global" VALUE="Valider"></input></td>
</table>
</FORM>
</center>
</div>

<div id="action-actionneur">
<center>
<br>
<?
  $query = "SELECT * FROM paramettres WHERE libelle = 'icones'";
  $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while ($data = mysql_fetch_assoc($req))
  {
    $icones1 = $data['value'];
    $iconesId = $data['id'];
  }
  $array = array( 1, 4, 2, 5, 6, 8, 7, 9 ); 
  echo '<p align=center><form method="post" action="./index.php?page=administration&detail=paramettres">';
  echo '<input type="hidden" name="id" value="'.$iconesId.'"/>';
  echo '<table border="0" cellpadding="0" cellspacing="2">';
  echo '<tr class="nom">';
  echo '<td colspan="4">Icones</td>';
  echo '</tr>';  
  $i = 0;
  foreach($array as $icones) {
    if ($i % 2 == 0) {
      echo '<tr>';
    }
    echo '<td><input type="radio" name="value" value="'.$icones.'"';
    if($icones1 == $icones) { 
      echo " checked"; 
    }
    echo '/></td>';
    echo '<td><img width="100" height="100" src="./img/icones/StyleIconPreview'.$icones.'.png"/></td>';
    if ($i % 2 == 1) {
      echo '</tr>';
    }
    $i = $i + 1;
  }
  echo '<tr>';
  echo '<td colspan="4" align="center" style="height: 30px;background-color: #ccc;"><INPUT TYPE="SUBMIT" NAME="valider" VALUE="Valider"/></td>';
  echo '</tr>';
  echo '</table></form></p>';
?>
</center>
</div>

<div id="action-actionneur">
<center>
<br>
<?
  $query = "SELECT * FROM paramettres WHERE id = 12";
  $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while ($data = mysql_fetch_assoc($req))
  {
    $meteoIconesFolder = $data['value'];
    $meteoIconesId = $data['id'];
  }
  $array = array( "colorful", "dark", "flat_black", "flat_colorful", "flat_white", "light" ); 
  echo '<p align=center><form method="post" action="./index.php?page=administration&detail=paramettres">';
  echo '<input type="hidden" name="id" value="'.$meteoIconesId.'"/>';
  echo '<table border="0" cellpadding="0" cellspacing="2">';
  echo '<tr class="nom">';
  echo '<td colspan="4">Icones météo</td>';
  echo '</tr>';  
  $i = 0;
  foreach($array as $icones) {
    if ($i % 2 == 0) {
      echo '<tr>';
    }
    echo '<td><input type="radio" name="value" value="'.$icones.'"';
    if($meteoIconesFolder == $icones) { 
      echo " checked"; 
    }
    echo '/></td>';
    echo '<td><img width="100" height="100" src="./img/meteo/'.$icones.'/39.png"/ style="background-color: #103144;" title="Created by MerlinTheRed (http://merlinthered.deviantart.com/)"></td>';
    if ($i % 2 == 1) {
      echo '</tr>';
    }
    $i = $i + 1;
  }
  echo '<tr>';
  echo '<td colspan="4" align="center" style="height: 30px;background-color: #ccc;"><INPUT TYPE="SUBMIT" NAME="valider" VALUE="Valider"/></td>';
  echo '</tr>';
  echo '</table></form></p>';
?>
</center>
</div>
<?
}
?>
