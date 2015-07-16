#Localisation GPS iPhone et Zibase

# Localisation GPS iPhone et Zibase #

<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/iphone-1.png' /> <br>

Vous pouvez ici préciser le nom de votre périphérique Icloud,  ainsi que les identifiants de connexion a ce service.<br>
Une fois ajoutés, cliqué sur le bouton « coordonnées ». vous pouvez ici choisir les coordonnées GPS de votre maison, de votre travail ou autre.<br>
<br>
<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/iphone-2.png' /> <br>

Un script va ensuite calculer la distance qui sépare votre téléphone avec les coordonnées choisies et l’envoyer a la zibase dans une sonde virtuelle.<br>
<br>
Le temp d’attente entre chaque requetes = (distance relevée en m minimum / sleep coef) + sleep base<br>
<br>
Pour cela, vous devrez créer un périphérique comme suivant :<br>
<br>
<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/iphone-3.png' /> <br>

Vous pouvez ensuite utiliser les valeurs avec les scénarios suivants :<br>
<br>
<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/iphone-4.png' /> <br>
<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/iphone-5.png' /> <br>
<br> <img src='http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/iphone-6.png' /> <br>

Vous pouvez bien entendu remplacer l’action de notification push par n’importe quel action de votre choix.<br>
<br>
Par exemple, ouvrir votre portail et votre porte de garrage en arrivant chez vous. Activer l’alarme en quitant votre maison et la désactive en arrivant. Etc…<br>
