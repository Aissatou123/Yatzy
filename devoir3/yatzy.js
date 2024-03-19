// Fonction pour lancer les dés en effectuant un appel AJAX à votre API PHP
function rollDice() {
    fetch('api.php?action=rollDice', {
        method: 'GET',
    })
    .then(response => response.json())
    .then(data => {
        // Mettre à jour l'état du jeu en fonction de la réponse de l'API
        updateUI(data);
    })
    .catch(error => {
        console.error('Erreur lors du lancer des dés :', error);
    });
}

// Fonction pour choisir une cellule dans la grille des scores
function selectCell(row, column) {
    fetch('api.php?action=selectCell', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ row: row, column: column }),
    })
    .then(response => response.json())
    .then(data => {
        // Mettre à jour l'état du jeu en fonction de la réponse de l'API
        updateUI(data);
    })
    .catch(error => {
        console.error('Erreur lors de la sélection de la cellule :', error);
    });
}

// Fonction pour mettre à jour l'interface utilisateur en fonction de la réponse de l'API
function updateUI(response) {
    updateDice(response.dice);
    updateScores(response.scores);
}

// Fonction pour mettre à jour les dés affichés
function updateDice(diceValues) {
    var diceElements = document.querySelectorAll('.dice');
    diceElements.forEach((element, index) => {
    element.textContent = diceValues[index]; // Supposant que les valeurs des dés sont stockées dans un tableau
    });
}

// Fonction pour mettre à jour les scores des joueurs
function updateScores(scores) {
    document.getElementById('player1-score').textContent = scores.player1Score;
    document.getElementById('player2-score').textContent = scores.player2Score;
}

