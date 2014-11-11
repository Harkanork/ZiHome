<?
if(isset($_SESSION['auth']))
{
?>
<div id="body-action">
  <br>
  <div id="action-tableau">
  <center>
    <table border="0">
      <tr class="title" bgcolor="#6a6a6a">
        <TH>
        Nom
        </TH>
        <TH>
        Action
        </TH>
        <TH>
        Ordre
        </TH>
        <TH>
        </TH>
      </tr>
<?
      if(isset($_POST['id'])){
        $query = "UPDATE modules SET actif = '".$_POST['actif']."', ordre = '".$_POST['ordre']."' WHERE id = '".$_POST['id']."'";
        mysql_query($query, $link);
        echo "<meta http-equiv=\"refresh\" content=\"0; url=./index.php?page=administration&detail=gerer_modules\">";
      }
      $query = "SELECT * FROM modules";
      $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
      while ($data = mysql_fetch_assoc($req))
      {
?>
      <tr class="contenu">
        <FORM method="post" action="./index.php?page=administration&detail=gerer_modules">
          <td width="190px" align="center">
            <? echo $data['libelle']; ?>
          </td>
          <td>
            <select name="actif">
            <option value="1"<? if($data['actif'] == "1"){ echo " selected"; } ?>>Actif</option>
            <option value="0"<? if($data['actif'] == "0"){ echo " selected"; } ?>>Inactif</option>
            </select>
          </td>
          <td>
            <input type="number" name="ordre" value="<? echo $data['ordre']; ?>"></input>
          </td>
            <INPUT TYPE="HIDDEN" NAME="id" VALUE="<? echo $data['id']; ?>">
          <td>
            <INPUT TYPE="SUBMIT" NAME="Valider" VALUE="Valider">
          </td>
        </FORM>
      </tr>
<?
      }
?>
    </table>
    </center>
    <br>
  </div>
</div>
<?
}
?>
