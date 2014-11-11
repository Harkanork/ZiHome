<title>V&eacute;rification et correction des donn&eacute;es de consommation &eacute;lectrique</title>
<div id="action-tableau">
<CENTER>
<br>
<table width="800px" border=0>
  <tr class="title" bgcolor="#6a6a6a">
    <TH>Date</TH>
    <TH>Puissance</TH>
    <TH>Conso</TH>
    <TH width="200px">Action</TH>
  </tr>

<?php

// on d&eacute;sactive la limite de chargement
set_time_limit(0);

// on r&eacute;cup&egrave;re l'url de cette page pour la destination des formulaires
$urlGet = explode("?",dirname($_SERVER['SERVER_PROTOCOL']) . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
$urlSansLeGet = $urlGet[0]; // URL sans les diverses variables get
$urlform = $urlSansLeGet."?page=administration&detail=verif_conso"; // on remet juste les variables page et detail qui permettent de faire appel &agrave; cette page

$message="V&eacute;rification des donn&eacute;es effectu&eacute;e";
if (isset($_GET['action'])) {//on v&eacute;rifie si on vient d'envoyer une action de correction, si oui on fait l'action

	if ($_GET['action']=="precdim") {// on a cliqu&eacute; sur corriger les pr&eacute;c&eacute;dents &agrave; la baisse : l'outil retranche manuellement la valeur maximale &agrave; partir de laquelle il est reparti de z&eacute;ro
		$date=$_GET['date'];
		$valdim=$_GET['valdim'];
		$periph=$_GET['periph'];
		$querydate="SELECT * FROM `".$periph."` WHERE date < '".$date."' ORDER BY `date` ASC";
		$reqdate = mysql_query($querydate, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		while($valuedate = mysql_fetch_assoc($reqdate)) {
			$valuedatenew=$valuedate['conso_total']-$valdim;
			$querymaj="UPDATE `".$periph."` SET `conso_total`= '".$valuedatenew."' WHERE date = '".$valuedate['date']."'" ;
			$reqmaj = mysql_query($querymaj, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		}
		$message="Correction &agrave; la baisse effectu&eacute;e avec succ&egrave;s pour ".$periph;
	}
	if ($_GET['action']=="precadd") {// on a cliqu&eacute; sur corriger les pr&eacute;c&eacute;dents &agrave; la hausse : l'outil ajoute manuellement la valeur maximale &agrave; partir de laquelle il est reparti de z&eacute;ro
		$date=$_GET['date'];
		$valadd=$_GET['valadd'];
		$periph=$_GET['periph'];
		$queryadd="SELECT * FROM `".$periph."` WHERE date < '".$date."' ORDER BY `date` ASC";
		$reqadd = mysql_query($queryadd, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		while($valueadd = mysql_fetch_assoc($reqadd)) {
			$valueaddnew=$valueadd['conso_total']+$valadd;
			$querymajadd="UPDATE `".$periph."` SET `conso_total`= '".$valueaddnew."' WHERE date = '".$valueadd['date']."'" ;
			$reqmajadd = mysql_query($querymajadd, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		}
		$message="Correction &agrave; la hausse effectu&eacute;e avec succ&egrave;s pour ".$periph;
	}
	if ($_GET['action']=="suppr") {
		$date=$_GET['date'];
		$periph=$_GET['periph'];
		$querysuppr="DELETE FROM `".$periph."` WHERE date = '".$date."'";
		$reqsuppr = mysql_query($querysuppr, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		$message="Valeur ".$date." supprim&eacute;e pour ".$periph;
	}
	if ($_GET['action']=="simplif") {  // on a cliqu&eacute; sur simplifier l'historique du capteur
		$periph=$_GET['periph'];
		$querysimplif="SELECT * FROM `".$periph."` WHERE date < DATE_SUB(NOW(), INTERVAL 31 DAY) ORDER BY `date` ASC";
		$reqsimplif = mysql_query($querysimplif, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		$jour_prec1=0;
		$jour_prec2=0;
		$HC_prec1=0;
		$HC_prec2=0;
		$date_prec1="";
		while ($datasimplif = mysql_fetch_assoc($reqsimplif)) {
			$jour=substr($datasimplif['date'],0,10);
			if ($jour<>$jour_prec1) { // chaque jour on remet &agrave; z&eacute;ro les conso min et max
				$conso_min=10000;
				$conso_max=0;
				$date_min="";
				$date_max="";
			}
			$HC=0;
			foreach($heuresCreuses as $heureCreuse){
			      if ($heureCreuse['debut'] != "00:00:00" || $heureCreuse['fin'] != "00:00:00") {
			      		if (substr($datasimplif['date'],11) >= $heureCreuse['debut']  AND substr($datasimplif['date'],11) <= $heureCreuse['fin']) {
			      			$HC=1;
			      		}
			      }
   			}
			if ($jour==$jour_prec1 AND $jour_prec1==$jour_prec2 AND $HC==$HC_prec1 AND $HC_prec1==$HC_prec2) {
				// si trois &eacute;gaux &agrave; la suite, on supprime celui du milieu, ce qui permet de tout supprimer sauf la premi&egrave;re et la derni&egrave;re valeur de chaque jour et de chaque plage HC/HP
				// mais on supprime seulement si ce n'est ni le max journalier, ni le min journalier
				if ($datasimplif['conso']<=$conso_max AND $datasimplif['conso']>=$conso_min) {
					$querysimplifsuppr="DELETE FROM `".$periph."` WHERE date = '".$date_prec1."'";
					$reqsimplifsuppr = mysql_query($querysimplifsuppr, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
				} elseif ($datasimplif['conso']>$conso_max) {
					$querysimplifsuppr="DELETE FROM `".$periph."` WHERE date = '".$date_max."'";
					$reqsimplifsuppr = mysql_query($querysimplifsuppr, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
					$conso_max=$datasimplif['conso'];
					$date_max=$datasimplif['date'];
				} elseif ($datasimplif['conso']<$conso_min) {
					$querysimplifsuppr="DELETE FROM `".$periph."` WHERE date = '".$date_min."'";
					$reqsimplifsuppr = mysql_query($querysimplifsuppr, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
					$conso_min=$datasimplif['conso'];
					$date_min=$datasimplif['date'];
				}
			}
			$jour_prec2=$jour_prec1;
			$jour_prec1=$jour;
			$HC_prec2=$HC_prec1;
			$HC_prec1=$HC;
			$date_prec1=$datasimplif['date'];
		}
		$message="Simplification des donn&eacute;es effectu&eacute;e avec succ&egrave;s pour ".$periph." .";
	}
}

// On affiche le message
echo "<p style='color:red'><b>".$message."</b></p>";


// on v&eacute;rifie les tableaux et affiche les erreurs
$inf_neg=-999999999999999999999999999999999; // pour les prochains tests
$query = "SELECT * FROM peripheriques WHERE periph = 'conso' ORDER BY ordre";
$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while ($data = mysql_fetch_assoc($req))
{
	if($data['libelle'] == ""){
		$nom = $data['nom'];
	} else {
		$nom = $data['libelle'];
	}
	echo "<tr class=\"contenu\"><td colspan=3><strong>".$nom."</strong></td><td><a href=\"".$urlform."&action=simplif&periph=conso_".$data['nom']."\" style=\"color:black;text-decoration: underline;\">Simplifier l'historique de ce capteur</a><br/>(au del&agrave; de 30 jours, ne conserve que les extr&ecirc;mes journaliers et consos HP/HC)</td></tr>";
	$erreurs=0;
	$conso_prec2=0;
	$date_prec2=0;
	$conso_prec1=$inf_neg; 
	$date_prec1=0;
	$puis_prec1=0;
	$puis_prec2=0;
	$rang=0;
	$query0 = "SELECT * FROM `conso_".$data['nom']."` WHERE date > DATE_SUB(NOW(), INTERVAL 300 DAY) ORDER BY `date` ASC";
	$req0 = mysql_query($query0, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
	while($value0 = mysql_fetch_assoc($req0))
	{
		if ($rang>0) {
			echo "<tr class=\"contenu\"><td>".$value0['date']."</td><td>".$value0['conso']."</td><td>".$value0['conso_total']."</td></tr>";
			$rang=$rang-1;
		}
		if ($value0['conso_total']<$conso_prec1) {
			$erreurs++;
			$valeur_supposee=0;
			if ($value0['conso_total']<0) {$valeur_supposee=$value0['conso_total'];}
			$valdim=$conso_prec1-$valeur_supposee;
			$rang=2;
			echo "<tr class=\"contenu\"><td>".$date_prec2."</td><td>".$puis_prec2."</td><td>".$conso_prec2."</td></tr>";
			echo "<tr class=\"contenu\"><td>".$date_prec1."</td><td>".$puis_prec1."</td><td>".$conso_prec1."</td></tr>";
			echo "<tr class=\"contenu\"><td>".$value0['date']."</td><td>".$value0['conso']."</td><td><strong>".$value0['conso_total']."</strong></td><td>";
			echo "Remise &agrave; z&eacute;ro du capteur ? ";
			echo " -".strtotime(substr($value0['date'],11))."- ";
			echo "<a href=\"".$urlform."&action=precdim&periph=conso_".$data['nom']."&date=".$value0['date']."&valdim=".$valdim."\">Corriger les pr&eacute;c&eacute;dents &agrave; la baisse (-".$valdim.")</a><br/>";
			echo "<a href=\"".$urlform."&action=suppr&periph=conso_".$data['nom']."&date=".$value0['date']."\">Supprimer la valeur</a>";
			echo "</td></tr>";
		}
		if (($value0['conso_total']-$conso_prec1)/(strtotime($value0['date'])-strtotime($date_prec1))>30 AND $conso_prec1<>$inf_neg) {
			$erreurs++;
			$rang=2;
			echo "<tr class=\"contenu\"><td>".$date_prec2."</td><td>".$puis_prec2."</td><td>".$conso_prec2."</td></tr>";
			echo "<tr class=\"contenu\"><td>".$date_prec1."</td><td>".$puis_prec1."</td><td>".$conso_prec1."</td></tr>";
			echo "<tr class=\"contenu\"><td>".$value0['date']."</td><td>".$value0['conso']."</td><td><strong>".$value0['conso_total']."</strong></td><td>";
			$ecart=$value0['conso_total']-$conso_prec1;
			echo "Erreur de correction pr&eacute;c&eacute;dente ? ";
			echo "<a href=\"".$urlform."&action=precadd&periph=conso_".$data['nom']."&date=".$value0['date']."&valadd=".$ecart."\">Corriger les pr&eacute;c&eacute;dents &agrave; la hausse (+".$ecart.")</a><br/>";
			echo "<a href=\"".$urlform."&action=suppr&periph=conso_".$data['nom']."&date=".$value0['date']."\">Supprimer la valeur</a>";
			echo "</td></tr>";
		}
		$conso_prec2=$conso_prec1;
		$date_prec2=$date_prec1;
		$puis_prec2=$puis_prec1;
		$conso_prec1=$value0['conso_total'];
		$puis_prec1=$value0['conso'];
		$date_prec1=$value0['date'];
		if ((strtotime($value0['date'])-mktime(0, 0, 0, 1, 1, 2013))<0) {
			$erreurs++;
			echo "<tr class=\"contenu\"><td>".$value0['date']."</td><td>".$value0['conso']."</td><td><strong>".$value0['conso_total']."</strong></td><td>";
			echo "Erreur de date sur cette valeur. ";
			echo "<a href=\"".$urlform."&action=suppr&periph=conso_".$data['nom']."&date=".$value0['date']."\">Supprimer la valeur</a>";
			echo "</td></tr>";
		}
	}
	if ($erreurs==0) {
		echo "<tr class=\"contenu\"><td colspan=4>Aucune erreur trouv&eacute;e dans l'historique de ce capteur</td></tr>";
	}
}
?>
</table>