<?php
declare(strict_types=1);
require __DIR__ . '/_nav.php';

/* ---- Données ----------------------------------------------------------- */

$arbre = [
    ['nom' => 'libs',      'prof' => 0, 'icone' => '▾', 'cls' => 'xo-info'],
    ['nom' => 'css',       'prof' => 1, 'icone' => '▾', 'cls' => 'xo-info'],
    ['nom' => 'js',        'prof' => 1, 'icone' => '▸', 'cls' => 'xo-info'],
    ['nom' => 'layouts',   'prof' => 0, 'icone' => '▸', 'cls' => 'xo-info'],
    ['nom' => 'docs',      'prof' => 0, 'icone' => '▸', 'cls' => 'xo-info'],
    ['nom' => 'demo.php',  'prof' => 0, 'icone' => ' ', 'cls' => 'xo-alt'],
];

$fichiers = [
    ['nom' => 'xoshui.css', 'taille' => '28,4 K', 'date' => '04/08 18:36', 'cls' => ''],
    ['nom' => 'reset.css',  'taille' => '1,2 K',  'date' => '02/08 11:04', 'cls' => 'xo-faint'],
    ['nom' => 'print.css',  'taille' => '0,6 K',  'date' => '02/08 11:04', 'cls' => 'xo-faint'],
];

$apercu = <<<'CSS'
.xo-panel {
  position: relative;
  background: var(--xo-panel);
  border: 1px solid var(--xo-border);
  padding: calc(var(--xo-pad) + 2px) 0 var(--xo-pad);
  min-width: 0;
}
CSS;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Explorateur — XOSHUI</title>
<link rel="stylesheet" href="/libs/css/xoshui.css">
</head>
<body>
<div class="xo-app">

<?php xo_layout_nav('explorer'); ?>

  <nav class="xo-breadcrumb" aria-label="Chemin">
    <span class="xo-breadcrumb__sep" aria-hidden="true">/</span><a href="#">libs</a>
    <span class="xo-breadcrumb__sep" aria-hidden="true">/</span><a href="#">css</a>
    <span class="xo-breadcrumb__sep" aria-hidden="true">/</span><span aria-current="page">xoshui.css</span>
  </nav>

  <main class="xo-main">
    <div class="xo-grid">

      <!-- Volet 1 : arborescence -->
      <section class="xo-panel xo-col-3" style="max-height: 70vh; overflow: auto">
        <h2 class="xo-panel__title">Arborescence</h2>
        <ul class="xo-list xo-list--tree" data-xo-list role="tree" aria-label="Dossiers">
          <?php foreach ($arbre as $i => $n): ?>
          <li class="xo-list__item" role="treeitem"
              aria-selected="<?= $i === 1 ? 'true' : 'false' ?>"
              aria-expanded="<?= $n['icone'] === ' ' ? 'false' : ($n['icone'] === '▾' ? 'true' : 'false') ?>"
              style="--xo-depth: <?= (int) $n['prof'] ?>">
            <span class="xo-list__icon" aria-hidden="true"><?= xo_e($n['icone']) ?></span>
            <span class="<?= xo_e($n['cls']) ?>"><?= xo_e($n['nom']) ?></span>
          </li>
          <?php endforeach; ?>
        </ul>
      </section>

      <!-- Volet 2 : contenu du dossier -->
      <section class="xo-panel xo-col-4" style="max-height: 70vh; overflow: auto">
        <h2 class="xo-panel__title">libs/css</h2>
        <ul class="xo-list" data-xo-list role="listbox" aria-label="Fichiers">
          <?php foreach ($fichiers as $i => $f): ?>
          <li class="xo-list__item" role="option"
              aria-selected="<?= $i === 0 ? 'true' : 'false' ?>" data-value="<?= xo_e($f['nom']) ?>">
            <span class="xo-list__icon" aria-hidden="true">≡</span>
            <span class="<?= xo_e($f['cls']) ?>"><?= xo_e($f['nom']) ?></span>
            <span class="xo-list__meta"><?= xo_e($f['taille']) ?></span>
          </li>
          <?php endforeach; ?>
        </ul>
        <span class="xo-panel__count">1 of <?= count($fichiers) ?></span>
      </section>

      <!-- Volet 3 : aperçu -->
      <section class="xo-panel xo-panel--pad xo-col-5" style="max-height: 70vh; overflow: auto">
        <h2 class="xo-panel__title">Aperçu</h2>
        <dl class="xo-kv" style="margin-bottom: 8px">
          <?php foreach ([
              'Nom'      => 'xoshui.css',
              'Taille'   => '28,4 K',
              'Modifié'  => '04/08 18:36',
              'Lignes'   => '881',
          ] as $k => $v): ?>
          <div class="xo-kv__row">
            <dt><?= xo_e($k) ?></dt>
            <span class="xo-kv__leader" aria-hidden="true"></span>
            <dd><?= xo_e($v) ?></dd>
          </div>
          <?php endforeach; ?>
        </dl>
        <pre class="xo-pre"><?= xo_e($apercu) ?></pre>
        <div class="xo-row" style="margin-top: 8px">
          <button class="xo-btn xo-btn--primary">Ouvrir</button>
          <button class="xo-btn">Renommer</button>
          <button class="xo-btn xo-btn--danger">Supprimer</button>
        </div>
      </section>

    </div>
  </main>

  <div class="xo-keys">
    <span><kbd>↑↓</kbd> naviguer</span>
    <span><kbd>←→</kbd> volet</span>
    <span><kbd>Entrée</kbd> ouvrir</span>
    <span><kbd>/</kbd> filtrer</span>
    <span class="xo-spacer"></span>
    <span class="xo-faint">3 fichiers · 28,4 K</span>
  </div>

</div>
<script type="module" src="/libs/js/xoshui.js"></script>
</body>
</html>
