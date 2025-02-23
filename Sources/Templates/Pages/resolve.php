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
* Of all the files in Popcorn, I hate this one the most.
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
    <title>Popcorn | Admin Edit and Resolve</title>
  </head>
<body>

<div class="hero is-fullheight">


  <!-- Nav Bar -->
  <?php include $parts . "nav.php"; ?>

  <!-- Menu Panel -->
  <?php //include $parts . "menu.php"; ?>

<!-- Content -->
<div class="container hero-body mclear py-4">
  <div class="notification">
      <form method="POST">
        <input type="hidden" name="resolve_issue" value="<?=$issue["id"]?>">
        <input type="hidden" name="delete_issue" value="<?=$issue["id"]?>">
        <button class="button is-danger is-dark js-modal-trigger is-pulled-right" <?=$disable?>>Delete Issue</button>
      </form>
    <h1 class="title">Admin Edit and Resolve</h1>
    <div class="content">

      <div class="columns is-multiline">

        <div class="column is-half">

          <div id="card" class="card <?=$issue["cat"]?>" style="height:100%">
            <header class="bid card-header mflex">
              <p class="id-fader"><?=$issue["id"]?></p>
              <p id="question_header" class="card-header-title is-size-5 center-align"><?=$issue["question"]?></p>
            </header>

            <form class="m-4" method="POST">
              <input type="hidden" name="resolve_issue" value="<?=$issue["id"]?>">

              <div class="field is-horizontal">
                <div class="field-label is-normal">
                  <label class="label" for="question">Question</label>
                </div>
                <div class="field-body">
                  <div class="field">
                    <input
                      id="question_input"
                      class="input is-warning"
                      name="edit_issue[question]"
                      type="text"
                      value="<?=$issue["question"]?>"
                      oninput="update()"
                      <?=$disable?>
                    >
                  </div>
                  <div class="field">
                    <div class="select is-warning">
                      <select id="category" name="edit_issue[category]" <?=$disable?>>
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
                    <textarea
                    name="edit_issue[context]"
                    class="textarea is-warning"
                    value="<?=$issue["context"]?>"
                    <?=$disable?>><?=$issue["context"]?></textarea>
                  </div>
                </div>
              </div>

              <?php for($i = 0; $i < count($options); ++$i): ?>

                <div class="field is-horizontal" id="theme_<?=($i+1)?>">
                  <div class="field-label is-normal">
                    <label class="label" for="edit_issue[options][<?=($i)?>][text]">Option <?=($i+1)?></label>
                  </div>

                  <div class="field-body">
                    <div class="field">
                      <input
                        class="input is-warning"
                        name="edit_issue[options][<?=($i)?>][text]"
                        value="<?=$options[$i]["text"]?>"
                        type="text"
                        <?=$disable?>
                      >
                    </div>
                    <div class="field">
                      <input
                        class="input is-warning"
                        name="edit_issue[options][<?=($i)?>][colour]"
                        value="<?=$options[$i]["colour"]?>"
                        type="text"
                        <?=$disable?>
                      >
                    </div>
                  </div>
                </div>

                <?php endfor; ?>

              <div class="field is-horizontal">
                <div class="field-label is-normal">
                  <label class="label" for="edit_issue[date_end]">Ends</label>
                </div>
                <div class="field-body">
                  <div class="field">
                    <input type="date" name="edit_issue[date_end]" value="<?=date("Y-m-d", $issue["ends"])?>" <?=$disable?>>
                    <input type="time" name="edit_issue[time_end]" value="<?=date("H:i:s", $issue["ends"])?>" <?=$disable?>>
                  </div>
                </div>
              </div>

              <div class="field is-horizontal">
                <div class="field-label is-normal">
                  <label class="label" for="edit_issue[status]">Status</label>
                </div>
                <div class="field-body">
                  <div class="field">
                    <div class="select is-warning">
                      <select name="edit_issue[status]" <?=$disable?>>
                        <?php
                          if ($issue["result"] === 0) {
                            echo "<option value=\"0\" selected>Current</option>";
                            echo "<option value=\"1\">Pending</option>";
                          } else {
                            echo "<option value=\"0\">Current</option>";
                            echo "<option value=\"1\" selected>Pending</option>";
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="field center">
                    <button class="button is-warning" <?=$disable?>>Edit Issue</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="column is-half">

          <div class="card <?=$issue["cat"]?> centre" style="height:100%">
            <form method="POST">
              <input type="hidden" name="resolve_issue" value="<?=$issue["id"]?>">

              <header class="bid card-header mflex">
                <p class="card-header-title is-size-5 center-align">Resolve Issue Favouring...</p>
              </header>

              <p class="py-4 mb-0">Choose a betting option that was correct</p>
              <div class="is-flex center">

                <?php $options = json_decode($issue["options"], True);
                  foreach ($options as $option):
                    if (!isset($tally[$option["text"]])) {
                      $tally[$option["text"]] = "0";
                    }
                ?>

                  <label class="bid-option">
                    <input type="radio" name="option" value="<?=$option["text"]?>" <?=$disable?>>
                    <span><?=$option["text"]?></span>
                  </label>

                <?php endforeach; ?>

              </div>

              <hr>

              <p>Cancel the bet and refund the participants</p>
              <div class="is-flex center">
                <label class="bid-option has-background-black">
                  <input type="radio" name="option" value="--abort" <?=$disable?>>
                  <span>Call Off the Issue</span>
                </label>
              </div>

              <hr class="mt-2 mb-4">

              <button class="button is-success is-dark" <?=$disable?>>Resolve Issue</button>

            </form>
          </div>
        </div>

      </div>

    </div>
  </div>
</div>

  <!-- Footer -->
  <?php include $parts . "footer.php"; ?>

<script>

// Get the category type from the card, and make it the default select
value = document.getElementById("card").className.split(" ");
let element = document.getElementById("category");
element.value = value[1];

// Update question title to the title input whenever it changes
function update() {
  let value = document.getElementById("question_input").value;
  document.getElementById("question_header").innerHTML = value;
}

</script>

</div>

</body>
</html>