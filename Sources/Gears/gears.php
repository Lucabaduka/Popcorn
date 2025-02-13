<?php

/*
*
* Popcorn: Lofi Bets to Chill and Watch the World Burn to
* Copyright 2025 Luca McGrath, MIT License
* https://github.com/Lucabaduka/Popcorn
*
* This file contains all the functions and objects used by Tart in other areas
*
*/

// Create and/or connect to the database
$dbname = dirname(__DIR__, 1) . "/Data/pop.db";
if (!file_exists($dbname)) {
  db_build($dbname);
}
$pdo = new PDO("sqlite:$dbname");

// Creates the database and its typical schema
// Called if the database does not exist
// This should ideally only happen once
function db_build($dbname) {
  $pdo = new PDO("sqlite:$dbname");
  $statements = array(
    "CREATE TABLE IF NOT EXISTS operators (id INTEGER, pdn TEXT, bal INTEGER, staked INTEGER, active JSON);",
    "CREATE TABLE IF NOT EXISTS topics (id INTEGER PRIMARY KEY, cat TEXT, question TEXT, context TEXT, options JSON, ends INTEGER, result INTEGER, resolution TEXT);",
    "CREATE TABLE IF NOT EXISTS bets (topic INTEGER, tally JSON, pool INTEGER, bets JSON);",
    "CREATE TABLE IF NOT EXISTS ideas (id INTEGER PRIMARY KEY, operator TEXT, idea TEXT, delivery TEXT);"
  );

  foreach($statements as $statement){
    $pdo->exec($statement);
  }

  $pdo = null;
}


// Function to reduce a fraction to its lowest form
// NOTE TO LUCA, VALUES NEED TO BE ROUNDED
function reduceFraction($x, $y)
{
    $d;
    $d = __gcd($x, $y);

    $x = $x / $d;
    $y = $y / $d;

    echo("x = " . $x . ", y = " . $y);
}

function __gcd($a, $b)
{
    if ($b == 0)
        return $a;
    return __gcd($b, $a % $b);

}

$blues_lib   = ["CornflowerBlue", "DarkSlateBlue", "RoyalBlue", "DodgerBlue",    "LightSeaGreen"];
$reds_lib    = ["Crimson",        "DarkMagenta",   "FireBrick", "Maroon",        "MediumVioletRed"];
$greens_lib  = ["DarkGreen",      "ForestGreen",   "Green",     "MediumSeaGreen","SeaGreen"];
$yellows_lib = ["GoldenRod",      "Gold",          "Yellow",    "Khaki",         "PaleGoldenRod"];
$purples_lib = ["MediumPurple",   "BlueViolet",    "Indigo",    "DarkViolet",    "RebeccaPurple"];

function pluralise ($array) {
  if ($array != 1 and $array != -1) {
    return "s";
  } else {
    return "";
  }
}
?>