<?
if(isset($_SESSION['auth']) && $_SESSION['niveau'] == 'admin')
{
  if(isset($_GET['Supprimer'])){
    $query = "DELETE FROM `vues` WHERE `id` = '".$_GET['Supprimer']."'";
    mysql_query($query, $link);
  }
  else if(isset($_GET['Ajouter'])) {
    $query = "INSERT INTO vues (`libelle`, `grid`) VALUES ('".$_POST['libelle']."', '".$_POST['grid']."')";
    mysql_query($query, $link);
  } 
  
  
?>
<div id="action-tableau">
<CENTER>
<br>
<TABLE border=0><TR class="title" bgcolor="#6a6a6a"><TH>Id</TH><TH>Nom</TH><TH>Accrochage</TH><TH>Supprimer</TH></TR>
<?
  $query = "SELECT * FROM vues";
  $req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while ($data = mysql_fetch_assoc($req))
  {
      echo "<TR class=\"contenu\">";
      echo "<TD>".$data['id']."</TD>";
      echo "<TD><input type=\"text\" value=\"".$data['libelle']."\" data-ajax=\"maj\" data-db=\"vues\" data-type=\"text\" data-champ=\"libelle\" data-id=\"".$data['id']."\"></TD>";
      ?>
      <TD><select name="grid" data-ajax="maj" data-db="vues" data-type="select" data-champ="grid" data-id="<? echo $data['id'] ?>">
        <option value="false" <? if ($data['grid']=="false") { echo "selected";} ?>>Libre</option>
        <option value="5" <? if ($data['grid']=="5") { echo "selected";} ?>>5x5</option>
        <option value="10" <? if ($data['grid']=="10") { echo "selected";} ?>>10x10</option>
        <option value="20" <? if ($data['grid']=="20") { echo "selected";} ?>>20x20</option>
        <option value="30" <? if ($data['grid']=="30") { echo "selected";} ?>>30x30</option>
        <option value="50" <? if ($data['grid']=="50") { echo "selected";} ?>>50x50</option>
      </select></TD>
      <td class="input"><center><a href="./index.php?page=administration&detail=gerer_vues&Supprimer=<? echo $data['id'] ?>">X</a></center></td>
      </FORM>
    </TR>
    <?
  }
?>
</TABLE></CENTER>
<P align=center>
<TABLE class=panneau_table >
  <TR class=panneau_titre>
    <TH>Nouvelle vue</TH>
  </TR>
  <TR>
    <TD class=panneau_centre>
      <CENTER>
      <TABLE>
      <form method=POST action="./index.php?page=administration&detail=gerer_vues&Ajouter=1">
        <TR><TD class=panneau_libelle>Nom</TD><TD><input type=text name="libelle"></INPUT></TD></TR>
        <TR><TD class=panneau_libelle>Accrochage</TD><TD> 
          <select name="grid">
            <option value="false">Libre</option>
            <option value="5">5x5</option>
            <option value="10">10x10</option>
            <option value="20">20x20</option>
            <option value="30">30x30</option>
            <option value="50">50x50</option>
          </select></TD></TR>
        <TR><TD colspan=2 class=panneau_boutons><INPUT type=submit name="Ajouter" value="Ajouter"></TD></TR>
      </FORM>
      </TABLE>
      </CENTER>
    </TD>
  </TR>
</TABLE>
</div>


<? 
} 
?>
