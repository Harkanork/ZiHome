#!/bin/sh


#-------------------------------------------------------------------------------
installCron () { 
  echo "-------------------------------"
  echo "Configuration du fichier cron"
  echo ""
  
  echo "Creation d'une copie du fichier crontab"
  cp /etc/crontab $currentFolder/crontab.back
  
  echo "Suppression des anciennes commandes"
  
  # List des fichiers de ZiHome
  commands="ZiHome meteo.php scenario.php peripheriques_value peripheriques.php message_zibase_auth.php pollution.php";
  # Transforme la liste en tableau
  commands=${commands//:/ }
  
  # Recupere la crontab actuelle
  text=`cat /etc/crontab`
  
  # Supprime les anciennes commandes de la crontab
  for command in ${commands}
  do
  a=`echo "$text" | sed "/$command/d"`
  text=$a
  done
  
  echo "Ecriture du nouveau fichier"
  
  # On ecrase le crontab actuel avec la version nettoyee
  echo "$text" > /etc/crontab;
  
  # On remet notre couche en remplaçant les jokers par le bon nom de dossier
  currentFolderSed=`echo "$currentFolder" | sed "s.\/.\\\\\/.g"`
  ZiHome=`cat "$currentFolder/template_crontab" | sed "s/remplacement/$currentFolderSed/g"`
  echo "$ZiHome" >> /etc/crontab
  
  # On redemarre cron pour qu'il prenne en compte les modifs
  echo "Redemarrage du demon cron"
  /usr/syno/sbin/synoservicectl --restart crond
}

#-------------------------------------------------------------------------------
configureScripts () { 
  echo "-------------------------------"
  echo "Configuration des scripts"
  echo ""
  
  ZiHomePathSed=`echo "$ZiHomePath" | sed "s.\/.\\\\\/.g"`
  ZiHome=`cat "$currentFolder/template_conf_scripts.php" | sed "s/remplacement/$ZiHomePathSed/g"`
  echo "$ZiHome" > "$currentFolder/conf_scripts.php"
}

# recuperation du repertoire courant
currentFolder=`dirname $0`
currentFolder="`( cd \"$currentFolder\" && pwd )`"

echo "-------------------------------"
echo "Installation de ZiHome"
echo ""

ZiHomePath="/volume1/web/www"

if [ "$#" -ge 1 ] 
then
  ZiHomePath=$1
fi

if [ ! -d "$ZiHomePath/pages/admin" ]
then
  echo "Le dossier '$ZiHomePath' n'existe pas, veuillez passer le bon chemin en paramètre."
  echo "Exemple :"
  echo "./install.sh /volume1/web/monsite"
  exit 1
fi


configureScripts

installCron


echo "-------------------------------"
echo "Fini!"
echo "-------------------------------"
