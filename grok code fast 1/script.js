const ROWS = 20;
const COLS = 10;
let board = [];
let currentPiece = null;
let score = 0;
let gameInterval = null;
let isPaused = false;

document.addEventListener('DOMContentLoaded', () => {
    initBoard();
    document.getElementById('start-btn').addEventListener('click', startGame);
    document.getElementById('pause-btn').addEventListener('click', pauseGame);
    document.addEventListener('keydown', handleKeyPress);
});

function initBoard() {
    const gameBoard = document.getElementById('game-board');
    gameBoard.innerHTML = '';
    board = Array.from({length: ROWS}, () => Array(COLS).fill(0));
    for (let r = 0; r < ROWS; r++) {
        for (let c = 0; c < COLS; c++) {
            const cell = document.createElement('div');
            cell.classList.add('cell');
            cell.dataset.row = r;
            cell.dataset.col = c;
            gameBoard.appendChild(cell);
        }
    }
}

function startGame() {
    if (gameInterval) clearInterval(gameInterval);
    initBoard();
    score = 0;
    updateScore();
    isPaused = false;
    spawnPiece();
    gameInterval = setInterval(gameLoop, 500);
}

function pauseGame() {
    isPaused = !isPaused;
    if (isPaused) {
        clearInterval(gameInterval);
    } else {
        gameInterval = setInterval(gameLoop, 500);
    }
}

function gameLoop() {
    if (isPaused) return;
    movePieceDown();
}

function spawnPiece() {
    const pieces = [
        [[1,1,1,1]], // I
        [[1,1],[1,1]], // O
        [[0,1,0],[1,1,1]], // T
        [[1,0,0],[1,1,1]], // J
        [[0,0,1],[1,1,1]], // L
        [[0,1,1],[1,1,0]], // S
        [[1,1,0],[0,1,1]]  // Z
    ];
    const randomPiece = pieces[Math.floor(Math.random() * pieces.length)];
    currentPiece = {
        shape: randomPiece,
        row: 0,
        col: Math.floor(COLS / 2) - Math.floor(randomPiece[0].length / 2)
    };
    if (!isValidMove(currentPiece)) {
        gameOver();
        return;
    }
    drawPiece();
}

function drawPiece() {
    clearBoard();
    for (let r = 0; r < currentPiece.shape.length; r++) {
        for (let c = 0; c < currentPiece.shape[r].length; c++) {
            if (currentPiece.shape[r][c]) {
                const cell = document.querySelector(`[data-row="${currentPiece.row + r}"][data-col="${currentPiece.col + c}"]`);
                if (cell) cell.classList.add('filled');
            }
        }
    }
}

function clearBoard() {
    document.querySelectorAll('.cell').forEach(cell => cell.classList.remove('filled'));
    for (let r = 0; r < ROWS; r++) {
        for (let c = 0; c < COLS; c++) {
            if (board[r][c]) {
                const cell = document.querySelector(`[data-row="${r}"][data-col="${c}"]`);
                if (cell) cell.classList.add('filled');
            }
        }
    }
}

function movePieceDown() {
    const newPiece = { ...currentPiece, row: currentPiece.row + 1 };
    if (isValidMove(newPiece)) {
        currentPiece = newPiece;
        drawPiece();
    } else {
        placePiece();
        clearLines();
        spawnPiece();
    }
}

function movePieceLeft() {
    const newPiece = { ...currentPiece, col: currentPiece.col - 1 };
    if (isValidMove(newPiece)) {
        currentPiece = newPiece;
        drawPiece();
    }
}

function movePieceRight() {
    const newPiece = { ...currentPiece, col: currentPiece.col + 1 };
    if (isValidMove(newPiece)) {
        currentPiece = newPiece;
        drawPiece();
    }
}

function rotatePiece() {
    const rotated = currentPiece.shape[0].map((_, index) =>
        currentPiece.shape.map(row => row[index]).reverse()
    );
    const newPiece = { ...currentPiece, shape: rotated };
    if (isValidMove(newPiece)) {
        currentPiece = newPiece;
        drawPiece();
    }
}

function isValidMove(piece) {
    for (let r = 0; r < piece.shape.length; r++) {
        for (let c = 0; c < piece.shape[r].length; c++) {
            if (piece.shape[r][c]) {
                const newRow = piece.row + r;
                const newCol = piece.col + c;
                if (newRow >= ROWS || newCol < 0 || newCol >= COLS || board[newRow][newCol]) {
                    return false;
                }
            }
        }
    }
    return true;
}

function placePiece() {
    for (let r = 0; r < currentPiece.shape.length; r++) {
        for (let c = 0; c < currentPiece.shape[r].length; c++) {
            if (currentPiece.shape[r][c]) {
                board[currentPiece.row + r][currentPiece.col + c] = 1;
            }
        }
    }
}

function clearLines() {
    for (let r = ROWS - 1; r >= 0; r--) {
        if (board[r].every(cell => cell === 1)) {
            board.splice(r, 1);
            board.unshift(Array(COLS).fill(0));
            score += 100;
            updateScore();
            r++; // Check the same row again
        }
    }
}

function updateScore() {
    document.getElementById('score').textContent = `Punkte: ${score}`;
}

function gameOver() {
    clearInterval(gameInterval);
    alert('Spiel vorbei! Punkte: ' + score);
}

function handleKeyPress(e) {
    if (isPaused) return;
    switch (e.key) {
        case 'ArrowLeft':
            movePieceLeft();
            break;
        case 'ArrowRight':
            movePieceRight();
            break;
        case 'ArrowDown':
            movePieceDown();
            break;
        case 'ArrowUp':
            rotatePiece();
            break;
    }
}
