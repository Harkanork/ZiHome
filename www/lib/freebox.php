<?php
/**
  * Classe de connexion au Freebox Server
  * Basésur https://gist.github.com/dandelionmood/2579869
  * 
*/
class FreeboxClient
{
  private $url_serveur;
  private $identifiant;
  private $mot_de_passe;
  
  private $cookie;
  
  /**
    * Constructeur classique
    * @param string URL de votre freebox
    * @param string Identifiant de connexion (saisir «freebox» par déut)
    * @param string Votre mot de passe
  */
  public function __construct( $url_serveur, $identifiant, $mot_de_passe )
  {
    // On assigne les paramètres aux variables d'instance.
    $this->uri = $url_serveur;
    $this->identifiant = $identifiant;
    $this->mot_de_passe = $mot_de_passe;
    
    // Connexion automatique puis répétion du cookie.
    $this->cookie = $this->recuperer_cookie();
  }
  
  /**
    * Interroger l'API de la Freebox.
    * @param string le nom de la méode àppeler (ex. conn.status)
    * @param array paramèes àasser
    * @return mixed le retour de la méode appelé
  */
  public function interroger_api( $methode, $parametres = array() )
  {
    // On dérmine la page àppeler en fonction du nom de la méode.
    $page_a_appeler = explode('.', $methode);
    $page_a_appeler = "{$page_a_appeler[0]}.cgi";
    
        // On force le user agent par quelque chose qui fonctionne
        ini_set('user_agent', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:21.0) Gecko/20100101 Firefox/21.0');
        
    // Initialisation de la connexion avec CURL.
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $this->uri.'/'.$page_a_appeler);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    
    // On passe le cookie àa requê, c'est important.
    curl_setopt($ch, CURLOPT_COOKIE, 'FBXSID='.$this->cookie);
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json'
    ));
    
    // On respecte le formalisme JSON/RPC
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
      'jsonrpc' => '2.0',
      'method' => $methode,
      'params' => $parametres
    )));
    
    $retour_curl = curl_exec($ch);
    curl_close($ch);
    
    // On essaye de déder le retour JSON.
    $retour_json = json_decode( $retour_curl, true );
    
    // Gestion minimale des erreurs.
    if( $retour_json === false )
      throw new Exception("Erreur dans le retour JSON !");
    if( isset($retour_json['error']) ) 
      throw new Exception( json_encode($retour_json) );
    
    // Ce qui nous intésse est dans l'index «result»
    return $retour_json['result'];
  }
  
  /**
    * Répétion du cookie de session.
    * @return l'identifiant de la session.
  */
  private function recuperer_cookie( )
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->uri.'/login.php');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        // On doit lire le header pour répér le cookie, il va donc nous
    // falloir le retourner.
    curl_setopt($ch, CURLOPT_HEADER, 1);
    
    // On se connecte via ces deux paramèes.
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, array(
      'login' => $this->identifiant,
      'passwd' => $this->mot_de_passe
    ));
    
    $r = curl_exec($ch);
    curl_close($ch);
        
        // Répétion du cookie dans les entês à'aide d'une expression 
    // réliè.
    $ptn = '/FBXSID=\"([^"]*)/';
    preg_match($ptn, $r, $matches);
    
    // En cas de problè, on jette une exception.
    if( count($matches) != 2 )
      throw new Exception("Pas de cookie retourné");
    
    // On retourne l'identifiant de la session.
    return $matches[1];
  }
}

function ARRAYtoXML($doc, $noeud_parent, $noeud, $array, $depth = 0){
    $indent = '';
    $return = '';
    for($i = 0; $i < $depth; $i++)
        $indent .= "\t";
        if (is_array($array))
        {
    foreach($array as $key => $item){
        if (is_numeric($key))
                        $key = "key-".$key;
                $return .= "{$indent}< {$key}>\n";
      
                if(is_array($item))
        {
                        $element = $doc->createElement($key);
                        $return .= ARRAYtoXML($doc, $noeud_parent, $noeud, $item, $depth + 1);
                        $noeud_parent->appendChild($element);
                }
                else
        {
                        if ($item === true) $item = 1;
                        if ($item === false) $item = 0;
                        $return .= "{$indent}\t< ![CDATA[{$item}]]>\n";
                        $element = $doc->createElement($key,utf8_encode($item));        
                        $noeud_parent->appendChild($element);
                }        
                $return .= "{$indent}\n";
        }
        }
        else
        {
                $element = $doc->createElement($noeud,utf8_encode($array));        
                $noeud_parent->appendChild($element);
    }
        return $return;
}
?>
