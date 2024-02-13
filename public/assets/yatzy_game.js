class YatzyGame {
    constructor() {
        this.turn = 0; 
        this.diceValues = [0, 0, 0, 0, 0]; 
        this.diceState = [false, false, false, false, false];
    }

    updateDiceState(newState) {
        this.diceState = newState;
    }
    updateDiceValues(newValues) {
        this.diceValues = newValues;
    }

    
}
module.exports = YatzyGame;
