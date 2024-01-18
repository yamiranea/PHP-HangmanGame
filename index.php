<?php

session_start();

if (!isset($_SESSION['word'])) {
    $words = file("words.txt");
    $word = rtrim(strtoupper($words[array_rand($words)]));
    $_SESSION['word'] = $word;
    $_SESSION['guesses'] = [];
    $_SESSION['lives'] = 6;
    if (!isset($_SESSION['gamesWon'])) {
        $_SESSION['gamesWon'] = 0;
    }
    if (!isset($_SESSION['gamesLost'])) {
        $_SESSION['gamesLost'] = 0;
    }
}
?>

<form method="post" action="">
    <select name="guess">
        <?php
        foreach (range('A', 'Z') as $letter) {
            echo '<option value = "' . strtoupper($letter) . '">' . strtoupper($letter) . '</option>';
        }
        ?>
    </select>
    <input type="submit" name="submit" value="GUESS">
</form>

<?php
for ($i = 0; $i < $wordLength; $i++) {
    if (in_array($word[$i], $guesses)) {
        echo $word[$i];
    } else {
        echo "_";
    }
    echo " ";
}