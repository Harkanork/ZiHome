<?
$fichier = fopen("./config/conf_zibase.php","w"); 
if (fwrite($fichier,"test")) { 
	echo "les droits sur le dossier son ok";
$erreur=false;
} else { 
	echo "Impossible de creer le fichier. merci d'ajouter les droits en ecriture sur le dossier config"; 
	$erreur = true;
} 
fclose($fichier);
unlink("./config/conf_zibase.php");
if(!($erreur == true)) {
	if(isset($_POST['valider'])){
		$message = "";
		if(empty($_POST['hote'])) { $message .= "<br> Merci de preciser un hote Mysql"; }
		if(empty($_POST['base'])) { $message .= "<br> Merci de preciser une base Mysql"; }
		if(empty($_POST['login'])) { $message .= "<br> Merci de preciser un login Mysql"; }
		if(empty($_POST['plogin'])) { $message .= "<br> Merci de preciser un mot de passe Mysql"; }
		if(empty($_POST['idzibase'])) { $message .= "<br> Merci de preciser votre ID ZiBase"; }
		if(empty($_POST['tokenzibase'])) { $message .= "<br> Merci de preciser votre token ZiBase"; }
		if(empty($_POST['ipzibase'])) { $message .= "<br> Merci de preciser l'adresse IP de votre ZiBase"; }
		if(empty($_POST['ipserver'])) { $message .= "<br> Merci de preciser l'adresse IP de votre serveur / nas"; }
		$link = mysql_connect($_POST['hote'],$_POST['login'],$_POST['plogin']);
		if (!$link) { $message .= "<br>Connexion au serveur mysql impossible"; }
		if(!($_POST['creer_base'] == '1')) {
			$db_selected = mysql_select_db($_POST['base'],$link);
			if (!$db_selected) { $message .= "<br>Connexion a la base mysql impossible"; }
		}
		if($message == "") {
			if($_POST['creer_base'] == '1') {
				$query = 'CREATE Database IF NOT EXISTS `'.$_POST['base'].'`';
				$req = mysql_query( $query, $link );
				if(!$req)
				{
					echo "<BR>erreur lors de la creation de la base";
				} else {
					echo "<BR>La base ".$_POST['base']." a ete cree avec succes";
					$db_selected = mysql_select_db($_POST['base'],$link);
					$sql = file_get_contents("./sql/zibase.sql");
					$sql_array = mb_split(";[\s$]",$sql);
					foreach ($sql_array as $val) {
						mysql_query($val,$link);
					}
				}
			}
		$query = "UPDATE  `paramettres` SET  `value` =  '".$_POST['meteo_ville']."' WHERE  `libelle` = 'meteo ville'";
		$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		$query = "UPDATE  `paramettres` SET  `value` =  '".$_POST['meteo_temperature']."' WHERE  `libelle` = 'meteo sonde temperature'";
		$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		$query = "UPDATE  `paramettres` SET  `value` =  '".$_POST['meteo_vent']."' WHERE  `libelle` = 'meteo sonde vent'";
		$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		$query = "UPDATE  `paramettres` SET  `value` =  '".$_POST['ville']."' WHERE  `libelle` = 'pollution ville'";
		$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		$query = "UPDATE  `paramettres` SET  `value` =  '".$_POST['idzibase']."' WHERE  `libelle` = 'idzibase'";
		$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		$query = "UPDATE  `paramettres` SET  `value` =  '".$_POST['tokenzibase']."' WHERE  `libelle` = 'tokenzibase'";
		$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		$query = "UPDATE  `paramettres` SET  `value` =  '".$_POST['ipzibase']."' WHERE  `libelle` = 'ipzibase'";
		$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		$query = "UPDATE  `paramettres` SET  `value` =  '".$_POST['ipserver']."' WHERE  `libelle` = 'ipserver'";
		$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		$query = "UPDATE  `paramettres` SET  `value` =  '".$_POST['coutfixe']."' WHERE  `libelle` = 'cout fixe'";
		$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		$query = "UPDATE  `paramettres` SET  `value` =  '".$_POST['HP']."' WHERE  `libelle` = 'cout heure pleine'";
		$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		$query = "UPDATE  `paramettres` SET  `value` =  '".$_POST['HC']."' WHERE  `libelle` = 'cout heure creuse'";
		$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		$query = "UPDATE  `paramettres` SET  `value` =  '".$_POST['heurescreusesdebut1']."' WHERE  `libelle` = 'heure creuse 0 debut'";
		$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		$query = "UPDATE  `paramettres` SET  `value` =  '".$_POST['heurescreusesfin1']."' WHERE  `libelle` = 'heure creuse 0 fin'";
		$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		$query = "UPDATE  `paramettres` SET  `value` =  '".$_POST['heurescreusesdebut2']."' WHERE  `libelle` = 'heure creuse 1 debut'";
		$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		$query = "UPDATE  `paramettres` SET  `value` =  '".$_POST['heurescreusesfin2']."' WHERE  `libelle` = 'heure creuse 1 fin'";
		$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		$query = "UPDATE  `paramettres` SET  `value` =  '".$_POST['heurescreusesdebut3']."' WHERE  `libelle` = 'heure creuse 2 debut'";
		$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		$query = "UPDATE  `paramettres` SET  `value` =  '".$_POST['heurescreusesfin3']."' WHERE  `libelle` = 'heure creuse 2 fin'";
		$req = mysql_query($query, $link) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		$file = "<?php\n/*--------------------Paramettres Mysql--------------------------------*/\n\n\$login = '".$_POST['login']."';\n\$plogin = '".$_POST['plogin']."';\n\$hote = '".$_POST['hote']."';\n\$base = '".$_POST['base']."';\n\n/*--------------------fin des paramettres de configuration--------------*/\n?>";
		$fichier = fopen("./config/conf_zibase.php","w"); if (fwrite($fichier,$file)) { echo "
		<br>Fichier de configuration correctement cree"; } else { echo "Impossible de creer le fichier. merci d'ajouter les droits en ecriture sur le dossier config"; } fclose($fichier); } else { echo $message; ?> 
		<P align=center>
			<FORM method="post" action="./index.php">
				<BR>Serveur Mysql : 
				<INPUT type=text name=hote value="<? echo $_POST['hote']; ?>">
				</INPUT>
				<BR>Base Mysql : 
				<INPUT type=text name=base value="<? echo $_POST['base']; ?>">
				</INPUT>
				<BR>Creer la base Mysql : 
				<INPUT type=checkbox name=creer_base value=1 <? if($_POST['creer_base'] == '1') { echo " checked"; } ?>>
				</INPUT>
				<BR>Login Mysql : 
				<INPUT type=text name=login value="<? echo $_POST['login']; ?>">
				</INPUT>
				<BR>Mot de passe Mysql : 
				<INPUT type=text name=plogin value="<? echo $_POST['plogin']; ?>">
				</INPUT>
				<BR>
				<BR>
				<BR>Electricite Cout fixe : 
				<INPUT type=text name=coutfixe value="<? echo $_POST['coutfixe']; ?>">
				</INPUT>
				<BR>Electricite Cout Heure Pleine : 
				<INPUT type=text name=HP value="<? echo $_POST['HP']; ?>">
				</INPUT>
				<BR>Electricite Cout Heure Creuse : 
				<INPUT type=text name=HC value="<? echo $_POST['HC']; ?>">
				</INPUT>
				<BR>Electricite plage Heure Creuse 1 debut : 
				<INPUT type=time name=heurescreusesdebut1 value="<? echo $_POST['heurescreusesdebut1']; ?>">
				</INPUT>
				<BR>Electricite plage Heure Creuse 1 fin : 
				<INPUT type=time name=heurescreusesfin1 value="<? echo $_POST['heurescreusesfin1']; ?>">
				</INPUT>
				<BR>Electricite plage Heure Creuse 2 debut : 
				<INPUT type=time name=heurescreusesdebut2 value="<? echo $_POST['heurescreusesdebut2']; ?>">
				</INPUT>
				<BR>Electricite plage Heure Creuse 2 fin : 
				<INPUT type=time name=heurescreusesfin2 value="<? echo $_POST['heurescreusesfin2']; ?>">
				</INPUT>
				<BR>Electricite plage Heure Creuse 3 debut : 
				<INPUT type=time name=heurescreusesdebut3 value="<? echo $_POST['heurescreusesdebut3']; ?>">
				</INPUT>
				<BR>Electricite plage Heure Creuse 3 fin : 
				<INPUT type=time name=heurescreusesfin3 value="<? echo $_POST['heurescreusesfin3']; ?>">
				</INPUT>
				<BR>
				<BR>
				<BR>Meteo Ville :
				<INPUT type=text name=meteo_ville value="<? echo $_POST['meteo_ville']; ?>">
				</INPUT>
				<BR>Meteo sonde temperature :
				<INPUT type=text name=meteo_temperature value="<? echo $_POST['meteo_temperature']; ?>">
				</INPUT>
				<BR>Meteo sonde vent :
				<INPUT type=text name=meteo_vent value="<? echo $_POST['meteo_vent']; ?>">
				</INPUT>
				<BR>
				<BR>
				<BR>ID ZiBase : 
				<INPUT type=text name=idzibase value="<? echo $_POST['idzibase']; ?>">
				</INPUT>
				<BR>Token Zibase : 
				<INPUT type=text name=tokenzibase value="<? echo $_POST['tokenzibase']; ?>">
				</INPUT>
				<BR>Adresse IP ZiBase : 
				<INPUT type=text name=ipzibase value="<? echo $_POST['ipzibase']; ?>">
				</INPUT>
				<BR>Adresse IP Serveur : 
				<INPUT type=text name=ipserver value="<? echo $_POST['ipserver']; ?>">
				</INPUT>
				<BR>
				<BR>
                                <BR>Ville :
                                <INPUT type=text name=ville value="<? echo $_POST['ville']; ?>">
                                </INPUT>
				<BR>
				<BR>
				<INPUT type=submit name=valider value=Valider>
				</INPUT>
			</FORM>
		</P>
		<?
		}
	} else {
	?>
	<P align=center>
		<FORM method="post" action="./index.php">
			<BR>Serveur Mysql : 
			<INPUT type=text name=hote>
			</INPUT>
			<BR>Base Mysql : 
			<INPUT type=text name=base>
			</INPUT>
			<BR>Creer la base Mysql : 
			<INPUT type=checkbox name=creer_base value=1>
			</INPUT>  
			<BR>Login Mysql : 
			<INPUT type=text name=login>
			</INPUT>
			<BR>Mot de passe Mysql : 
			<INPUT type=text name=plogin>
			</INPUT>
			<BR>
			<BR>
			<BR>Electricite Cout fixe : 
			<INPUT type=text name=coutfixe>
			</INPUT>
			<BR>Electricite Cout Heure Pleine : 
			<INPUT type=text name=HP>
			</INPUT>
			<BR>Electricite Cout Heure Creuse : 
			<INPUT type=text name=HC>
			</INPUT>
			<BR>Electricite plage Heure Creuse 1 debut : 
			<INPUT type=time name=heurescreusesdebut1 value="00:00">
			</INPUT>
			<BR>Electricite plage Heure Creuse 1 fin : 
			<INPUT type=time name=heurescreusesfin1 value="00:00">
			</INPUT>
			<BR>Electricite plage Heure Creuse 2 debut : 
			<INPUT type=time name=heurescreusesdebut2 value="00:00">
			</INPUT>
			<BR>Electricite plage Heure Creuse 2 fin : 
			<INPUT type=time name=heurescreusesfin2 value="00:00">
			</INPUT>
			<BR>Electricite plage Heure Creuse 3 debut : 
			<INPUT type=time name=heurescreusesdebut3 value="00:00">
			</INPUT>
			<BR>Electricite plage Heure Creuse 3 fin : 
			<INPUT type=time name=heurescreusesfin3 value="00:00">
			</INPUT>
			<BR>
			<BR>
			<BR>Meteo Ville :
			<INPUT type=text name=meteo_ville>
			</INPUT>
			<BR>Meteo sonde temperature :
			<INPUT type=text name=meteo_temperature>
			</INPUT>
			<BR>Meteo sonde vent :
			<INPUT type=text name=meteo_vent>
			</INPUT>
			<BR>
			<BR>
			<BR>ID ZiBase : 
			<INPUT type=text name=idzibase>
			</INPUT>
			<BR>Token Zibase : 
			<INPUT type=text name=tokenzibase>
			</INPUT>
			<BR>Adresse IP ZiBase : 
			<INPUT type=text name=ipzibase>
			</INPUT>
			<BR>Adresse IP Serveur : 
			<INPUT type=text name=ipserver>
			</INPUT>
			<BR>
			<BR>
                        <BR>Ville :
                        <INPUT type=text name=ville>
                        </INPUT>
			<BR>
			<BR>
			<INPUT type=submit name=valider value=Valider>
			</INPUT>
		</FORM>
	</P>
	<?
	}
}
?>
