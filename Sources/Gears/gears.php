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
function get_operator($pdo, $context) {

  // Check if the operator's profile is in the operators table
  $query = $pdo->prepare("SELECT * FROM operators WHERE id = (?)");
  $query->execute(array($context["user"]["id"]));
  $result = $query->fetchAll();

  // if not, then we need to create it with values from the forum and 25,000 planets
  if (count($result) < 1) {
    $dummy = array(
      "id"     => $context["user"]["id"],
      "pdn"    => $context["user"]["name"],
      "bal"    => 25000,
      "staked" => 0
    );
    $order = $pdo->prepare("INSERT INTO operators ('id', 'pdn', 'bal', 'staked') VALUES (?, ?, ?, ?)");
    $order->execute([$dummy["id"], $dummy["pdn"], $dummy["bal"], $dummy["staked"]]);
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

// Function to pull all the bets of an issue from the database and commit it to an array
// Called in places like bet.php and resolve.php to prepare forms and handle resolutions
// Always returns an array of bets. The array will be empty if there are no bets or the ID is invalid
function get_bets($pdo, $id) {

  $x = 0;
  $bets = array();
  $query =  "SELECT * FROM bets WHERE topic = $id";
  foreach ($pdo->query($query) as $bet) {
    $bets[$x] = $bet;
    $x++;
  }
  if (!$bets) {
    $bets = array();
  }

  return $bets;
}

// Function to get the record of how much an operator has received from a previously successful bet
// Called in records.php when generating its main table
// Returns a string of the formatted int payout, if there is one, or an empty string if there's not
function get_payout($pdo, $issue_id, $operator) {
  $query =  "SELECT * FROM payouts WHERE topic = $issue_id AND operator = $operator";
  $result = $pdo->query($query)->fetch(PDO::FETCH_ASSOC);

  if (!$result) {
    $payout = "";
  } else {
    $payout = "<code class=\"has-text-success\">" . number_format($result["payout"]) . "</code>";
  }

  return $payout;
}

// Function to take form data from the admin page and insert a new issue to the database
// Called in admin.php when the issue modal closes via the submit button
// Returns a 0 on success or a 1 on failure
function new_issue($pdo, $issue_data) {

  // We can't require fields in this modal because of how we handle modals in general
  // Therefore we will simply validate the form here in the backend.
  $required = ["question", "context", "category", "date_end"];
  foreach ($required as $requirement) {
    if (!isset($issue_data[$requirement]) || $issue_data[$requirement] === "") return 1;
  }

  // Default unset hours to midnight
  if (strlen($issue_data["time_end"]) < 1) $issue_data["time_end"] = "00:00";

  // Translate the datetime input to unix
  $issue_data["ends"] = strtotime($issue_data["date_end"] . " " . $issue_data["time_end"] . ":00");

  // By default, all options will have a colour set from the select, so we must exclude any that don't have a name
  foreach ($issue_data["options"] as $entry) {
    if (strlen($entry["text"]) > 0) $issue_data["c_options"][] = $entry;
  }

  // We presume all is well at this point.
  $issue = array(
    NULL,                                  // id INTEGER PRIMARY KEY
    $issue_data["category"],               // cat TEXT
    $issue_data["question"],               // question TEXT
    $issue_data["context"],                // context TEXT
    json_encode($issue_data["c_options"]), // options JSON
    $issue_data["ends"],                   // ends INTEGER
    0,                                     // result INTEGER (0: current, 1: pending, 2: finished, 3: refunded)
    "",);                                  // resolution TEXT (what admin writes to describe the outcome)

  $order = $pdo->prepare("INSERT INTO topics ('id', 'cat', 'question', 'context', 'options', 'ends', 'result', 'resolution')
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
  $order->execute($issue);

  // In the future, we could also return $pdo->lastInsertId() to get the auto-incremented ID
  return 0;
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

// Function to commit a new bet for an issue to the database, including the operator's active tally
// Called on the bet.php page when submitting its form.
// Returns 0 on success or 1 on failure
function new_bet($pdo, $op, $data, $issue) {

  // Firstly is the bid a number?
  if (!is_numeric($data["bid"])) {
    return 1;
  }

  // Second, is the bid a valid option
  $pass = False;
  $options = json_decode($issue["options"], True);
  foreach($options as $key=>$val) {
    if(is_array($val) && in_array($data["option"], $val)) {
      $pass = True;
    }
  } if (!$pass) {
    return 1;
  }

  // Finally, make sure that the bid is not somehow over the operator's maximum
  if ($data["bid"] > $op["max"]) {
    return 1;
  }

  // We are probably clear at this point to start updating the db
  // First commit the item to the bets table
  $bet = array($issue["id"], $op["id"], $data["option"], $data["bid"]);
  $order = $pdo->prepare("INSERT INTO bets ('topic', 'operator', 'opinion', 'volume') VALUES (?, ?, ?, ?)");
  $order->execute($bet);

  // Let's not forget to add to the operator's staked
  $op["staked"] += $data["bid"];

  // We'll need to immediately call get_operator on success here to get the new values
  $order = $pdo->prepare("UPDATE operators SET staked = (?) WHERE id = (?)");
  $order->execute([$op["staked"], $op["id"]]);

  // Return success
  return 0;
}

?>