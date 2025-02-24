<?php

/*
*
* Popcorn: Lofi Bets to Chill and Watch the World Burn to
* Copyright 2025 Luca McGrath, MIT License
* https://github.com/Lucabaduka/Popcorn
*
* This is the general class and function "brains" storage.
*
* Here we can keep anything that's used by multiple php files or
* things that index needs to handle in routine or fallback work.
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
    "CREATE TABLE IF NOT EXISTS operators (id INTEGER, pdn TEXT, bal INTEGER, staked INTEGER);",
    "CREATE TABLE IF NOT EXISTS topics (id INTEGER PRIMARY KEY, cat TEXT, question TEXT, context TEXT, options JSON, ends INTEGER, result INTEGER, resolution TEXT);",
    "CREATE TABLE IF NOT EXISTS bets (topic INTEGER, operator INTEGER, opinion TEXT, volume INTEGER);",
    "CREATE TABLE IF NOT EXISTS ideas (id INTEGER PRIMARY KEY, operator TEXT, idea TEXT, delivery TEXT);",
    "CREATE TABLE IF NOT EXISTS payouts (topic INTEGER, operator INTEGER, payout INTEGER);"
  );

  foreach($statements as $statement){
    $pdo->exec($statement);
  }

  $pdo = null;
}

// Set any issues whose end is before the current time to pending
$order = $pdo->prepare("UPDATE topics SET result = 1 WHERE ends < (?)");
$order->execute([time()]);

// A function to produce an "s" if a supplied array has multiple items or an empty string if it's not
// Expected to be called anywhere
// Returns a grammar-correct string to be concatinated to any other string
function pluralise ($array) {
  if ($array != 1) {
    return "s";
  } else {
    return "";
  }
}

// A function to retrieve the operator's profile
// Always called when a page is loaded
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

// Function to pull a requested issue by ID from the database and commit it to an array
// Called in places like bet.php and resolve.php to prepare forms
// Returns an array for the issue if it exists, or False if it doesn't ("big(int) if true")
function get_issue($pdo, $id) {
  $query =  "SELECT * FROM topics WHERE id = $id";
  $issue = $pdo->query($query)->fetch(PDO::FETCH_ASSOC);
  return $issue;
}

// Function to post an alert to all Discord webhook URLs alerting the presence of a new issue for betting
// Called in the admin.php file on creating a new issue if new_issue returns a success response
// Returns 0 for success or (presumably) dies
function push_new_issue($webhooks, $name, $cat) {

  // We will translate the category to an appropriate Discord embed sidebar
  $cat_colours = array(
    "admin"     => "8e0891",
    "economics" => "025b0c",
    "conflict"  => "910808",
    "sports"    => "ffbf00",
    "sapphire"  => "0087ff",
  );

  // Nowe we will construct the json object that will be sent to create the embed
  $json_data = json_encode([

    "username" => "Popcorn",
    "avatar_url" => "https://pop.calref.ca/Static/Assets/logo.png",
    "embeds" => [
      [
        "type" => "rich",
        "description" => "## [" . $name . "](https://pop.calref.ca/)",

        "url" => "https://pop.calref.ca",
        "color" => hexdec($cat_colours[$cat]),

        "author" => [
          "name" => "New " . ucwords($cat) . " Issue Available for Betting:",
          "icon_url" => "https://pop.calref.ca/Static/Assets/planet.png"
        ],
      ]
    ]

  ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

  // Post to all webhooks that we know about
  foreach ($webhooks as $webhook) {

    $ch = curl_init($webhook);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($ch);
    curl_close($ch);

  }

  return 0;
}

?>