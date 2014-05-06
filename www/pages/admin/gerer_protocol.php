<?
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin') 
{
  ?>
  <div id="action-actionneur">
  <center>
  <br>
  <table border="0" align="center">
    <tr class="nom">
      <td class="nom">
      Protocole
      </td>
      <TD>
      Status
      </TD>
      <TD>
      </TD>
    </tr>
    <?
    if(isset($_POST['id'])){
      $query = "UPDATE protocol SET actif = '".$_POST['actif']."' WHERE id = '".$_POST['id']."'";
      mysql_query($query, $link);
    }
    $query = "SELECT * FROM protocol";
    $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    while ($data = mysql_fetch_assoc($req))
    {
      ?>
      <tr class="contenu">
        <FORM method="post" action="./index.php?page=administration&detail=gerer_protocol">
        <td class="name">
          <? echo $data['nom']; ?>
        </td>
        <td>
          <center>
          <select name="actif">
          <option value="1"<? if($data['actif'] == "1"){ echo " selected"; } ?>>Actif</option>
          <option value="0"<? if($data['actif'] == "0"){ echo " selected"; } ?>>Inactif</option>
          </select>
          </center>
        </td>
        <td class="input">
          <center>
          <INPUT TYPE="HIDDEN" NAME="id" VALUE="<? echo $data['id']; ?>">
          <INPUT TYPE="SUBMIT" NAME="Valider" VALUE="Valider">
          </center>
        </td>
        </FORM>
      </tr>
      <?
    }
    ?>
  </table>
  </center>
  </div>
  <? 
} 
?>
