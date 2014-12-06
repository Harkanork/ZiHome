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
  commands="ZiHome meteo.php scenario.php peripheriques_value peripheriques.php message_zibase_auth.php pollution.php domo.sh";
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

#-------------------------------------------------------------------------------
configureS99 () { 
  # On remplace les jokers par le bon nom de dossier
  currentFolderSed=`echo "$currentFolder" | sed "s.\/.\\\\\/.g"`
  ZiHome=`cat "$currentFolder/template_S99$1" | sed "s/remplacement/$currentFolderSed/g"`
  echo "$ZiHome" > "$2/S99$1"
  chmod a+x "$2/S99$1"

  ZiHome=`cat "$currentFolder/template_$1" | sed "s/remplacement/$currentFolderSed/g"`
  echo "$ZiHome" > "$currentFolder/$1"
  chmod a+x "$currentFolder/$1"
}

#-------------------------------------------------------------------------------
installS99 () {
  echo "Installation du script de recuperation des messages ZiBase"
  configureS99 "message_zibase.sh" "/usr/syno/etc.defaults/rc.d/"
  echo "Installation du script de gestion des sondes OWL"
  configureS99 "owl.sh" "/usr/syno/etc.defaults/rc.d/"
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

installS99

echo "-------------------------------"
echo "Fini!"
echo "-------------------------------"
echo "Vous devez redemarrer le NAS pour que les messages ZiBase et les sondes OWL fonctionnent"
echo "-------------------------------"
