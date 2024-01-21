<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Hangman The Game</title>
    <link rel="stylesheet" href="./styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Roboto:wght@100;400&display=swap"
        rel="stylesheet">
</head>

<body>

    <?php
    include 'game_logic.php';

    $guess = getCurrentWord();
    ?>

    <div class="game-container">

        <div class="img-container">
            <h1>Hangman the Game - Friendly version 🎈</h1>
            <img src="<?php echo getCurrentPart(); ?>" />

            <?php if (gameComplete()) : ?>
            <h1 class="game-complete">GAME COMPLETED</h1>
            <?php endif; ?>
            <?php if ($WON && gameComplete()) : ?>
            <p class="win-txt">Yay, YOU WON! 🎉</p>
            <?php elseif (!$WON && gameComplete()) : ?>
            <p class="lost-txt">Oh no, YOU LOST! 😔 <br>The correct word was:
                <?php echo getCurrentWord(); ?></p>
            <?php endif; ?>

        </div>

        <div class="guess-word-container">
            <?php displayGuessedWord(); ?>
        </div>

        <div class="keys-container">
            <div>
                <form method="get">
                    <?php displayKeyboardButtons(); ?>
                    <br><br>
                    <button class="submit-btn" type="submit" name="start">Restart Game</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>