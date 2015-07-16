

# Introduction #
Cet onglet permet de gérer les stickers.

Les stickers sont des images que l'on affiche sur le pla en fonction de conditions. L'utilisation des stickers peux être multiple.
Les coordonnées sont globales au plan (les stickers peuvent donc être à cheval sur plusieurs pièces).

Pour le champ condition, il faut mettre une expression conditionnelle javascript en utilisant les fonctions détaillées au chapitre ci-dessous.

# Fonctions #

  * `jour()` : Renvoie vrai s'il fait jour
  * `nuit()` : Renvoie vrai s'il fait nuit
  * `temperature("nom capteur")` : Renvoie la température (degrés)
  * `hygrometrie("nom capteur")` : Renvoie le pourcentage d'hygrométrie
  * `vitesseVent("nom capteur")` : Renvoie la vitesse du vent (m/s)
  * `directionVent("nom capteur")` : Renvoie la direction du vent
  * `actionneur("nom capteur")` : Renvoie vrai si l'actionneur est activé
  * `luminosite("nom capteur")` : Renvoie la luminosité
  * `consoElec("Nom du capteur")` : Renvoie la consommation électrique
  * `variable(Numéro de la variable)` : Renvoie la valeur numérique de la variable

**Attention, il faut bien mettre le nom des capteurs entre guillemets.**

## Exemples ##

  * Afficher le sticker s'il fait nuit et que l'interrupteur du salon est allumé : `nuit() && actionneur("interrupteur salon")`
  * Afficher le sticker s'il fait jour et que l'interrupteur du salon est éteint : `jour() && ! actionneur("interrupteur salon")`
  * Afficher le sticker si l'hygrometrie renvoyé par le capteur appelé SdB est > 80 : `hygrometrie("SdB") > 80`

# Configuration #

A compléter

# Idées d'utilisation #

  * Afficher une image spécifique si la lumière est allumée
  * Afficher une image spécifique si la cheminée est allumée (température de la salle à manger anormalement élevée)
  * Afficher une image spécifique s'il y a quelqu'un dans une pièce
  * Afficher une image spécifique si le taux d'hygrométrie est trop haut dans la cave
  * Afficher une image spécifique s'il fait chaud dehors
  * Afficher une image spécifique s'il fait froid dehors
  * Afficher une image spécifique si la température de la piscine est idéale