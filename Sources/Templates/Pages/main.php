<?php

/*
*
* Popcorn: Lofi Bets to Chill and Watch the World Burn to
* Copyright 2025 Luca McGrath, MIT License
* https://github.com/Lucabaduka/Popcorn
*
* This is the main issue overview, showing everything that an
* operator can bid on, and handling filtering for narrowing
* that list down.
*
* It is the launch point for lodging bids via bid.php
*
*/

// Needs a case statement
$filter = "ends ASC";

// Load all current issues and committ them to category arrays
$all_issues = array("admin" => array(), "conflict" => array(), "economics" => array(), "spots" => array(), "sapphire" => array());
$query =  "SELECT * FROM topics WHERE result < 1 ORDER BY $filter;";
foreach ($pdo->query($query) as $issue) {
  switch ($issue["cat"]) {
    case "admin":
      $all_issues["admin"][count($all_issues["admin"])] = $issue;
      break;
    case "conflict":
      $all_issues["conflict"][count($all_issues["conflict"])] = $issue;
      break;
    case "economics":
      $all_issues["economics"][count($all_issues["economics"])] = $issue;
      break;
    case "sports":
      $all_issues["sports"][count($all_issues["sports"])] = $issue;
      break;
    case "sapphire":
      $all_issues["sapphire"][count($all_issues["sapphire"])] = $issue;
      break;
  }
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Popcorn: Lofi Bets to Chill and Watch the World Burn to. Check out what fucked up things are or may happen in the future, and make in-game 'planets' on how you think they will progress.">
    <meta name="theme-color" content="#25ac25">
    <meta property="og:image" content="/Static/Assets/logo.png">
    <meta id="status" data-values="<?=$status?>">
    <link rel="icon" type="image/x-icon" href="/Static/favicon.ico">
    <link rel="stylesheet" href="/Static/bulma.css" type="text/css">
    <link rel="stylesheet" href="/Static/pop.css" type="text/css">
    <title>Popcorn | Lofi Bets to Watch the World Burn to</title>
  </head>
  <body>

  <!-- Nav Bar -->
  <?php include $parts . "nav.php"; ?>

  <!-- Menu Panel -->
  <?php include $parts . "menu.php"; ?>

  <div class="container mclear py-4">

    <div class="notification">
      <div class="tags mb-0 has-addons is-pulled-right">
        <span class="tag px-2 is-dark is-size-7"><svg style="width:24px; height:auto; filter: invert();" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title>PHP</title><path d="M7.01 10.207h-.944l-.515 2.648h.838c.556 0 .97-.105 1.242-.314.272-.21.455-.559.55-1.049.092-.47.05-.802-.124-.995-.175-.193-.523-.29-1.047-.29zM12 5.688C5.373 5.688 0 8.514 0 12s5.373 6.313 12 6.313S24 15.486 24 12c0-3.486-5.373-6.312-12-6.312zm-3.26 7.451c-.261.25-.575.438-.917.551-.336.108-.765.164-1.285.164H5.357l-.327 1.681H3.652l1.23-6.326h2.65c.797 0 1.378.209 1.744.628.366.418.476 1.002.33 1.752a2.836 2.836 0 0 1-.305.847c-.143.255-.33.49-.561.703zm4.024.715l.543-2.799c.063-.318.039-.536-.068-.651-.107-.116-.336-.174-.687-.174H11.46l-.704 3.625H9.388l1.23-6.327h1.367l-.327 1.682h1.218c.767 0 1.295.134 1.586.401s.378.7.263 1.299l-.572 2.944h-1.389zm7.597-2.265a2.782 2.782 0 0 1-.305.847c-.143.255-.33.49-.561.703a2.44 2.44 0 0 1-.917.551c-.336.108-.765.164-1.286.164h-1.18l-.327 1.682h-1.378l1.23-6.326h2.649c.797 0 1.378.209 1.744.628.366.417.477 1.001.331 1.751zM17.766 10.207h-.943l-.516 2.648h.838c.557 0 .971-.105 1.242-.314.272-.21.455-.559.551-1.049.092-.47.049-.802-.125-.995s-.524-.29-1.047-.29z"/></svg></span>
        <span class="tag px-2 is-info is-size-7">v<?=$version?></span>
      </div>
      <h1 class="title">Popcorn</h1>
      <h2 class="subtitle is-6">Lofi Bets to Chill and Watch the World Burn to</h2>
      <div class="content is-primary">
        <p>
          Explore the bets below and wager what you think will happen in this unfathomably unstable world.
        </p>
      </div>

      <!-- Current Operator Balance and Max -->
      <article class="message is-info">
        <div class="message-body py-4">
          <div class="is-flex center-align" style="flex-wrap: wrap;">
            <p class="mx-2"><strong>Balance:</strong> <code><?=number_format($op["bal"])?></code></p>
            <p class="mx-2"><strong>Staked:</strong> <code><?=number_format($op["staked"])?></code></p>
            <p class="mx-2"><strong>Max Bet:</strong> <code><?=number_format($op["max"])?></code></p>
          </div>
        </div>
      </article>

    </div>

    <div class="is-flex mb-2 center-align">

      <fieldset class="mx-3">
      <legend class="is-size-7">Filters</legend>
        <div class="buttons center-align has-addons">
          <button class="button filter is-small">🟣 Administrative</button>
          <button class="button filter is-small">🔴 Conflict</button>
          <button class="button filter is-small">🟢 Economics</button>
          <button class="button filter is-small">🟡 Sports</button>
          <?php if (count($all_issues["sapphire"]) > 0) : ?>
            <button class="button filter is-small">🔵 Sapphire</button>
          <?php endif; ?>
        </div>
      </fieldset>

      <fieldset class="mx-3">
      <legend class="is-size-7">Sort By</legend>
        <div class="buttons center-align has-addons">
          <button class="button filter is-small">Name</button>
          <button class="button filter is-small">Category</button>
          <button class="button filter is-small">Newest</button>
          <button class="button filter is-small">Ending Soonest</button>
        </div>
      </fieldset>

    </div>

  </div>

  <?php foreach (array_keys($all_issues) as $key): ?>
    <?php if (count($all_issues[$key]) > 0): ?>

      <!-- <?=ucwords($key)?> Title Block -->
      <section class="section pt-2">
        <div class="container">
          <div class="title <?=$key?> has-text-weight-light depth">
            <?php $title = $key === "admin" ? "Administration" : ucwords($key); echo $title; ?>
          </div>
        </div>
      </section>

      <!-- <?=ucwords($key)?> Issue Cards -->
      <div class="columns is-multiline mx-4">

      <?php foreach ($all_issues[$key] as $issue): $options = json_decode($issue["options"], True);?>

        <div class="column is-one-third">

          <!-- Issue Title/Header -->
          <div class="card mx-2 mb-4 <?=$key?>">
            <header class="card-header mflex">
              <p class="id-fader"><?=$issue["id"]?></p>
              <p class="card-header-title mslim is-size-5"><?=$issue["question"]?></p>

              <div class="is-flex">
                <fieldset class="odds p-0">
                  <legend class="is-size-7">Betting Pool</legend>
                  <code class="has-text-warning">0</code>
                </fieldset>
                <fieldset class="odds p-0">
                  <legend class="is-size-7">Your Bet</legend>
                  <code class="has-text-info">0</code>
                </fieldset>

                <div class="icon card-header-icon pl-5">
                  <span class="tag slap is-warning">Bet Available</span>
                </div>
              </div>

              <p class="card-header-title is-size-5 mobile"><?=$issue["question"]?></p>
            </header>

            <!-- Issue Context -->
            <div class="card-content">
              <?=$issue["context"]?>
            </div>

            <!-- Current Odds Ratio -->
            <div class="columns is-multiline mb-0">
              <div class="column is-one-half">
                <fieldset class="odds">
                  <legend class="is-size-7">Current Odds</legend>
                  <code>0</code> : <code>0</code> : <code>0</code>
                </fieldset>
              </div>

              <!-- Ending Time -->
              <div class="column is-one-half">
                <fieldset class="odds">
                  <legend class="is-size-7">Ends</legend>
                  <code><time class="local-time" data-epoch="1736848799"><?=date("M j Y \a\\t H:i", $issue["ends"])?></time></code>
                </fieldset>
              </div>
            </div>

            <!-- Betting Options -->
            <form method="POST" action="/bid">
              <footer class="card-footer">
                <input type="hidden" name="bid_request" value="<?=$issue["id"]?>"/>

                <?php foreach ($options as $option): ?>

                  <button class="is-block has-text-centered card-footer-item p-0">
                    <div class="odds" style="background:<?=$option["colour"]?>; height: 20px; width:64%"></div>
                    <p><?=$option["text"]?></p>
                  </button>

                <?php endforeach; ?>

              </footer>
            </form>
          </div>

        </div>

      <?php endforeach; ?>
      </div>
    <?php endif; ?>
  <?php endforeach; ?>

  <!-- Footer -->
  <?php include $parts . "footer.php"; ?>

  </body>
</html>