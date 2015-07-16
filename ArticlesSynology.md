# Sommaire #



# Pré-requis #

Avant de commencer l’installation, voici la liste des outils dont vous aurez besoin :
  * La dernière version de ZiHome. L'archive est téléchargeable depuis la page d'accueil : https://code.google.com/p/interface-utilisateur-domotique-zibase/
  * Un éditeur de fichier évolué installé sur le PC. Notepad++ est très bien et gratuit. Il est téléchargeable à l'adresse : http://notepad-plus-plus.org/fr/
  * Le logiciel PuTTY installé sur le PC. Il permettra de se connecter au NAS. Il est téléchargeable à l’adresse : http://www.chiark.greenend.org.uk/~sgtatham/putty/download.html
  * L’une des dernières versions du DSM installée sur le NAS.

Le NAS doit ensuite être configuré avec les paramètres suivants :
  * Dans Panneau de configuration/terminal du NAS autoriser les connexions SSH :
![http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/Synology1.png](http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/Synology1.png)
  * Installer Mariadb et phpMyAdmin via le centre de paquets.
![http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/Syno_paquets.jpg](http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/Syno_paquets.jpg)
  * Activer le service Web station en allant dans le panneau de configuration/Service Web
![http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/Synology3.png](http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/Synology3.png)
  * Liste des options à cocher dans panneau de configuration/services web onglet Paramètre PHP et dans personnaliser PHP open\_basedir,  ajouter à la fin le texte  :/volume1/Scripts/InterfaceZibase/
![http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/Synology4.jpg](http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/Synology4.jpg)
  * Activation des extensions PHP dans panneau de configuration/services web onglet Paramètres PHP cliquer sur « Sélectionner PHP extension » puis cocher les options comme indiqué :
![http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/Synology5.jpg](http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/Synology5.jpg)
  * Créer un dossier partagé où se trouvera le répertoire bin, panneau de configuration/ dossier partagé/créer puis attribuer les droits de lecture et écriture aux personnes souhaitées:
![http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/Synology6.png](http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/Synology6.png)
  * Si vous ne maîtrisez par la commande vi, vous pouvez essayé d'installer Config File Editor qui servira pour modifier les fichiers de configuration comme le fichier crontab. La procédure d’installation est décrite sur cette page : http://www.sil51.com/informatique/ds1812/65-ds1812-config-file-editor.html. Pour l’utilisation de ce logiciel décocher la case « Améliorer la protection contre les falsifications de requêtes inter-site » puis utiliser Config File Editor à partir du compte utilisateur admin :
![http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/Synology7.png](http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/Synology7.png)

# Installation de l’interface #
## Installation de www ##
Avec un explorateur Windows copier le répertoire www dans \\votreNAS\web. Lors de la première connexion avec votre navigateur internet préféré une page de renseignement s’affiche, ce qui permettra de remplir automatiquement le fichier \\votreNAS \web\www\config\conf\_zibase.php. Ce fichier peut être modifié ultérieurement en cas de problème ou de changement de configuration :

![http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/Synology8.png](http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/Synology8.png)


Si tout se passe bien, voici le message qui sera affiché :

![http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/Synology9.png](http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/Synology9.png)

## Description du fichier config\_zibase.php ##
Ce descriptif est donné de manière informative. Normalement, il n'est pas nécessaire d'éditer ce fichier à la main.

```
$login = 'user'; // Il s'agit du login de connexion a Mysql 
$plogin = 'password'; // Il s'agit du mot de passe de connexion a Mysql 
$hote = 'localhost'; // Il s'agit de l'adresse du serveur Mysql 
$base = 'zibase'; // Il s'agit du nom de la base Mysql associé à votre interface 
```

## Installation du répertoire bin ##
  * Avec un explorateur Windows, créer le répertoire « InterfaceZibase » dans \\votreNAS\Scripts\
  * Avec un explorateur Windows, copier le répertoire bin dans \\votreNAS\Scripts\InterfaceZibase\
  * Puis se connecter au NAS en SSH avec PuTTY en saisissant les champs Host name, Port Saved sessions et en cliquant sur SSH puis sur save pour sauver la configuration et pour finir open :

![http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/Synology11.png](http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/Synology11.png)

> Une fois que le terminal s’ouvre, suivre cette procédure :
  * Se connecter avec
    * Login as : root
    * root@votreNAS password: motdepasseadministrateur
  * Lancer les commandes suivantes
```
cd /volume1/Scripts/InterfaceZibase/bin/
./install.sh
```
  * Vous pouvez fermer PuTTY
  * Redémarrer le NAS via le DSM pour prendre en compte la nouvelle configuration.

# Mise à jour de la base de données #
En cas de mise à jour du site suite à une évolution, vous serez peut être amené à importer un fichier updatex.sql. Voici comment faire :
  * Aller à l’adresse : http://IPduNAS/phpMyAdmin
  * Renseigner l’utilisateur ainsi que son mot de passe (le même décrit dans « Installation de www »).
  * Ouvrir la base de données qui a été créé précédemment.
  * Cliquer sur l’onglet Importer, parcourir le fichier www/sql/updatex.sql, laisser les options par défaut et exécuter :
![http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/Synology10.png](http://wiki.interface-utilisateur-domotique-zibase.googlecode.com/git/images/Synology10.png)

Merci à Chric pour la contribution pour cette documentation.
Merci à Sdo pour son script de remonter d'info.

n'hésitez pas à nous proposer vos expériences d'installation ou d'utilisation.