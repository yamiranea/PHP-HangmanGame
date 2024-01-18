<?php
$words = ["zapallo", "pera", "manzana"];

$word = $words[array_rand($words)];

echo $word;

$wordLength = strlen($word);

for ($i = 1; $i <= $wordLength; $i++) {
    echo "_ ";
}