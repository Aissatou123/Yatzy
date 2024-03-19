<?php
session_start();

// Variables de jeu
$_SESSION['player1Score'] = [];
$_SESSION['player2Score'] = [];
$_SESSION['player1Dice'] = [];
$_SESSION['player2Dice'] = [];
$_SESSION['rollCount'] = 0;
$_SESSION['roundCount'] = 0;
$_SESSION['onlyPossibleRow'] = "blank";
$_SESSION['jokerCard'] = false;
$_SESSION['isPlayerOneTurn'] = true;
$_SESSION['transformValues'] = [
    [0, 30], [-5, 40], [0, 35], [5, 40], [0, 30]
];

// Traitement des requêtes POST

// Endpoint pour réinitialiser les positions des dés
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_dice_positions'])) {
    resetDicePositions();
    echo json_encode(array("success" => true));
}

// Endpoint pour changer la position d'un dé
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_die_position'])) {
    $x = $_POST['x'];
    $y = $_POST['y'];
    $diceElement = $_POST['dice_element'];
    changeDiePosition($diceElement, $x, $y);
    echo json_encode(array("success" => true));
}

// Endpoint pour changer les faces des dés
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_dice_faces'])) {
    $randomDice = $_POST['random_dice'];
    changeDiceFaces($randomDice);
    echo json_encode(array("success" => true));
}

// Endpoint pour réinitialiser les faces des dés
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_dice_faces'])) {
    resetDiceFaces();
    echo json_encode(array("success" => true));
}

// Endpoint pour effectuer une action lorsqu'une cellule est cliquée
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['on_cell_click'])) {
    $row = $_POST['row'];
    $column = $_POST['column'];
    onCellClick($row, $column);
    echo json_encode(array("success" => true));
}

// Endpoint pour changer de tour
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_turn'])) {
    changeTurn();
    echo json_encode(array("success" => true));
}

// Endpoint pour mettre à jour le tableau des scores
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_score_table'])) {
    updateScoreTable();
    echo json_encode(array("success" => true));
}

// Endpoint pour calculer le score de fin de partie
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['calculate_end_game_score'])) {
    calculateEndGameScore();
    echo json_encode(array("success" => true));
}

// Fonction pour lancer les dés
function rollDice() {
    $_SESSION['rollCount']++;
    $diceArr = [1, 2, 3, 4, 5];
    $randomDice = [];
    for ($i = 0; $i < count($diceArr); $i++) {
        $randomDice[] = rand(1, 6);
    }

    $numDice = count($_SESSION['player1Dice']);
    $counter = 0;
    foreach ($_SESSION['diceElements'] as $index => $diceElement) {
        if (in_array("active", $diceElement['classList']) || $_SESSION['rollCount'] == 1) {
            resetDicePositions();
            $x = $_SESSION['transformValues'][$index][0];
            $y = $_SESSION['transformValues'][$index][1];

            usleep(500000);
            $counter++;
            changeDiePosition($diceElement, $x, $y);
            changeDiceFaces($randomDice);

            if ($counter == 1) {
                if ($_SESSION['isPlayerOneTurn']) {
                    writeTempValuesInScoreTable($_SESSION['player1Dice']);
                } else {
                    writeTempValuesInScoreTable($_SESSION['player2Dice']);
                }
            }
            if ($_SESSION['rollCount'] == 3) {
                $_SESSION['rollButton']['disabled'] = true;
                $_SESSION['rollButton']['style']['opacity'] = 0.5;
            }
        }
    }
}

function resetDicePositions() {
    foreach ($_SESSION['diceElements'] as &$diceElement) {
        $diceElement['style']['transform'] = "none";
    }
}

function changeDiePosition(&$diceElement, $x, $y) {
    $angle = 135 * rand(0, 9);
    $diceRollDirection = -1;
    if (!$_SESSION['isPlayerOneTurn']) {
        $diceRollDirection = 1;
    }
    $angle = 135 * rand(0, 9);
    $diceElement['style']['transform'] =
        "translateX(" .
        $x . "vw) translateY(" . $diceRollDirection * $y .
        "vh) rotate(" . $angle . "deg)";
}

