<?php

/*
*
* Popcorn: Lofi Bets to Chill and Watch the World Burn to
* Copyright 2025 Luca McGrath, MIT License
* https://github.com/Lucabaduka/Popcorn
*
* This page is intended to handle an admin overview of receiving
* bet suggestions and creating new issues to vote on.
*
* It is the launch point for editing and resolving bids via resolve.php
*
*/

// List of approved CSS name brands for graph options
$blues_lib   = ["CornflowerBlue", "DarkSlateBlue", "RoyalBlue", "DodgerBlue",    "LightSeaGreen"];
$reds_lib    = ["Crimson",        "DarkMagenta",   "FireBrick", "Maroon",        "MediumVioletRed"];
$greens_lib  = ["DarkGreen",      "ForestGreen",   "Green",     "MediumSeaGreen","SeaGreen"];
$yellows_lib = ["GoldenRod",      "Gold",          "Yellow",    "Khaki",         "PaleGoldenRod"];
$purples_lib = ["MediumPurple",   "BlueViolet",    "Indigo",    "DarkViolet",    "RebeccaPurple"];

// We have received some kind of form request
if ($_SERVER["REQUEST_METHOD"] === "POST") {

  try {

    // This request was to remove a suggestion from the ideas table.
    if (isset($_POST["suggestion"])) {

      foreach ($_POST["suggestion"] as $checked) {
        $statement = "DELETE FROM ideas WHERE id= (?)";
        $order = $pdo->prepare($statement);
        $order->execute([$checked]);
      }

      // Send back a success response with how many rows were removed
      $status = 1;
      $snacks = "<div class=\"notification is-info\" id=\"snacks\">Successfully obliterated <code>" .
      $order->rowCount() . "</code> suggestion". pluralise($order->rowCount()) . " </div>.";
    }

    // This request was to add a new issue to the database
    elseif  (isset($_POST["new_issue"])) {

      // Move things out of $_POST to a more reliably maliable variable
      $issue_data = $_POST["new_issue"];
      $send_issue = new_issue($pdo, $issue_data);

      // Send feedback. The function returns a 0 for success and 1 for failure.
      if ($send_issue === 0) {
        $status = 1;
        $snacks = "<div class=\"notification is-info\" id=\"snacks\">Successfully added <code>" . $issue_data["question"] .
        "</code> to the issue database.</div>";
        $response = push_new_issue($webhooks, $issue_data["question"], $issue_data["category"]);

      } else {
        $status = 1;
        $snacks = "<div class=\"notification is-danger\" id=\"snacks\">Some required fields were missing
        from the New Issue form.</div>";
      }
    }

  // Or send back a failure response with a message no one will probably see.
  } catch (Throwable $e) {

    $status = 1;
    $snacks = "<div class=\"notification is-danger\" id=\"snacks\">Something has gone wrong here.
    An error report has been logged to the server.</div>";
    error_log("--- Script error in admin.php (" . date("Y-m-d H:i:s ", time()) . ") ---\n" . $e . "\n\n", 3, $errors);
  }
}

// Collect all suggestions and commit them to an array
$x = 0;
$ideas = array();
$query =  "SELECT * FROM ideas";
foreach ($pdo->query($query) as $idea) {
  $ideas[$x] = $idea;
  $x++;
}

// Collect all current and pending issues, and commit them to an array
$x = 0;
$issues = array();
$query =  "SELECT * FROM topics WHERE result < 2 ORDER BY ends ASC;";
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
    <meta id="status" data-values="<?=$status?>">
    <link rel="icon" type="image/x-icon" href="/Static/favicon.ico">
    <link rel="stylesheet" href="/Static/bulma.css" type="text/css">
    <link rel="stylesheet" href="/Static/pop.css" type="text/css">
    <title>Popcorn | Admin Control</title>
  </head>
<body>

<div class="hero is-fullheight">

<!-- Nav Bar -->
<?php include $parts . "nav.php"; ?>

<!-- Menu Panel -->
<?php include $parts . "menu.php"; ?>

