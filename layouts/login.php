<?php
declare(strict_types=1);
require __DIR__ . '/_nav.php';

$erreur = null; // ex. 'Identifiants invalides.'
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Connexion — XOSHUI</title>
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="stylesheet" href="/libs/css/xoshui.css">
</head>
<body>
<div class="xo-app">

<?php xo_layout_nav('login'); ?>

  <main class="xo-main" style="display: flex; align-items: center; justify-content: center">

    <div style="width: min(56ch, 100%)">

      <div class="xo-banner" style="margin-bottom: 16px">
        <pre class="xo-banner__art">┌───────────────────────┐
│   X O S H U I   1.0   │
└───────────────────────┘</pre>
        <p class="xo-banner__tagline">Authentification requise</p>
      </div>

      <?php if ($erreur !== null): ?>
      <div class="xo-alert xo-alert--danger" role="alert" style="margin-bottom: 16px">
        <span aria-hidden="true">!</span>
        <span class="xo-alert__body"><?= xo_e($erreur) ?></span>
      </div>
      <?php endif; ?>

      <section class="xo-panel xo-panel--pad xo-panel--active">
        <h1 class="xo-panel__title">Connexion</h1>

        <form method="post" action="">
          <div class="xo-field">
            <label class="xo-label" for="l-user">Identifiant</label>
            <input class="xo-input" id="l-user" name="user" autocomplete="username" autofocus required>
          </div>

          <div class="xo-field">
            <label class="xo-label" for="l-pass">Mot de passe</label>
            <input class="xo-input" id="l-pass" name="pass" type="password"
                   autocomplete="current-password" required>
          </div>

          <div class="xo-row" style="margin-bottom: 16px">
            <label class="xo-check">
              <input type="checkbox" name="memoriser">
              <span>Rester connecté</span>
            </label>
            <span class="xo-spacer"></span>
            <a href="#">Mot de passe oublié ?</a>
          </div>

          <button class="xo-btn xo-btn--primary" type="submit" style="width: 100%; justify-content: center">
            Se connecter
          </button>
        </form>

        <span class="xo-panel__count">TLS actif</span>
      </section>

      <div class="xo-rule" style="margin: 16px 0">ou</div>

      <div class="xo-row" style="justify-content: center">
        <button class="xo-btn">Clé SSO</button>
        <button class="xo-btn">Jeton d’accès</button>
      </div>

      <p class="xo-faint" style="text-align: center; margin-top: 16px">
        Trois échecs consécutifs verrouillent le compte 15 minutes.
      </p>

    </div>
  </main>

  <div class="xo-keys">
    <span><kbd>Tab</kbd> champ suivant</span>
    <span><kbd>Entrée</kbd> valider</span>
    <span class="xo-spacer"></span>
    <span class="xo-faint">xoshui.test</span>
  </div>

</div>
<script type="module" src="/libs/js/xoshui.js"></script>
</body>
</html>
