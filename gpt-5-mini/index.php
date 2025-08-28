<?php
// Einfaches PHP-Frontend für ein Tetris-ähnliches Spiel
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tetris-ähnlich — gpt-5-mini</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="game-container">
        <h1>Tetris-ähnliches Spiel</h1>
        <div id="score">Punkte: 0</div>
        <div id="game-board" aria-label="Spielfeld"></div>
        <div id="controls">
            <button id="start-btn">Start</button>
            <button id="pause-btn">Pause</button>
        </div>
        <p class="hint">Steuerung: Pfeiltasten (← → ↓) und Hoch (↑) zum Drehen.</p>
    </div>
    <script src="script.js"></script>
</body>
</html>
