<?php

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

  <div class="container mclear py-4 is-max-desktop">

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

  <div style="clear:both;"></div>

  <article class="message overview mslim is-info">
        <div class="message-body p-2">

        <div class="fixed-grid">
          <div class="grid mb-0">
            <div class="cell">
              <strong>Balance:</strong>
            </div>
            <div class="cell">
              <code>5,000</code>
            </div>

            <div class="cell">
              <strong>Staked:</strong>
            </div>
            <div class="cell">
              <code>5,000</code>
            </div>

            <div class="cell">
              <strong>Max Bet:</strong>
            </div>
            <div class="cell">
              <code>5,000</code>
            </div>
          </div>
          <div>

        </div>
      </article>

      <article class="message mobile is-info">
        <div class="message-body p-2 py-4">

          <div class="is-flex" style="flex-wrap:wrap;">
            <div class="cell my-1 mx-2">
              <strong>Balance:</strong> <code>5,000</code>
            </div>

            <div class="cell my-1 mx-2">
              <strong>Staked:</strong> <code>5,000</code>
            </div>

            <div class="cell my-1 mx-2">
              <strong>Max Bet:</strong> <code>5,000</code>
            </div>
          </div>

        </div>
      </article>

  <section class="section">
    <div class="container">
      <div class="title admin has-text-weight-light depth">
        Administrative
      </div>
    </div>
  </section>

  <div class="columns is-multiline mx-4">

    <div class="column is-one-third">

      <!-- Issue Title/Header -->
      <div class="card mx-2 mb-4 admin">
        <header class="card-header">
          <p class="card-header-title is-size-5">Next Prime Minister of Canada</p>
          <div class="icon card-header-icon">
            <span class="tag slap is-success">Bet in Place</span>
          </div>
        </header>

        <!-- Issue Context -->
        <div class="card-content">
          Canada will be holding a federal election to determine the country's leadership sometime this year. Upon its conclusion,
          who will become the next Prime Minister of Canada?
        </div>

        <!-- Current Odds Ratio -->
        <div class="columns is-multiline mb-1">
          <div class="column is-one-half">
            <fieldset class="odds">
              <legend class="is-size-7">Current Odds</legend>
              <code>7</code> : <code>3</code> : <code>1</code>
            </fieldset>
          </div>

          <!-- Ending Time -->
          <div class="column is-one-half">
            <fieldset class="odds">
              <legend class="is-size-7">Ends</legend>
              <code><time class="local-time" data-epoch="1736848799">14 January 2025 at 01:59</time></code>
            </fieldset>
          </div>
        </div>

        <!-- Betting Options -->
        <footer class="card-footer">

          <a href="#" class="is-block has-text-centered card-footer-item p-0">
            <div class="odds" style="background:FireBrick; height: 20px; width:64%"></div>
            <p class="">Mark Carney</p>
          </a>

          <a href="#" class="is-block has-text-centered card-footer-item p-0">
            <div class="odds" style="background:DodgerBlue; height: 20px; width:27%"></div>
            <p class="">Pierre Poilievre</p>
          </a>

          <a href="#" class="is-block has-text-centered card-footer-item p-0">
            <div class="odds" style="background:GoldenRod; height: 20px; width:9%"></div>
            <p class="">Jagmeet Singh</p>
          </a>

        </footer>
      </div>

    </div>
  </div>

  <section class="section">
    <div class="container">
      <div class="title conflict has-text-weight-light depth">
        Conflict
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="title economics has-text-weight-light depth">
        Economics
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="title sports has-text-weight-light depth">
        Sports
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="title sapphire has-text-weight-light depth">
        Sapphire
      </div>
    </div>
  </section>

  <!-- Footer -->
  <?php include $parts . "footer.php"; ?>

  </body>
</html>