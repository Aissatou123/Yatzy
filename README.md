L'ensemble des fichiers pour notre jeu yatzy se trouve dans public--->assets. 
Notre jeu comprends 2 joueurs. Chaque joueur a trois lancers par tour pour obtenir la meilleure combinaison possible. Les combinaisons comprennent des suites, des brelans, des carrés, un full, etc. Après chaque lancer, le joueur peut choisir de garder certains dés et de relancer les autres pour améliorer sa main. Une fois les trois lancers effectués, le joueur doit choisir une catégorie dans laquelle enregistrer son score pour ce tour. Le joueur avec le score total le plus élevé à la fin de toutes les manches remporte la partie. 
J'ai choisit de mettre deux joueurs pour rendre la partie plus amusante. 

DESCRIPTION DE MES FONCTIONS: 

rollDice() : Cette fonction est déclenchée lorsque le joueur clique sur le bouton "ROLL". Elle simule le lancer des dés en générant des nombres aléatoires pour chaque dé, puis met à jour l'affichage des dés avec les résultats du lancer.

resetDicePositions() : Cette fonction réinitialise la position de tous les dés à leur position d'origine.

changeDiePosition(diceElement, x, y) : Cette fonction change la position d'un dé en lui appliquant une translation et une rotation aléatoires, ce qui simule un effet de lancer de dé.

changeDiceFaces(randomDice) : Cette fonction met à jour l'affichage des faces des dés avec les résultats du lancer actuel.

writeTempValuesInScoreTable(dice) : Cette fonction calcule les valeurs temporaires des scores pour chaque combinaison possible en fonction des dés lancés et les affiche dans la table des scores.

writeTempValueOnOnlyPossibleRaw(dice, playerNumber) : Cette fonction est appelée lorsque le joueur obtient une combinaison unique et doit la saisir dans la seule rangée possible dans laquelle elle peut être enregistrée.

onCellClick() : Cette fonction est déclenchée lorsque le joueur clique sur une cellule de la table des scores pour enregistrer son score dans une catégorie spécifique. Elle met à jour les scores et les couleurs des cellules correspondantes.

changeTurn() : Cette fonction est appelée à la fin de chaque tour pour passer au joueur suivant, réinitialiser les dés et mettre à jour l'état du jeu.

updateScoreTable() : Cette fonction met à jour la table des scores en supprimant les cellules vides et en nettoyant les anciens scores du joueur.

calculateEndGameScore() : Cette fonction calcule le score final et affiche le message de fin de partie indiquant le vainqueur ou s'il y a un match nul.

calculateOnes(dice) : Cette fonction calcule le score pour la catégorie "Uns" en comptant le nombre de dés ayant la valeur 1.

calculateTwos(dice) : Cette fonction calcule le score pour la catégorie "Deux" en comptant le nombre de dés ayant la valeur 2.

calculateThrees(dice) : Cette fonction calcule le score pour la catégorie "Trois" en comptant le nombre de dés ayant la valeur 3.

calculateFours(dice) : Cette fonction calcule le score pour la catégorie "Quatre" en comptant le nombre de dés ayant la valeur 4.

calculateFives(dice) : Cette fonction calcule le score pour la catégorie "Cinq" en comptant le nombre de dés ayant la valeur 5.

calculateSixes(dice) : Cette fonction calcule le score pour la catégorie "Six" en comptant le nombre de dés ayant la valeur 6.

Les autres fonctions effectuent des calculs similaires pour les différentes combinaisons de dés possibles dans le jeu Yatzy.
