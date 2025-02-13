<?php

// We have probably received a suggestion post
if ($_SERVER["REQUEST_METHOD"] === "POST") {

  // Attempt to add the suggestion to the database
  try {

    // The form returns the following convention
    // array(2) { ["idea"]=> string(5) "Beans" ["delivery"]=> string(14) "beans and rice" }
    $order = $pdo->prepare("INSERT INTO ideas ('id', 'operator', 'idea', 'delivery') VALUES (?, ?, ?, ?)");
    $order->execute(array(NULL, $context["user"]["name"], $_POST["idea"], $_POST["delivery"]));

    // We assume everything is working at this point, so we'll prepare a snack for the JS to deliver to report it worked
    $status = 1;
    $snacks = '<div class="notification is-info" id="snacks">Suggestion submitted successfully.</div>';

  // Something has gone wrong, so we'll report the error and load the rest of the page.
  } catch (Throwable $e) {

    $status = 1;
    $snacks = '<div class="notification is-danger" id="snacks">Something has gone wrong here.<br>' . $e->getLine() . ': ' . $e->getMessage() . '</code></div>';
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
    <title>Popcorn | Suggest a Bet</title>
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
      <h1 class="title">Suggest a Bet</h1>
      <div class="content is-primary">
        <p>
          Note that in order for a suggestion to be accepted, it has to be undetermined, tangible, and deliverable.
          In other words, the subject of the bet must exist in the real or electronic world, its outcome cannot be
          known in advance, and that outcome must be emperically verifiable such that any independent observer could
          objectively determine the outcome.
        </p>

        <form method="POST">
          <div class="field">
          <label class="label" for="delivery">What is the premise of the bet?</label>
            <textarea id="idea" name="idea" class="textarea is-medium"></textarea>
          </div>

          <div class="field">
            <label class="label" for="delivery">How can we check the outcome?</label>
            <div class="control">
              <input class="input" id="delivery" name="delivery" type="text" placeholder="Where is the data?">
            </div>
          </div>

          <div class="field">
            <label class="checkbox">
              <input type="checkbox" required> This suggestion is undetermined, tangible, and deliverable.</a>
            </label>
          </div>
          <div class="field">
            <button class="button is-success">Send it</button>
          </div>
        </form>


      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php include $parts . "footer.php"; ?>

</div>

<?=$snacks?>

<script src="/Static/pop.js"></script>

</body>
</html>