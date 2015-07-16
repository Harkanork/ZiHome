#Procédure d'installation

# Introduction #

Présentation de la procédure d'installation de cette interface

# Details #

Pré-requis :
Pour pouvoir utilisez notre système, vous avez besoins d'une zibase et d'un système hôte (actuellement testé sous linux Debian avec succès comprenant Apache, MySQL et PHP. Le php doit être disponible en ligne de commande. Fonctionne également sur WAMP server)

- copier le contenu de www dans le dossier de votre serveur web.
<br>- afficher votre site et procéder a la configuration du système.<br>
<br>- copier le contenu du dossier bin dans le dossier de votre choix (pour moi, /usr/bin/) et modifiez les chemins en début du fichier conf_script.php par rapport a votre configuration.<br>
<br>- ajouter les taches de cron en respectant les paramètres de votre système. (fichier cron/zibase a copier dans le dossier /etc/cron.d/ pour les systèmes linux habituels) (fichier cron/zibase.bat a copier a copier dans le dossier de votre choix pour moi : c:\wamp\bin\zibase\ pour Windows)<br>
<br>
Dans le cadre de l'utilisation du module OWL :<br>
<br>- copier le fichier init/owl dans le dossier /etc/init.d , ajoutez y les droits d’exécution : "chmod a+x /etc/init.d/owl" et activez le au démarrage du système avec la commande "update-rc.d owl defaults".<br>
<br>
Dans le cadre de l'utilisation de récupérations des messages de la zibase :<br>
<br>- copier le fichier init/message_zibase dans le dossier /etc/init.d , ajoutez y les droits d'exécution : "chmod a+x /etc/init.d/message_zibase" et activez le au démarrage du système avec la commande "update-rc.d message_zibase defaults".<br>
<br>
Si vous utilisez WampServer :<br>
<br>- dans php.ini, modifier short_open_tag = on<br>
<br>- activer l'extension php : php_sockets<br>
<br>- créer une tache planifiée qui éxécute le fichier zibase.bat chaque minutes et modifier ce fichier avec vos chemins spécifiques.<br>
<br>- exécuter owl.bat et message_zibase.bat au démarrage de la machine<br>
<br>
Vous pouvez maintenant vous connecter sur l'interface. les identifiants par défauts sont "Admin / secret"