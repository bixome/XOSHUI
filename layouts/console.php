<?php
declare(strict_types=1);
require __DIR__ . '/_nav.php';

/* ---- Données ----------------------------------------------------------- */

$flux = [
    ['09:31:02', 'info',  'worker#3 démarré'],
    ['09:31:04', 'ok',    'file d’attente vidée (0 en attente)'],
    ['09:31:20', 'info',  'GET /api/orders?page=2 — 41 ms'],
    ['09:31:44', 'warn',  'cache: taux de succès 61 % sur 5 min'],
    ['09:32:01', 'info',  'POST /api/orders — 128 ms'],
    ['09:32:12', 'error', 'redis: connexion refusée sur 127.0.0.1:6379'],
    ['09:32:12', 'warn',  'bascule des sessions vers MySQL'],
    ['09:32:40', 'ok',    'worker#3 sain'],
];

$sources = [
    ['app',    true],
    ['nginx',  true],
    ['mysql',  false],
    ['redis',  true],
    ['cron',   false],
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Console — XOSHUI</title>
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="stylesheet" href="/libs/css/xoshui.css">
</head>
<body>
<div class="xo-app">

<?php xo_layout_nav('console'); ?>

  <!-- Tout l'écran est en mode console. La navigation du site reste en dehors :
       c'est le chrome de la vitrine, pas de l'outil. Retirer « xo-console »
       ci-dessous rend la recette à sa grammaire d'origine, sans rien d'autre
       à changer. -->
  <div class="xo-console" style="flex: 1; display: flex; flex-direction: column; min-height: 0">

  <div class="xo-toolbar">
    <div class="xo-btn-group" role="group" aria-label="Niveau">
      <button class="xo-btn" aria-pressed="true">Tout</button>
      <button class="xo-btn" aria-pressed="false">Warn</button>
      <button class="xo-btn" aria-pressed="false">Error</button>
    </div>
    <span class="xo-toolbar__sep" aria-hidden="true"></span>
    <label class="xo-search" style="width: 30ch">
      <span class="xo-search__prefix" aria-hidden="true">/</span>
      <input type="search" placeholder="filtrer le flux…" aria-label="Filtrer">
    </label>
    <label class="xo-check">
      <input type="checkbox" checked>
      <span>Suivre</span>
    </label>
    <span class="xo-spacer"></span>
    <span class="xo-row">
      <span class="xo-spinner" aria-hidden="true"></span>
      <span class="xo-muted">en écoute</span>
    </span>
  </div>

  <main class="xo-main">
    <div class="xo-grid">

      <section class="xo-panel xo-col-9" style="display: flex; flex-direction: column">
        <h2 class="xo-panel__title">Flux</h2>

        <div class="xo-log" style="--xo-max-h: 52vh; flex: 1">
          <?php foreach ($flux as [$heure, $niveau, $message]): ?>
          <div class="xo-log__line xo-log__line--<?= xo_e($niveau) ?>">
            <span class="xo-log__time"><?= xo_e($heure) ?></span>
            <span class="xo-log__level"><?= xo_e($niveau) ?></span>
            <span class="xo-log__msg"><?= xo_e($message) ?></span>
          </div>
          <?php endforeach; ?>
        </div>

        <form class="xo-prompt" method="post" action="" style="padding: 8px 1ch; border-top: 1px solid var(--xo-rule)">
          <span class="xo-prompt__sign" aria-hidden="true">$</span>
          <input type="text" name="cmd" placeholder="tail -f app.log" aria-label="Commande" autofocus>
          <span class="xo-cursor" aria-hidden="true"></span>
        </form>

        <span class="xo-panel__count"><?= count($flux) ?> lignes</span>
      </section>

      <div class="xo-col-3 xo-stack">
        <section class="xo-panel xo-panel--pad">
          <h2 class="xo-panel__title">Sources</h2>
          <div class="xo-stack xo-stack--tight">
            <?php foreach ($sources as [$nom, $actif]): ?>
            <label class="xo-check">
              <input type="checkbox" <?= $actif ? 'checked' : '' ?>>
              <span><?= xo_e($nom) ?></span>
            </label>
            <?php endforeach; ?>
          </div>
        </section>

        <section class="xo-panel xo-panel--pad">
          <h2 class="xo-panel__title">Volume</h2>
          <div class="xo-bars">
            <?php foreach (['info' => 61, 'ok' => 22, 'warn' => 12, 'error' => 5] as $niveau => $pct): ?>
            <span class="xo-bars__label"><?= xo_e($niveau) ?></span>
            <span class="xo-bars__bar" aria-hidden="true"><?= str_repeat('█', (int) round($pct / 5)) ?></span>
            <span class="xo-bars__value"><?= (int) $pct ?>%</span>
            <?php endforeach; ?>
          </div>
        </section>

        <section class="xo-panel xo-panel--pad">
          <h2 class="xo-panel__title">Session</h2>
          <dl class="xo-kv">
            <?php foreach ([
                'Depuis'  => '09:14',
                'Lignes'  => '4 812',
                'Débit'   => '18 /s',
            ] as $k => $v): ?>
            <div class="xo-kv__row">
              <dt><?= xo_e($k) ?></dt>
              <span class="xo-kv__leader" aria-hidden="true"></span>
              <dd><?= xo_e($v) ?></dd>
            </div>
            <?php endforeach; ?>
          </dl>
        </section>
      </div>

    </div>
  </main>

  <div class="xo-keys">
    <span><kbd>↑↓</kbd> historique</span>
    <span><kbd>Entrée</kbd> exécuter</span>
    <span><kbd>Ctrl+L</kbd> effacer</span>
    <span><kbd>/</kbd> filtrer</span>
    <span class="xo-spacer"></span>
    <span class="xo-faint">app · nginx · redis</span>
  </div>

  </div>

</div>
<script type="module" src="/libs/js/xoshui.js"></script>
</body>
</html>
