Réglage rapide de l’application
Lors de la première installation, il faut régler l’interface ZiHome, je vais vous indiquer ce qu’il faut paramétrer pour bien commencer.
  * Changer le nom et/ou mot de passe du compte admin    (dans l’onglet Utilisateur)
  * Affecter les protocoles  (dans l’onglet protocoles)  désactiver les protocoles non utilises
  * Gérer les modules  (dans l’onglet modules) désactiver les modules non utilises
  * Gérer les pièces
Maintenant vous pouvez commencer à affecter capteurs, actionneurs etc …

**Dans cette notice, tous les noms des actionneurs, précipitation etc …  sont des exemples !
À vous de l’adapter à votre convenance bien sûr.**

Une fois sur l’interface web, on se retrouve avec ce menu.
Connecter vous a l’interface.
**Les images du menu haut ci-dessous peuvent changer suivant les modules activés ou non.**
> Nom utilisateur : **Admin**     Mot de pass : **secret**    (par défaut)
<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/bandeau.jpg' /> <br>
On accède à ce menu, avec une icône Administration pour administrer le site. Trois autres icones apparaissent aussi, Thermostat et calendrier et camera, <b>Pour une question de sécurité elles ne sont accessible uniquement une fois connecter.</b>
<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/bandeau_a.jpg' /> <br>
Cliquer sur l’icône administration, vous aurez un menu à gauche comme ci-dessous, nous allons le détailler.<br>
<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/administration.jpg' /> <br>
<h2>Gérer les pièces</h2>
Ici on gère les pièces, passage obligatoire pour y affecter une sonde, ou un actionneur ou autres …<br>
<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/gerer_pieces.jpg' /> <br>
<h3>Pour ajouter une pièce :</h3>
Renseigner les cases  puis cliquer sur Ajouter      (Taille bordure si vous ne voulez pas de bordure ne rien inscrire dedans) et Option supplémentaire est optionnel)<br>
<h3>Exemple :</h3>
Dans mon exemple ci-dessous, je nomme ma première pièce « Rdc » après on indique les dimensions, on renseigne la Largeur « 800 », la Hauteur « 300 », on positionne la pièce sur le plan en indiquant la Position Droite « 0 » et la Position Bas « 0 »(Quand je positionne par exemple : Position Droite « 50 », et  Position Bas « 60 », cela auras pour effet de placer la pièce a « 50 » à partir de la gauche, et a « 60 »du haut.) Les pièces peuvent ce chevaucher.<br>
<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/exemple_pieces.jpg' /> <br>
Ci-dessous un exemple de la gestion des pièces d’une maison.<br>
<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/exemple_pieces_maison.jpg' /> <br>
<h2>Gérer les stickers</h2>
Maintenant, on peut afficher des images spécifiques sur le plan en fonction d'une condition.<br>
Les coordonnées sont globales au plan (les stickers peuvent donc être à cheval sur plusieurs pièces).</li></ul>

Pour le champ condition, il faut mettre une expression conditionnelle javascript en utilisant les fonctions suivantes :<br>
jour()<br>
nuit()<br>
temperature("nom capteur")<br>
hygrometrie("nom capteur")<br>
vitesseVent("nom capteur")<br>
directionVent("nom capteur")<br>
actionneur("nom capteur")<br>
luminosite("nom capteur")<br>
<br>
Attention, il faut bien mettre le nom des capteurs entre guillemets.<br>
<br>
<h3>Exemple :</h3>
Afficher le sticker s'il fait nuit et que l'interrupteur du salon est allumé :<br>
nuit() && actionneur("interrupteur salon")<br>
Afficher le sticker s'il fait jour et que l'interrupteur du salon est éteind :<br>
jour() && ! actionneur("interrupteur salon")<br>
Afficher le sticker si l'hygrometrie renvoyé par le capteur appelé SdB est > 80<br>
hygrometrie("SdB") > 80<br>
<br>
<h2>Idées d'utilisation :</h2>
<ul><li>Afficher une image spécifique si la lumière est allumée<br>
</li><li>Afficher une image spécifique si la cheminée est allumée (température de la salle à manger anormalement élevée)<br>
</li><li>Afficher une image spécifique s'il y a quelqu'un dans une pièce<br>
</li><li>Afficher une image spécifique si le taux d'hygrométrie est trop haut dans la cave<br>
</li><li>Afficher une image spécifique s'il fait chaud dehors<br>
</li><li>Afficher une image spécifique s'il fait froid dehors<br>
</li><li>Afficher une image spécifique si la température de la piscine est idéale<br>
</li><li>consoElec("Nom du capteur")<br>
<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/stickers.jpg' /> <br>
<h2>Page d’accueil</h2></li></ul>

<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/accueil.jpg' /> <br>

<h2>Cameras</h2>
En cours de développement …<br>
<br>
<br>
<br>
<br>
<br>
<br>
<h2>Iphone</h2>
<a href='ArticlesiPhone.md'>iPhone</a>

<h2>Android</h2>
<a href='ArticlesAndroid.md'>Android</a>
<h2>Gérer les sondes</h2>
Ici on gère les différentes sondes.<br>
<br>
<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/sondes.jpg' /> <br>

<h3>Pour gérer une sonde :</h3>
Sélectionner la pièce, renseigner le positionnement, sélectionner ou non les cases<b>, ajouter une date (si votre sonde a une pile), renseigner un libellé si vous voulez,  puis cliquer sur Valider<br></b>Les quatre cases  à sélectionner, « Icones »  « Texte » « Hygro » « Batterie » sont à activer suivant votre sonde, car par exemple dans la photo ci-dessus, pour les capteurs de luminosité et le pluviomètre ne gère pas l’hygrométrie.<br>
<br>
<h3>Exemple :</h3>
Dans mon exemple ci-dessous, pour gérer le pluviomètre  on clique sur « ne pas afficher », la liste des pièces apparais, sélectionner Jardin puis on la positionne à Droite « 50 » et Bas « 50 »par rapport à la pièces sélectionner, on sélectionne « Icone » pour avoir une icône dans la page plan sur la pièce Jardin, on sélectionne « Batterie » et on indique une date ou sélectionner un jour grâce au calendrier qui apparais. On clique sur valider.<br>
<br>
<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/exemple_sondes.jpg' /> <br>

<h2>Affecter un actionneur</h2>
Pour affecter un nouvel actionneur,<br>
<br>
<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/actionneur.jpg' /> <br>

<h2>Affecter un capteur</h2>
Pour affecter un capteur, il suffit<br>
<br>
<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/capteur.jpg' /> <br>

<h2>Affecter un scenario</h2>

<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/scenario.jpg' /> <br>

<h2>Gérer les utilisateurs</h2>
Pour modifier le mot de pass, cliquer sur Editer comme ci-dessous.<br>
<br>
<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/editer_users.jpg' /> <br>

Un nouveau bloc apparaitra, renseigner les informations et cliquer sur Valider.<br>
<br>
<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/pwd_users.jpg' /> <br>

<h2>Gérer les modules</h2>

<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/modules.jpg' /> <br>

<h2>Gérer les protocoles</h2>

<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/protocoles.jpg' /> <br>

<h2>Message Zibase</h2>

<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/message_zibase.jpg' /> <br>

<h2>Variables</h2>

<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/variables.jpg' /> <br>

<h2>Insertion de pages</h2>

<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/insertion_pages.jpg' /> <br>

<h2>Paramètre</h2>

<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/parametres.jpg' /> <br>

<h2>Depannage</h2>


<h2>Divers</h2>