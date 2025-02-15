<?php

$version = "0.1.0";

// Testing
$user_info["groups"] = array(9);
$context["user"]["is_logged"] = true;
$context["user"]["id"] = 1;
$context["user"]["name"] = "Luca";
$context["user"]["is_admin"] = true;

// Load any libraries of functions and classes we've prepared earlier
require("../Sources/Gears/gears.php");

// Setting up shorthand
$gears   = dirname(__DIR__, 1) . "/Sources/Gears/";
$pages   = dirname(__DIR__, 1) . "/Sources/Templates/Pages/";
$parts   = dirname(__DIR__, 1) . "/Sources/Templates/Parts/";
$errors  = dirname(__DIR__, 1) . "/Sources/Data/error.log";
$scripts = "/Static/Scripts/";

// In any given page, we will assume we do not need a toast
// but we will prepare to change that if necessary.
$status = 0;
$snacks = "";

$op = get_operator($pdo, $context);

// Handle the routing to our blessed site
$request = $_SERVER["REQUEST_URI"];

switch ($request) {
  case "":
  case "/":
    include $pages . "main.php";
    break;
  case "/admin":

    // Check that they're actually an admin first
    if ($context["user"]["is_admin"]) {
      include $pages . "admin.php";
    } else {
      include $parts . "403.php";
    }
    break;
  case "/bets":
    include $pages . "bets.php";
    break;
  case "/archives":
    include $pages . "archives.php";
    break;
  case "/suggest":
    include $pages . "suggest.php";
    break;

  default:
    http_response_code(404);
    include $parts . "404.php";
}



?>