<!-- Content -->
<div class="is-block container hero-body mclear py-4">
  <div class="notification">

    <h1 class="title">Admin Control</h1>
    <p>
      As you well know, everything in Popcorn can be controlled here, and it's a good thing. Because it's not like
      I'm going to break out manual SQLite3 queries to fix things if they break. No, we will simply delete the database
      and start over.
    </p>

  </div>

  <!-- Active Vote Section -->
  <div class="notification">
    <button class="button is-success js-modal-trigger is-pulled-right" data-target="js-modal">New Issue</button>
    <h1 class="title is-4">Active Issues</h1>

    <table class="table table-sortable is-hoverable is-fullwidth has-text-centered">
      <thead>
        <tr>
          <th class="is-link has-text-centered" data-sort="int" data-dir="">ID</th>
          <th class="is-link has-text-centered" data-sort="string" data-dir="">Question</th>
          <th class="is-link has-text-centered">Options</th>
          <th class="is-link has-text-centered" data-sort="date" data-dir="">Ends</th>
          <th class="is-link has-text-centered" data-sort="string" data-dir="">Status</th>
          <th class="is-link has-text-centered">Edit</th>
        </tr>
      </thead>

      <!-- Dynamic Suggestion Table/Form -->
      <tbody>

      <?php foreach ($issues as $issue): $issue["options"] = json_decode($issue["options"], True); ?>
        <tr class="<?=$issue["cat"]?>">
          <td><code><strong><?=$issue["id"]?></strong></code></td>
          <td><?=$issue["question"]?></td>

          <td>
            <?php
              $count = 0;
              foreach ($issue["options"] as $option) {
                echo $option["text"];
                $count++;
                if ($count < count($issue["options"])) {
                  echo " | ";
                }
              }
            ?>
          </td>

          <td><code><?=date("Y-m-d H:i:s ", $issue["ends"])?></code></td>
          <td><?php $status = $issue["result"] === 0 ? "Current" : "Pending"; echo $status;?></td>
          <td>
            <form method="POST" action="/resolve">
              <input type="hidden" name="resolve_issue" value="<?=$issue["id"]?>"/>
              <button class="edit">🛠️</button>
            </form>

          </td>
        </tr>

      <?php endforeach; ?>

      </tbody>

    </table>

  </div>

  <!-- Suggestion Section -->
  <div class="notification">
    <h1 class="title is-4">Suggestions from Operators</h1>

    <form method="POST">
      <div class="table-wrapper">
        <table class="table table-sortable is-fullwidth has-text-centered">
          <thead>
            <tr>
              <th class="is-link has-text-centered">Select</th>
              <th class="is-link has-text-centered" data-sort="string" data-dir="">Author</th>
              <th class="is-link has-text-centered" data-sort="string" data-dir="">Suggestion</th>
              <th class="is-link has-text-centered" data-sort="string" data-dir="">Deliverable</th>
            </tr>
          </thead>
          <tfoot>

            <?php if (count($ideas) > 0): ?>
              <tr>
                <td><button class="button is-small is-link"><strong>Dismiss</strong></button></td>
                <td colspan="4"></td>
              </tr>

            <?php else: ?>
              <tr>
                <td colspan="5">No new suggestions at this time.</td>
              </tr>

            <?php endif; ?>
            </tfoot>

          <!-- Dynamic Suggestion Table/Form -->
          <tbody>

          <?php foreach ($ideas as $idea): ?>
            <tr>
              <td><input type="checkbox" name="suggestion[]" value="<?=$idea["id"]?>"/></td>
              <td><?=$idea["operator"]?></td>
              <td><?=$idea["idea"]?></td>
              <td><?=$idea["delivery"]?></td>
            </tr>

          <?php endforeach; ?>

          </tbody>
        </table>
      </div>
    </form>

  <!-- Notification end -->
  </div>

<!-- Hero body End -->
</div>

<!-- Footer -->
<?php include $parts . "footer.php"; ?>

</div>

