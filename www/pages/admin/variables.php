<?
if(isset($_SESSION['auth']))
{
  include("./lib/zibase.php");
  $zibase = new ZiBase($ipzibase);
  if(isset($_POST['Valider'])) {
    $zibase->setVariable($_POST['id'], $_POST['value']);
    $query = "UPDATE variables SET description = '".$_POST['description']."' WHERE `id` = '".$_POST['id']."'";
    //echo $query;
    mysql_query($query, $link);
  }
  ?>
  <div id="action-tableau">
  <center>
  <br>
  <table border="0">
    <tr class="title" bgcolor="#6a6a6a">
      <TH class="name-variable">
      Variable
      </TH>
      <TH>
      Valeur
      </TH>
      <td class="desc-variable">
      Description
      </TH>
      <TH></TH>
    </tr>
    <?
    for ($i = 0; $i < 60; $i++) {
      $var = $zibase->getVariable($i);
      $query0 = "SELECT * FROM `variables` WHERE id = '".$i."'";
      $req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
      $data0 = mysql_fetch_assoc($req0)
      
      ?>
      <tr class="contenu">
        <form method="post" action="./index.php?page=administration&detail=variables">
        <td class="name-variable"><? echo $i; ?></td>
        <td><input type="number" name="value" min="-32768" max="32767" value="<? echo $var; ?>"></td>
        <td class="desc-variable"><input type="text" style="width:95%;" name="description" value="<? echo $data0['description']; ?>"></td>
        <td>
          <input type="hidden" name="id" value="<? echo $i; ?>">
          <INPUT TYPE="SUBMIT" NAME="Valider" VALUE="Valider">
        </td>
        </form>
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
