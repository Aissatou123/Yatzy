// Aïssatou Kangou Diome, 300139476
//ce fichier contient un état d'un jeu de Yatzy


let player1Score=[];
let player2Score=[];
let player1Dice=[];
let player2Dice=[];
let rollCount=0;
let roundCount=0;
let onlyPossibleRow="blank";
let jokerCard=false;
let isPlayerOneTurn=true;
let transformValues=[
[0,30],[-5,40],[0,35],[5,40],[0,30]
];
const player1Container=document.getElementById("player1Container");
const player2Container=document.getElementById("player2Container");
function writeTempValuesInScoreTable(dice) {
  let scoreTable = [];
  scoreTable = player1Score.slice();
  let playerNumber = 1;
  if (!isPlayerOneTurn) {
    scoreTable = [];
    playerNumber = 2;
    scoreTable = player2Score.slice();
  }
  jokerCard=false;
  onlyPossibleRow="blank";
  let yahtzeeScore=calculateYahtzee(dice);
  const yahtzeeElement=document.getElementById("yahtzee"+playerNumber);
  if(scoreTable[12]===undefined){
    yahtzeeElement.innerHTML=yahtzeeScore;
  } else if(yahtzeeScore>0 && scoreTable[12]) {
    yahtzeeScore=parseInt(yahtzeeElement.innerHTML)+100;
    yahtzeeElement.innerHTML=yahtzeeScore;
  }
  if(yahtzeeScore>0 && scoreTable[dice[0]-1]!=undefined && scoreTable[12]!==undefined){
    jokerCard=true;
  }
  if(yahtzeeScore>0 && scoreTable[dice[0]-1]==undefined && scoreTable[12]!==undefined){
    onlyPossibleRow=dice[0];
    writeTempValueOnOnlyPossibleRaw(dice,playerNumber);
    return;
  }
  //------------------------------------------------------------
  if (scoreTable[0] === undefined) {
    let onesScore = calculateOnes(dice);
    document.getElementById("ones" + playerNumber).innerHTML = onesScore;
  }
  if (scoreTable[1] === undefined) {
    let twosScore = calculateTwos(dice);
    document.getElementById("twos" + playerNumber).innerHTML = twosScore;
  }
  if (scoreTable[2] === undefined) {
    let threesScore = calculateThrees(dice);
    document.getElementById("threes" + playerNumber).innerHTML = threesScore;
  }
  if (scoreTable[3] === undefined) {
    let foursScore = calculateFours(dice);
    document.getElementById("fours" + playerNumber).innerHTML = foursScore;
  }
  if (scoreTable[4] === undefined) {
    let fivesScore = calculateFives(dice);
    document.getElementById("fives" + playerNumber).innerHTML = fivesScore;
  }
  if (scoreTable[5] === undefined) {
    let sixesScore = calculateSixes(dice);
    document.getElementById("sixes" + playerNumber).innerHTML = sixesScore;
  }
  if (scoreTable[6] === undefined) {
    let threeOfAKindScore = calculateThreeOfAKind(dice);
    document.getElementById("threeOfAKind" + playerNumber).innerHTML =
      threeOfAKindScore;
  }
  if (scoreTable[7] === undefined) {
    let fourOfAKindScore = calculateFourOfAKind(dice);
    document.getElementById("fourOfAKind" + playerNumber).innerHTML =
      fourOfAKindScore;
  }
  if (scoreTable[8] === undefined) {
    let fullHouseScore = calculateFullHouse(dice);
    document.getElementById("fullHouse" + playerNumber).innerHTML =
      fullHouseScore;
  }
  if (scoreTable[9] === undefined) {
    let smallStraightScore = jokerCard ? 30: calculateSmallStraight(dice);
    document.getElementById("smallStraight" + playerNumber).innerHTML =
      smallStraightScore;
  }
  if (scoreTable[10] === undefined) {
    let largeStraightScore = jokerCard ? 40 : calculateLargeStraight(dice);
    document.getElementById("largeStraight" + playerNumber).innerHTML =
      largeStraightScore;
  }
  if (scoreTable[11] === undefined) {
    let chanceScore = calculateChance(dice);
    document.getElementById("chance" + playerNumber).innerHTML = chanceScore;
  }
}

