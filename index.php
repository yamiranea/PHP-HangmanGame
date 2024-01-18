<?php
$words = file("words.txt");

$word = rtrim($words[array_rand($words)]);

echo $word;
echo "<br>";

$wordLength = strlen($word);
echo $wordLength;
echo "<br>";

$guesses = ["a", "e", "i"];

for ($i = 0; $i < $wordLength; $i++) {
    if (in_array($word[$i], $guesses)) {
        echo $word[$i];
    } else {
        echo "_";
    }
    echo " ";
}