// Aïssatou Kangou Diome, 300139476
//ce fichier contient un ensemble de fonctions pour calculer le score du match

function calculateOnes(dice) {
  let score=0;
  for (let i=0;i<dice.length;i++){
    if(dice[i]===1) {
      score+=1;
    }
  }
  return score;
}
function calculateTwos(dice) {
  let score=0;
  for (let i=0;i<dice.length;i++){
    if(dice[i]===2) {
      score+=2;
    }
  }
  return score;
}
function calculateThrees(dice) {
  let score=0;
  for (let i=0;i<dice.length;i++){
    if(dice[i]===3) {
      score+=3;
    }
  }
  return score;
}
function calculateFours(dice) {
  let score=0;
  for (let i=0;i<dice.length;i++){
    if(dice[i]===4) {
      score+=4;
    }
  }
  return score;
}
function calculateFives(dice) {
  let score=0;
  for (let i=0;i<dice.length;i++){
    if(dice[i]===5) {
      score+=5;
    }
  }
  return score;
}
function calculateSixes(dice) {
  let score=0;
  for (let i=0;i<dice.length;i++){
    if(dice[i]===6) {
      score+=6;
    }
  }
  return score;
}
function calculateChance(dice) {
  let score=0;
  for (let i=0;i<dice.length;i++){ 
      score+=dice[i];
  }
  return score;
}
function calculateYahtzee(dice) {
  let firstDie=dice[0];
  let score=50;
  for (let i=0;i<dice.length;i++){
    if(dice[i]!==firstDie) {
      score=0;
    }
  }
  return score;
}

function calculateThreeOfAKind(dice) {
  let score=0;
  for(let i=0;i<dice.length;i++){
    let count=1;
    for(let j=0;j<dice.length;j++) {
      if(j!==i && dice[i]===dice[j]){
        count++;
      }
    }
    if(count>=3) {
      score=dice.reduce((acc,val)=>acc+val);
      break;
    }
  }
  return score;
}
function calculateFourOfAKind(dice) {
  let score=0;
  for(let i=0;i<dice.length;i++){
    let count=1;
    for(let j=0;j<dice.length;j++) {
      if(j!==i && dice[i]===dice[j]){
        count++;
      }
    }
    if(count>=4) {
      score=dice.reduce((acc,val)=>acc+val);
      break;
    }
  }
  return score;
}
function calculateFullHouse(dice) {
  let score=0;
  let diceCopy=dice.slice();
  diceCopy.sort();
  if(
    (diceCopy[0]==diceCopy[1] &&
      diceCopy[1]==diceCopy[2] &&
      diceCopy[3]==diceCopy[4]   
      ) ||
        (diceCopy[0]==diceCopy[1] &&
          diceCopy[2]==diceCopy[3] &&
          diceCopy[3]==diceCopy[4]   
          )     
  ) {
    score=25;
    return score;
  }
  return score;
}
function calculateSmallStraight(dice) {
  let score=0;
  let diceCopy=[...new Set(dice)];
  diceCopy.sort();
  if(
    (diceCopy[1]==diceCopy[0]+1 &&
      diceCopy[2]==diceCopy[1]+1 &&
      diceCopy[3]==diceCopy[2] +1  
      ) ||
        (diceCopy[2]==diceCopy[1]+1 &&
          diceCopy[3]==diceCopy[2]+1 &&
          diceCopy[4]==diceCopy[3] +1  
          )     
  ) {
    score=30;
  }
  return score;
}
function calculateLargeStraight(dice) {
  let score=0;
  let diceCopy=[...new Set(dice)];
  diceCopy.sort();
  if(
    (diceCopy[1]==diceCopy[0]+1 &&
      diceCopy[2]==diceCopy[1]+1 &&
      diceCopy[3]==diceCopy[2] +1 &&
      diceCopy[4]==diceCopy[3] +1
      )  
  ) {
    score=40;
  }
  return score;
}
function calculateUpperSection(playerScore){
  let score=0;
  let ones=playerScore[0]==undefined ? 0 : playerScore[0];
  let twos=playerScore[1]==undefined ? 0 : playerScore[1];
  let threes=playerScore[2]==undefined ? 0 : playerScore[2];
  let fours=playerScore[3]==undefined ? 0 : playerScore[3];
  let fives=playerScore[4]==undefined ? 0 : playerScore[4];
  let sixes=playerScore[5]==undefined ? 0 : playerScore[5];
  score=ones+twos+threes+fours+fives+sixes;
  return score;
}
function calculateLowerSectionScore(playerScore){
  let lowerSectionScore=0;
  let threeOfAKind=playerScore[6]===undefined ? 0 : playerScore[6];
  let fourOfAKind=playerScore[7]===undefined ? 0 : playerScore[7];
  let fullHouse=playerScore[8]===undefined ? 0 : playerScore[8];
  let smallStraight=playerScore[9]===undefined ? 0 : playerScore[9];
  let largeStraight=playerScore[10]===undefined ? 0 : playerScore[10];
  let chance=playerScore[11]===undefined ? 0 : playerScore[11];
  let yahtzee=playerScore[12]===undefined ? 0 : playerScore[12];
  if(yahtzee>0) {
    playerNumber=isPlayerOneTurn ? 1 : 2;
    yahtzee=parseInt(document.getElementById("yahtzee"+playerNumber).innerHTML);
  }
  lowerSectionScore=threeOfAKind+fourOfAKind+fullHouse+smallStraight+largeStraight
  + chance+yahtzee;
  return lowerSectionScore;
}
