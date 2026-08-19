<?php
declare(strict_types=1);

/**
 * L'écran de contrôle : tout le framework en une page, sans explication.
 *
 * Rôle distinct des autres entrées — components/ isole un composant et le
 * commente, layouts/ en assemble des pages entières, celle-ci les montre
 * tous à la fois. C'est ici qu'on juge la densité et la cohésion : un défaut
 * d'ensemble ne se voit pas sur une page qui ne montre qu'une chose.
 */

require __DIR__ . '/libs/site.php';
$e = 'xo_e';

$processus = [
    ['pid' => 58406, 'user' => 'romain', 'cpu' => 41.0, 'mem' => 0.9,  'cmd' => 'php-fpm'],
    ['pid' => 400,   'user' => 'romain', 'cpu' => 7.5,  'mem' => 1.2,  'cmd' => 'mysqld'],
    ['pid' => 91045, 'user' => 'romain', 'cpu' => 5.2,  'mem' => 15.2, 'cmd' => 'chrome'],
    ['pid' => 578,   'user' => 'root',   'cpu' => 3.6,  'mem' => 0.2,  'cmd' => 'httpd'],
];

$branches = [
    ['nom' => 'main',            'meta' => '✓',  'cls' => 'xo-success'],
    ['nom' => 'feat/tokens',     'meta' => '1d', 'cls' => ''],
    ['nom' => 'feat/components', 'meta' => '3d', 'cls' => ''],
    ['nom' => 'fix/contrast',    'meta' => '1w', 'cls' => ''],
];

$arbre = [
    ['icone' => '▾', 'nom' => 'libs',       'prof' => 0, 'cls' => 'xo-info'],
    ['icone' => '▾', 'nom' => 'css',        'prof' => 1, 'cls' => 'xo-info'],
    ['icone' => ' ', 'nom' => 'xoshui.css', 'prof' => 2, 'cls' => ''],
    ['icone' => '▸', 'nom' => 'js',         'prof' => 1, 'cls' => 'xo-info'],
    ['icone' => ' ', 'nom' => 'demo.php',   'prof' => 0, 'cls' => 'xo-alt'],
];

$journal = [
    ['14:00:27', 'ok',    'Connexion établie sur xoshui.test'],
    ['14:00:31', 'info',  'Cache vidé — 128 entrées'],
    ['14:01:02', 'warn',  'Requête lente : SELECT * FROM sessions (1.4 s)'],
    ['14:01:09', 'error', 'Échec du montage /mnt/backup'],
];

/* ---- Onglets 6 et 7 : les deux modes ------------------------------------ */

/**
 * Les rangées d'un graphe temporel, en blocs — voir docs/api.md.
 *
 * @param list<float> $valeurs entre 0 et 1
 * @return list<string>
 */
function xo_demo_plot(array $valeurs, int $hauteur): array
{
    $blocs   = [' ', '▁', '▂', '▃', '▄', '▅', '▆', '▇', '█'];
    $rangees = array_fill(0, $hauteur, '');

    foreach ($valeurs as $v) {
        $rempli = max(0.0, min(1.0, $v)) * $hauteur;
        for ($r = 0; $r < $hauteur; $r++) {
            $part = max(0.0, min(1.0, $rempli - ($hauteur - 1 - $r)));
            $rangees[$r] .= $blocs[(int) round($part * 8)];
        }
    }

    return $rangees;
}

/* Console — arbre, série et carte, tous figés : l'écran de contrôle doit se
   lire à l'identique d'un rechargement à l'autre. */
$conArbre = [
    ['',       '▾', 'xoshui',     'xo-info', ''],
    ['├─',     '▾', 'libs',       'xo-info', ''],
    ['│  ├─',  ' ', 'xoshui.css', '',        '41K'],
    ['│  └─',  ' ', 'xoshui.js',  '',        '13K'],
    ['├─',     '▸', 'layouts',    'xo-info', '10'],
    ['└─',     ' ', 'demo.php',   'xo-alt',  '46K'],
];

$conSerie = [];
for ($i = 0; $i < 60; $i++) {
    $conSerie[] = max(0.0, min(1.0, 0.45 + 0.34 * sin($i / 7) + 0.16 * sin($i / 2.3)));
}
$conPic = (int) round(max($conSerie) * 100);

$conHeat = [];
foreach (['lun', 'mar', 'mer', 'jeu', 'ven', 'sam', 'dim'] as $d => $jour) {
    $ligne = [];
    for ($h = 0; $h < 24; $h++) {
        $charge = sin(max(0.0, ($h - 6) / 16) * M_PI) * ($d >= 5 ? 0.35 : 1.0);
        $ligne[] = max(0, min(4, (int) round($charge * 4)));
    }
    $conHeat[$jour] = $ligne;
}
$conNiveaux = [0 => '·', 1 => '░', 2 => '▒', 3 => '▓', 4 => '█'];

$conMois     = new DateTimeImmutable('2026-08-01');
$conJours    = (int) $conMois->format('t');
$conDecalage = (int) $conMois->format('N') - 1;   // 0 = lundi

/* CLI — le transcrit d'un déploiement. */
$cliDeps = [
    ['',      'xoshui',         '1.0.0',   'xo-info'],
    ['├─',    'jetbrains-mono', '2.304',   ''],
    ['├─',    'php-fpm',        '8.3.30',  ''],
    ['│  └─', 'opcache',        'intégré', 'xo-muted'],
    ['└─',    'nginx',          '1.25.3',  ''],
];

$cliFichiers = [
    ['✓', 'libs/css/xoshui.css',   '41.2K', 'xo-success'],
    ['✓', 'libs/js/xoshui.js',     '12.8K', 'xo-success'],
    ['✓', 'libs/site.php',          '7.4K', 'xo-success'],
    ['⚠', 'templates/page-nue.php', '1.1K', 'xo-warning'],
    ['✓', 'demo.php',              '46.0K', 'xo-success'],
];

