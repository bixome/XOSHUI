<?php
declare(strict_types=1);
require __DIR__ . '/_nav.php';

/* ---- Tri : liste blanche obligatoire ----------------------------------- */

$colonnes = [
    'ref'    => ['Référence', false],
    'client' => ['Client',    false],
    'date'   => ['Date',      false],
    'total'  => ['Total',     true],
    'etat'   => ['État',      false],
];

// Jamais $_GET directement dans un ORDER BY : on valide contre les clés connues.
$tri   = isset($_GET['tri'], $colonnes[$_GET['tri']]) ? (string) $_GET['tri'] : 'date';
$sens  = ($_GET['sens'] ?? 'desc') === 'asc' ? 'asc' : 'desc';
$fleche = $sens === 'asc' ? '↑' : '↓';

$lignes = [
    ['ref' => 'CMD-2041', 'client' => 'Dupont SARL',  'date' => '04/08', 'total' => 1240.50, 'etat' => 'payée',   'cls' => 'xo-success'],
    ['ref' => 'CMD-2040', 'client' => 'Martin & Cie', 'date' => '04/08', 'total' => 89.90,   'etat' => 'en cours','cls' => 'xo-warning'],
    ['ref' => 'CMD-2039', 'client' => 'Atelier Nord', 'date' => '03/08', 'total' => 3410.00, 'etat' => 'payée',   'cls' => 'xo-success'],
    ['ref' => 'CMD-2038', 'client' => 'Leroy',        'date' => '03/08', 'total' => 15.00,   'etat' => 'annulée', 'cls' => 'xo-danger'],
    ['ref' => 'CMD-2037', 'client' => 'Bureau Sud',   'date' => '02/08', 'total' => 742.30,  'etat' => 'payée',   'cls' => 'xo-success'],
    ['ref' => 'CMD-2036', 'client' => 'Dupont SARL',  'date' => '02/08', 'total' => 210.00,  'etat' => 'remboursée', 'cls' => 'xo-muted'],
];

$page = 3;
$pages = 42;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Table — XOSHUI</title>
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="stylesheet" href="/libs/css/xoshui.css">
</head>
<body>
<div class="xo-app">

<?php xo_layout_nav('table'); ?>

  <nav class="xo-breadcrumb" aria-label="Fil d’Ariane">
    <span class="xo-breadcrumb__sep" aria-hidden="true">/</span><a href="#">ventes</a>
    <span class="xo-breadcrumb__sep" aria-hidden="true">/</span><span aria-current="page">commandes</span>
  </nav>

  <div class="xo-toolbar">
    <label class="xo-search" style="width: 30ch">
      <span class="xo-search__prefix" aria-hidden="true">/</span>
      <input type="search" placeholder="référence, client…" aria-label="Rechercher">
    </label>
    <span class="xo-toolbar__sep" aria-hidden="true"></span>
    <div class="xo-btn-group" role="group" aria-label="Période">
      <button class="xo-btn" aria-pressed="false">7 j</button>
      <button class="xo-btn" aria-pressed="true">30 j</button>
      <button class="xo-btn" aria-pressed="false">Tout</button>
    </div>
    <details class="xo-dropdown">
      <summary class="xo-btn">Exporter ▾</summary>
      <div class="xo-dropdown__menu" role="menu">
        <button class="xo-dropdown__item" role="menuitem">CSV <span class="xo-dropdown__key">c</span></button>
        <button class="xo-dropdown__item" role="menuitem">JSON <span class="xo-dropdown__key">j</span></button>
        <div class="xo-dropdown__sep" role="separator"></div>
        <button class="xo-dropdown__item" role="menuitem" aria-disabled="true">PDF (bientôt)</button>
      </div>
    </details>
    <span class="xo-spacer"></span>
    <span class="xo-muted"><?= number_format(1247, 0, ',', ' ') ?> commandes</span>
  </div>

  <main class="xo-main">
    <section class="xo-panel">
      <h2 class="xo-panel__title">Commandes</h2>

      <div class="xo-table-wrap" style="--xo-max-h: 60vh">
        <table class="xo-table" data-xo-list aria-label="Commandes">
          <thead>
            <tr>
              <?php foreach ($colonnes as $cle => [$libelle, $num]): ?>
              <th<?= $num ? ' class="xo-num"' : '' ?>>
                <a href="?tri=<?= xo_e($cle) ?>&amp;sens=<?= $tri === $cle && $sens === 'asc' ? 'desc' : 'asc' ?>">
                  <?= $tri === $cle ? $fleche : '' ?><?= xo_e($libelle) ?>
                </a>
              </th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($lignes as $i => $l): ?>
            <tr aria-selected="<?= $i === 0 ? 'true' : 'false' ?>" data-value="<?= xo_e($l['ref']) ?>">
              <td class="xo-special"><?= xo_e($l['ref']) ?></td>
              <td><?= xo_e($l['client']) ?></td>
              <td><?= xo_e($l['date']) ?></td>
              <td class="xo-num"><?= xo_e(number_format($l['total'], 2, ',', ' ')) ?> €</td>
              <td class="<?= xo_e($l['cls']) ?>"><?= xo_e($l['etat']) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <span class="xo-panel__count">1 of <?= count($lignes) ?></span>
    </section>

    <div class="xo-pagination" style="margin-top: 16px">
      <button class="xo-btn" aria-label="Première page">«</button>
      <button class="xo-btn" aria-label="Page précédente">‹</button>
      <span class="xo-pagination__info">page <?= (int) $page ?> / <?= (int) $pages ?></span>
      <button class="xo-btn" aria-label="Page suivante">›</button>
      <button class="xo-btn" aria-label="Dernière page">»</button>
    </div>
  </main>

  <div class="xo-keys">
    <span><kbd>↑↓</kbd> ligne</span>
    <span><kbd>Entrée</kbd> ouvrir</span>
    <span><kbd>/</kbd> rechercher</span>
    <span><kbd>e</kbd> exporter</span>
    <span class="xo-spacer"></span>
    <span class="xo-faint">tri : <?= xo_e($colonnes[$tri][0]) ?> <?= $fleche ?></span>
  </div>

</div>
<script type="module" src="/libs/js/xoshui.js"></script>
</body>
</html>