<!-- Issue-Creator Modal -->
<div id="js-modal" class="modal">
  <div class="modal-background"></div>
  <div class="modal-card">

    <header class="modal-card-head">
      <p class="modal-card-title">Create a New Issue</p>
      <button class="is-large delete" aria-label="close"></button>
    </header>

    <form method="POST">
      <section class="modal-card-body">

      <div class="field is-horizontal">
        <div class="field-label is-normal">
          <label class="label" for="question">Question</label>
        </div>
        <div class="field-body">
          <div class="field">
            <input class="input is-info" name="new_issue[question]" type="text">
          </div>
          <div class="field">
            <div class="select is-info">
              <select name="new_issue[category]">
                <option value="admin">🟣 Administrative</option>
                <option value="conflict">🔴 Conflict</option>
                <option value="economics">🟢 Economics</option>
                <option value="sports">🟡 Sports</option>
                <option value="sapphire">🔵 Sapphire</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <div class="field is-horizontal">
        <div class="field-label is-normal">
          <label class="label">Context</label>
        </div>
        <div class="field-body">
          <div class="field">
            <textarea name="new_issue[context]" class="textarea is-info" placeholder="Explain more about the context and premise of the question."></textarea>
          </div>
        </div>
      </div>

      <?php for($i = 0; $i < 5; ++$i): ?>

        <div class="field is-horizontal" id="theme_<?=($i+1)?>">
          <div class="field-label is-normal">
            <label class="label" for="new_issue[options][<?=($i)?>][text]">Option <?=($i+1)?></label>
          </div>

          <div class="field-body">
            <div class="field">
              <input class="input is-info" name="new_issue[options][<?=($i)?>][text]" type="text">
            </div>
            <div class="field">
              <div class="select is-info">
                <select id="selector_<?=($i+1)?>" name="new_issue[options][<?=($i)?>][colour]">

                  <optgroup label="Blue Themes">
                    <?php foreach ($blues_lib as $colour): ?>
                      <option value="<?=$colour?>"><?=$colour?></option>
                    <?php endforeach; ?>
                  </optgroup>

                  <optgroup label="Red Themes">
                    <?php foreach ($reds_lib as $colour): ?>
                      <option value="<?=$colour?>"><?=$colour?></option>
                    <?php endforeach; ?>
                  </optgroup>

                  <optgroup label="Green Themes">
                    <?php foreach ($greens_lib as $colour): ?>
                      <option value="<?=$colour?>"><?=$colour?></option>
                    <?php endforeach; ?>
                  </optgroup>

                  <optgroup label="Yellow Themes">
                    <?php foreach ($yellows_lib as $colour): ?>
                      <option value="<?=$colour?>"><?=$colour?></option>
                    <?php endforeach; ?>
                  </optgroup>

                  <optgroup label="Purple Themes">
                    <?php foreach ($purples_lib as $colour): ?>
                      <option value="<?=$colour?>"><?=$colour?></option>
                    <?php endforeach; ?>
                  </optgroup>

                </select>
              </div>
            </div>
          </div>
        </div>

        <?php endfor; ?>

      <div class="field is-horizontal">
        <div class="field-label is-normal">
          <label class="label" for="new_issue[date_end]">Betting Ends</label>
        </div>
        <div class="field-body">
          <div class="field">
            <input type="date" name="new_issue[date_end]" value="<?=date("Y-m-d", time())?>" min="<?=date("Y-m-d", time())?>"/>
            <input type="time" name="new_issue[time_end]"/>
          </div>
        </div>
      </div>

      </section>
      <footer class="modal-card-foot">
        <div class="buttons">
          <input type="submit" value="Send it" class="button is-success">
        </div>
      </footer>
    </form>
  </div>
</div>

<?=$snacks?>

<script src="/Static/Scripts/pop.js"></script>
<script src="/Static/Scripts/admin.js"></script>
<script src="/Static/Scripts/sort.js"></script>
<script>document.querySelectorAll('.table-sortable').forEach(el => el.tsortable())</script>

</body>
</html>