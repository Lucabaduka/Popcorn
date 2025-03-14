<?php

/*
*
* Popcorn: Lofi Bets to Chill and Watch the World Burn to
* Copyright 2025 Luca McGrath, MIT License
* https://github.com/Lucabaduka/Popcorn
*
* This page handles validating and submitting operator bids
* for specific issues. Bets can only be loaded via POST submissions
* from issue cards in main.php or through bets on this one.
*
*/

// Validate the post request by making sure we're not receiving garbage
$issue_id = 0;
if (is_numeric($_POST["bet_request"])) {
  $issue_id = $_POST["bet_request"];
}

// Load the issue and commit it to an array
$issue = get_issue($pdo, $issue_id);

// Here, we are receiving an actual bid submission
if (!isset($eligible) && (isset($_POST["option"]) && isset($_POST["bid"]))) {

  try {

    // Try to run the new_bet function
    $send_bet = new_bet($pdo, $op, $_POST, $issue);

    // Get current operator information
    $op = get_operator($pdo, $context);

    // Respond if something in the request was broken for some reason
    if ($send_bet > 0) {
      $status = 1;
      $snacks = "<div class=\"notification is-danger\" id=\"snacks\">Something has gone wrong here.
        The bet you just requested to submit did not contain valid data.</div>";
    } else {
      $eligible = False; // Prevent them from placing a second bet on the same success page
      $status = 1;
      $snacks = "<div class=\"notification is-success\" id=\"snacks\">Your bet of <code>" . number_format($_POST["bid"]) .
                  "</code> has been lodged for <code>" . ucwords($_POST["option"]) . "</code></div>";
    }

  // Or send back a failure response with a message no one will probably see.
  } catch (Throwable $e) {

    $status = 1;
    $snacks = "<div class=\"notification is-danger\" id=\"snacks\">Something has gone wrong here.
    An error report has been logged to the server.</div>";
    error_log("--- Script error in bet.php (" . date("Y-m-d H:i:s ", time()) . ") ---\n" . $e . "\n\n", 3, $errors);
  }

}

// Load any existing bets and commit them to an array
$bets = get_bets($pdo, $issue_id);

$options = json_decode($issue["options"], True);
$pool = count($options)*1000;
$tally = array();
foreach ($bets as $bet) {
  $pool += $bet["volume"];
  if (!isset($tally[$bet["opinion"]], $tally)) {
    $tally[$bet["opinion"]] = 1;
  } else {
    $tally[$bet["opinion"]] += 1;
  }

  // We'll also take the opportunity to see if they've bet before.
  if ($bet["operator"] === $op["id"]) {
    $eligible = False;
  }
}

// Disable our inputs on the front end if the page is loaded
$expired = "disabled";

// The bid id was probably invalid (we then need a dummy $issue to prevent the page from dying)
if (!$issue) {
  $expired_reason = "No issue, past or present, could be found with the id your request supplied.";
  $issue = array(
    "id" => 0,
    "cat" => "conflict",
    "question" => "How did you even get here?",
    "context" => "",
    "options" => json_encode(array(), JSON_FORCE_OBJECT),
  );

// The issue has timed out or has moved to a pending stage
} elseif ($issue["result"] === 3) {
  $expired_reason = "This issue's betting was called off because none of the options turned out to be what happened.<br>
                     Correspondingly, all players who participated in the issue were refunded their bets in full.";

// The issue has timed out or has moved to a pending stage
} elseif ($issue["ends"] < time() || $issue["result"] > 0) {
  $expired_reason = "This issue's timer has expired, or it was moved to a pending/resolved state early. It is no longer
                     possible to place a bet, but you can track the issue's status and results through the
                     <a href=\"/records\">Records</a> page.";

} elseif (isset($eligible)) {
  $expired_reason = "You have already made a bet on this particular topic in the past. You cannot adjust or retract
                     that bet without receiving the unfair gameplay advantage of \"hindsight\". If you forgoet your bid,
                     however, you can review it in the <a href=\"/records\">Records</a> page, and filter by your bets.";

// We presume everything is valid, or at least valid enough to try bidding
} else {
  $expired = "required";
  $expired_message = "";
}

