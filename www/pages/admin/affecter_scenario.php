<?
if(isset($_SESSION['auth']))
{
  ?>
  <div id="body-action">
    <br>
    <div id="action-actionneur">
      <center>
      <table border="0" width="700px" align="center">
      <tr class="nom">
        <td>
        Nom
        </td>
        <td>
        Pi&egrave;ce
        </td>
        <td>
        Droite
        </td>
        <td>
        Bas
        </td>
        <td>
        Libell&eacute;
        </td>
        <td>
        </td>
        <td>
        </td>
      </tr>
      <?
      if(isset($_GET['Supprimer'])){
        $query = "DELETE FROM `scenarios` WHERE `id` = '".$_GET['id']."'";
        mysql_query($query, $link);
      }
      else if(isset($_POST['id'])){
        $query = "UPDATE scenarios SET id_plan = '".$_POST['sonde']."', `top` = '".$_POST['top']."', `left` = '".$_POST['left']."', `libelle` = '".$_POST['libelle']."' WHERE nom = '".$_POST['id']."'";
        mysql_query($query, $link);
      }
      
      $query = "SELECT * FROM scenarios";
      $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
      while ($data = mysql_fetch_assoc($req))
      {
        ?>
        <FORM method="post" action="./index.php?page=administration&detail=affecter_scenario">
        <tr class="contenu"><td class="name">
        <? echo $data['nom']; ?></td>
        <td><center><select name="sonde">
        <option value="-1">ne pas afficher</option>
        <?
        $query3 = "SELECT * FROM `plan` ORDER BY `libelle`";
        $req3 = mysql_query($query3, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
        while($data3 = mysql_fetch_assoc($req3))
        { ?>
          <option value="<? echo $data3['id']; ?>"<? if($data3['id'] ==  $data['id_plan']){ echo " selected"; } ?>><? echo $data3['libelle']; ?></option>
        <? } ?>
        </select></center>
        </td>
        <td class="droite"><center>
          <INPUT TYPE="number" NAME="left" VALUE="<? echo $data['left']; ?>" style="width:60px;">
          </center>
        </td>
        <td class="bas">
          <center>
          <INPUT TYPE="number" NAME="top" VALUE="<? echo $data['top']; ?>" style="width:60px;">
          </center>
        </td>
        <td class="name"><center>
          <INPUT TYPE="text" NAME="libelle" VALUE="<? echo $data['libelle']; ?>" style="width:100px;">
          </center>
        </td>
        <INPUT TYPE="HIDDEN" NAME="id" VALUE="<? echo $data['nom']; ?>">
        <td class="input">
          <center>
          <INPUT TYPE="SUBMIT" NAME="Valider" VALUE="Valider">
          </center>
        </td>
        </FORM>
        <td class="input">
          <center>
          <button onclick='javascript:askConfirmDeletion("./index.php?page=administration&detail=affecter_scenario&Supprimer=Supprimer&id=<? echo $data['id']; ?>")'>Supprimer</button>
          </center>
        </td>
        </tr>
        <?
      }
      ?>
      </table>
      </center>
    </div>
  </div>
  <?
}
?>
