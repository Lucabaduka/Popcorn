<?php

// Only display the admin link if the user is an admin
if ($context["user"]["is_admin"]) {
  $admin_link = '<p class="menu-label">Administration</p>
  <ul class="menu-list">
    <li><a href="/admin">Admin Controls</a></li>
  </ul>';
} else {
  $admin_link = '';
}

?>

<aside class="menu mslim pl-4">
  <?=$admin_link?>
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