// If we found anything that invalidated the operator's attempts, report it here
if ($expired != "required") {
  $expired_message = "<div class=\"notification center info\">
    <p class=\"title is-4\">~ Betting Disabled ~</p>
    <p>" . $expired_reason . "</p>
  </div>";
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
    <meta id="status" data-values="<?=$status?>">
    <link rel="icon" type="image/x-icon" href="/Static/favicon.ico">
    <link rel="stylesheet" href="/Static/bulma.css" type="text/css">
    <link rel="stylesheet" href="/Static/pop.css" type="text/css">
    <title>Popcorn | Submit a bid</title>
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

  <?=$expired_message?>

  <form method="POST">
  <input type="hidden" name="bet_request" value="<?=$issue["id"]?>">

    <h1 class="title">Place a Bid</h1>
    <div class="content">

      <div class="columns is-multiline">

        <div class="column is-half">

            <!-- Issue Title/Header -->
            <div class="card <?=$issue["cat"]?>" style="height:100%">
              <header class="bid card-header mflex">
                <p class="id-fader"><?=$issue["id"]?></p>
                <p class="card-header-title is-size-5 center-align"><?=$issue["question"]?></p>
              </header>


              <div class="card-content">

                <?=$issue["context"]?>

                <hr>

                <?php $options = json_decode($issue["options"], True);
                      foreach ($options as $option):
                        if (!isset($tally[$option["text"]])) {
                          $tally[$option["text"]] = "0";
                        }
                ?>

                  <label class="bid-option">
                    <input type="radio" name="option" value="<?=$option["text"]?>" <?=$expired?>>
                    <span><?=$option["text"]?></span>
                    <progress
                      class="progress is-large"
                      value="<?=$tally[$option["text"]]+1?>"
                      max="<?=count($bets)+count($options)?>"
                      style="--bulma-progress-value-background-color: <?=$option["colour"]?>;">
                    </progress>
                  </label>

                <?php endforeach; ?>

                <div class="center">
                  <h3 class="mb-2">Total Pool</h3>
                  <code class="subtitle has-text-success"><i class="ico ico-planet"></i> <?=number_format($pool)?></code>
                </div>
              </div>
            </div>
        </div>

        <div class="column is-half">

          <!-- Issue Title/Header -->
          <div class="card" style="height:100%">
            <header class="bid card-header mflex">
              <p class="card-header-title is-size-5 center-align">Account Statement</p>
            </header>

            <div class="card-content pt-0">

              <table class="table plain is-hoverable is-fullwidth has-text-centered">
                <tbody>
                  <tr>
                    <th>Total Balance</th>
                    <td><code class="has-text-success"><i class="ico ico-planet"></i> <?=number_format($op["bal"])?></code></td>
                  </tr>
                  <tr>
                    <th>Unavailable (Staked)</th>
                    <td><code><i class="ico ico-planet"></i> <?=number_format($op["staked"])?></code></td>
                  </tr>
                  <tr>
                    <th>Max Bet Available</th>
                    <td><code class="has-text-info"><i class="ico ico-planet"></i> <?=number_format($op["max"])?></code></td>
                  </tr>
                </tbody>
              </table>

              <div class="field">
              <div class="control">
                <label class="label is-size-4" for="bid_volume"> Enter a Bid</label>
                <input class="input" type="number" id="bid_volume" name="bid" max="<?=$op["max"]?>" <?=$expired?> required>
              </div>
              </div>

              <p class="has-text-centered">
                Note that when you submit a bid, you will not be able to change it or retract it later on. Furthermore,
                you will not be able to turn in a bid for a different option. You are committed until the issue is resolved.
              </p>

              <button class="button is-fullwidth is-link" <?=$expired?>>Submit</button>

            </div>
          </div>

        </div>
      </div>

    </div>
  </form>
  </div>
</div>

<!-- Footer -->
<?php include $parts . "footer.php"; ?>

</div>

<?=$snacks?>

<script src="/Static/Scripts/pop.js"></script>

</body>
</html>