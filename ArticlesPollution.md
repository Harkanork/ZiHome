

# Introduction #

Permet d'afficher une icone suivant le niveau de pollution de votre ville.

![http://img15.hostingpics.net/pics/199305niveaupollution.jpg](http://img15.hostingpics.net/pics/199305niveaupollution.jpg)

# Configuration #

Pour activer la fonction pollution, il va falloir rechercher sa ville (ou une grande ville proche) dans le fichier xml suivant http://www.lcsqa.org/surveillance/indices/prevus/jour/xml

une fois la ville ou grande ville trouvée, renseignez la dans le fichier **conf\_zibase.php** dans la **section parametre pollution**

dans l'exemple ci-dessous, j'ai renseigné **PARIS** car ma ville ne figure pas dans le **Xml**

![http://img15.hostingpics.net/pics/980342confzibaseparametre.jpg](http://img15.hostingpics.net/pics/980342confzibaseparametre.jpg)

Ajoutez une tache Cron sur le fichier **/Scripts/InterfaceZibase/bin/pollution.php**

et enfin paramétrez l'application. Connectez vous au site, cliquez sur l'icone **Administration** puis toute en bas cliquez sur **Paramètres**

![http://img15.hostingpics.net/pics/347036pollutionparaweb.jpg](http://img15.hostingpics.net/pics/347036pollutionparaweb.jpg)

**Icone pollution :** active ou désactive l'icone pollution du plan, puis on valide

**Icone pollution largeur :** Renseigne la largeur de l'icone pollution, puis on valide

**Icone pollution hauteur :** Renseigne la hauteur de l'icone pollution, puis on valide

**Icone pollution droite :** Renseigne la localisation par rapport au plan, puis on valide

**Icone pollution bas :** Renseigne la localisation par rapport au plan, puis on valide

Voila, il ne reste plus qu'à aller sur le plan et admirer notre icone pollution.