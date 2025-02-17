<aside class="menu mslim pl-4">

  <?php if ($context["user"]["is_admin"]): ?>
  <p class="menu-label">Administration</p>
    <ul class="menu-list">
      <li><a href="/admin">Admin Controls</a></li>
    </ul>
  <?php endif; ?>

  <p class="menu-label">General</p>
  <ul class="menu-list">
  <li><a href="/">Main Page</a></li>
    <li><a href="/bets">Your Bets</a></li>
    <li><a href="/archives">Archives</a></li>
  </ul>
  <p class="menu-label">Extras</p>
  <ul class="menu-list">
    <li><a href="/suggest">Suggest a Bet</a></li>
  </ul>
</aside>