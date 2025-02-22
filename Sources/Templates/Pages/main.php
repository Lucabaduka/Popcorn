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
$sort = "ends ASC";

// Load all current issues and committ them to category arrays
$all_issues = array("admin" => array(), "conflict" => array(), "economics" => array(), "spots" => array(), "sapphire" => array());
$query =  "SELECT * FROM topics WHERE result < 1 ORDER BY $sort;";
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

// Make a random tagline subtitle for the day
$taglines = [
  "Lofi Bets to Chill and Watch the World Burn to",
  "My alternate name idea was the \"Irish Kneebreaker Association\", but Emily said no.",
  ];
$seed = floor(time()/86400);
srand($seed);
$subtitle = $taglines[rand(0, count($taglines)-1)]

?>

<!DOCTYPE html>
<html data-theme="dark">
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
        <span class="tag px-2 is-dark is-size-7">Version</span>
        <span class="tag px-2 is-success is-size-7"><?=$version?></span>
      </div>

      <div class="media">
        <figure class="image mr-2 is-64x64">
          <a href="/"><img height="64" width="64" src="/Static/Assets/popcorn_logo.svg" alt="logo" aria-label="Return to splash page"></a>
        </figure>
        <div class="media-content mb-3">
          <h1 class="title">
            Popcorn
          </h1>
          <h2 class="subtitle is-6">
            <?=$subtitle?>
          </h2>
        </div>
      </div>

      <div class="content is-primary">
        <h3 class="title mb-1 is-5">
          Overview
        </h3>
        <hr class="default-line">
        <p>
          Active issues will be populated on this page. In each, you can pick one of the identified possible outcomes
          that you think will happen, and then back those predictions with the in-game currency — the Refugia planet.
          When the outcome is known, an admin will resolve the issue. Players who picked the winning option will get
          their bet back, along with a share of the remaining betting pool, proportionate to their contribution.
        </p>
        <p>
          Every player starts with twenty-five thousand planets. You can bet up to all of your available planets on
          an issue or series of issues. While your funds are tied up, you nominally cannot use them to place new
          bets. However, you are always allowed to place a bet of five thousand planets so that you can participate
          in any issue. In other words, you're allowed to plunge yourself into debt and, just like life, there is no
          statutory maximum level of possible debt.
        </p>
      </div>

      <!-- Current Operator Balance and Max -->
      <article class="message is-success">
        <div class="message-body py-4">
          <div class="is-flex center-align" style="flex-wrap: wrap;">
            <p class="mx-2"><strong>Balance:</strong> <code><i class="ico ico-planet"></i> <?=number_format($op["bal"])?></code></p>
            <p class="mx-2"><strong>Staked:</strong> <code><i class="ico ico-planet"></i> <?=number_format($op["staked"])?></code></p>
            <p class="mx-2"><strong>Max Bet:</strong> <code><i class="ico ico-planet"></i> <?=number_format($op["max"])?></code></p>
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

      <?php foreach ($all_issues[$key] as $issue):

        $options      = json_decode($issue["options"], True);
        $issue_id     = $issue["id"];
        $eligible     = True;
        $operator_bet = "None";

        // Load any existing bids and commit them to an array
        $x = 0;
        $bets = array();
        $query =  "SELECT * FROM bets WHERE topic = $issue_id";
        foreach ($pdo->query($query) as $bet) {
          $bets[$x] = $bet;
          $x++;
        }

        // Determine the total betting pool and the counts of all bets so far
        $pool = 0;
        $tally = array();
        foreach ($bets as $bet) {
          $pool += $bet["volume"];
          if (isset($tally[$bet["opinion"]])) {
            $tally[$bet["opinion"]] += 1;
          } else {
            $tally[$bet["opinion"]] = 1;
          }

          // We'll also take the opportunity to see if they've bet before.
          if ($bet["operator"] === $op["id"]) {
            $eligible = False;
            $operator_bet = number_format($bet["volume"]);
          }
        }

      ?>

        <div class="column is-one-third">

          <!-- Issue Title/Header -->
          <div class="card mx-2 mb-4 <?=$key?>">
            <header class="card-header mflex">
              <p class="id-fader"><?=$issue["id"]?></p>
              <p class="card-header-title mslim is-size-5"><?=$issue["question"]?></p>

              <div class="is-flex">
                <fieldset class="odds p-0">
                  <legend class="is-size-7">Betting Pool</legend>
                  <code class="has-text-warning"><?=number_format($pool+(count($options)*1000))?></code>
                </fieldset>
                <fieldset class="odds p-0">
                  <legend class="is-size-7">Your Bet</legend>
                  <code class="has-text-info"><?=$operator_bet?></code>
                </fieldset>

                <div class="icon card-header-icon pl-5">

                  <?php

                    // Generate the advertisment tag
                    if ($eligible) {
                      echo "<span class=\"tag slap is-warning\">Bet Available</span>";
                    } else {
                      echo "<span class=\"tag slap is-link\">Bet in Place</span>";
                    }

                  ?>

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

                  <?php

                  $count = 0;
                  foreach ($options as $option) {
                    if (!isset($tally[$option["text"]])) $tally[$option["text"]] = 1;

                    echo "<code>" . $tally[$option["text"]] . "</code>";
                    $count++;
                    if ($count < count($options)) {
                      echo " : ";
                    }
                  }
                  ?>

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
            <form method="POST" action="/bet">
              <footer class="card-footer">
                <input type="hidden" name="bet_request" value="<?=$issue["id"]?>"/>

                <?php foreach ($options as $option): ?>

                  <button class="is-block has-text-centered card-footer-item p-0">
                  <progress
                    class="progress mb-2"
                    value="<?=$tally[$option["text"]]+1?>"
                    max="<?=count($bets)+count($options)?>"
                    style="border-radius: 0px; --bulma-progress-value-background-color: <?=$option["colour"]?>;">
                  </progress>
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