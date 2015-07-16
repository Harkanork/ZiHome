#Howto Update.

# Introduction #

Comment mettre à jour ZiHome.


# Détails #

  * Télécharger l'archive de la dernière version de ZiHome
  * Ecraser les fichiers se trouvant dans le dossier www
  * Importer les fichiers sql se trouvant dans le dossier www/sql/updateX.sql pour aller de la version courante à la nouvelle nouvelle (à l'aide de phpMyAdmin)
  * Ecraser les fichiers se trouvant dans le dossier bin
  * Lancer le script bin/install.sh (en se connectant en root à l'aide de putty)