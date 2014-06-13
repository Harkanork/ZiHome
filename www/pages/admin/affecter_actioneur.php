<?
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin')
{
?>
<div id="action-actionneur">
  <center>
  <br>
  <table border="0" align="center">
    <tr class="nom">
      <td>
      Nom
      </td>
      <td>
      Pi&egrave;ce
      </td>
      <td>
      Type
      </td>
      <td>
      Droite
      </td>
      <td>
      Bas
      </td>
      <td>
      Icone
      </td>
      <td>
      Texte
      </td>      
      <td>Batterie</td>
      <td>Ordre</td>
      <td>Date changement batterie</td>
      <td>Libell&eacute;</td>
      <td>Consommation<br>(W/h)</td>
      <td></td>
      <td></td>
    </tr>
<?
  include("./lib/date_francais.php");
  if(isset($_GET['Supprimer'])){
    $query = "DELETE FROM `peripheriques` WHERE `id` = '".$_GET['id']."'";
    mysql_query($query, $link);
  }
  else if(isset($_POST['id'])){
    $date_chgt_batterie = date_ISO($_POST['date_chgt_batterie']);
    $query = "UPDATE peripheriques SET id_plan = '".$_POST['sonde']."', type = '".$_POST['type']."', `top` = '".$_POST['top']."', `left` = '".$_POST['left']."', Icone = '".$_POST['icone']."', Texte = '".$_POST['texte']."', gerer_batterie = '".$_POST['gerer_batterie']."', libelle = '".$_POST['libelle']."', date_chgt_batterie = '".$date_chgt_batterie."', ordre = '".$_POST['ordre']."', conso = '".$_POST['conso']."' WHERE nom = '".$_POST['id']."'";
    mysql_query($query, $link);
  }
  
  $query = "SELECT * FROM peripheriques WHERE periph = 'actioneur'";
  $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while ($data = mysql_fetch_assoc($req))
  {
?>
    <tr class="contenu">
    <FORM method="post" action="./index.php?page=administration&detail=affecter_actioneur">
    <td class="name"><? echo $data['nom']; ?></td>
    <td><select name="sonde">
    <option value="-1">ne pas afficher</option>
    <?
    $query3 = "SELECT * FROM `plan` ORDER BY `libelle`";
    $req3 = mysql_query($query3, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while($data3 = mysql_fetch_assoc($req3))
    { 
    ?>
      <option value="<? echo $data3['id']; ?>"<? if($data3['id'] ==  $data['id_plan']){ echo " selected"; } ?>><? echo $data3['libelle']; ?></option>
    <? } ?>
    </select></td>
    <td><select name="type">
    <option value="on"<? if($data['type'] == "on"){ echo " selected"; } ?>>On</option>
    <option value="on_off"<? if($data['type'] == "on_off"){ echo " selected"; } ?>>On - Off</option>
    <option value="dim"<? if($data['type'] == "dim"){ echo " selected"; } ?>>Dimable</option>
    </select></td> 
    <td><INPUT TYPE="number" NAME="left" VALUE="<? echo $data['left']; ?>" style="width:60px;"></td> 
    <td><INPUT TYPE="number" NAME="top" VALUE="<? echo $data['top']; ?>" style="width:60px;"></td>
    <td><center><INPUT type="checkbox" name="icone" value="1"<? if($data['icone'] == "1"){ echo " checked"; } ?>></center></td>
    <td class="icone"><center><INPUT type="checkbox" name="texte" value="1"<? if($data['texte'] == "1"){ echo " checked"; } ?>></center></td>
    <td><center><INPUT type="checkbox" name="gerer_batterie" value="1"<? if($data['gerer_batterie'] == "1"){ echo " checked"; } ?>></center></td>
    <td><center><input type="number" name="ordre" value="<? echo $data['ordre']; ?>" style="width:50px;"></input></center></td>
        <td> <INPUT id="date_chgt_batterie_<? echo $data['nom']; ?>" type="date" name="date_chgt_batterie" size="10"/>
      <script>
        if (!Modernizr.inputtypes['date']) 
        {
          document.getElementById('date_chgt_batterie_<? echo $data["nom"]; ?>').value = "<? echo date_francais($data['date_chgt_batterie']); ?>";
        }
        else
        {
          document.getElementById('date_chgt_batterie_<? echo $data["nom"]; ?>').value = "<? echo $data['date_chgt_batterie']; ?>";
        }
      </script>
    </td>
    <td><INPUT type="texte" name="libelle" value="<? echo $data['libelle']; ?>"></td>
    <td><input type="number" name="conso" value="<? echo $data['conso']; ?>"></input></td>
    <td class="input"><center><INPUT TYPE="HIDDEN" NAME="id" VALUE="<? echo $data['nom']; ?>">
    <INPUT TYPE="SUBMIT" NAME="Valider" VALUE="Valider"></center></td>
    </FORM>
    <td class="input">
      <center>
      <button onclick='javascript:askConfirmDeletion("./index.php?page=administration&detail=affecter_actioneur&Supprimer=Supprimer&id=<? echo $data['id']; ?>")'>Supprimer</button>
      </center>
    </td>
  </tr>
  <?
  }
}
?>