function changeDiceFaces($randomDice) {
    for ($i = 0; $i < count($_SESSION['diceElements']); $i++) {
        if ($_SESSION['rollCount'] === 1) {
            $_SESSION['diceElements'][$i]['class'][] = "active";
        }
        if (in_array("active", $_SESSION['diceElements'][$i]['class'])) {
            if ($_SESSION['isPlayerOneTurn']) {
                $_SESSION['player1Dice'][$i] = $randomDice[$i];
            } else {
                $_SESSION['player2Dice'][$i] = $randomDice[$i];
            }
            $_SESSION['diceElements'][$i]['childNodes'][0]['src'] = "dice" . $randomDice[$i] . ".png";
        }
    }
}

function resetDiceFaces() {
    for ($i = 0; $i < count($_SESSION['diceElements']); $i++) {
        $_SESSION['diceElements'][$i]['class'] = array_diff($_SESSION['diceElements'][$i]['class'], ["active"]);
        $diceNumber = $i + 1;
        $_SESSION['diceElements'][$i]['childNodes'][0]['src'] = "dice" . $diceNumber . ".png";
        $_SESSION['player1Dice'][$i] = 0;
        $_SESSION['player2Dice'][$i] = 0;
    }
}

foreach ($_SESSION['diceElements'] as $diceElement) {
    $diceElement->addEventListener("click", function () {
        if ($_SESSION['rollCount'] == 0) {
            return;
        }
        $classList = $diceElement->getAttribute("class");
        if (!in_array("active", $classList)) {
            $diceElement->classList[] = "active";
        } else {
            $classList = array_diff($classList, ["active"]);
            $diceElement->setAttribute("class", $classList);
            $diceElement->style->transform = "none";
        }
        if (in_array("active", $classList)) {
            $diceNumber = intval(substr($diceElement->getAttribute("id"), 3));
            $x = $_SESSION['transformValues'][$diceNumber - 1][0];
            $y = $_SESSION['transformValues'][$diceNumber - 1][1];
            changeDiePosition($diceElement, $x, $y);
        }
    });
}

function writeTempValuesInScoreTable($dice) {
  $scoreTable = [];
  $playerNumber = 1;
  if (!$_SESSION['isPlayerOneTurn']) {
    $scoreTable = $_SESSION['player2Score'];
    $playerNumber = 2;
  } else {
    $scoreTable = $_SESSION['player1Score'];
  }
  $_SESSION['jokerCard'] = false;
  $_SESSION['onlyPossibleRow'] = "blank";
  $yahtzeeScore = calculateYahtzee($dice);
  $yahtzeeElement = $_SESSION['yahtzee'.$playerNumber];
  if (!isset($scoreTable[12])) {
    $yahtzeeElement->nodeValue = $yahtzeeScore;
  } elseif ($yahtzeeScore > 0 && isset($scoreTable[12])) {
    $yahtzeeScore += 100;
    $yahtzeeElement->nodeValue = $yahtzeeScore;
  }
  if ($yahtzeeScore > 0 && isset($scoreTable[$dice[0] - 1]) && isset($scoreTable[12])) {
    $_SESSION['jokerCard'] = true;
  }
  if ($yahtzeeScore > 0 && !isset($scoreTable[$dice[0] - 1]) && isset($scoreTable[12])) {
    $_SESSION['onlyPossibleRow'] = $dice[0];
    writeTempValueOnOnlyPossibleRaw($dice, $playerNumber);
    return;
  }
 
  if (!isset($scoreTable[0])) {
    $onesScore = calculateOnes($dice);
    $_SESSION['ones' . $playerNumber]->nodeValue = $onesScore;
  }
  if (!isset($scoreTable[1])) {
    $twosScore = calculateTwos($dice);
    $_SESSION['twos' . $playerNumber]->nodeValue = $twosScore;
  }
  if (!isset($scoreTable[2])) {
    $threesScore = calculateThrees($dice);
    $_SESSION['threes' . $playerNumber]->nodeValue = $threesScore;
  }
  if (!isset($scoreTable[3])) {
    $foursScore = calculateFours($dice);
    $_SESSION['fours' . $playerNumber]->nodeValue = $foursScore;
  }
  if (!isset($scoreTable[4])) {
    $fivesScore = calculateFives($dice);
    $_SESSION['fives' . $playerNumber]->nodeValue = $fivesScore;
  }
  if (!isset($scoreTable[5])) {
    $sixesScore = calculateSixes($dice);
    $_SESSION['sixes' . $playerNumber]->nodeValue = $sixesScore;
  }
  if (!isset($scoreTable[6])) {
    $threeOfAKindScore = calculateThreeOfAKind($dice);
    $_SESSION['threeOfAKind' . $playerNumber]->nodeValue = $threeOfAKindScore;
  }
  if (!isset($scoreTable[7])) {
    $fourOfAKindScore = calculateFourOfAKind($dice);
    $_SESSION['fourOfAKind' . $playerNumber]->nodeValue = $fourOfAKindScore;
  }
  if (!isset($scoreTable[8])) {
    $fullHouseScore = calculateFullHouse($dice);
    $_SESSION['fullHouse' . $playerNumber]->nodeValue = $fullHouseScore;
  }
  if (!isset($scoreTable[9])) {
    $smallStraightScore = $_SESSION['jokerCard'] ? 30 : calculateSmallStraight($dice);
    $_SESSION['smallStraight' . $playerNumber]->nodeValue = $smallStraightScore;
  }
  if (!isset($scoreTable[10])) {
    $largeStraightScore = $_SESSION['jokerCard'] ? 40 : calculateLargeStraight($dice);
    $_SESSION['largeStraight' . $playerNumber]->nodeValue = $largeStraightScore;
  }
  if (!isset($scoreTable[11])) {
    $chanceScore = calculateChance($dice);
    $_SESSION['chance' . $playerNumber]->nodeValue = $chanceScore;
  }
}