$cliFlux = [
    ['09:41:02', 'info',  'xoshui-deploy 1.0 — cible : xoshui.test'],
    ['09:41:03', 'ok',    'lint : 0 erreur, 0 avertissement sur 44 fichiers'],
    ['09:41:07', 'info',  'copie de 44 fichiers'],
    ['09:41:12', 'warn',  'templates/page-nue.php : aucun xo-keys en bas d’écran'],
    ['09:41:14', 'ok',    'déploiement terminé en 12,4 s'],
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Démo — XOSHUI</title>
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="stylesheet" href="/libs/css/xoshui.css">
</head>
<body>
<div class="xo-app">

<?php xo_nav('demo'); ?>

  <div class="xo-statusbar">
    <strong>XOSHUI</strong>
    <span><span class="xo-statusbar__label">v</span>1.0</span>
    <span><span class="xo-statusbar__label">CPU:</span> <span class="xo-success">29%</span></span>
    <span><span class="xo-statusbar__label">TEMP:</span> <span class="xo-warning">74°C</span></span>
    <span class="xo-spacer"></span>
    <span class="xo-faint">tout à l’écran, sans commentaire — le détail est dans
      <a href="/components/">Composants</a></span>
  </div>

  <main class="xo-main">

    <div class="xo-tabs" data-xo-tabs role="tablist">
      <button class="xo-tabs__tab" role="tab" aria-selected="true"  aria-controls="t-struct">[1] Structure</button>
      <button class="xo-tabs__tab" role="tab" aria-selected="false" aria-controls="t-data">[2] Données</button>
      <button class="xo-tabs__tab" role="tab" aria-selected="false" aria-controls="t-form">[3] Formulaire</button>
      <button class="xo-tabs__tab" role="tab" aria-selected="false" aria-controls="t-retour">[4] Retour</button>
      <button class="xo-tabs__tab" role="tab" aria-selected="false" aria-controls="t-code">[5] Code</button>
      <button class="xo-tabs__tab" role="tab" aria-selected="false" aria-controls="t-console">[6] Console</button>
      <button class="xo-tabs__tab" role="tab" aria-selected="false" aria-controls="t-cli">[7] CLI</button>
    </div>

    <!-- ============================================== 1. Structure -->
    <section id="t-struct" role="tabpanel" class="xo-tabpanel">

      <div class="xo-banner" style="margin-bottom: 16px">
        <pre class="xo-banner__art"> __  __ ___  ___ _  _ _   _ ___
 \ \/ // _ \/ __| || | | | |_ _|
  &gt;  &lt;| (_) \__ \ __ | |_| || |
 /_/\_\\___/|___/_||_|\___/|___|</pre>
        <p class="xo-banner__tagline">238 classes, une feuille, un module</p>
      </div>

      <nav class="xo-breadcrumb" aria-label="Fil d’Ariane" style="margin-bottom: 16px">
        <span class="xo-breadcrumb__sep" aria-hidden="true">/</span><a href="/">accueil</a>
        <span class="xo-breadcrumb__sep" aria-hidden="true">/</span><span aria-current="page">démo</span>
      </nav>

      <div class="xo-menubar" style="margin-bottom: 16px">
        <?php foreach (['F1' => 'Aide', 'F2' => 'Ouvrir', 'F3' => 'Chercher', 'F10' => 'Quitter'] as $k => $v): ?>
        <button class="xo-menubar__item"><span class="xo-menubar__key"><?= $e($k) ?></span><?= $e($v) ?></button>
        <?php endforeach; ?>
      </div>

      <div class="xo-toolbar">
        <div class="xo-btn-group" role="group" aria-label="Tri">
          <button class="xo-btn" aria-pressed="true">CPU</button>
          <button class="xo-btn" aria-pressed="false">MEM</button>
          <button class="xo-btn" aria-pressed="false">PID</button>
        </div>
        <span class="xo-toolbar__sep" aria-hidden="true"></span>
        <label class="xo-search" style="width: 24ch">
          <span class="xo-search__prefix" aria-hidden="true">/</span>
          <input type="search" placeholder="filtrer…" aria-label="Filtrer">
        </label>
        <details class="xo-dropdown">
          <summary class="xo-btn">Actions ▾</summary>
          <div class="xo-dropdown__menu" role="menu">
            <button class="xo-dropdown__item" role="menuitem">Rafraîchir <span class="xo-dropdown__key">r</span></button>
            <div class="xo-dropdown__sep" role="separator"></div>
            <button class="xo-dropdown__item" role="menuitem" aria-disabled="true">Tuer <span class="xo-dropdown__key">k</span></button>
          </div>
        </details>
        <span class="xo-spacer"></span>
        <span class="xo-muted xo-nowrap">537 tâches</span>
      </div>

      <div class="xo-grid">

        <section class="xo-panel xo-panel--active xo-col-3">
          <h2 class="xo-panel__title">Branches</h2>
          <div class="xo-panel__body" style="--xo-max-h: 12em">
            <ul class="xo-list" data-xo-list role="listbox" aria-label="Branches">
              <?php foreach ($branches as $i => $b): ?>
              <li class="xo-list__item" role="option" aria-selected="<?= $i === 0 ? 'true' : 'false' ?>">
                <span class="xo-list__icon" aria-hidden="true">├</span>
                <span><?= $e($b['nom']) ?></span>
                <span class="xo-list__meta <?= $e($b['cls']) ?>"><?= $e($b['meta']) ?></span>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
          <span class="xo-panel__count">1 of <?= count($branches) ?></span>
        </section>

        <section class="xo-panel xo-col-3">
          <h2 class="xo-panel__title">Arbre</h2>
          <ul class="xo-list xo-list--tree" data-xo-list role="tree" aria-label="Fichiers">
            <?php foreach ($arbre as $n): ?>
            <li class="xo-list__item" role="treeitem" style="--xo-depth: <?= (int) $n['prof'] ?>">
              <span class="xo-list__icon" aria-hidden="true"><?= $e($n['icone']) ?></span>
              <span class="<?= $e($n['cls']) ?>"><?= $e($n['nom']) ?></span>
            </li>
            <?php endforeach; ?>
          </ul>
        </section>

        <section class="xo-panel xo-panel--pad xo-col-6">
          <h2 class="xo-panel__title">Colonnes et séparateur</h2>
          <div class="xo-grid">
            <?php foreach ([2, 4, 6, 3, 9, 5, 8, 12] as $n): ?>
            <span class="xo-col-<?= (int) $n ?>" style="background: var(--xo-subtle); text-align: center">
              <?= (int) $n ?>
            </span>
            <?php endforeach; ?>
          </div>
          <div class="xo-split" data-xo-split style="min-height: 6em; border: 1px solid var(--xo-border); margin-top: 16px">
            <div class="xo-scroll" style="padding: 8px 1ch">Gauche</div>
            <button class="xo-split__handle" role="separator" aria-orientation="vertical"
                    aria-label="Redimensionner" aria-valuenow="50" aria-valuemin="15" aria-valuemax="85"></button>
            <div class="xo-scroll" style="padding: 8px 1ch">Droite — ← → au clavier</div>
          </div>
        </section>

        <section class="xo-panel xo-col-12" style="padding: 0">
          <div class="xo-layout" style="min-height: 10em">
            <nav class="xo-sidebar" aria-label="Sections">
              <div class="xo-sidebar__group">Projet</div>
              <a class="xo-sidebar__link" href="#" aria-current="page">Vue d’ensemble</a>
              <a class="xo-sidebar__link" href="#">Fichiers</a>
              <div class="xo-sidebar__group">Réglages</div>
              <a class="xo-sidebar__link" href="#">Accès</a>
            </nav>
            <main class="xo-main">
              <article class="xo-prose">
                <h2>Texte de lecture</h2>
                <p>Seule zone qui ne remplit pas l’écran : <code>80ch</code> au plus.
                Au-delà, l’œil décroche en fin de ligne.</p>
                <ul><li>Les marges que le reset supprime sont rétablies ici.</li></ul>
              </article>
            </main>
          </div>
        </section>

      </div>
    </section>

    <!-- ================================================ 2. Données -->
    <section id="t-data" role="tabpanel" class="xo-tabpanel" hidden>
      <div class="xo-grid">

        <?php foreach ([
            ['12 480', 'Requêtes', '+8%',  'up'],
            ['37',     'Erreurs',  '−12%', 'down'],
            ['84 ms',  'Latence',  'p95',  ''],
            ['312',    'Sessions', 'live', ''],
        ] as [$v, $l, $d, $dir]): ?>
        <section class="xo-panel xo-panel--pad xo-col-3">
          <div class="xo-stat">
            <span class="xo-stat__value"><?= $e($v) ?></span>
            <span class="xo-stat__label"><?= $e($l) ?></span>
            <span class="xo-stat__delta<?= $dir ? ' xo-stat__delta--' . $e($dir) : '' ?>"><?= $e($d) ?></span>
          </div>
        </section>
        <?php endforeach; ?>

        <section class="xo-panel xo-col-8">
          <h2 class="xo-panel__title">Processus</h2>
          <div class="xo-table-wrap" style="--xo-max-h: 12em">
            <table class="xo-table" data-xo-list aria-label="Processus">
              <thead><tr><th>PID</th><th>USER</th><th class="xo-num">CPU%</th><th class="xo-num">MEM%</th><th>CMD</th></tr></thead>
              <tbody>
                <?php foreach ($processus as $i => $p): ?>
                <tr aria-selected="<?= $i === 0 ? 'true' : 'false' ?>">
                  <td class="xo-special"><?= $e($p['pid']) ?></td>
                  <td><?= $e($p['user']) ?></td>
                  <td class="xo-num"><?= $e(number_format($p['cpu'], 1)) ?></td>
                  <td class="xo-num"><?= $e(number_format($p['mem'], 1)) ?></td>
                  <td><?= $e($p['cmd']) ?></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <span class="xo-panel__count">1 of <?= count($processus) ?></span>
        </section>

        <section class="xo-panel xo-panel--pad xo-col-4">
          <h2 class="xo-panel__title">Système</h2>
          <dl class="xo-kv">
            <?php foreach (['Version' => '1.0', 'PHP' => PHP_VERSION, 'Hôte' => 'xoshui.test'] as $k => $v): ?>
            <div class="xo-kv__row">
              <dt><?= $e($k) ?></dt>
              <span class="xo-kv__leader" aria-hidden="true"></span>
              <dd><?= $e($v) ?></dd>
            </div>
            <?php endforeach; ?>
          </dl>
        </section>

        <section class="xo-panel xo-panel--pad xo-col-6">
          <h2 class="xo-panel__title">Ressources</h2>
          <div class="xo-stack xo-stack--tight">
            <?php foreach ([['CPU', 29, 'success'], ['Mémoire', 78, 'warning'], ['Disque', 94, 'danger']] as [$l, $p, $mod]): ?>
            <div class="xo-progress xo-progress--<?= $e($mod) ?>">
              <span class="xo-progress__label"><?= $e($l) ?></span>
              <div class="xo-progress__track" role="meter" aria-valuenow="<?= (int) $p ?>"
                   aria-valuemin="0" aria-valuemax="100" aria-label="<?= $e($l) ?>">
                <div class="xo-progress__fill" style="width: <?= (int) $p ?>%"></div>
              </div>
              <span class="xo-progress__value"><?= (int) $p ?>%</span>
            </div>
            <?php endforeach; ?>
            <div class="xo-row">
              <span class="xo-muted" style="min-width: 9ch">Trafic</span>
              <span class="xo-spark" aria-hidden="true">▁▂▄▇█▆▄▃▂▄▆█▇▅▃▂▁</span>
            </div>
            <div class="xo-bars">
              <?php foreach (['CSS' => 62, 'JS' => 21, 'PHP' => 12] as $lang => $pct): ?>
              <span class="xo-bars__label"><?= $e($lang) ?></span>
              <span class="xo-bars__bar" aria-hidden="true"><?= str_repeat('█', (int) round($pct / 4)) ?></span>
              <span class="xo-bars__value"><?= (int) $pct ?>%</span>
              <?php endforeach; ?>
            </div>
          </div>
        </section>

        <section class="xo-panel xo-panel--pad xo-col-6">
          <h2 class="xo-panel__title">Suivi</h2>
          <div class="xo-steps" style="margin-bottom: 8px">
            <span class="xo-steps__step xo-steps__step--done">✓ Analyse</span>
            <span class="xo-steps__sep" aria-hidden="true">─►</span>
            <span class="xo-steps__step" aria-current="step">● Build</span>
            <span class="xo-steps__sep" aria-hidden="true">─►</span>
            <span class="xo-steps__step">○ Envoi</span>
          </div>
          <ul class="xo-timeline">
            <?php foreach ([['14:00', 'Dépôt initialisé'], ['14:12', 'Premier lot de composants']] as [$h, $t]): ?>
            <li class="xo-timeline__item">
              <span class="xo-timeline__marker" aria-hidden="true">●</span>
              <div class="xo-timeline__body">
                <div><?= $e($t) ?></div>
                <div class="xo-timeline__time"><?= $e($h) ?></div>
              </div>
            </li>
            <?php endforeach; ?>
          </ul>
        </section>

        <section class="xo-panel xo-col-12">
          <h2 class="xo-panel__title">Journal</h2>
          <div class="xo-log" style="--xo-max-h: 8em">
            <?php foreach ($journal as [$h, $n, $msg]): ?>
            <div class="xo-log__line xo-log__line--<?= $e($n) ?>">
              <span class="xo-log__time"><?= $e($h) ?></span>
              <span class="xo-log__level"><?= $e($n) ?></span>
              <span class="xo-log__msg"><?= $e($msg) ?></span>
            </div>
            <?php endforeach; ?>
          </div>
        </section>

      </div>
    </section>

    <!-- ============================================= 3. Formulaire -->
    <section id="t-form" role="tabpanel" class="xo-tabpanel" hidden>
      <div class="xo-grid">

        <section class="xo-panel xo-panel--pad xo-col-6">
          <h2 class="xo-panel__title">Champs</h2>
          <div class="xo-field">
            <label class="xo-label" for="d-hote">Hôte</label>
            <input class="xo-input" id="d-hote" value="localhost">
          </div>
          <div class="xo-field">
            <label class="xo-label" for="d-port">Port</label>
            <input class="xo-input" id="d-port" value="33O6" aria-invalid="true" aria-describedby="d-port-e">
            <span class="xo-error" id="d-port-e">! Valeur numérique attendue</span>
          </div>
          <div class="xo-field">
            <label class="xo-label" for="d-mode">Mode</label>
            <select class="xo-select" id="d-mode"><option>Développement</option><option>Production</option></select>
          </div>
          <div class="xo-field">
            <label class="xo-label" for="d-note">Notes</label>
            <textarea class="xo-textarea" id="d-note" placeholder="Optionnel…"></textarea>
            <span class="xo-hint">xo-hint pour l’aide d’un champ.</span>
          </div>
          <div class="xo-field xo-field--inline">
            <label class="xo-label" for="d-inline">En ligne</label>
            <input class="xo-input" id="d-inline" value="libellé à gauche">
          </div>
        </section>

        <section class="xo-panel xo-panel--pad xo-col-6">
          <h2 class="xo-panel__title">Contrôles et actions</h2>
          <fieldset class="xo-fieldset">
            <legend>Options</legend>
            <div class="xo-stack xo-stack--tight">
              <label class="xo-check"><input type="checkbox" checked> Forcer TLS</label>
              <label class="xo-check"><input type="checkbox"> Journaliser</label>
              <label class="xo-check"><input type="checkbox" disabled> Indisponible</label>
              <div class="xo-rule">Jeu de caractères</div>
              <label class="xo-radio"><input type="radio" name="d-cs" checked> utf8mb4</label>
              <label class="xo-radio"><input type="radio" name="d-cs"> latin1</label>
              <div class="xo-range">
                <span class="xo-muted" style="min-width: 12ch">Connexions</span>
                <input type="range" min="1" max="64" value="16" aria-label="Connexions">
                <span class="xo-range__value">16</span>
              </div>
              <div class="xo-file"><input type="file" aria-label="Fichier"></div>
            </div>
          </fieldset>

          <div class="xo-row" style="margin-top: 16px">
            <button class="xo-btn">Neutre</button>
            <button class="xo-btn xo-btn--primary">Principal</button>
            <button class="xo-btn xo-btn--danger">Destructif</button>
            <button class="xo-btn xo-btn--ghost">Discret</button>
            <button class="xo-btn" disabled>Inerte</button>
          </div>
          <div class="xo-row" style="margin-top: 8px">
            <button class="xo-btn"><span class="xo-icon" aria-hidden="true">✓</span> Valider</button>
            <button class="xo-btn xo-btn--ghost">[/] filtrer</button>
            <a class="xo-btn" href="/components/button.php">Lien-bouton</a>
          </div>
          <div class="xo-pagination" style="margin-top: 16px">
            <button class="xo-btn" aria-label="Première">«</button>
            <button class="xo-btn" aria-label="Précédente">‹</button>
            <span class="xo-pagination__info">page 3 / 42</span>
            <button class="xo-btn" aria-label="Suivante">›</button>
            <button class="xo-btn" aria-label="Dernière">»</button>
          </div>
        </section>

      </div>
    </section>

    <!-- ================================================= 4. Retour -->
    <section id="t-retour" role="tabpanel" class="xo-tabpanel" hidden>
      <div class="xo-grid">

        <section class="xo-panel xo-panel--pad xo-col-6">
          <h2 class="xo-panel__title">Alertes</h2>
          <div class="xo-stack xo-stack--tight">
            <div class="xo-alert" role="status"><span aria-hidden="true">i</span>
              <span class="xo-alert__body">Information neutre.</span></div>
            <div class="xo-alert xo-alert--success" role="status"><span aria-hidden="true">✓</span>
              <span class="xo-alert__body"><span class="xo-alert__title">Déployé.</span> Version 1.4.2.</span></div>
            <div class="xo-alert xo-alert--warning" role="status"><span aria-hidden="true">▲</span>
              <span class="xo-alert__body"><span class="xo-alert__title">Disque.</span> 94 % occupés.</span></div>
            <div class="xo-alert xo-alert--danger" role="alert"><span aria-hidden="true">✗</span>
              <span class="xo-alert__body"><span class="xo-alert__title">redis.</span> Injoignable.</span></div>
          </div>
        </section>

        <section class="xo-panel xo-panel--pad xo-col-6">
          <h2 class="xo-panel__title">Marqueurs</h2>
          <div class="xo-row">
            <span class="xo-badge xo-badge--success">✓ READY</span>
            <span class="xo-badge xo-badge--warning">▲ M</span>
            <span class="xo-badge xo-badge--danger">✗ FAIL</span>
            <span class="xo-badge xo-badge--info">● 3</span>
            <span class="xo-badge">??</span>
            <span class="xo-badge xo-badge--solid xo-badge--danger">bloqué</span>
          </div>
          <div class="xo-row" style="margin-top: 8px">
            <span class="xo-tag xo-tag--accent">api</span>
            <span class="xo-tag">css</span>
            <span class="xo-tag xo-tag--success">à jour</span>
            <span class="xo-tag xo-tag--danger">cassé</span>
            <span class="xo-tag xo-tag--warning">non suivi
              <button class="xo-tag__remove" aria-label="Retirer">×</button></span>
          </div>
          <div class="xo-row" style="margin-top: 8px">
            <span class="xo-avatar">RL</span>
            <span>Romain Lamboley</span>
            <span class="xo-muted" data-xo-tip="Infobulle au survol et au focus" tabindex="0">survolez-moi</span>
          </div>
          <div class="xo-row" style="margin-top: 8px">
            <span class="xo-accent">accent</span><span class="xo-success">succès</span>
            <span class="xo-warning">alerte</span><span class="xo-danger">erreur</span>
            <span class="xo-info">info</span><span class="xo-special">spécial</span>
            <span class="xo-alt">autre</span><span class="xo-muted">discret</span>
            <span class="xo-faint">décor</span><span class="xo-bold">gras</span>
          </div>
          <p class="xo-right xo-muted" style="margin-top: 8px">aligné à droite · <span class="xo-sr">invisible mais lu</span>✓</p>
        </section>

        <section class="xo-panel xo-panel--pad xo-col-4">
          <h2 class="xo-panel__title">Attente</h2>
          <div class="xo-state" style="--xo-min-h: 7em">
            <span class="xo-spinner" aria-hidden="true"></span>
            <p class="xo-state__title">Chargement…</p>
            <p class="xo-state__msg">Interrogation de 4 services.</p>
          </div>
          <div class="xo-stack xo-stack--tight">
            <span class="xo-skeleton" style="width: 22ch">&nbsp;</span>
            <span class="xo-skeleton" style="width: 16ch">&nbsp;</span>
          </div>
        </section>

        <section class="xo-panel xo-panel--pad xo-col-4">
          <h2 class="xo-panel__title">Vide</h2>
          <div class="xo-empty">
            <pre class="xo-empty__art" aria-hidden="true">┌───────┐
│ vide  │
└───────┘</pre>
            <p class="xo-empty__msg">Aucun élément.</p>
            <button class="xo-btn">Créer</button>
          </div>
        </section>

        <section class="xo-panel xo-panel--pad xo-col-4">
          <h2 class="xo-panel__title">Erreur</h2>
          <div class="xo-state" style="--xo-min-h: 11em">
            <p class="xo-state__code xo-danger">500</p>
            <p class="xo-state__title">Réponse impossible</p>
            <p class="xo-state__msg"><code>err-4f21c8</code></p>
            <button class="xo-btn xo-btn--primary">Réessayer</button>
          </div>
        </section>

      </div>
    </section>

    <!-- =================================================== 5. Code -->
    <section id="t-code" role="tabpanel" class="xo-tabpanel" hidden>
      <div class="xo-grid">

        <section class="xo-panel xo-panel--pad xo-col-6">
          <h2 class="xo-panel__title">Bloc, terminal, invite</h2>
          <pre class="xo-pre"><code>.xo-panel {
  border: 1px solid var(--xo-border);
  min-width: 0;
}</code></pre>
          <pre class="xo-pre xo-pre--terminal" style="margin-top: 8px">$ php -S localhost:8000
[200]: GET /demo.php
$ _</pre>
          <label class="xo-prompt" style="margin-top: 8px">
            <span class="xo-prompt__sign" aria-hidden="true">$</span>
            <input type="text" value="git status" aria-label="Commande">
          </label>
          <div style="margin-top: 8px"><span class="xo-muted">sortie</span>
            <span class="xo-cursor" aria-hidden="true"></span></div>
        </section>

        <section class="xo-panel xo-panel--pad xo-col-6">
          <h2 class="xo-panel__title">Diff et accordéon</h2>
          <div class="xo-diff">
            <div class="xo-diff__line"><span class="xo-diff__num">12</span><span>.xo-panel {</span></div>
            <div class="xo-diff__line xo-diff__line--del"><span class="xo-diff__num">13</span><span>-  padding: 8px 1ch;</span></div>
            <div class="xo-diff__line xo-diff__line--add"><span class="xo-diff__num">13</span><span>+  padding: 8px 0;</span></div>
            <div class="xo-diff__line"><span class="xo-diff__num">14</span><span>}</span></div>
          </div>
          <details class="xo-accordion" style="margin-top: 8px">
            <summary>Accordéon</summary>
            <div class="xo-accordion__body">
              Replié par défaut, chevron automatique.
            </div>
          </details>
          <div class="xo-rule xo-rule--start" style="margin-top: 8px">Surlignage</div>
          <p class="xo-muted" style="margin-top: 8px">
            Résultat de recherche : <mark class="xo-mark">xoshui</mark>.css
          </p>
        </section>

        <section class="xo-panel xo-panel--pad xo-col-12">
          <h2 class="xo-panel__title">Surcouches</h2>
          <div class="xo-row">
            <button class="xo-btn" data-xo-open="#d-info">Message</button>
            <button class="xo-btn xo-btn--danger" data-xo-open="#d-conf">Confirmation</button>
            <button class="xo-btn" data-xo-open="#d-full">Plein écran</button>
            <button class="xo-btn xo-btn--primary" data-xo-open="#xo-palette"><kbd>Ctrl+K</kbd> palette</button>
            <button class="xo-btn" data-xo-open="#xo-help">? aide</button>
          </div>
        </section>

      </div>
    </section>

    <!-- ============================================== 6. Console -->
    <!-- Le mode console : les composants ci-dessus, sans une ligne de HTML
         changée, dans un conteneur qui porte xo-console. L'apparition
         échelonnée rejoue à chaque ouverture de l'onglet : une sortie
         masquée ne s'anime pas, elle repart quand elle s'affiche. -->
    <section id="t-console" role="tabpanel" class="xo-tabpanel" hidden>

      <div class="xo-console">

        <div class="xo-statusbar">
          <strong>xoshui-top</strong>
          <span><span class="xo-statusbar__label">hôte:</span> laragon</span>
          <span><span class="xo-statusbar__label">charge:</span> <span class="xo-warning">1.84</span></span>
          <span class="xo-spacer"></span>
          <span class="xo-spinner" aria-hidden="true"></span>
          <span class="xo-faint">1 s</span>
        </div>

        <div class="xo-main">
          <div class="xo-grid">

            <section class="xo-panel xo-col-4">
              <h3 class="xo-panel__title">Fichiers</h3>
              <ul class="xo-list xo-list--tree" data-xo-list role="tree" aria-label="Fichiers">
                <?php foreach ($conArbre as $i => [$guide, $chevron, $nom, $cls, $meta]): ?>
                <li class="xo-list__item xo-appear" role="treeitem" style="--xo-depth: 0; --xo-i: <?= $i ?>"
                    aria-selected="<?= $i === 2 ? 'true' : 'false' ?>">
                  <span class="xo-list__guide" aria-hidden="true"><?= $e($guide) ?></span>
                  <span class="xo-list__icon" aria-hidden="true"><?= $e($chevron) ?></span>
                  <span class="<?= $e($cls) ?>"><?= $e($nom) ?></span>
                  <?php if ($meta !== ''): ?><span class="xo-list__meta"><?= $e($meta) ?></span><?php endif; ?>
                </li>
                <?php endforeach; ?>
              </ul>
              <span class="xo-panel__count">↑↓ pour naviguer</span>
            </section>

            <section class="xo-panel xo-col-8">
              <h3 class="xo-panel__title">Processus</h3>
              <table class="xo-table" data-xo-list>
                <thead>
                  <tr>
                    <th class="xo-num">PID</th><th>UTIL.</th>
                    <th class="xo-num">%CPU</th><th class="xo-num">%MÉM</th><th>COMMANDE</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($processus as $i => $p): ?>
                  <tr class="xo-appear" style="--xo-i: <?= $i ?>" aria-selected="<?= $i === 0 ? 'true' : 'false' ?>">
                    <td class="xo-num"><?= $e($p['pid']) ?></td>
                    <td><?= $e($p['user']) ?></td>
                    <td class="xo-num"><?= $e(number_format($p['cpu'], 1)) ?></td>
                    <td class="xo-num"><?= $e(number_format($p['mem'], 1)) ?></td>
                    <td><?= $e($p['cmd']) ?></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
              <span class="xo-panel__count">4 / 187</span>
            </section>

            <section class="xo-panel xo-panel--pad xo-col-8">
              <h3 class="xo-panel__title">Charge</h3>
              <div class="xo-plot xo-plot--warning">
                <div class="xo-plot__scale" aria-hidden="true">
                  <span>100%</span><span>50%</span><span>0%</span>
                </div>
                <pre class="xo-plot__area" role="img"
                     aria-label="Charge processeur sur 60 minutes, pic à <?= $e($conPic) ?> %"><?php
                     echo $e(implode("\n", xo_demo_plot($conSerie, 6))); ?></pre>
                <div class="xo-plot__foot">
                  <span>-60m</span><span class="xo-spacer"></span>
                  <span>pic <?= $e($conPic) ?>%</span><span class="xo-spacer"></span><span>maintenant</span>
                </div>
              </div>
            </section>

            <section class="xo-panel xo-panel--pad xo-col-4">
              <h3 class="xo-panel__title">Ressources</h3>
              <?php foreach ([['CPU', 29, 'success'], ['Mémoire', 78, 'warning'], ['Disque', 94, 'danger']] as [$n, $v, $ton]): ?>
              <div class="xo-progress xo-progress--<?= $e($ton) ?>">
                <span class="xo-progress__label"><?= $e($n) ?></span>
                <div class="xo-progress__track" role="meter" aria-valuenow="<?= $e($v) ?>"
                     aria-valuemin="0" aria-valuemax="100" aria-label="<?= $e($n) ?>">
                  <div class="xo-progress__fill" style="width: <?= $e($v) ?>%"></div>
                </div>
                <span class="xo-progress__value"><?= $e($v) ?>%</span>
              </div>
              <?php endforeach; ?>

              <div class="xo-progress xo-progress--busy">
                <span class="xo-progress__label">Indexation</span>
                <div class="xo-progress__track" role="progressbar" aria-label="Indexation en cours">
                  <div class="xo-progress__fill"></div>
                </div>
                <span class="xo-progress__value xo-muted">…</span>
              </div>
            </section>

            <section class="xo-panel xo-panel--pad xo-col-4">
              <h3 class="xo-panel__title">Activité</h3>
              <div class="xo-heat xo-heat--seuils" role="img"
                   aria-label="Activité par heure : creux la nuit, pic l’après-midi, week-end calme">
                <?php foreach ($conHeat as $jour => $heures): ?>
                <div class="xo-heat__row">
                  <span class="xo-heat__label"><?= $e($jour) ?></span>
                  <span class="xo-heat__cells" aria-hidden="true"><?php
                      foreach ($heures as $h => $n) {
                          $cls = 'xo-heat__cell xo-heat__cell--' . $n;
                          printf('<span class="%s" title="%s %02dh">%s</span>', $cls, $e($jour), $h, $conNiveaux[$n]);
                      } ?></span>
                </div>
                <?php endforeach; ?>
              </div>
              <p class="xo-heat__foot" style="margin-top: 8px">
                <span>moins</span><span aria-hidden="true"><?= implode('', $conNiveaux) ?></span><span>plus</span>
              </p>
            </section>

            <section class="xo-panel xo-panel--pad xo-col-4">
              <h3 class="xo-panel__title">Planification</h3>
              <div class="xo-cal">
                <div class="xo-cal__grid" aria-hidden="true">
                  <?php foreach (['lu','ma','me','je','ve','sa','di'] as $j): ?>
                  <span class="xo-cal__dow"><?= $e($j) ?></span>
                  <?php endforeach; ?>
                </div>
                <div class="xo-cal__grid" data-xo-list="grid" role="listbox" aria-label="Août 2026">
                  <?php for ($i = 0; $i < $conDecalage; $i++): ?><span aria-hidden="true"></span><?php endfor; ?>
                  <?php for ($j = 1; $j <= $conJours; $j++): ?>
                  <button type="button" role="option"
                          class="xo-cal__day<?= in_array($j, [3, 12, 14, 21, 28], true) ? ' xo-cal__day--event' : '' ?>"
                          aria-selected="<?= $j === 21 ? 'true' : 'false' ?>"
                          <?= $j === 14 ? 'aria-current="date"' : '' ?>><?= $j ?></button>
                  <?php endfor; ?>
                </div>
              </div>
              <span class="xo-panel__count">←→↑↓ dans la grille</span>
            </section>

            <section class="xo-panel xo-panel--pad xo-col-4">
              <h3 class="xo-panel__title">Filtre</h3>
              <div class="xo-field">
                <label class="xo-label" for="c-cmd">Commande</label>
                <input class="xo-input" id="c-cmd" value="xoshui" placeholder="motif">
              </div>
              <div class="xo-row">
                <label class="xo-check"><input type="checkbox" checked><span>fils</span></label>
                <label class="xo-radio"><input type="radio" name="c-tri" checked><span>par CPU</span></label>
              </div>
              <div class="xo-row" style="margin-top: 8px">
                <button class="xo-btn xo-btn--primary"><span class="xo-btn__key">A</span>ppliquer</button>
                <button class="xo-btn xo-btn--danger"><span class="xo-btn__key">T</span>uer</button>
              </div>
            </section>

          </div>
        </div>

        <div class="xo-keys">
          <span><kbd>↑↓</kbd> ligne</span>
          <span><kbd>Tab</kbd> volet</span>
          <span><kbd>q</kbd> quitter</span>
          <span class="xo-spacer"></span>
          <span class="xo-faint">xoshui-top 1.0</span>
        </div>

      </div>

      <p class="xo-muted" style="margin-top: 16px">
        Une seule classe sépare cet écran du reste de la page :
        <code>xo-console</code>. Le détail est dans <a href="/tui.php">Console</a>.
      </p>

    </section>

    <!-- ============================================== 7. CLI -->
    <!-- Le mode CLI : un flux. Une colonne, aucun cadre, rien qui défile en
         interne. La ligne de commande se tape, la sortie arrive ligne à
         ligne — le retard fait tout, la durée ne fait rien. -->
    <section id="t-cli" role="tabpanel" class="xo-tabpanel" hidden>

      <div class="xo-cli">
        <div class="xo-main">

          <div class="xo-prompt">
            <span class="xo-prompt__sign" aria-hidden="true">$</span>
            <span class="xo-type" style="--xo-n: 34">xoshui deploy --cible xoshui.test</span>
          </div>

          <div class="xo-grid" style="margin-top: 16px">

            <section class="xo-panel xo-col-6">
              <h3 class="xo-panel__title">Dépendances</h3>
              <ul class="xo-list xo-list--tree" role="tree" aria-label="Dépendances">
                <?php foreach ($cliDeps as $i => [$guide, $nom, $ver, $cls]): ?>
                <li class="xo-list__item xo-appear" role="treeitem"
                    style="--xo-depth: 0; --xo-i: <?= $i + 16 ?>">
                  <span class="xo-list__guide" aria-hidden="true"><?= $e($guide) ?></span>
                  <span class="<?= $e($cls) ?>"><?= $e($nom) ?></span>
                  <span class="xo-muted"><?= $e($ver) ?></span>
                </li>
                <?php endforeach; ?>
              </ul>
            </section>

            <section class="xo-panel xo-col-6">
              <h3 class="xo-panel__title">Fichiers</h3>
              <table class="xo-table">
                <thead><tr><th>ÉTAT</th><th>CHEMIN</th><th class="xo-num">TAILLE</th></tr></thead>
                <tbody>
                  <?php foreach ($cliFichiers as $i => [$etat, $chemin, $taille, $cls]): ?>
                  <tr class="xo-appear" style="--xo-i: <?= $i + 22 ?>">
                    <td class="<?= $e($cls) ?>"><?= $e($etat) ?></td>
                    <td><?= $e($chemin) ?></td>
                    <td class="xo-num"><?= $e($taille) ?></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
              <span class="xo-panel__count">5 fichiers, 74,1K</span>
            </section>

            <section class="xo-panel xo-col-12">
              <h3 class="xo-panel__title">Transfert</h3>
              <?php foreach ([['Envoi', 100, 'success'], ['Vérification', 100, 'success']] as [$n, $v, $ton]): ?>
              <div class="xo-progress xo-progress--<?= $e($ton) ?>">
                <span class="xo-progress__label"><?= $e($n) ?></span>
                <div class="xo-progress__track" role="progressbar" aria-valuenow="<?= $e($v) ?>"
                     aria-valuemin="0" aria-valuemax="100" aria-label="<?= $e($n) ?>">
                  <div class="xo-progress__fill" style="width: <?= $e($v) ?>%"></div>
                </div>
                <span class="xo-progress__value"><?= $e($v) ?>%</span>
              </div>
              <?php endforeach; ?>
              <div class="xo-progress xo-progress--busy">
                <span class="xo-progress__label">Bascule</span>
                <div class="xo-progress__track" role="progressbar" aria-label="Bascule en cours">
                  <div class="xo-progress__fill"></div>
                </div>
                <span class="xo-progress__value xo-muted">…</span>
              </div>
            </section>

            <section class="xo-panel xo-col-12">
              <h3 class="xo-panel__title">Journal</h3>
              <div class="xo-log">
                <?php foreach ($cliFlux as $i => [$heure, $niveau, $message]): ?>
                <div class="xo-log__line xo-log__line--<?= $e($niveau) ?> xo-appear" style="--xo-i: <?= $i + 28 ?>">
                  <span class="xo-log__time"><?= $e($heure) ?></span>
                  <span class="xo-log__level"><?= $e($niveau) ?></span>
                  <span class="xo-log__msg"><?= $e($message) ?></span>
                </div>
                <?php endforeach; ?>
              </div>
            </section>

            <section class="xo-panel xo-col-12">
              <h3 class="xo-panel__title">Résultat</h3>
              <div class="xo-alert xo-alert--success xo-appear" role="status" style="--xo-i: 34">
                <span aria-hidden="true">✓</span>
                <span class="xo-alert__body">
                  <span class="xo-alert__title">Déployé.</span> 44 fichiers en 12,4 s — 1 avertissement.
                </span>
              </div>
              <dl class="xo-kv" style="margin-top: 8px">
                <?php foreach (['Cible' => 'xoshui.test', 'Durée' => '12,4 s', 'Révision' => 'ffdb5ef'] as $k => $v): ?>
                <div class="xo-kv__row">
                  <dt><?= $e($k) ?></dt>
                  <span class="xo-kv__leader" aria-hidden="true"></span>
                  <dd><?= $e($v) ?></dd>
                </div>
                <?php endforeach; ?>
              </dl>
              <div class="xo-row" style="margin-top: 8px">
                <button class="xo-btn xo-btn--primary">Voir le rapport</button>
                <button class="xo-btn">Relancer</button>
                <button class="xo-btn xo-btn--danger">Annuler le déploiement</button>
              </div>
            </section>

          </div>

          <div class="xo-prompt xo-appear" style="--xo-i: 36; margin-top: 16px">
            <span class="xo-prompt__sign" aria-hidden="true">$</span>
            <span class="xo-cursor" aria-hidden="true"></span>
          </div>

        </div>
      </div>

      <p class="xo-muted" style="margin-top: 16px">
        La grille est déclarée comme partout ailleurs — le mode la rend en empilement,
        et les <code>xo-col-*</code> n’ont plus d’effet. Le détail est dans
        <a href="/cli.php">CLI</a>.
      </p>

    </section>

  </main>

  <div class="xo-keys">
    <span><kbd>↑↓</kbd> naviguer</span>
    <span><kbd>←→</kbd> onglet</span>
    <span><kbd>Ctrl+K</kbd> aller à…</span>
    <span><kbd>?</kbd> aide</span>
    <span class="xo-spacer"></span>
    <span class="xo-faint">xoshui.test</span>
  </div>

  <footer class="xo-footer">
    <span>XOSHUI 1.0</span>
    <span class="xo-spacer"></span>
    <span>Aucune dépendance</span>
    <span>Aucun build</span>
  </footer>

</div>

<!-- Boîtes : sévérité, largeur, corps défilant, garde et touches -->
<dialog class="xo-dialog xo-dialog--success xo-dialog--narrow" id="d-info" aria-labelledby="d-info-t">
  <p class="xo-dialog__title" id="d-info-t">✓ Enregistré</p>
  <p>4 fichiers écrits.</p>
  <div class="xo-dialog__actions">
    <button class="xo-btn xo-btn--primary" data-xo-close autofocus>Fermer</button>
  </div>
</dialog>

<dialog class="xo-dialog xo-dialog--danger xo-dialog--wide" id="d-conf" aria-labelledby="d-conf-t">
  <p class="xo-dialog__title" id="d-conf-t">Supprimer feat/tokens ?</p>
  <div class="xo-dialog__body">
    <p>12 commits non fusionnés seront perdus.</p>
    <div class="xo-field" style="margin-top: 8px">
      <label class="xo-label" for="d-g">Saisir <code>tokens</code> pour confirmer</label>
      <input class="xo-input" id="d-g" data-xo-guard="tokens" autocomplete="off">
    </div>
  </div>
  <div class="xo-dialog__keys" style="margin-top: 8px">
    <span><kbd>N</kbd> annuler</span><span><kbd>S</kbd> supprimer</span>
  </div>
  <div class="xo-dialog__actions">
    <button class="xo-btn" data-xo-key="n" data-xo-close autofocus>Annuler</button>
    <button class="xo-btn xo-btn--danger" data-xo-key="s" data-xo-guard-ok data-xo-close>Supprimer</button>
  </div>
</dialog>

<dialog class="xo-dialog xo-dialog--full" id="d-full" aria-label="Plein écran">
  <div class="xo-statusbar">
    <strong>xoshui.css</strong>
    <span class="xo-muted">1.4.1 → 1.4.2</span>
    <span class="xo-spacer"></span>
    <button class="xo-btn xo-btn--ghost" data-xo-close autofocus>[Échap] fermer</button>
  </div>
  <div class="xo-dialog__body" style="padding: 8px 1ch">
    <p class="xo-muted">Pour comparer, lire un journal complet ou éditer.</p>
  </div>
</dialog>

<div class="xo-toasts">
  <div class="xo-toast xo-toast--success" role="status" data-xo-toast="0">
    <span aria-hidden="true">✓</span>
    <span class="xo-toast__body"><span class="xo-toast__title">Enregistré.</span> 4 fichiers.</span>
    <button class="xo-toast__close" aria-label="Fermer">×</button>
  </div>
</div>

<script type="module" src="/libs/js/xoshui.js"></script>
</body>
</html>
