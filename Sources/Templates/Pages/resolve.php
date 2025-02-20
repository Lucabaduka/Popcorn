<?php

/*
*
* Popcorn: Lofi Bets to Chill and Watch the World Burn to
* Copyright 2025 Luca McGrath, MIT License
* https://github.com/Lucabaduka/Popcorn
*
* This page allows an admin to edit an current issue or to
* resolve a current / pending issue and deliver a payout
* for all operators who turned in a bet with the winning
* option.
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
    <title>Popcorn | <?=$title?></title>
  </head>
<body>

<div class="hero is-fullheight">


  <!-- Nav Bar -->
  <?php include $parts . "nav.php"; ?>

  <!-- Menu Panel -->
  <?php include $parts . "menu.php"; ?>

  <!-- Content -->
  <div class="container hero-body mclear py-4">
    <div class="notification">
      <h1 class="title"><?=$title?></h1>
      <h2 class="subtitle is-7"><?=$subtitle?></h2>
      <div class="content is-primary">
        <p>
          <?=$text?>
        </p>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php include $parts . "footer.php"; ?>

</div>

</body>
</html>