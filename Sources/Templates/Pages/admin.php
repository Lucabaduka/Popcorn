<?php

// We have received some kind of form request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  var_dump($_POST);

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
    } elseif  (isset($_POST["question"])) {





    }



  // Or send back a failure response with a message no one will probably see.
  } catch (Throwable $e) {
    $status = 1;
    $snacks = '<div class="notification is-danger" id="snacks">Something has gone wrong here.
    An error report has been logged to the server.</div>';
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
    <button class="button is-link js-modal-trigger is-pulled-right" data-target="js-modal">New Issue</button>
    <h1 class="title is-4">Active Issues</h1>

    <!-- Issue-Creator Modal -->
    <?php include $parts . "creator.php"; ?>

    <!-- cat TEXT, question TEXT, context TEXT, options JSON, ends INTEGER, result INTEGER, resolution TEXT -->

  </div>

  <!-- Suggestion Section -->
  <div class="notification">
    <h1 class="title is-4">Suggestions from Operators</h1>

    <form name="suggestions" method="POST">
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

<?=$snacks?>

<script src="/Static/pop.js"></script>
<script src="/Static/admin.js"></script>
<script>



</script>

</body>
</html>