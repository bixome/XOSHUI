<?php
declare(strict_types=1);

$e = static fn (string|int|float $v): string
    => htmlspecialchars((string) $v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>XOSHUI</title>
<link rel="stylesheet" href="/libs/css/xoshui.css">
</head>
<body>
<div class="xo-app">

  <nav class="xo-nav" aria-label="Principale">
    <span class="xo-nav__brand">XOSHUI</span>
    <ul class="xo-nav__list">
      <li><a class="xo-nav__link" href="/" aria-current="page">Accueil</a></li>
      <li><a class="xo-nav__link" href="/layouts/">Layouts</a></li>
      <li><a class="xo-nav__link" href="/demo.php">Démo</a></li>
      <li><a class="xo-nav__link" href="/docs/api.md">Aide-mémoire</a></li>
    </ul>
    <span class="xo-spacer"></span>
    <span class="xo-muted">1.0</span>
  </nav>

  <main class="xo-main">

    <div class="xo-banner" style="margin-bottom: 16px">
      <pre class="xo-banner__art"> __  __ ___  ___ _  _ _   _ ___
 \ \/ // _ \/ __| || | | | |_ _|
  &gt;  &lt;| (_) \__ \ __ | |_| || |
 /_/\_\\___/|___/_||_|\___/|___|</pre>
      <p class="xo-banner__tagline">Bootstrap maison au look TUI — PHP / MySQL / JS vanilla</p>
    </div>

    <div class="xo-grid">

      <section class="xo-panel xo-panel--pad xo-col-4">
        <h2 class="xo-panel__title">Layouts</h2>
        <p class="xo-muted" style="margin-bottom: 8px">
          Des pages entières à copier : tableau de bord, maître-détail, table,
          explorateur, formulaire, console, article, connexion.
        </p>
        <a class="xo-btn xo-btn--primary" href="/layouts/">Parcourir</a>
      </section>

      <section class="xo-panel xo-panel--pad xo-col-4">
        <h2 class="xo-panel__title">Démo</h2>
        <p class="xo-muted" style="margin-bottom: 8px">
          Toutes les classes sur une page, en quatre onglets.
        </p>
        <a class="xo-btn" href="/demo.php">Ouvrir</a>
      </section>

      <section class="xo-panel xo-panel--pad xo-col-4">
        <h2 class="xo-panel__title">Aide-mémoire</h2>
        <p class="xo-muted" style="margin-bottom: 8px">
          Une ligne par classe. À lire avant d’écrire du HTML.
        </p>
        <a class="xo-btn" href="/docs/api.md">Lire</a>
      </section>

      <section class="xo-panel xo-panel--pad xo-col-12">
        <h2 class="xo-panel__title">Utilisation</h2>
        <pre class="xo-pre">&lt;link rel="stylesheet" href="/libs/css/xoshui.css"&gt;
&lt;script type="module" src="/libs/js/xoshui.js"&gt;&lt;/script&gt;</pre>
        <dl class="xo-kv" style="margin-top: 8px">
          <?php foreach ([
              'Feuille'      => 'libs/css/xoshui.css',
              'Module'       => 'libs/js/xoshui.js',
              'Dépendances'  => 'aucune',
              'Build'        => 'aucun',
              'PHP'          => PHP_VERSION,
          ] as $k => $v): ?>
          <div class="xo-kv__row">
            <dt><?= $e($k) ?></dt>
            <span class="xo-kv__leader" aria-hidden="true"></span>
            <dd><?= $e($v) ?></dd>
          </div>
          <?php endforeach; ?>
        </dl>
      </section>

    </div>
  </main>

  <div class="xo-keys">
    <span><kbd>Tab</kbd> parcourir</span>
    <span><kbd>Ctrl+K</kbd> commandes</span>
    <span><kbd>?</kbd> aide</span>
    <span class="xo-spacer"></span>
    <span class="xo-faint">xoshui.test</span>
  </div>

</div>
<script type="module" src="/libs/js/xoshui.js"></script>
</body>
</html>
