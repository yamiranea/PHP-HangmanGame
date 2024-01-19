<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Hangman The Game</title>
</head>

<body style="background: deepskyblue">

    <?php
    include 'game_logic.php';

    $guess = getCurrentWord();
    ?>

    <div style="margin: 0 auto; background: #dddddd; width:900px; height:900px; padding:5px; border-radius:3px;">

        <div style="display:inline-block; width: 500px; background:#fff;">
            <img style="width:80%; display:inline-block;" src="<?php echo getCurrentPart(); ?>" />

            <?php if (gameComplete()) : ?>
            <h1>GAME COMPLETE</h1>
            <?php endif; ?>
            <?php if ($WON && gameComplete()) : ?>
            <p style="color: darkgreen; font-size: 25px;">You Won! HURRAY! :)</p>
            <?php elseif (!$WON && gameComplete()) : ?>
            <p style="color: darkred; font-size: 25px;">You LOST! OH NO! :( <br>The correct word was:
                <?php echo getCurrentWord(); ?></p>
            <?php endif; ?>

        </div>

        <div style="float:right; display:inline; vertical-align:top;">
            <h1>Hangman the Game</h1>
            <div style="display:inline-block;">
                <form method="get">
                    <?php
                    $letters = range('A', 'Z');
                    foreach ($letters as $letter) {
                        echo "<button type='submit' name='kp' value='$letter'>$letter</button>";
                        if ($letter % 7 == 0 && $letter > 0) {
                            echo '<br>';
                        }
                    }
                    ?>
                    <br><br>
                    <button type="submit" name="start">Restart Game</button>
                </form>
            </div>
        </div>

        <div style="margin-top:20px; padding:15px; background: lightseagreen; color: #fcf8e3">
            <?php
            $maxLetters = strlen($guess) - 1;
            for ($j = 0; $j <= $maxLetters; $j++) :
                $l = $guess[$j];
            ?>
            <?php if (in_array($l, getCurrentResponses())) : ?>
            <span style="font-size: 35px; border-bottom: 3px solid #000; margin-right: 5px;"><?php echo $l; ?></span>
            <?php else : ?>
            <span style="font-size: 35px; border-bottom: 3px solid #000; margin-right: 5px;">&nbsp;&nbsp;&nbsp;</span>
            <?php endif; ?>
            <?php endfor; ?>
        </div>

    </div>

</body>

</html>