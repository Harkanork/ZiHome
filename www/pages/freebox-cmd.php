<?php
if((isset($_SESSION['auth'])) || ($_SERVER["REMOTE_ADDR"] == $ipzibase) || ($_SERVER["REMOTE_ADDR"] == $ipserveur))
{

if (isset($_GET['do']) && ($_GET['do'] != null))
        $do = $_GET['do'];
else if(isset($_POST['do']) && ($_POST['do'] != null))
        $do = $_POST['do'];
else if(!(isset($do)))
        parse_str($argv[1]);

	switch ($do)
	{
		case "lcd" :
		{
                        // Fixe la valeur de luminosité du lcd.
                        $configuration = new Configuration($freebox);
                        // Valeur en %, de 0 à 100.
                        if (isset($_GET['val']) && (is_numeric($_GET['val'])))
                                $brightness = $_GET['val'];
                        else
                                $brightness = 100;
                        $array_config = array('brightness' => $brightness);
                        $freebox->DisplayResult($configuration->UpdateLcdConfig($array_config),"lcd_brightness");
                        break;
		}
		case "reboot" :
		{
                        // Reboote la Freebox Server
                                                                                                                                                              
                        $system = new System($freebox);
                        $freebox->DisplayResult($system->Reboot(),"reboot");
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
                        $configuration = new Configuration($freebox);
                        $enabled = true;
                        $array_config = array("ap_params" => array( "enabled" => $enabled));
                        $freebox->DisplayResult($configuration->UpdateWifiConfig($array_config),"wifi");
			break;
		}
		case "wifi_off" :
		{
                        $configuration = new Configuration($freebox);
                        $enabled = false;
                        $array_config = array("ap_params" => array( "enabled" => $enabled));
                        $freebox->DisplayResult($configuration->UpdateWifiConfig($array_config),"wifi");
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
		case "dhcp_baux_dynamique" :
		{
				// récupérer la liste des baux dynamiques du dhcp
				$methode = "dhcp.leases_get";
				$params = "";
				break;
		}
	}
 }
?>