function writeTempValueOnOnlyPossibleRaw($dice, $playerNumber) {
  if ($dice[0] == 1) {
    $score = calculateOnes($dice);
    $_SESSION['ones' . $playerNumber]->nodeValue = $score;
  }
  if ($dice[0] == 2) {
    $score = calculateTwos($dice);
    $_SESSION['twos' . $playerNumber]->nodeValue = $score;
  }
  if ($dice[0] == 3) {
    $score = calculateThrees($dice);
    $_SESSION['threes' . $playerNumber]->nodeValue = $score;
  }
  if ($dice[0] == 4) {
    $score = calculateFours($dice);
    $_SESSION['fours' . $playerNumber]->nodeValue = $score;
  }
  if ($dice[0] == 5) {
    $score = calculateFives($dice);
    $_SESSION['fives' . $playerNumber]->nodeValue = $score;
  }
  if ($dice[0] == 6) {
    $score = calculateSixes($dice);
    $_SESSION['sixes' . $playerNumber]->nodeValue = $score;
  }
}

function onCellClick() {
  $row = $this->getAttribute("data-row");
  $column = $this->getAttribute("data-column");
  if (
    $_SESSION['rollCount'] == 0 ||
    $row === null ||
    ($_SESSION['onlyPossibleRow'] != "blank" && $row != $_SESSION['onlyPossibleRow'])
  ) return;
  if ($_SESSION['isPlayerOneTurn'] && $column == 1) {
    $_SESSION['player1Score'][$row - 1] = (int)$this->nodeValue;
    $upperSectionScore1 = calculateUpperSection($_SESSION['player1Score']);
    $bonusScore1 = $upperSectionScore1 > 63 ? 35 : 0;
    $lowerSectionScore1 = calculateLowerSectionScore($_SESSION['player1Score']);
    $totalScore1 = $upperSectionScore1 + $lowerSectionScore1 + $bonusScore1;
    $_SESSION['sum1']->nodeValue = $upperSectionScore1;
    $_SESSION['bonus1']->nodeValue = $bonusScore1;
    $_SESSION['total1']->nodeValue = $totalScore1;
    $this->removeEventListener("click", "onCellClick");
    $this->style->color = "green";
    $_SESSION['sum1']->style->color = "green";
    $_SESSION['bonus1']->style->color = "green";
    $_SESSION['total1']->style->color = "green";
    changeTurn();
  }
  if (!$_SESSION['isPlayerOneTurn'] && $column == 2) {
    $_SESSION['player2Score'][$row - 1] = (int)$this->nodeValue;
    $upperSectionScore2 = calculateUpperSection($_SESSION['player2Score']);
    $bonusScore2 = $upperSectionScore2 > 63 ? 35 : 0;
    $lowerSectionScore2 = calculateLowerSectionScore($_SESSION['player2Score']);
    $totalScore2 = $upperSectionScore2 + $lowerSectionScore2 + $bonusScore2;
    $_SESSION['sum2']->nodeValue = $upperSectionScore2;
    $_SESSION['bonus2']->nodeValue = $bonusScore2;
    $_SESSION['total2']->nodeValue = $totalScore2;
    $this->removeEventListener("click", "onCellClick");
    $this->style->color = "green";
    $_SESSION['sum2']->style->color = "green";
    $_SESSION['bonus2']->style->color = "green";
    $_SESSION['total2']->style->color = "green";
    changeTurn();
  }
}

