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
      Protocole
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
      <td>Date changement batterie</td>
      <td>Libell&eacute;</td>
      <td></td>
    </tr>
<?
  if(isset($_POST['id'])){
    include("./pages/connexion.php");
    $query = "UPDATE peripheriques SET id_plan = '".$_POST['sonde']."', type = '".$_POST['type']."', protocol = '".$_POST['protocol']."', `top` = '".$_POST['top']."', `left` = '".$_POST['left']."', Icone = '".$_POST['icone']."', Texte = '".$_POST['texte']."', gerer_batterie = '".$_POST['gerer_batterie']."', libelle = '".$_POST['libelle']."', date_chgt_batterie = '".$_POST['date_chgt_batterie']."' WHERE nom = '".$_POST['id']."'";
    mysql_query($query, $link);
  }
  include("./pages/connexion.php");
  $query = "SELECT * FROM peripheriques WHERE periph = 'actioneur'";
  $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while ($data = mysql_fetch_assoc($req))
  {
?>
    <tr>
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
    <td><select name="protocol">
    <?
    $query1 = "SELECT * FROM protocol WHERE actif = 1 ORDER BY `nom`";
    $req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while($data1 = mysql_fetch_assoc($req1)) {
    ?>
      <option value="<? echo $data1['zcode']; ?>"<? if($data1['zcode'] ==  $data['protocol']){ echo " selected"; } ?>><? echo $data1['nom']; ?></option>
    <? } ?>
    </select></td>
    <td><INPUT TYPE="number" NAME="left" VALUE="<? echo $data['left']; ?>" style="width:60px;"></td> 
    <td><INPUT TYPE="number" NAME="top" VALUE="<? echo $data['top']; ?>" style="width:60px;"></td>
    <td><INPUT type="checkbox" name="icone" value="1"<? if($data['icone'] == "1"){ echo " checked"; } ?>></td>
    <td class="icone"><center><INPUT type="checkbox" name="texte" value="1"<? if($data['texte'] == "1"){ echo " checked"; } ?>></center></td>        
    <td><INPUT type="checkbox" name="gerer_batterie" value="1"<? if($data['gerer_batterie'] == "1"){ echo " checked"; } ?>></td>
    <td><INPUT type="date" name="date_chgt_batterie" value="<? echo $data['date_chgt_batterie']; ?>"></td>
    <td><INPUT type="texte" name="libelle" value="<? echo $data['libelle']; ?>"></td>
    <td class="input"><center><INPUT TYPE="HIDDEN" NAME="id" VALUE="<? echo $data['nom']; ?>">
    <INPUT TYPE="SUBMIT" NAME="Valider" VALUE="Valider"></center></td>
  </FORM>
  </tr>
  <?
  }
}
?>
