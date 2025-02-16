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

// A function to retrieve the operator's profile
// Called whenever any page on Popcorn is loaded
// Returns an array of the Operators table based on ID
function get_operator ($pdo, $context) {

  // Check if the operator's profile is in the operators table
  $query = $pdo->prepare("SELECT * FROM operators WHERE id = (?)");
  $query->execute(array($context["user"]["id"]));
  $result = $query->fetchAll();

  // if not, then we need to create it with values from the forum and 25,000 planets
  if (count($result) < 1) {
    $dummy = array($context["user"]["id"], $context["user"]["name"], 25000, 0, json_encode(array()));
    $order = $pdo->prepare("INSERT INTO operators ('id', 'pdn', 'bal', 'staked', 'active') VALUES (?, ?, ?, ?, ?)");
    $order->execute($dummy);
    $result[0] = $dummy;
  }

  // Determine the maximum bet size between what's available
  // A player must always be able to make at least a 5,000  planet bet
  if (($result[0]["bal"] - $result[0]["staked"]) < 5000) {
    $max_bet = 5000;
  } else {
    $max_bet = ($result[0]["bal"] - $result[0]["staked"]);
  }

  // Compress them all of our data into a more tidy function
  $operator = array(
    "id"     => $result[0]["id"],
    "pdn"    => $result[0]["pdn"],
    "bal"    => $result[0]["bal"],
    "staked" => $result[0]["staked"],
    "max"    => $max_bet
  );

  return $operator;

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