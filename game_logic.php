<?php
session_start();

$WON = false;

$words = file("words.txt", FILE_IGNORE_NEW_LINES); // Lee las palabras desde el archivo

// Live variables here

// ALl the body parts
$bodyParts = ["gameImg_0.png", "gameImg_1.png", "gameImg_2.png", "gameImg_3.png", "gameImg_4.png", "gameImg_5.png", "gameImg_6.png", "gameImg_7.png", "gameImg_8.png"];

function getCurrentPicture($part)
{
    return "img/" . $part;
}

function startGame()
{
}

// restart the game. Clear the session variables
function restartGame()
{
    session_destroy();
    session_start();
}

// Get all the hangman Parts
function getParts()
{
    global $bodyParts;
    return isset($_SESSION["parts"]) ? $_SESSION["parts"] : $bodyParts;
}

// add part to the Hangman
function addPart()
{
    $parts = getParts();
    array_shift($parts);
    $_SESSION["parts"] = $parts;
}

// get Current Hangman Body part
function getCurrentPart()
{
    $parts = getParts();
    return getCurrentPicture($parts[0]);
}

// get the current words
function getCurrentWord()
{
    global $words;
    if (!isset($_SESSION["word"]) || empty($_SESSION["word"])) {
        $key = array_rand($words);
        $_SESSION["word"] = strtoupper($words[$key]);
    }
    return $_SESSION["word"];
}

// user responses logic

// get user response
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

// check if pressed letter is correct
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

// is the word (guess) correct
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

// check if the body is ready to hang
function isBodyComplete()
{
    $parts = getParts();
    // is the current parts less than or equal to one
    if (count($parts) <= 1) {
        return true;
    }
    return false;
}

// manage game session

// is game complete
function gameComplete()
{
    return isset($_SESSION["gamecomplete"]) ? $_SESSION["gamecomplete"] : false;
}

// set game as complete
function markGameAsComplete()
{
    $_SESSION["gamecomplete"] = true;
}

// start a new game
function markGameAsNew()
{
    $_SESSION["gamecomplete"] = false;
}

/* Detect when the game is to restart. From the restart button press*/
if (isset($_GET['start'])) {
    restartGame();
}

/* Detect when Key is pressed */
if (isset($_GET['kp'])) {
    $currentPressedKey = isset($_GET['kp']) ? $_GET['kp'] : null;
    // if the key press is correct
    if (
        $currentPressedKey
        && isLetterCorrect($currentPressedKey)
        && !isBodyComplete()
        && !gameComplete()
    ) {
        addResponse($currentPressedKey);
        if (isWordCorrect()) {
            $WON = true; // game complete
            markGameAsComplete();
        }
    } else {
        // start hanging the man :)
        if (!isBodyComplete()) {
            addPart();
            if (isBodyComplete()) {
                markGameAsComplete(); // lost condition
            }
        } else {
            markGameAsComplete(); // lost condition
        }
    }
}