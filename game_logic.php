<?php
session_start();

$WON = false;

$words = file("words.txt", FILE_IGNORE_NEW_LINES);

$bodyParts = ["gameImg_0.png", "gameImg_1.png", "gameImg_2.png", "gameImg_3.png", "gameImg_4.png", "gameImg_5.png", "gameImg_6.png", "gameImg_7.png", "gameImg_8.png"];

function getCurrentPicture($part)
{
    return "img/" . $part;
}

function startGame()
{
}

function restartGame()
{
    session_destroy();
    session_start();
}

function getParts()
{
    global $bodyParts;
    return isset($_SESSION["parts"]) ? $_SESSION["parts"] : $bodyParts;
}

function addPart()
{
    $parts = getParts();
    array_shift($parts);
    $_SESSION["parts"] = $parts;
}

function getCurrentPart()
{
    $parts = getParts();
    return getCurrentPicture($parts[0]);
}

function getCurrentWord()
{
    global $words;
    if (!isset($_SESSION["word"]) || empty($_SESSION["word"])) {
        $key = array_rand($words);
        $_SESSION["word"] = strtoupper($words[$key]);
    }
    return $_SESSION["word"];
}

function getCurrentResponses()
{
    return isset($_SESSION["responses"]) ? $_SESSION["responses"] : [];
}

function addResponse($letter)
{
    $responses = getCurrentResponses();
    array_push($responses, $letter);
    $_SESSION["responses"] = $responses;
}

function isLetterCorrect($letter)
{
    $word = getCurrentWord();
    $max = strlen($word) - 1;
    for ($i = 0; $i <= $max; $i++) {
        if ($letter == $word[$i]) {
            return true;
        }
    }
    return false;
}

function isWordCorrect()
{
    $guess = getCurrentWord();
    $responses = getCurrentResponses();
    $max = strlen($guess) - 1;
    for ($i = 0; $i <= $max; $i++) {
        if (!in_array($guess[$i],  $responses)) {
            return false;
        }
    }
    return true;
}

function isBodyComplete()
{
    $parts = getParts();
    if (count($parts) <= 1) {
        return true;
    }
    return false;
}


function gameComplete()
{
    return isset($_SESSION["gamecomplete"]) ? $_SESSION["gamecomplete"] : false;
}

function markGameAsComplete()
{
    $_SESSION["gamecomplete"] = true;
}

function markGameAsNew()
{
    $_SESSION["gamecomplete"] = false;
}

if (isset($_GET['start'])) {
    restartGame();
}

if (isset($_GET['kp'])) {
    $currentPressedKey = isset($_GET['kp']) ? $_GET['kp'] : null;
    if (
        $currentPressedKey
        && isLetterCorrect($currentPressedKey)
        && !isBodyComplete()
        && !gameComplete()
    ) {
        addResponse($currentPressedKey);
        if (isWordCorrect()) {
            $WON = true;
            markGameAsComplete();
        }
    } else {
        if (!isBodyComplete()) {
            addPart();
            if (isBodyComplete()) {
                markGameAsComplete();
            }
        } else {
            markGameAsComplete();
        }
    }
}