function changeTurn() {
  $_SESSION['roundCount']++;
  updateScoreTable();
  resetDiceFaces();
  $_SESSION['isPlayerOneTurn'] = !$_SESSION['isPlayerOneTurn'];
  $_SESSION['rollCount'] = 0;
  if ($_SESSION['isPlayerOneTurn']) {
    $player2ContainerDice = $_SESSION['player2Container']->querySelectorAll(".dice");
    foreach ($player2ContainerDice as $diceElement) {
      $diceElement->style->transform = "none";
      $_SESSION['player2Container']->removeChild($diceElement);
      $_SESSION['player1Container']->appendChild($diceElement);
    }
  } else {
    $player1ContainerDice = $_SESSION['player1Container']->querySelectorAll(".dice");
    foreach ($player1ContainerDice as $diceElement) {
      $diceElement->style->transform = "none";
      $_SESSION['player1Container']->removeChild($diceElement);
      $_SESSION['player2Container']->appendChild($diceElement);
    }
  }
  if ($_SESSION['roundCount'] == 26) {
    calculateEndGameScore();
    return;
  }
  $_SESSION['rollButton']->disabled = false;
  $_SESSION['rollButton']->style->opacity = 1;
}

function updateScoreTable() {
  $scoreTable = [];
  $scoreTable = $_SESSION['isPlayerOneTurn'] ? $_SESSION['player1Score'] : $_SESSION['player2Score'];
  $column = $_SESSION['isPlayerOneTurn'] ? 1 : 2;
  $scoreCells = $_SESSION['document']->querySelectorAll('[data-column="' . $column . '"]');
  for ($i = 0; $i < count($scoreCells); $i++) {
    if (!isset($scoreTable[$i])) {
      $scoreCells[$i]->nodeValue = "";
    }
  }
}

function calculateEndGameScore() {
  $player1Total = (int)$_SESSION['total1']->nodeValue;
  $player2Total = (int)$_SESSION['total2']->nodeValue;
  $endGameMessage = $player1Total == $player2Total ? "Draw" : ($player1Total > $player2Total ? "Player1 Wins" : "Player2 Wins");
  $_SESSION['endGameMessage']->nodeValue = $endGameMessage;
  $_SESSION['rollButton']->disabled = true;
  $_SESSION['rollButton']->style->opacity = 0.5;
}

function calculateOnes($dice) {
  $score = 0;
  foreach ($dice as $die) {
    if ($die === 1) {
      $score += 1;
    }
  }
  return $score;
}

function calculateTwos($dice) {
  $score = 0;
  foreach ($dice as $die) {
    if ($die === 2) {
      $score += 2;
    }
  }
  return $score;
}

function calculateThrees($dice) {
  $score = 0;
  foreach ($dice as $die) {
    if ($die === 3) {
      $score += 3;
    }
  }
  return $score;
}

function calculateFours($dice) {
  $score = 0;
  foreach ($dice as $die) {
    if ($die === 4) {
      $score += 4;
    }
  }
  return $score;
}

function calculateFives($dice) {
  $score = 0;
  foreach ($dice as $die) {
    if ($die === 5) {
      $score += 5;
    }
  }
  return $score;
}

function calculateSixes($dice) {
  $score = 0;
  foreach ($dice as $die) {
    if ($die === 6) {
      $score += 6;
    }
  }
  return $score;
}

function calculateChance($dice) {
  $score = 0;
  foreach ($dice as $die) {
    $score += $die;
  }
  return $score;
}

