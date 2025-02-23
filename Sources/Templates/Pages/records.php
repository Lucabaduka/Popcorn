<?php

/*
*
* Popcorn: Lofi Bets to Chill and Watch the World Burn to
* Copyright 2025 Luca McGrath, MIT License
* https://github.com/Lucabaduka/Popcorn
*
* This page allows an operator to browse any current, pending,
* or resolved issue that has ever been lodged to popcorn. The
* goal is that someone can check previous issues and consult
* the bets they may have placed, or check how they turned out.
*
*/

// "Your Bets" toggle
//  We expect it to always be a 1 if it's on or a 0 if it's off.
if (isset($_POST["you_bets"]) && is_numeric($_POST["you_bets"])) {
  $you_bets = $_POST["you_bets"];
  $bets_toggle = $you_bets > 0 ? 0 : 1;
  $bets_active = $you_bets > 0 ? "is-active" : "";
} else {
  $bets_toggle = 1;
  $bets_active = "";
}

// Needs a case statement
$sort = "ends ASC";

// Load all issues and commit them to an array
$x = 0;
$issues = array();
$query =  "SELECT * FROM topics ORDER BY id ASC;";
foreach ($pdo->query($query) as $issue) {
  $issues[$x] = $issue;
  $x++;
}

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
    <title>Popcorn | Records Registry</title>
  </head>
<body>

<div class="hero is-fullheight">

  <!-- Nav Bar -->
  <?php include $parts . "nav.php"; ?>

  <!-- Menu Panel -->
  <?php include $parts . "menu.php"; ?>

  <!-- Content -->
  <div class="container is-block hero-body mclear py-4">
    <div class="notification">

      <?php if ($logged): ?>
        <div class="tags mb-0 has-addons is-pulled-right">
          <form method="POST">
            <input type="hidden" name="you_bets" value="<?=$bets_toggle?>">
            <button class="button <?=$bets_active?> filter">Your Bets</button>
          </form>
        </div>
      <?php endif; ?>

      <h1 class="title">Popcorn Records</h1>
      <h2 class="subtitle is-7">Our underhanded agents demanded information, straight from the Kernel</h2>
      <div class="content is-primary">
        <p>
          The following is a list of all issues that have been lodged to Popcorn, past and present. You can filter by the issues
          you've placed bets on by using the "My Bets" toggle button. You can sort through this list by clicking the header
          items in the table to sort them based on that thing and, additionally, combine that with the filter buttons to better
          find items.
        </p>
      </div>
    </div>

    <div class="is-flex mb-2 center-align">

      <fieldset class="mx-3">
      <legend class="is-size-7">Filters</legend>
        <div class="buttons center-align has-addons">
          <button class="button filter is-small">🟣 Administrative</button>
          <button class="button filter is-small">🔴 Conflict</button>
          <button class="button filter is-small">🟢 Economics</button>
          <button class="button filter is-small">🟡 Sports</button>
          <button class="button filter is-small">🔵 Sapphire</button>
        </div>
      </fieldset>

    </div>

    <div class="notification">

    <div class="table-wrapper">
      <table class="table table-sortable is-hoverable is-fullwidth has-text-centered">
        <thead>
          <tr>
            <th class="is-link has-text-centered" data-sort="int"    data-dir="">ID</th>
            <th class="is-link has-text-centered" data-sort="string" data-dir="">Category</th>
            <th class="is-link has-text-centered" data-sort="string" data-dir="">Question</th>
            <th class="is-link has-text-centered" data-sort="int"    data-dir="">Total Pool</th>
            <?php if ($logged): ?>
              <th class="is-link has-text-centered" data-sort="int"    data-dir="">Your Bet</th>
            <?php endif; ?>
            <th class="is-link has-text-centered" data-sort="string" data-dir="">Status</th>
            <th class="is-link has-text-centered" data-sort="string" data-dir="">Answer</th>
            <th class="is-link has-text-centered" data-sort="int"    data-dir="">Payout</th>
          </tr>
        </thead>

        <!-- Dynamic Suggestion Table/Form -->
        <tbody>

        <?php if (count($issues) === 0): ?>

          <tr>
            <td colspan="7">No new suggestions at this time.</td>
          </tr>

        <?php else:
          foreach ($issues as $issue):
            $options      = json_decode($issue["options"], True);
            $issue_id     = $issue["id"];
            $operator_bet = 0;

            // Load any existing bids and commit them to an array
            $x = 0;
            $bets = array();
            $query =  "SELECT * FROM bets WHERE topic = $issue_id";
            foreach ($pdo->query($query) as $bet) {
              $bets[$x] = $bet;
              $x++;
            }

            // Determine the betting pool and whether the operator has a bet in it
            $pool = 0;
            foreach ($bets as $bet) {
              $pool += $bet["volume"];
              if ($bet["operator"] === $op["id"]) $operator_bet = number_format($bet["volume"]);
            }

            // if the Your Bets filter is on and the operator has not bet, skip
            if ($operator_bet === 0 && $bets_toggle === 0) continue;

          ?>

          <tr class="<?=$issue["cat"]?>">
            <td>
              <form method="POST" action="/bet">
                <input type="hidden" name="bet_request" value="<?=$issue["id"]?>">
                <button class="edit"><?=$issue["id"]?></button>
              </form>
            </td>
            <td><?=ucwords($issue["cat"])?></td>
            <td><?=$issue["question"]?></td>
            <td><code class="has-text-warning"><?=number_format($pool+(count($options)*1000))?></code></td>
            <?php if ($logged): ?>
              <td class="has-text-info"><code class="has-text-info"><?=$operator_bet?></code></td></td>
            <?php endif; ?>

              <?php
                switch ($issue["result"]) {
                  case 0:
                    $current = "Active";
                    break;
                  case 1:
                    $current = "Pending";
                    break;
                  case 2:
                    $current = "Finished";
                    break;
                }
              ?>

            <td><?=$current?></td>
            <td>Beans</td>
            <td>0</td>
          </tr>

          <?php endforeach; ?>
        <?php endif; ?>

        </tbody>
      </table>
    </div>

  <!-- Notification end -->
  </div>

  </div>

  <!-- Footer -->
  <?php include $parts . "footer.php"; ?>

</div>

<script src="/Static/Scripts/sort.js"></script>
<script>document.querySelector('.table-sortable').tsortable()</script>

</body>
</html>