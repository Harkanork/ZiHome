Bonjour,

Il a été demandé un descriptif complet du fichier de configuration de la Zibase. voici donc les informations vitales pour configurer correctement votre interface :

<br>$login = 'user';      // Il s'agit du login de connexion a Mysql<br>
<br>$plogin = 'password'; // Il s'agit du mot de passe de connexion a Mysql<br>
<br>$hote = 'localhost';  // Il s'agit de l'adresse du serveur Mysql<br>
<br>$base = 'zibase';     // Il s'agit du nom de la base Mysql associé a votre interface<br>
<br>
<br>$coutfixe                   = '1.7368';  // Il s'agit du cout fixe journalier de votre abonnement EDF<br>
<br>$coutHC                     = '0.1002';  // Il s'agit du cout du Kw/h en heure creuse de votre abonnement EDF<br>
<br>$coutHP                     = '0.1467';  // Il s'agit du cout du Kw/h en heure pleine de votre abonnement EDF<br>
<br>$heuresCreuses<a href='0.md'>0</a>['debut']      = '01:30:00';<br>
<br>$heuresCreuses<a href='0.md'>0</a>['fin']        = '08:00:00';<br>
<br>$heuresCreuses<a href='1.md'>1</a>['debut']      = '12:30:00';<br>
<br>$heuresCreuses<a href='1.md'>1</a>['fin']        = '14:00:00';<br>
<br> // vous indiquez ci-dessus la liste des plage horaires d'heure creuses de votre région EDF. dans l'exemple ci-dessus, il y a 2 plages horaires de 01h30 a 08h00 et de 12h30 a 14h00.<br>
<br>
<br>
<br>$idzibase = "ZiBASEXXXXXX";   // Il s'agit de l'id de votre Zibase disponible dans votre interface d'administration en mode expert<br>
<br>$tokenzibase = "ZZZZZZZZZZ";  // Il s'agit du token de votre Zibase disponible dans votre interface d'administration en mode expert<br>
<br>$ipzibase = "192.168.X.Y";    // Il s'agit de l'adresse ip de votre Zibase.<br>
<br>$ipserver = "192.168.X.Y";    // Il s'agit de l'adresse ip du serveur qui heberge les script (s'il s'agit d'un NAS, il s'agit de l'adresse ip de votre nas).