function calculateYahtzee($dice) {
  $firstDie = $dice[0];
  $score = 50;
  foreach ($dice as $die) {
    if ($die !== $firstDie) {
      $score = 0;
    }
  }
  return $score;
}

function calculateThreeOfAKind($dice) {
  $score = 0;
  foreach ($dice as $die) {
    $count = 1;
    foreach ($dice as $otherDie) {
      if ($otherDie === $die) {
        $count++;
      }
    }
    if ($count >= 3) {
      $score = array_sum($dice);
      break;
    }
  }
  return $score;
}

function calculateFourOfAKind($dice) {
  $score = 0;
  foreach ($dice as $die) {
    $count = 1;
    foreach ($dice as $otherDie) {
      if ($otherDie === $die) {
        $count++;
      }
    }
    if ($count >= 4) {
      $score = array_sum($dice);
      break;
    }
  }
  return $score;
}

function calculateFullHouse($dice) {
  $score = 0;
  $diceCopy = $dice;
  sort($diceCopy);
  if (
    ($diceCopy[0] == $diceCopy[1] &&
      $diceCopy[1] == $diceCopy[2] &&
      $diceCopy[3] == $diceCopy[4]
    ) ||
    ($diceCopy[0] == $diceCopy[1] &&
      $diceCopy[2] == $diceCopy[3] &&
      $diceCopy[3] == $diceCopy[4]
    )
  ) {
    $score = 25;
    return $score;
  }
  return $score;
}

function calculateSmallStraight($dice) {
  $score = 0;
  $diceCopy = array_unique($dice);
  sort($diceCopy);
  if (
    ($diceCopy[1] == $diceCopy[0] + 1 &&
      $diceCopy[2] == $diceCopy[1] + 1 &&
      $diceCopy[3] == $diceCopy[2] + 1
    ) ||
    ($diceCopy[2] == $diceCopy[1] + 1 &&
      $diceCopy[3] == $diceCopy[2] + 1 &&
      $diceCopy[4] == $diceCopy[3] + 1
    )
  ) {
    $score = 30;
  }
  return $score;
}

function calculateLargeStraight($dice) {
  $score = 0;
  $diceCopy = array_unique($dice);
  sort($diceCopy);
  if (
    ($diceCopy[1] == $diceCopy[0] + 1 &&
      $diceCopy[2] == $diceCopy[1] + 1 &&
      $diceCopy[3] == $diceCopy[2] + 1 &&
      $diceCopy[4] == $diceCopy[3] + 1
    )
  ) {
    $score = 40;
  }
  return $score;
}

function calculateUpperSection($playerScore) {
  $ones = isset($playerScore[0]) ? $playerScore[0] : 0;
  $twos = isset($playerScore[1]) ? $playerScore[1] : 0;
  $threes = isset($playerScore[2]) ? $playerScore[2] : 0;
  $fours = isset($playerScore[3]) ? $playerScore[3] : 0;
  $fives = isset($playerScore[4]) ? $playerScore[4] : 0;
  $sixes = isset($playerScore[5]) ? $playerScore[5] : 0;
  $score = $ones + $twos + $threes + $fours + $fives + $sixes;
  return $score;
}

function calculateLowerSectionScore($playerScore) {
  $threeOfAKind = isset($playerScore[6]) ? $playerScore[6] : 0;
  $fourOfAKind = isset($playerScore[7]) ? $playerScore[7] : 0;
  $fullHouse = isset($playerScore[8]) ? $playerScore[8] : 0;
  $smallStraight = isset($playerScore[9]) ? $playerScore[9] : 0;
  $largeStraight = isset($playerScore[10]) ? $playerScore[10] : 0;
  $chance = isset($playerScore[11]) ? $playerScore[11] : 0;
  $yahtzee = isset($playerScore[12]) ? $playerScore[12] : 0;

  if ($yahtzee > 0) {
    $playerNumber = $_SESSION['isPlayerOneTurn'] ? 1 : 2;
    $yahtzee = intval($_SESSION['yahtzee'.$playerNumber]->nodeValue);
  }

  $lowerSectionScore = $threeOfAKind + $fourOfAKind + $fullHouse + $smallStraight + $largeStraight + $chance + $yahtzee;
  return $lowerSectionScore;
}

?>
