# Actions sur la freebox a partir de la Zibase #
contexte : Ma femme désirait que le wifi de la freebox soit désactivé la nuit lorsqu'il n'est pas utile. j'ai donc décidé de le couper de 0h00 a 06h59 les nuit de semaine (du lundi au vendredi matin).

pour se faire, j'ai programmé les scénarios suivants :
![http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/freebox-zibase-1.png](http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/freebox-zibase-1.png)
![http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/freebox-zibase-5.png](http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/freebox-zibase-5.png)
![http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/freebox-zibase-2.png](http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/freebox-zibase-2.png)
![http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/freebox-zibase-4.png](http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/freebox-zibase-4.png)

l'url attaque mon serveur ZiHome avec les parramètres nécessaires pour lancer l'action.

et j'ai programmé le calendrier comme suit a partir de ZiHome (car je ne sais pas comment gérer les calendriers de la zibase) :
![http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/freebox-zibase-3.png](http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/freebox-zibase-3.png)

Les applications sont multiples et configurable selon vos souhaits.

voici les fonction disponibles (remplacer la valeur de la variable "do" dans l'URL) :
  * reboot
  * ring\_on
  * ring\_off
  * wifi\_on
  * wifi\_off