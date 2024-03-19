SVP ALLEZ AU DEPOT PORTFOLIO   https://github.com/Aissatou123/Portfolio/tree/main/public  POUR BIEN VOIR QUE LE JEU A ETE AJOUTE DANS LE DEPOT PORTFOLIO. VOUS M'AVEZ PAS MIS LES POINTS AU DEVOIR 2.

L'ensemble des fichiers pour notre jeu yatzy du devoir 3 se trouve dans devoir3. J'ai eu du mal a joindre api.php avec yatzy.js donc ca a créé un bug pour le jeu. L'ensmble des tache ont été complété mais seulement ya un bugg qui empeche un lanceur de jeu que j'ignore.
Notre jeu comprends 2 joueurs. Chaque joueur a trois lancers par tour pour obtenir la meilleure combinaison possible. Les combinaisons comprennent des suites, des brelans, des carrés, un full, etc. Après chaque lancer, le joueur peut choisir de garder certains dés et de relancer les autres pour améliorer sa main. Une fois les trois lancers effectués, le joueur doit choisir une catégorie dans laquelle enregistrer son score pour ce tour. Le joueur avec le score total le plus élevé à la fin de toutes les manches remporte la partie. 
J'ai choisit de mettre deux joueurs pour rendre la partie plus amusante. 

DESCRIPTION DE MES FONCTIONS ET TÂCHES: 

Fonction rollDice() :

Cette fonction est appelée lorsqu'un joueur clique sur le bouton "ROLL" pour lancer les dés.
Elle envoie une requête GET à api.php?action=rollDice pour demander au serveur de générer de nouveaux résultats de dés.
Le serveur génère les résultats des dés et les renvoie sous forme de réponse JSON.
Le JavaScript côté client reçoit cette réponse et met à jour l'interface utilisateur en conséquence.
Fonction selectCell(row, column) :

Cette fonction est appelée lorsqu'un joueur sélectionne une cellule dans la grille des scores.
Elle envoie une requête POST à api.php?action=selectCell avec les coordonnées de la cellule sélectionnée (ligne et colonne).
Le serveur traite cette sélection, met à jour l'état du jeu et renvoie les nouvelles données du jeu sous forme de réponse JSON.
Le JavaScript côté client reçoit cette réponse et met à jour l'interface utilisateur en conséquence.
Déroulement du jeu :

Le jeu commence lorsque les joueurs chargent la page HTML contenant le jeu Yatzy.
Les joueurs peuvent cliquer sur le bouton "ROLL" pour lancer les dés.
Après chaque lancer de dés, les résultats sont envoyés au serveur via la fonction rollDice().
Les joueurs peuvent sélectionner une cellule dans la grille des scores, ce qui déclenche l'appel à la fonction selectCell(row, column).
Le serveur met à jour l'état du jeu en fonction des actions des joueurs et renvoie les données mises à jour au client.
Le JavaScript côté client reçoit les données mises à jour et met à jour l'interface utilisateur pour refléter l'état actuel du jeu.
Lien avec JavaScript :

Les fonctions rollDice() et selectCell(row, column) sont appelées à partir du code JavaScript côté client pour interagir avec l'API fournie par api.php.Le JavaScript analyse les réponses JSON renvoyées par le serveur et met à jour l'interface utilisateur en fonction des données reçues.
Ainsi, le lien entre api.php et JavaScript permet une interaction dynamique entre le client et le serveur pour gérer le déroulement du jeu Yatzy.