function writeTempValueOnOnlyPossibleRaw(dice,playerNumber) {
  if(dice[0]==1) {
    let score=calculateOnes(dice);
    document.getElementById("ones"+playerNumber).innerHTML=score;
  }
  if(dice[0]==2) {
    let score=calculateTwos(dice);
    document.getElementById("twos"+playerNumber).innerHTML=score;
  }
  if(dice[0]==3) {
    let score=calculateThrees(dice);
    document.getElementById("threes"+playerNumber).innerHTML=score;
  }
  if(dice[0]==4) {
    let score=calculateFours(dice);
    document.getElementById("fours"+playerNumber).innerHTML=score;
  }
  if(dice[0]==5) {
    let score=calculateFives(dice);
    document.getElementById("fives"+playerNumber).innerHTML=score;
  }
  if(dice[0]==6) {
    let score=calculateSixes(dice);
    document.getElementById("sixes"+playerNumber).innerHTML=score;
  }
}

scoreTableCells.forEach(function(cell){
  cell.addEventListener("click",onCellClick);
});
function onCellClick(){
  let row=this.getAttribute("data-row");
  let column=this.getAttribute("data-column");
  if(
    rollCount==0 ||
    row===null ||(onlyPossibleRow!="blank" && row!=onlyPossibleRow)
  ) return;
  if(isPlayerOneTurn && column==1){
    player1Score[row-1]=parseInt(this.innerHTML);
    let upperSectionScore1=calculateUpperSection(player1Score);
    let bonusScore1=upperSectionScore1>63 ? 35 : 0;
    let lowerSectionScore1=calculateLowerSectionScore(player1Score);
    let totalScore1=upperSectionScore1+lowerSectionScore1+bonusScore1;
    sum1.innerHTML=upperSectionScore1;
    bonus1.innerHTML=bonusScore1;
    total1.innerHTML=totalScore1;
    this.removeEventListener("click",onCellClick);
    this.style.color="green";
    sum1.style.color="green";
    bonus1.style.color="green";
    total1.style.color="green";
    changeTurn();
  }
  if(!isPlayerOneTurn && column==2){
    player2Score[row-1]=parseInt(this.innerHTML);
    let upperSectionScore2=calculateUpperSection(player2Score);
    let bonusScore2=upperSectionScore2>63 ? 35 : 0;
    let lowerSectionScore2=calculateLowerSectionScore(player2Score);
    let totalScore2=upperSectionScore2+lowerSectionScore2+bonusScore2;
    sum2.innerHTML=upperSectionScore2;
    bonus2.innerHTML=bonusScore2;
    total2.innerHTML=totalScore2;
    this.removeEventListener("click",onCellClick);
    this.style.color="green";
    sum2.style.color="green";
    bonus2.style.color="green";
    total2.style.color="green";
    changeTurn();
  }
}

function changeTurn(){
  roundCount++;
  updateScoreTable();
  resetDiceFaces();
  isPlayerOneTurn=!isPlayerOneTurn;
  rollCount=0;
  if(isPlayerOneTurn){
    const player2ContainerDice=player2Container.querySelectorAll(".dice");
    player2ContainerDice.forEach((diceElement)=> {
      diceElement.style.transform="none";
      player2Container.removeChild(diceElement);
      player1Container.appendChild(diceElement);
    });
  }else {
    const player1ContainerDice=player1Container.querySelectorAll(".dice");
    player1ContainerDice.forEach((diceElement)=> {
      diceElement.style.transform="none";
      player1Container.removeChild(diceElement);
      player2Container.appendChild(diceElement);
    });
}
  if(roundCount==26)  {
    calculateEndGameScore();
    return;
  }
  rollButton.disabled=false;
  rollButton.style.opacity=1;
}
function updateScoreTable(){
  let scoreTable=[];
  scoreTable=player1Score.slice();
  let column =1 ;
  if(!isPlayerOneTurn) {
    scoreTable=[];
    scoreTable=player2Score.slice();
    column=2;
  }
  let scoreCells=document.querySelectorAll('[data-column="'+column+'"]');
  for (let i=0;i<scoreCells.length;i++) {
    if(scoreTable[i]===undefined) {
      scoreCells[i].innerHTML="";
    }
  }
}

function calculateEndGameScore() {
  let player1Total=parseInt(document.getElementById("total1").innerHTML);
  let player2Total=parseInt(document.getElementById("total2").innerHTML);
  const endGameMessage=player1Total==player2Total ? "Draw" : player1Total>player2Total ? "Player1 Wins" : "Player2 Wins";
  document.getElementById("endGameMessage").innerHTML=endGameMessage;
  rollButton.disabled=true;
  rollButton.style.opacity=0.5;

}
