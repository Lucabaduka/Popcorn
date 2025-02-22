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
    <li><a href="/records">Records</a></li>

    <?php if ($context["user"]["is_logged"]): ?>
      <li><a href="/suggest">Suggest an Issue</a></li>
    <?php else: ?>
      <li><a href="/login">Log In</a></li>
    <?php endif; ?>

  </ul>
</aside>