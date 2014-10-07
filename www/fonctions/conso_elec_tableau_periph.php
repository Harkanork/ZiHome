<?php
echo "<p class=titre-texte>Statistiques pour ".$periph['libelle']." :</p>";
echo "<p><CENTER><TABLE width=500px>";
echo "<TR class=tab-titre><TD><b>P&eacute;riode</b></TD><TD width=120px><b>&nbsp;Consommation&nbsp;</b></TD><TD width=150px><b>&nbsp;Coût&nbsp;</b></TD></TR>";
$query0 = "SELECT max(conso_total) as max, min(conso_total) as min, date FROM `conso_".$periph['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 3 DAY) GROUP BY DATE_FORMAT(`date`, '%Y%m%d') ORDER BY DATE_FORMAT(`date`, '%Y%m%d') DESC LIMIT 2";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$i=1;
while ($value0 = mysql_fetch_assoc($req0))
{
  $consoTemp = 0;
  foreach($heuresCreuses as $heureCreuse){
    if ($heureCreuse['debut'] != "00:00:00" || $heureCreuse['fin'] != "00:00:00")
    {
      $query6 = "SELECT min(conso_total) as min, max(conso_total) as max FROM `conso_".$periph['nom']."` where `date` >= '".substr($value0['date'], 0, 10)." ".$heureCreuse['debut']."' and `date` <= '".substr($value0['date'], 0, 10)." ".$heureCreuse['fin']."'";
      $res_query6 = mysql_query($query6, $link);
      if(mysql_numrows($res_query6) > 0){
        $consoTemp += mysql_result($res_query6,0,"max") - mysql_result($res_query6,0,"min");
      }
    }
  }
  if($i == 1) {
    echo "<TR bgcolor='#dddddd' class=tab-ligne><TD>Aujourd'hui&nbsp;</TD><TD style='text-align: right'>".number_format((($value0['max'] - $value0['min'])/1000),1, ',', ' ')." kWh&nbsp;</TD><TD style='text-align: right'>".number_format(((($consoTemp*$coutHC/1000)+(($value0['max'] - $value0['min'] - $consoTemp)*$coutHP)/1000)),2,',',' ')." &euro;&nbsp;</TD></TR>";
  } else {
    echo "<TR bgcolor='#eeeeee' class=tab-ligne><TD>Hier</TD><TD style='text-align: right'>".number_format((($value0['max'] - $value0['min'])/1000),1, ',', ' ')." kWh&nbsp;</TD><TD style='text-align: right'>".number_format(((($consoTemp*$coutHC/1000)+(($value0['max'] - $value0['min'] - $consoTemp)*$coutHP)/1000)),2,',',' ')." &euro;&nbsp;</TD></TR>";
  }
  $i++;
}
$query0 = "SELECT max(conso_total) as max, min(conso_total) as min, date, DATE_FORMAT(`date`, '%Y-%m') AS mois FROM `conso_".$periph['nom']."` WHERE date < curdate() AND date > DATE_SUB(curdate(), INTERVAL 7 DAY)";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value0 = mysql_fetch_assoc($req0))
{
  $consoTemp = 0;
  $query1 = "SELECT max(conso_total) as max, min(conso_total) as min, date FROM `conso_".$periph['nom']."` WHERE date < curdate() AND date > DATE_SUB(curdate(), INTERVAL 7 DAY) GROUP BY DATE_FORMAT(`date`, '%Y%m%d')";
  $req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while($value1 = mysql_fetch_assoc($req1))
  {
    foreach($heuresCreuses as $heureCreuse){
      if ($heureCreuse['debut'] != "00:00:00" || $heureCreuse['fin'] != "00:00:00")
      {
        $query6 = "SELECT min(conso_total) as min, max(conso_total) as max FROM `conso_".$periph['nom']."` where `date` >= '".substr($value1['date'], 0, 10)." ".$heureCreuse['debut']."' and `date` <= '".substr($value1['date'], 0, 10)." ".$heureCreuse['fin']."'";
        $res_query6 = mysql_query($query6, $link);
        if(mysql_numrows($res_query6) > 0){
         $consoTemp += mysql_result($res_query6,0,"max") - mysql_result($res_query6,0,"min");
        }
      }
    }
  }
  echo "<TR bgcolor='#dddddd' class=tab-ligne><TD>Semaine</TD><TD style='text-align: right'>".number_format((($value0['max'] - $value0['min'])/1000),0, ',', ' ')." kWh&nbsp;</TD><TD style='text-align: right'>". number_format(((($consoTemp*$coutHC/1000)+(($value0['max'] - $value0['min'] - $consoTemp)*$coutHP)/1000)),2,',',' ')." &euro;&nbsp;</TD></TR>";
}
$query0 = "SELECT max(conso_total) as max, min(conso_total) as min, date, DATE_FORMAT(`date`, '%Y-%m') AS mois FROM `conso_".$periph['nom']."` WHERE date < curdate() AND date > DATE_SUB(curdate(), INTERVAL 30 DAY)";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($value0 = mysql_fetch_assoc($req0))
{
  $consoTemp = 0;
  $query1 = "SELECT max(conso_total) as max, min(conso_total) as min, date FROM `conso_".$periph['nom']."` WHERE date < curdate() AND date > DATE_SUB(NOW(), INTERVAL 30 DAY) GROUP BY DATE_FORMAT(`date`, '%Y%m%d')";
  $req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while($value1 = mysql_fetch_assoc($req1))
  {
    foreach($heuresCreuses as $heureCreuse){
      if ($heureCreuse['debut'] != "00:00:00" || $heureCreuse['fin'] != "00:00:00")
      {
        $query6 = "SELECT min(conso_total) as min, max(conso_total) as max FROM `conso_".$periph['nom']."` where `date` >= '".substr($value1['date'], 0, 10)." ".$heureCreuse['debut']."' and `date` <= '".substr($value1['date'], 0, 10)." ".$heureCreuse['fin']."'";
        $res_query6 = mysql_query($query6, $link);
        if(mysql_numrows($res_query6) > 0){
          $consoTemp += mysql_result($res_query6,0,"max") - mysql_result($res_query6,0,"min");
        }
      }
    }
  }
  echo "<TR bgcolor='#eeeeee' class=tab-ligne><TD>Mois</TD><TD style='text-align: right'>".number_format((($value0['max'] - $value0['min'])/1000),0, ',', ' ')." kWh&nbsp;</TD><TD style='text-align: right'>". number_format(((($consoTemp*$coutHC/1000)+(($value0['max'] - $value0['min'] - $consoTemp)*$coutHP)/1000)),2,',',' ')." &euro;&nbsp;</TD></TR>";
}
$query0 = "SELECT max(conso_total) as max, min(conso_total) as min, date, DATE_FORMAT(`date`, '%Y-%m') AS mois FROM `conso_".$periph['nom']."` WHERE date < curdate() AND date > DATE_SUB(curdate(), INTERVAL 1 YEAR)";
$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.'<br>'.mysql_error());
while($value0 = mysql_fetch_assoc($req0))
{
  $consoTemp = 0;
  $query1 = "SELECT max(conso_total) as max, min(conso_total) as min, date FROM `conso_".$periph['nom']."` WHERE date < curdate() AND date > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY DATE_FORMAT(`date`, '%Y%m%d')";
  $req1 = mysql_query($query1, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
  while($value1 = mysql_fetch_assoc($req1))
  {
    foreach($heuresCreuses as $heureCreuse){
      if ($heureCreuse['debut'] != "00:00:00" || $heureCreuse['fin'] != "00:00:00")
      {
        $query6 = "SELECT min(conso_total) as min, max(conso_total) as max FROM `conso_".$periph['nom']."` where `date` >= '".substr($value1['date'], 0, 10)." ".$heureCreuse['debut']."' and `date` <= '".substr($value1['date'], 0, 10)." ".$heureCreuse['fin']."'";
        $res_query6 = mysql_query($query6, $link);
        if(mysql_numrows($res_query6) > 0){
          $consoTemp += mysql_result($res_query6,0,"max") - mysql_result($res_query6,0,"min");
        }
      }
    }
  }
  echo "<TR bgcolor='#dddddd' class=tab-ligne><TD>Ann&eacute;e</TD><TD style='text-align: right'>".number_format((($value0['max'] - $value0['min'])/1000),0, ',', ' ')." kWh&nbsp;</TD><TD style='text-align: right'>". number_format(((($consoTemp*$coutHC/1000)+(($value0['max'] - $value0['min'] - $consoTemp)*$coutHP)/1000)),0, ',', ' ')." &euro;&nbsp;</TD></TR>";
}
echo "</TABLE></CENTER></p>";
?>
