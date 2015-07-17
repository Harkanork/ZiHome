<?

// fonction qui va analyser un fichier xml à partir d'une URL. Utilise uniquement Curl, mais prévoir d'autres méthodes au cas où
// prévoir éventuellement une fonction la plus universelle possible qui pourrait servir à d'autres choses que le versioning de ZiHome
function RemoteToXml($url)
{
  if( ini_get('allow_url_fopen') ) {  // essaie d'abord de récupérer directement le fichier si allow_url_fopen est activé
    $contenu = simplexml_load_file($url);
  }
  if (!isset($contenu)) { // si ça n'a pas marché, essaie avec curl
    if (extension_loaded('curl')) {
      $curl = curl_init();  // Initialise cURL.
      curl_setopt($curl, CURLOPT_URL, $url);  // Indique quel URL récupérer
      ob_start();  // Commence à récupérer les données
      curl_exec($curl);  // Exécute la requète.
      curl_close($curl);  // Ferme cURL.
      $content = ob_get_contents();  // Sauvegarde les données dans la variable $content
      ob_end_clean();  // Vide le buffer
      $contenu=simplexml_load_string($content); // convertit au format objet  xml 
    } else {  // sinon renvoie qu'il n'a pas réussi
      $contenu=false;
    }
  }
  return $contenu;  // renvoie l'objet
}

////////////////////////////
// Début du script pour le versioning
////////////////////////////

// traite les données xml si elles ont été récupérées, sinon "Non disponible"
$version_server="Non disponible";
$version_local="Non disponible";
$version_dev="Non disponible";

// récupère les données xml locales
$xmlLocal=simplexml_load_file("./config/version.xml");

$version_local = floatval($xmlLocal->version);
$version_dev = $xmlLocal->attributes()->dev;

// récupère les données xml sur le dépôt google ZiHome
if ($version_dev == "true")
{
  $xmlServer=RemoteToXml('https://raw.githubusercontent.com/Harkanork/ZiHome/dev/www/config/version.xml');
}
else
{
  $xmlServer=RemoteToXml('https://raw.githubusercontent.com/Harkanork/ZiHome/master/www/config/version.xml');
}

if (isset($xmlServer->version))
{
  $version_server = floatval($xmlServer->version);
}


?>