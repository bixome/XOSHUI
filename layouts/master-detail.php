<?php
declare(strict_types=1);
require __DIR__ . '/_nav.php';

/* ---- Données ----------------------------------------------------------- */

$tickets = [
    ['id' => 412, 'titre' => 'Timeout sur /api/export',   'etat' => 'ouvert',  'cls' => 'xo-danger'],
    ['id' => 408, 'titre' => 'Tri des colonnes inversé',  'etat' => 'en cours','cls' => 'xo-warning'],
    ['id' => 401, 'titre' => 'Ajouter le filtre par date','etat' => 'en cours','cls' => 'xo-warning'],
    ['id' => 388, 'titre' => 'Contraste des libellés',    'etat' => 'clos',    'cls' => 'xo-success'],
    ['id' => 377, 'titre' => 'Export CSV incomplet',      'etat' => 'clos',    'cls' => 'xo-success'],
];

$courant = $tickets[0];

$historique = [
    ['09:02', 'Ouvert par romain'],
    ['09:20', 'Assigné à l’équipe API'],
    ['10:41', 'Reproduit sur la recette'],
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Maître-détail — XOSHUI</title>
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="stylesheet" href="/libs/css/xoshui.css">
</head>
<body>
<div class="xo-app">

<?php xo_layout_nav('master-detail'); ?>

  <div class="xo-toolbar">
    <label class="xo-search" style="width: 32ch">
      <span class="xo-search__prefix" aria-hidden="true">/</span>
      <input type="search" placeholder="filtrer les tickets…" aria-label="Filtrer">
    </label>
    <div class="xo-btn-group" role="group" aria-label="État">
      <button class="xo-btn" aria-pressed="true">Tous</button>
      <button class="xo-btn" aria-pressed="false">Ouverts</button>
      <button class="xo-btn" aria-pressed="false">Clos</button>
    </div>
    <span class="xo-spacer"></span>
    <button class="xo-btn xo-btn--primary">+ Nouveau</button>
  </div>

  <main class="xo-main">
    <div class="xo-split" data-xo-split style="--xo-split: 34%; min-height: 32em">

      <!-- Maître -->
      <section class="xo-panel xo-panel--active" style="height: 100%; display: flex; flex-direction: column">
        <h2 class="xo-panel__title">Tickets</h2>
        <div class="xo-panel__body" style="flex: 1">
        <ul class="xo-list" data-xo-list role="listbox" aria-label="Tickets">
          <?php foreach ($tickets as $i => $t): ?>
          <li class="xo-list__item" role="option"
              aria-selected="<?= $i === 0 ? 'true' : 'false' ?>" data-value="<?= (int) $t['id'] ?>">
            <span class="xo-list__icon xo-special">#<?= (int) $t['id'] ?></span>
            <span><?= xo_e($t['titre']) ?></span>
            <span class="xo-list__meta <?= xo_e($t['cls']) ?>"><?= xo_e($t['etat']) ?></span>
          </li>
          <?php endforeach; ?>
        </ul>
        </div>
        <span class="xo-panel__count">1 of <?= count($tickets) ?></span>
      </section>

      <button class="xo-split__handle" role="separator" aria-orientation="vertical"
              aria-label="Redimensionner" aria-valuenow="34" aria-valuemin="15" aria-valuemax="85"></button>

      <!-- Détail -->
      <section class="xo-panel xo-panel--pad" style="height: 100%; display: flex; flex-direction: column">
        <h2 class="xo-panel__title">#<?= (int) $courant['id'] ?></h2>
        <div class="xo-panel__body" style="flex: 1">

        <div class="xo-row" style="margin-bottom: 8px">
          <h1 style="font-size: var(--xo-fs); font-weight: 700"><?= xo_e($courant['titre']) ?></h1>
          <span class="xo-badge xo-badge--solid xo-badge--danger"><?= xo_e($courant['etat']) ?></span>
          <span class="xo-tag">api</span>
          <span class="xo-tag xo-tag--warning">régression</span>
        </div>

        <dl class="xo-kv" style="margin-bottom: 8px">
          <?php foreach ([
              'Signalé par' => 'romain',
              'Assigné à'   => 'équipe API',
              'Créé le'     => '04/08/2026 09:02',
              'Priorité'    => 'haute',
          ] as $k => $v): ?>
          <div class="xo-kv__row">
            <dt><?= xo_e($k) ?></dt>
            <span class="xo-kv__leader" aria-hidden="true"></span>
            <dd><?= xo_e($v) ?></dd>
          </div>
          <?php endforeach; ?>
        </dl>

        <div class="xo-rule xo-rule--start">Description</div>
        <p class="xo-muted" style="margin: 8px 0">
          L’export dépasse 30 s au-delà de 50 000 lignes. Le pool de connexions sature
          et la requête est interrompue côté serveur.
        </p>

        <div class="xo-rule xo-rule--start">Trace</div>
        <pre class="xo-pre" style="margin: 8px 0">[2026-08-04 09:02:11] api.ERROR: Maximum execution time
  #0 /libs/export.php(88): Db::all()
  #1 /api/export.php(14): Export-&gt;run()</pre>

        <div class="xo-rule xo-rule--start">Historique</div>
        <ul class="xo-timeline" style="margin-top: 8px">
          <?php foreach ($historique as [$heure, $texte]): ?>
          <li class="xo-timeline__item">
            <span class="xo-timeline__marker" aria-hidden="true">●</span>
            <div class="xo-timeline__body">
              <div><?= xo_e($texte) ?></div>
              <div class="xo-timeline__time"><?= xo_e($heure) ?></div>
            </div>
          </li>
          <?php endforeach; ?>
        </ul>

        <div class="xo-row" style="margin-top: 8px">
          <button class="xo-btn xo-btn--primary">Prendre en charge</button>
          <button class="xo-btn">Commenter</button>
          <button class="xo-btn xo-btn--danger">Clore</button>
        </div>
        </div>
      </section>

    </div>
  </main>

  <div class="xo-keys">
    <span><kbd>↑↓</kbd> ticket</span>
    <span><kbd>←→</kbd> séparateur</span>
    <span><kbd>Entrée</kbd> ouvrir</span>
    <span><kbd>/</kbd> filtrer</span>
    <span class="xo-spacer"></span>
    <span class="xo-faint"><?= count($tickets) ?> tickets</span>
  </div>

</div>
<script type="module" src="/libs/js/xoshui.js"></script>
</body>
</html>
