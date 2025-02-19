<header id="head">
  <nav class="navbar">
    <div class="navbar-brand">
      <a class="navbar-item depth glowm" href="https://calref.ca/">
        <img height="48" width="48" src="/Static/Assets/icon.svg" alt="CalRef Logo" aria-label="Visit Calamity Refuge">
        <span class="depth mslim">CalRef</span>
      </a>
      <a class="mobile navbar-item px-2 depth" href="/">Main</a>

      <?php if ($context["user"]["is_admin"]): ?>
        <a class="mobile navbar-item px-2 depth" href="/admin">Admin</a>
      <?php endif; ?>

      <a class="mobile navbar-item px-2 depth" href="/records">Records</a>
      <a class="mobile navbar-item px-2 depth" href="/suggest">Ideas</a>
    </div>

    <div class="navbar-menu">
      <div class="navbar-end">
        <a href="https://calref.ca/dot/" class="navbar-item depth"><i class="ico ico-dot"></i>Dot</a>
        <a href="https://eyebeast.calref.ca/" class="navbar-item depth"><i class="ico ico-eyebeast"></i>Eyebeast</a>
        <a href="https://tart.calref.ca/" class="navbar-item depth"><i class="ico ico-tart"></i>Tart</a>
        <a href="https://pop.calref.ca/" class="navbar-item depth"><i class="ico ico-popcorn"></i>Popcorn</a>
        <a href="https://rmm.calref.ca/" class="navbar-item depth"><i class="ico ico-rmm"></i>RMM</a>
      </div>
    </div>
  </nav>
</header>