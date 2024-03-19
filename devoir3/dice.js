// Aïssatou Kangou Diome, 300139476
//ce fichier contient les particularité de nos dés


//dice.js
const diceElements=document.querySelectorAll(".dice");
const rollButton = document.getElementById("roll");
const scoreTableCells=document.querySelectorAll(".cell");
rollButton.addEventListener("click",rollDice);
let rollSound=new Audio("roll.wav");
function rollDice() {
  rollCount++;
  let diceArr=[1,2,3,4,5];
  let randomDice=[];
  for (let i=0;i<diceArr.length;i++) {
    randomDice.push(Math.floor(Math.random()*6)+1);
  }
  const playArea=document.getElementById("playArea");
  const diceContainer=document.getElementById("player1Container");
  let numDice=diceContainer.children.length;
  let counter=0;
  diceElements.forEach(function(diceElement,index){
    if(diceElement.classList.contains("active")|| rollCount==1){
      resetDicePositions();
      const x = transformValues[index][0];
      const y = transformValues[index][1];

      setTimeout(function(){
        counter++;
        changeDiePosition(diceElement,x,y);
        changeDiceFaces(randomDice);
      
        if(counter==1) {
          if (isPlayerOneTurn) writeTempValuesInScoreTable(player1Dice);
          else writeTempValuesInScoreTable(player2Dice);
       }
        if(rollCount==3){
          rollButton.disabled=true;
          rollButton.style.opacity=0.5;
        }
        rollSound.play();
      },500);
    }
  });

}
function resetDicePositions(){
  diceElements.forEach(function(diceElement){
    diceElement.style.transform="none";
  })
}
function changeDiePosition(diceElement,x,y){
  let angle=135*Math.floor(Math.random()*10);
  let diceRollDirection = -1;
  if(!isPlayerOneTurn) diceRollDirection=1;
  angle=135*Math.floor(Math.random()*10);
  diceElement.style.transform=
  "translateX("+
  x+"vw) translateY("+diceRollDirection*y+
  "vh) rotate(" + angle + "deg)";
}
function changeDiceFaces(randomDice) {
  for (let i=0; i < diceElements.length;i++) {
    if(rollCount ===1) diceElements[i].classList.add("active");
    if(diceElements[i].classList.contains("active")) {
      if(isPlayerOneTurn) player1Dice[i]=randomDice[i];
      else player2Dice[i]=randomDice[i];

      let face = diceElements[i].getElementsByClassName("face")[0];
      face.src="dice"+randomDice[i]+".png";
    }
  }
}
function resetDiceFaces() {
  for (let i=0;i<diceElements.length;i++){
    let face = diceElements[i].getElementsByClassName("face")[0];
    diceElements[i].classList.remove("active");
    let diceNumber=i+1;
    face.src="dice"+diceNumber+".png";
  }
}
diceElements.forEach(function(diceElement,index){
  diceElement.addEventListener("click",function(){
    if(rollCount==0) return;
    diceElement.classList.toggle("active");
    if(!diceElement.classList.contains("active")){
      diceElement.style.transform="none";      
    }
    else {
      const diceNumber=diceElement.id.charAt(3);
      const x = transformValues[diceNumber-1][0];
      const y = transformValues[diceNumber-1][1];
      changeDiePosition(diceElement,x,y);

    }
  })
})




