<?php

// Function to take form data from the admin page and insert a new issue to the database
// Called when the issue modal closes via the submit button
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
  $issue = array(NULL,                                  // id INTEGER PRIMARY KEY
                 $issue_data["category"],               // cat TEXT
                 $issue_data["question"],               // question TEXT
                 $issue_data["context"],                // context TEXT
                 json_encode($issue_data["c_options"]), // options JSON
                 $issue_data["ends"],                   // ends INTEGER
                 0,                                     // result INTEGER (0: current, 1: pending, 2: finished)
                 "",);                                  // resolution TEXT (what admin writes to describe the outcome)

  $order = $pdo->prepare("INSERT INTO topics ('id', 'cat', 'question', 'context', 'options', 'ends', 'result', 'resolution')
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
  $order->execute($issue);
  return 0;
}

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

    <table class="table is-fullwidth has-text-centered">
      <thead>
        <tr>
          <th class="is-link has-text-centered">Category</th>
          <th class="is-link has-text-centered">Question</th>
          <th class="is-link has-text-centered">Context</th>
          <th class="is-link has-text-centered">Options</th>
          <th class="is-link has-text-centered">Ends</th>
          <th class="is-link has-text-centered">Result</th>
          <th class="is-link has-text-centered">Resolution</th>
        </tr>
      </thead>

      <!-- Dynamic Suggestion Table/Form -->
      <tbody>

      <?php foreach ($issues as $issue): $issue["options"] = json_decode($issue["options"], True); ?>
        <tr>
          <td><?=$issue["cat"]?></td>
          <td><?=$issue["question"]?></td>
          <td><?=$issue["context"]?></td>

          <td>
            <?php
              $count = 0;
              foreach ($issue["options"] as $option) {
                echo $option["text"];
                $count++;
                if ($count < count($issue["options"])) {
                  echo ", ";
                }
              }
            ?>
          </td>

          <td><?=date("Y-m-d H:i:s ", $issue["ends"])?></td>
          <td><?=$issue["result"]?></td>
          <td><?=$issue["resolution"]?></td>
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
        <table class="table is-fullwidth has-text-centered">
          <thead>
            <tr>
              <th class="is-link has-text-centered">Select</th>
              <th class="is-link has-text-centered">Author</th>
              <th class="is-link has-text-centered">Suggestion</th>
              <th class="is-link has-text-centered">Deliverable</th>
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
<?php include $parts . "creator.php"; ?>

<?=$snacks?>

<script src="/Static/pop.js"></script>
<script src="/Static/admin.js"></script>
<script>



</script>

</body>
</html>