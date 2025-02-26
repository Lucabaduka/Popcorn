<?php

/*
*
* Popcorn: Lofi Bets to Chill and Watch the World Burn to
* Copyright 2025 Luca McGrath, MIT License
* https://github.com/Lucabaduka/Popcorn
*
* As might be obvious, this index file primarily handles all the
* routing that we'll need to interact with the site. Additionally,
* it is here that we establish variable shorthands for pages,
* parts, scripts, and universally needed variables like $op.
*
* We load the gears and forum SSI files here, but all other
* processing should take place in more specific php files.
*
*/

$version = "1.0.0";
$testing = False;  // Change to True to run locally

// These are our webhooks to push updates to. This may become dynamic
// and stored in the database late, but for now they are hard-coded
$webhooks = [

];

// Load any libraries of functions and classes we've prepared earlier
require("../Sources/Gears/gears.php");

// We are running in production
if (!$testing) {
  require("/var/www/calref/SSI.php"); // This is an absolute path to SMF's SSI

// We are testing locally
} else {
  $context["user"]["is_logged"] = True;
  $context["user"]["id"] = 1;
  $context["user"]["name"] = "Luca";
  $context["user"]["is_admin"] = True;
}

// Set up our log wall. Palisades, if you will
if (!$context["user"]["is_logged"]) {
  $logged   = False;
  $op["id"] = 0;
} else {
  $logged = True;
  $op     = get_operator($pdo, $context);
}

// Setting up shorthand
$gears   = dirname(__DIR__, 1) . "/Sources/Gears/";
$pages   = dirname(__DIR__, 1) . "/Sources/Templates/Pages/";
$parts   = dirname(__DIR__, 1) . "/Sources/Templates/Parts/";
$errors  = dirname(__DIR__, 1) . "/Sources/Data/error.log";

// In any given page, we will assume we do not need a toast
// but we will prepare to change that if necessary.
$status = 0;
$snacks = "";

// Handle the routing to our blessed site
$request = $_SERVER["REQUEST_URI"];

switch ($request) {
  case "":
  case "/":
    include $pages . "main.php";
    break;

    // Check someone is actually an admin before providing this page
    case "/admin":

    // Logged only
    if (!$logged) {
      include $pages . "login.php";
      break;
    }

    if ($context["user"]["is_admin"]) {
      include $pages . "admin.php";
    } else {
      http_response_code(403);
      include $parts . "403.php";
    }
    break;

  // Run a basic check that they're not navigating to the bet page directly
  case "/bet":

    // Logged only
    if (!$logged) {
      include $pages . "login.php";
      break;
    }

    if (isset($_POST["bet_request"]) || (isset($_POST["bid"]) && isset($_POST["bet_request"]))) {
      include $pages . "bet.php";
    } else {
      include $pages . "main.php";
    }
    break;

  case "/login":

    // Conversely, if we are already logged in, just go to main
    if ($logged) {
      include $pages . "main.php";
      break;
    }
    include $pages . "login.php";
    break;

  case "/records":
    include $pages . "records.php";
    break;

  // Check someone is actually an admin before providing this page as well
  case "/resolve":

    // Logged only
    if (!$logged) {
      include $pages . "login.php";
      break;
    }

    if ($context["user"]["is_admin"] && isset($_POST["resolve_issue"])) {
      include $pages . "resolve.php";
    } else {
      http_response_code(403);
      include $parts . "403.php";
    }
    break;

  case "/suggest":

    // Logged only
    if (!$logged) {
      include $pages . "login.php";
      break;
    }

    include $pages . "suggest.php";
    break;

  // Provide a 404 response for all url params we don't understand
  default:
    http_response_code(404);
    include $parts . "404.php";
}

?>