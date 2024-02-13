function calculateScore(game, scoreType) {
    let score = 0;

    switch (scoreType) {
        case 'Ones':
            score = calculateUpperSectionScore(game, 1);
            break;
        case 'Twos':
            score = calculateUpperSectionScore(game, 2);
            break;
        case 'Threes':
            score = calculateUpperSectionScore(game, 3);
            break;
        case 'Fours':
            score = calculateUpperSectionScore(game, 4);
            break;
        case 'Fives':
            score = calculateUpperSectionScore(game, 5);
            break;
        case 'Sixes':
            score = calculateUpperSectionScore(game, 6);
            break;
        // place pour ajouter d'autres cas pour les différents types de score comme TwoPairs, ThreeOfAKind, etc.
    }

    return score;
}

function calculateUpperSectionScore(game, number) {
    let diceValues = game.diceValues;
    let score = 0;

for (let i = 0; i < diceValues.length; i++) {
        if (diceValues[i] === number) {
            score += number;
        }
    }

    return score;
}

function updateTotalScore(game) {
    let totalScore = 0;

   for (let i = 1; i <= 6; i++) {
        totalScore += calculateScore(game, 'Ones' + i);
    }

    if (totalScore >= 63) {
        totalScore += 50;
    }

    // section pour calculer le score total en ajoutant les scores de la section inférieure
    // section pour ajouter les autres cas pour les différents types de score de la section inférieure

    return totalScore;
}

module.exports = {
    calculateScore,
    updateTotalScore
};
