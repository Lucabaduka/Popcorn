<?php

/*
*
* Popcorn: Lofi Bets to Chill and Watch the World Burn to
* Copyright 2025 Luca McGrath, MIT License
* https://github.com/Lucabaduka/Popcorn
*
* This page allows an operator to login via the SMF forum's
* SSI integration without leaving the Popcorn site. The
* link to login is only available through the menu and nav
* parts if the operator is not already logged in.
*
*/

?>

<!DOCTYPE html>
<html data-theme="dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Popcorn: Lofi Bets to Chill and Watch the World Burn to. Check out what fucked up things are or may happen in the future, and make in-game 'planets' on how you think they will progress.">
    <meta name="theme-color" content="#25ac25">
    <meta property="og:image" content="/Static/Assets/logo.png">
    <link rel="icon" type="image/x-icon" href="/Static/favicon.ico">
    <link rel="stylesheet" href="/Static/bulma.css" type="text/css">
    <link rel="stylesheet" href="/Static/pop.css" type="text/css">
    <title>Popcorn | Log In</title>
  </head>
<body>

<div class="hero is-fullheight">


  <!-- Nav Bar -->
  <?php include $parts . "nav.php"; ?>

  <!-- Menu Panel -->
  <?php include $parts . "menu.php"; ?>

  <!-- Content -->
  <div class="container hero-body mclear py-4">
    <div class="login">

      <div class="bar">
        <h1 class="title is-4">Log In</h1>
      </div>
      <div class="p-2">
        <div class="info center mx-2 my-4">
          <p>
            You need to be signed in with a CalRef account to use Popcorn. Login here or through the forum.
          </p>
        </div>
        <?php ssi_login(); ?>
        <hr>
        <div class="center">
          <a href="https://forum.calref.ca/index.php?action=reminder">Forgot your password?</a>
        </div>
      </div>

    </div>
  </div>

  <!-- Footer -->
  <?php include $parts . "footer.php"; ?>

</div>

</body>
</html>