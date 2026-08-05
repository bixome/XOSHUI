<?php
declare(strict_types=1);
require __DIR__ . '/_nav.php';

/* ---- Données : à remplacer par vos requêtes ---------------------------- */

$stats = [
    ['Requêtes',  '12 480', '+8%',  'up'],
    ['Erreurs',   '37',     '−12%', 'down'],
    ['Latence',   '84 ms',  'p95',  ''],
    ['Sessions',  '312',    'live', ''],
];

$ressources = [
    ['CPU',    29, 'success'],
    ['Mémoire', 78, 'warning'],
    ['Disque',  94, 'danger'],
];

$services = [
    ['nginx',   'actif',  'xo-success', '✓'],
    ['php-fpm', 'actif',  'xo-success', '✓'],
    ['mysql',   'lent',   'xo-warning', '▲'],
    ['redis',   'arrêté', 'xo-danger',  '✗'],
];

$journal = [
    ['09:14:02', 'ok',    'Déploiement 1.4.2 terminé'],
    ['09:20:41', 'info',  'Cache purgé — 2 310 entrées'],
    ['09:31:08', 'warn',  'Pool de connexions à 85 %'],
    ['09:32:55', 'error', 'redis: connexion refusée sur 6379'],
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tableau de bord — XOSHUI</title>
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="stylesheet" href="/libs/css/xoshui.css">
</head>
<body>
<div class="xo-app">

<?php xo_layout_nav('dashboard'); ?>

  <div class="xo-statusbar">
    <strong>production</strong>
    <span><span class="xo-statusbar__label">hôte:</span> web-01</span>
    <span><span class="xo-statusbar__label">uptime:</span> 12 j 04:18</span>
    <span class="xo-spacer"></span>
    <span class="xo-badge xo-badge--danger">1 incident</span>
  </div>

  <main class="xo-main">

    <div class="xo-alert xo-alert--danger" role="alert" style="margin-bottom: 16px">
      <span aria-hidden="true">✗</span>
      <span class="xo-alert__body">
        <span class="xo-alert__title">redis injoignable.</span>
        Les sessions basculent sur la base depuis 09:32.
      </span>
      <button class="xo-btn xo-btn--danger">Relancer</button>
    </div>

    <!-- Métriques -->
    <div class="xo-grid">
      <?php foreach ($stats as [$label, $value, $delta, $dir]): ?>
      <section class="xo-panel xo-panel--pad xo-col-3">
        <div class="xo-stat">
          <span class="xo-stat__value"><?= xo_e($value) ?></span>
          <span class="xo-stat__label"><?= xo_e($label) ?></span>
          <span class="xo-stat__delta<?= $dir ? ' xo-stat__delta--' . xo_e($dir) : '' ?>"><?= xo_e($delta) ?></span>
        </div>
      </section>
      <?php endforeach; ?>
    </div>

    <div class="xo-grid">

      <section class="xo-panel xo-panel--pad xo-col-4">
        <h2 class="xo-panel__title">Ressources</h2>
        <div class="xo-stack xo-stack--tight">
          <?php foreach ($ressources as [$label, $pct, $mod]): ?>
          <div class="xo-progress xo-progress--<?= xo_e($mod) ?>">
            <span class="xo-progress__label"><?= xo_e($label) ?></span>
            <div class="xo-progress__track" role="meter" aria-valuenow="<?= (int) $pct ?>"
                 aria-valuemin="0" aria-valuemax="100" aria-label="<?= xo_e($label) ?>">
              <div class="xo-progress__fill" style="width: <?= (int) $pct ?>%"></div>
            </div>
            <span class="xo-progress__value"><?= (int) $pct ?>%</span>
          </div>
          <?php endforeach; ?>
          <div class="xo-row">
            <span class="xo-muted" style="min-width: 9ch">Trafic</span>
            <span class="xo-spark" aria-hidden="true">▁▂▄▇█▆▄▃▂▄▆█▇▅▃▂▁▂▄</span>
          </div>
        </div>
      </section>

      <section class="xo-panel xo-col-4">
        <h2 class="xo-panel__title">Services</h2>
        <ul class="xo-list" data-xo-list role="listbox" aria-label="Services">
          <?php foreach ($services as $i => [$nom, $etat, $cls, $glyphe]): ?>
          <li class="xo-list__item" role="option"
              aria-selected="<?= $i === 0 ? 'true' : 'false' ?>" data-value="<?= xo_e($nom) ?>">
            <span class="xo-list__icon <?= xo_e($cls) ?>" aria-hidden="true"><?= xo_e($glyphe) ?></span>
            <span><?= xo_e($nom) ?></span>
            <span class="xo-list__meta <?= xo_e($cls) ?>"><?= xo_e($etat) ?></span>
          </li>
          <?php endforeach; ?>
        </ul>
        <span class="xo-panel__count">1 of <?= count($services) ?></span>
      </section>

      <section class="xo-panel xo-panel--pad xo-col-4">
        <h2 class="xo-panel__title">Système</h2>
        <dl class="xo-kv">
          <?php foreach ([
              'Version'  => '1.4.2',
              'PHP'      => PHP_VERSION,
              'Base'     => 'MySQL 8.0.36',
              'Déploiement' => 'il y a 3 h',
          ] as $k => $v): ?>
          <div class="xo-kv__row">
            <dt><?= xo_e($k) ?></dt>
            <span class="xo-kv__leader" aria-hidden="true"></span>
            <dd><?= xo_e($v) ?></dd>
          </div>
          <?php endforeach; ?>
        </dl>
      </section>

      <section class="xo-panel xo-col-12">
        <h2 class="xo-panel__title">Journal</h2>
        <div class="xo-log" style="--xo-max-h: 14em">
          <?php foreach ($journal as [$heure, $niveau, $message]): ?>
          <div class="xo-log__line xo-log__line--<?= xo_e($niveau) ?>">
            <span class="xo-log__time"><?= xo_e($heure) ?></span>
            <span class="xo-log__level"><?= xo_e($niveau) ?></span>
            <span class="xo-log__msg"><?= xo_e($message) ?></span>
          </div>
          <?php endforeach; ?>
        </div>
      </section>

    </div>
  </main>

  <div class="xo-keys">
    <span><kbd>↑↓</kbd> naviguer</span>
    <span><kbd>r</kbd> rafraîchir</span>
    <span><kbd>Ctrl+K</kbd> commandes</span>
    <span><kbd>?</kbd> aide</span>
    <span class="xo-spacer"></span>
    <span class="xo-faint">maj. il y a 4 s</span>
  </div>

</div>
<script type="module" src="/libs/js/xoshui.js"></script>
</body>
</html>
