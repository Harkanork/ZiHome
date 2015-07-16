#Localisation GPS android / Google now avec ZiHome

# Localisation GPS android / Google now avec ZiHome #

Attention, la géolocalisation Android utilise le service de Google now. Ce service permet d’activer un maximum de 100 requêtes par jour gratuites. Si vous désirez générer plus de 100 requêtes par jours, ce service est payant. Un abonnement Business permet de réaliser un nombre de requêtes plus important. Attention donc aux attributs sleep\_base et sleep\_coef.

Pour activer la géolocalisation Android, vous devez :
  * Avoir la dernière version de l’application installée.
  * Avoir réalisé les mises à jour de la base de donné.
  * activer les options de paiement sur votre compte google :
    * cliquez sur le menu Billing  a cette adresse : http://code.google.com/apis/console/?noredirect
    * Click the Google Wallet button in the Enable billing section. If prompted, sign in to your Google Account. A Google Checkout invoice is displayed.
    * Click Complete your purchase - $0.00. You are returned to the Billing page of the API Console. It may take a few minutes for your changes to take effect. Once your billing information has been accepted, the console will confirm: Billing is enabled for all active, billable services.
  * Activer la géolocalisation sur votre compte google :
    * Cliquer sur le menu service sur la gauche
    * Dans la liste des services, trouver l’API de géolocalisation Google Maps et cliquer sur le bouton on/off pour l’activer.
  * Obtenir votre clef API :
    * Cliquer sur le lien d’accès aux API : https://code.google.com/apis/console#access?noredirect
    * Cliquer sur créer une clef de navigateur ou créer une clef  de serveur puis suivez les instructions
    * Votre clef API est générée et listée dans la section d’accès API simple
  * Installez l’application Network info II : https://market.android.com/details?id=aws.apps.networkInfoIi&feature=search_result#?t=W251bGwsMSwyLDEsImF3cy5hcHBzLm5ldHdvcmtJbmZvSWkiXQ..
  * Vous obtiendrez toutes les informations pour notre interface :
    * APIkey : clef API google générée plus haut
    * MobileNetworkCode : ce qui apparait après le 208 (MNC) ‘10’
    * Carrier : libellé de l’opérateur ‘F SRF’
    * cellId : attribut CID
    * locationAreaCode : attribut LAC
    * Sleep Base : temp d’attente entre chaque requetes = (distance relevée en m minimum / sleep coef) + sleep base
    * Sleep Coef : temp d’attente entre chaque requetes = (distance relevée en m minimum / sleep coef) + sleep base


<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/android-1.png' /> <br>

Un script va ensuite calculer la distance qui sépare votre téléphone avec les coordonnées choisies et l’envoyer a la zibase dans une sonde virtuelle.<br>
Pour cela, vous devrez créer un périphérique comme suivant :<br>
<br>
<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/android-2.png' /> <br>

Vous pouvez ensuite utiliser les valeurs avec les scénarios suivants :<br>
<br>
<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/android-3.png' /> <br>
<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/android-4.png' /> <br>
<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/android-5.png' /> <br>

Vous pouvez bien entendu remplacer l’action de notification push par n’importe quel action de votre choix.<br>
<br>
Par exemple, ouvrir votre portail et votre porte de garrage en arrivant chez vous. Activer l’alarme en quitant votre maison et la désactive en arrivant. Etc…