<?php
if((isset($_SESSION['auth'])) || ($_SERVER["REMOTE_ADDR"] == $ipzibase))
{

/*************************************************************************************
**                                                                                                
** Script de gestion de la Freebox Rélution - Boitier Server
**
** https://github.com/DjMomo/apifreebox/
**
*******
** Renseignez votre mot de passe de la page de configuration de votre Freebox
** (http://mafreebox.freebox.fr) dans le fichier mafreebox.cfg
*******
**************************************************************************************/

require('./lib/freebox.php');
include('./lib/taille_fichier.php');
include('./lib/timestamp.php');

$config_file = './config/mafreebox.php';
if(file_exists($config_file))
        require_once($config_file);
else
        die ("Fichier de configuration manquant !");

$char_interdit_xml = array("!","\"","#","$","%","&","'","(",")","*","+",",","/",";","<","=",">","?","@","[","\\","]","^","`","{","|","}","~");

// Description des méodes : http://37.59.126.61/marc/github/mafreebox/doc/api/
$methodes_lecture = array (
        // Nom de méode ,                 // Page sur mafreebox.freebox.fr correspondante
        "conn.status",                                 // Connexion Internet / Status
        "conn.wan_adblock_get",         // Connexion Internet / Configuration / Blocage de la publicité
        "conn.wan_ping_get",                // Connexion Internet / Configuration / Rénse au ping
        "conn.remote_access_get",        // Connexion Internet / Configuration / Accèdistant
        "conn.proxy_wol_get",                // Connexion Internet / Configuration / Proxy WOL
        "conn.logs",                                // Connexion Internet / Historique
        // Manque Connexion Internet / ADSL
        // Manque Connexion Internet / FFTH
        // Manque Connexion Internet / DNS Dynamique
        "lan.ip_address_get",                // Réau local / Identité Adresse IP
        // Manque Réau local / Identité Nom d'hote
        "fw.lfilter_config_get",        // Réau local / Contrôparental / Etat
        "fw.lfilters_get",                        // Réau local / Contrôparental / Filtres
        // Manque Manque Réau local / Freebox AirMedia
        "ipv6.config_get",                        // Réau local / IPv6
        // Manque Réau local / Mode réau
        "fw.wan_redirs_get",                // Réau local / Redirections de ports / Simples
    "fw.wan_range_redirs_get",        // Réau local / Redirections de ports / Plages
    "fw.dmz_get",                                // Réau local / Redirections de ports / DMZ
    "dhcp.status_get",                        // Réau Local / Serveur DHCP / Configuratiion (ét du DHCP)
    "dhcp.config_get",                        // Réau Local / Serveur DHCP / Configuration (configuration du DHCP)
        "dhcp.sleases_get",                        // Réau Local / Serveur DHCP / Baux Statiques
    "dhcp.leases_get",                        // Réau Local / Serveur DHCP / Baux Dynamiques
        // Manque Réau local / Switch * 5
    "igd.config_get",                        // Réau local / UPnP IGD
        "igd.redirs_get",                        // Réau local / UPnP IGD
        "wifi.status_get",                        // Wifi / Etat
    "wifi.config_get",                        // Wifi / Configuration + Wifi / Réau personnel sauf / Wifi / Réau personnel / Stations
    "wifi.stations_get",                // Wifi / Réau personnel / Stations
        "storage.list",                                // NAS / Péphéques
    "storage.disk_get",                        // NAS / Péphéques + donné internes Freebox
        "ftp.get_config",                        // NAS / FTP
        "share.get_config",                        // NAS / Partages Windows
        // Manque NAS / Partages Mac OS
        // Manque NAS / UPnP AV
        "phone.status",                                // Téphone / Etat
        //"phone.calls",                                // Téphone / Journal d'appels  ------------> A tester
        "lcd.brightness_get",                // Divers / Afficheur
        "system.uptime_get",                // Divers / Systeme
    "system.mac_address_get",        // Divers / Systeme
    "system.serial_get",                // Divers / Systeme
        "system.fw_release_get",        // Divers / Systeme
        "download.list",                        // Seedbox / Liste
    "download.config_get"                // Seedbox / Configuration
        );

$freebox = new FreeboxClient($config['url'], $config['user'], $config['password']);

if (isset($_GET['do']) && ($_GET['do'] != null))
        $do = $_GET['do'];
else if(isset($_POST['do']) && ($_POST['do'] != null))
	$do = $_POST['do'];
else
        parse_str($argv[1]);

if (isset($do))
{
        switch ($do)
        {
                case "lcd" :
                {
                        // Fixe la valeur de luminositéu lcd. 
                        // Valeur en %, de 0 à00.
                        $methode = "lcd.brightness_set";
                        if (isset($_GET['val']) && (is_numeric($_GET['val'])))
                                $params = $_GET['val'];
                        else
                                $params = 100;
                        break;
                }
                case "reboot" :
                {
                        // Reboote la Freebox Server
                        // Tempo en secondes (int) avant reboot optionnelle
                        $methode = "system.reboot";
                        if (isset($_GET['val']) && (is_numeric($_GET['val'])))
                                $params = $_GET['val'];
                        else
                                $params = 0;
                        break;
                }
                case "ring_on" :
                {
                        // Fait sonner le téphone relié la Freebox
                        $params = 1;
                        $methode = "phone.fxs_ring";
                        break;
                }
                case "ring_off" :
                {
                        // Arrê de faire sonner le téphone relié la Freebox
                        $params = 0;
                        $methode = "phone.fxs_ring";
                        break;
                }
                case "wifi_on" :
                {
                        // Active la carte Wifi
                        $new_params = array("enabled" => 1);
                        
                        $json = $freebox->interroger_api("wifi.config_get",true);
                        $old_params = $json["ap_params"];
                        // Il faut passer le paramèe enabled à pour activer le wifi
                        $params = array_replace($old_params,$new_params);
                        $methode = "wifi.ap_params_set";
                        break;
                }
                case "wifi_off" :
                {
                        // Déctive la carte Wifi
                        $cle = "enabled";
                        
                        $json = $freebox->interroger_api("wifi.config_get",true);
                        $params = $json["ap_params"];
                        // Il faut supprimer le paramèe enabled pour déctiver le wifi
                        unset($params[array_search($cle, $params)]);
                        $methode = "wifi.ap_params_set";
                        break;
                }
		case "conn_status" :
		{
			// recupere le satus de connexion de la freebox
			$methode = "conn.status";
			$params = "";
			break;
		}
		case "conn_config" :
		{
			// recupere les options de configuration de la connexion freebox
			$methode = "conn.config";
			$params = "";
			break;
		}
		case "uptime" :
		{
			// recupation de l'uptime de la freebox
			$methode = "system.uptime_get";
			$params = "";
			break;
		}
		case "firmware" :
		{
			// recuperation de la version du firmware
			$methode = "system.fw_release_get";
			$params = "";
			break;
		}
		case "wifi_status" :
		{
			// recuperation du status du wifi
			$methode = "wifi.status_get";
			$params = "";
			break;
		}
                default:$methode="none";
        }
        if ($methode != "none")
        {
                $json = $freebox->interroger_api($methode,$params);
		switch ($do)
		{
			case "conn_status" :
			{
				echo "<table><tr><td>Parametre</td><td>Valeur</td></tr>";
				echo "<tr><td>adresse IP</td><td>".$json['ip_address']."</td></tr>";
				echo "<tr><td>Connexion type</td><td>".$json['media']."</td></tr>";
				echo "<tr><td>Connexion UP</td><td>".fch_tlb($json['bandwidth_up'])."</td></tr>";
				echo "<tr><td>Connexion DOWN</td><td>".fch_tlb($json['bandwidth_down'])."</td></tr>";
                                echo "<tr><td>Utilise UP</td><td>".fch_tlb($json['rate_up'])."</td></tr>";
                                echo "<tr><td>Utilise DOWN</td><td>".fch_tlb($json['rate_down'])."</td></tr>";
				echo "<tr><td>Total UP</td><td>".fch_tlo($json['bytes_up'])."</td></tr>";
				echo "<tr><td>Total DOWN</td><td>".fch_tlo($json['bytes_down'])."</td></tr>";				
				echo "</table>";
				break;
			}
			case "uptime" :
			{
				echo "Uptime : ".convertire_seconde($json);
				break;
			}
			case "firmware" :
			{
				echo "Version firmware : ".$json;
				break;
			}
			case "wifi_status" :
			{
				echo "<table><tr><td>nom</td><td>actif</td></tr>";
				echo "<tr><td>Carte WIFI</td><td>".$json['active']."</td></tr>";
				echo "<tr><td>".$json['bss']['perso']['name']."</td><td>".$json['bss']['perso']['active']."</td></tr>";
				echo "<tr><td>".$json['bss']['freewifi']['name']."</td><td>".$json['bss']['freewifi']['active']."</td></tr>";
				echo "</table>";
				break;
			}
	                default:var_dump($json);
		}
        }
}
else
{
        // Créion fichier XML avec les donné
        // Instance de la class DomDocument
        $doc = new DOMDocument();

        // Definition de la version et de l'encodage
        $doc->version = '1.0';
        $doc->encoding = 'UTF-8';
        $doc->formatOutput = true;

        // Ajout d'un commentaire a la racine
        $comment_elt = $doc->createComment(utf8_encode('Donné de la Freebox Rélution - Boitier Server'));
        $doc->appendChild($comment_elt);

        $racine = $doc->createElement('mafreebox');

        // Ajout la balise 'update' a la racine
        $version_elt = $doc->createElement('update',date("Y-m-d H:i"));
        $racine->appendChild($version_elt);

        foreach ($methodes_lecture as $methode)
        {
                $json = $freebox->interroger_api($methode,true);
                                
                $methode_element = $doc->createElement(str_replace($char_interdit_xml,"-",$methode));
                $racine->appendChild($methode_element);
                ARRAYtoXML($doc, $methode_element, $methode, $json);                
        }

        $doc->appendChild($racine);
        echo $doc->saveXML();
}
}
?>
