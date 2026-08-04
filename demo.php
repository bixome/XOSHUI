<?php
declare(strict_types=1);

/** Page de démonstration XOSHUI — toutes les classes visibles d'un coup. */

$e = static fn (string|int|float $v): string
    => htmlspecialchars((string) $v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

$processes = [
    ['pid' => 58406, 'user' => 'romain', 'cpu' => 41.0, 'mem' => 0.9,  'cmd' => 'php-fpm'],
    ['pid' => 400,   'user' => 'romain', 'cpu' => 7.5,  'mem' => 1.2,  'cmd' => 'mysqld'],
    ['pid' => 91045, 'user' => 'romain', 'cpu' => 5.2,  'mem' => 15.2, 'cmd' => 'chrome'],
    ['pid' => 578,   'user' => 'root',   'cpu' => 3.6,  'mem' => 0.2,  'cmd' => 'httpd'],
    ['pid' => 86056, 'user' => 'romain', 'cpu' => 3.2,  'mem' => 0.0,  'cmd' => 'ssh'],
];

$branches = [
    ['name' => 'main',            'meta' => '✓', 'cls' => 'xo-success'],
    ['name' => 'feat/tokens',     'meta' => '1d', 'cls' => ''],
    ['name' => 'feat/components', 'meta' => '3d', 'cls' => ''],
    ['name' => 'fix/contrast',    'meta' => '1w', 'cls' => ''],
];

$logs = [
    ['14:00:27', 'ok',    'Connexion établie sur xoshui.test'],
    ['14:00:31', 'info',  'Cache vidé — 128 entrées'],
    ['14:01:02', 'warn',  'Requête lente : SELECT * FROM sessions (1.4 s)'],
    ['14:01:09', 'error', 'Échec du montage /mnt/backup : périphérique occupé'],
    ['14:02:44', 'info',  'Rechargement de la configuration'],
];

$files = [
    ['icon' => '▾', 'name' => 'libs',      'depth' => 0, 'cls' => 'xo-info'],
    ['icon' => '▾', 'name' => 'css',       'depth' => 1, 'cls' => 'xo-info'],
    ['icon' => ' ', 'name' => 'xoshui.css','depth' => 2, 'cls' => ''],
    ['icon' => '▾', 'name' => 'js',        'depth' => 1, 'cls' => 'xo-info'],
    ['icon' => ' ', 'name' => 'xoshui.js', 'depth' => 2, 'cls' => ''],
    ['icon' => ' ', 'name' => 'demo.php',  'depth' => 0, 'cls' => 'xo-alt'],
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>XOSHUI — démo</title>
<link rel="stylesheet" href="/libs/css/xoshui.css">
</head>
<body>
<div class="xo-app">

  <!-- Navigation -->
  <nav class="xo-nav" aria-label="Principale">
    <span class="xo-nav__brand">XOSHUI</span>
    <ul class="xo-nav__list">
      <li><a class="xo-nav__link" href="#" aria-current="page">Démo</a></li>
      <li><a class="xo-nav__link" href="/docs/api.md">Aide-mémoire</a></li>
      <li><a class="xo-nav__link" href="/docs/charte-graphique.md">Charte</a></li>
    </ul>
    <span class="xo-spacer"></span>
    <nav class="xo-breadcrumb" aria-label="Fil d'Ariane">
      <span class="xo-breadcrumb__sep" aria-hidden="true">/</span><a href="#">libs</a>
      <span class="xo-breadcrumb__sep" aria-hidden="true">/</span><a href="#">css</a>
      <span class="xo-breadcrumb__sep" aria-hidden="true">/</span><span aria-current="page">xoshui.css</span>
    </nav>
  </nav>

  <!-- Barre de statut -->
  <div class="xo-statusbar">
    <strong>XOSHUI</strong>
    <span><span class="xo-statusbar__label">v</span>1.0</span>
    <span><span class="xo-statusbar__label">CPU:</span> <span class="xo-success">29%</span></span>
    <span><span class="xo-statusbar__label">MEM:</span> 17.07G / 17.18G</span>
    <span><span class="xo-statusbar__label">TEMP:</span> <span class="xo-warning">74°C</span></span>
    <span class="xo-spacer"></span>
  </div>

  <main class="xo-main">

    <!-- Onglets -->
    <div class="xo-tabs" data-xo-tabs role="tablist">
      <button class="xo-tabs__tab" role="tab" aria-selected="true"  aria-controls="tab-dash">[1] Dashboard</button>
      <button class="xo-tabs__tab" role="tab" aria-selected="false" aria-controls="tab-form">[2] Formulaire</button>
      <button class="xo-tabs__tab" role="tab" aria-selected="false" aria-controls="tab-code">[3] Code</button>
    </div>

    <!-- ------------------------------------------------ Onglet 1 -->
    <section id="tab-dash" role="tabpanel" class="xo-tabpanel">

      <div class="xo-toolbar">
        <div class="xo-btn-group" role="group" aria-label="Tri">
          <button class="xo-btn" aria-pressed="true">CPU</button>
          <button class="xo-btn" aria-pressed="false">MEM</button>
          <button class="xo-btn" aria-pressed="false">PID</button>
        </div>
        <span class="xo-toolbar__sep" aria-hidden="true"></span>

        <label class="xo-search" style="width: 28ch">
          <span class="xo-search__prefix" aria-hidden="true">/</span>
          <input type="search" placeholder="filtrer…" aria-label="Filtrer les processus">
        </label>

        <details class="xo-dropdown">
          <summary class="xo-btn">Actions ▾</summary>
          <div class="xo-dropdown__menu" role="menu">
            <button class="xo-dropdown__item" role="menuitem">
              Rafraîchir <span class="xo-dropdown__key">r</span>
            </button>
            <button class="xo-dropdown__item" role="menuitem">
              Exporter en CSV <span class="xo-dropdown__key">e</span>
            </button>
            <div class="xo-dropdown__sep" role="separator"></div>
            <button class="xo-dropdown__item" role="menuitem" aria-disabled="true">
              Tuer le processus <span class="xo-dropdown__key">k</span>
            </button>
          </div>
        </details>

        <span class="xo-spacer"></span>
        <span class="xo-muted">537 tâches · 1866 threads</span>
      </div>

      <div class="xo-alert xo-alert--warning" role="status" style="margin-bottom: 8px">
        <span aria-hidden="true">▲</span>
        <span class="xo-alert__body">
          <span class="xo-alert__title">Température élevée.</span>
          Le CPU dépasse 70 °C depuis 4 minutes.
        </span>
      </div>

      <div class="xo-grid" style="margin-bottom: 8px">
        <?php foreach ([
            ['Tâches',   '537',    '+12',   'up'],
            ['Threads',  '1 866',  '−4',    'down'],
            ['Charge',   '0.94',   'stable', ''],
            ['Uptime',   '7 j',    '08:40',  ''],
        ] as [$label, $value, $delta, $dir]): ?>
        <section class="xo-panel xo-panel--pad xo-col-3">
          <div class="xo-stat">
            <span class="xo-stat__value"><?= $e($value) ?></span>
            <span class="xo-stat__label"><?= $e($label) ?></span>
            <span class="xo-stat__delta<?= $dir ? ' xo-stat__delta--' . $e($dir) : '' ?>"><?= $e($delta) ?></span>
          </div>
        </section>
        <?php endforeach; ?>
      </div>

      <div class="xo-grid">

        <div class="xo-col-3 xo-stack">

          <section class="xo-panel xo-panel--active">
            <h2 class="xo-panel__title">Local Branches</h2>
            <ul class="xo-list" data-xo-list role="listbox" aria-label="Branches">
              <?php foreach ($branches as $i => $b): ?>
              <li class="xo-list__item" role="option"
                  aria-selected="<?= $i === 0 ? 'true' : 'false' ?>"
                  data-value="<?= $e($b['name']) ?>">
                <span class="xo-list__icon" aria-hidden="true">⎇</span>
                <span><?= $e($b['name']) ?></span>
                <span class="xo-list__meta <?= $e($b['cls']) ?>"><?= $e($b['meta']) ?></span>
              </li>
              <?php endforeach; ?>
            </ul>
            <span class="xo-panel__count">1 of <?= count($branches) ?></span>
          </section>

          <section class="xo-panel">
            <h2 class="xo-panel__title">Files</h2>
            <ul class="xo-list xo-list--tree" data-xo-list role="tree" aria-label="Fichiers">
              <?php foreach ($files as $f): ?>
              <li class="xo-list__item" role="treeitem" style="--xo-depth: <?= (int) $f['depth'] ?>">
                <span class="xo-list__icon" aria-hidden="true"><?= $e($f['icon']) ?></span>
                <span class="<?= $e($f['cls']) ?>"><?= $e($f['name']) ?></span>
              </li>
              <?php endforeach; ?>
            </ul>
          </section>

        </div>

        <div class="xo-col-9 xo-stack">

          <section class="xo-panel">
            <h2 class="xo-panel__title">Processes</h2>
            <div class="xo-table-wrap">
              <table class="xo-table" data-xo-list aria-label="Processus">
                <thead>
                  <tr>
                    <th>PID</th><th>USER</th>
                    <th class="xo-num">CPU%</th><th class="xo-num">MEM%</th>
                    <th>CMD</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($processes as $i => $p): ?>
                  <tr aria-selected="<?= $i === 0 ? 'true' : 'false' ?>" data-value="<?= $e($p['pid']) ?>">
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
            <span class="xo-panel__count">1 of <?= count($processes) ?></span>
          </section>

          <div class="xo-pagination">
            <button class="xo-btn" aria-label="Page précédente">‹</button>
            <span class="xo-pagination__info">page 1 / 30</span>
            <button class="xo-btn" aria-label="Page suivante">›</button>
          </div>

          <div class="xo-grid">
            <section class="xo-panel xo-panel--pad xo-col-6">
              <h2 class="xo-panel__title">Ressources</h2>
              <div class="xo-stack">
                <?php
                $gauges = [['CPU', 29, ''], ['MEM', 78, 'xo-gauge--warning'], ['DISK', 94, 'xo-gauge--danger']];
                foreach ($gauges as [$label, $pct, $mod]): ?>
                <div class="xo-gauge <?= $e($mod) ?>">
                  <span class="xo-muted" style="min-width:5ch"><?= $e($label) ?></span>
                  <div class="xo-gauge__track" role="meter" aria-valuenow="<?= (int) $pct ?>"
                       aria-valuemin="0" aria-valuemax="100" aria-label="<?= $e($label) ?>">
                    <div class="xo-gauge__fill" style="width: <?= (int) $pct ?>%"></div>
                  </div>
                  <span class="xo-gauge__value"><?= (int) $pct ?>%</span>
                </div>
                <?php endforeach; ?>
                <div class="xo-row">
                  <span class="xo-muted">NET</span>
                  <span class="xo-spark" aria-hidden="true">▁▂▃▅▇▆▄▃▅▇█▆▄▂▁▂▄▆</span>
                </div>
              </div>
            </section>

            <section class="xo-panel xo-panel--pad xo-col-6">
              <h2 class="xo-panel__title">Système</h2>
              <dl class="xo-kv">
                <?php foreach ([
                    'Version'     => '1.0',
                    'PHP'         => '8.3.30',
                    'Hôte'        => 'xoshui.test',
                    'Uptime'      => '7 j 08:40:22',
                ] as $k => $v): ?>
                <div class="xo-kv__row">
                  <dt><?= $e($k) ?></dt>
                  <span class="xo-kv__leader" aria-hidden="true"></span>
                  <dd><?= $e($v) ?></dd>
                </div>
                <?php endforeach; ?>
              </dl>
            </section>

            <section class="xo-panel xo-col-12">
              <h2 class="xo-panel__title">Journal</h2>
              <div class="xo-log" style="--xo-max-h: 12em">
                <?php foreach ($logs as [$time, $level, $msg]): ?>
                <div class="xo-log__line xo-log__line--<?= $e($level) ?>">
                  <span class="xo-log__time"><?= $e($time) ?></span>
                  <span class="xo-log__level"><?= $e($level) ?></span>
                  <span class="xo-log__msg"><?= $e($msg) ?></span>
                </div>
                <?php endforeach; ?>
              </div>
            </section>

            <section class="xo-panel xo-panel--pad xo-col-12">
              <h2 class="xo-panel__title">Transfert</h2>
              <div class="xo-stack">
                <div class="xo-progress">
                  <span class="xo-muted" style="min-width: 9ch">archive</span>
                  <div class="xo-progress__track" role="progressbar"
                       aria-valuenow="64" aria-valuemin="0" aria-valuemax="100" aria-label="archive">
                    <div class="xo-progress__fill" style="width: 64%"></div>
                  </div>
                  <span class="xo-progress__value">64%</span>
                </div>
                <div class="xo-row">
                  <span class="xo-spinner" aria-hidden="true"></span>
                  <span class="xo-muted">Indexation en cours…</span>
                  <span class="xo-tag xo-tag--accent">3 fichiers</span>
                  <span class="xo-tag">css</span>
                  <span class="xo-tag xo-tag--warning">
                    non suivi <button class="xo-tag__remove" aria-label="Retirer">×</button>
                  </span>
                </div>
              </div>
            </section>

            <section class="xo-panel xo-panel--pad xo-col-12">
              <h2 class="xo-panel__title">États</h2>
              <div class="xo-row" style="margin-bottom: 8px">
                <span class="xo-badge xo-badge--success">✓ READY</span>
                <span class="xo-badge xo-badge--warning">▲ M</span>
                <span class="xo-badge xo-badge--danger">✗ FAIL</span>
                <span class="xo-badge xo-badge--info">● 3</span>
                <span class="xo-badge">??</span>
              </div>
              <div class="xo-row">
                <button class="xo-btn xo-btn--primary">Valider</button>
                <button class="xo-btn">Annuler</button>
                <button class="xo-btn xo-btn--danger" data-xo-open="#confirm">Supprimer</button>
                <button class="xo-btn" disabled>Indispo</button>
              </div>
            </section>
          </div>

        </div>
      </div>
    </section>

    <!-- ------------------------------------------------ Onglet 2 -->
    <section id="tab-form" role="tabpanel" class="xo-tabpanel" hidden>
      <div class="xo-grid">
        <section class="xo-panel xo-panel--pad xo-col-6">
          <h2 class="xo-panel__title">Configuration</h2>

          <div class="xo-field">
            <label class="xo-label" for="f-host">Hôte</label>
            <input class="xo-input" id="f-host" value="localhost">
          </div>

          <div class="xo-field">
            <label class="xo-label" for="f-port">Port</label>
            <input class="xo-input" id="f-port" value="3306x" aria-invalid="true" aria-describedby="f-port-err">
            <span class="xo-error" id="f-port-err">! Valeur numérique attendue</span>
          </div>

          <div class="xo-field">
            <label class="xo-label" for="f-mode">Mode</label>
            <select class="xo-select" id="f-mode">
              <option>Développement</option><option>Production</option>
            </select>
          </div>

          <div class="xo-field">
            <label class="xo-label" for="f-note">Notes</label>
            <textarea class="xo-textarea" id="f-note" placeholder="Optionnel…"></textarea>
            <span class="xo-help">Markdown accepté.</span>
          </div>

          <label class="xo-check"><input type="checkbox" checked> Activer le journal</label>

          <details class="xo-accordion" style="margin-top: 8px">
            <summary>Options avancées</summary>
            <div class="xo-accordion__body">
              <fieldset class="xo-fieldset">
                <legend>Connexion</legend>
                <div class="xo-field">
                  <label class="xo-label" for="f-tout">Délai (s)</label>
                  <input class="xo-input" id="f-tout" value="30">
                </div>
                <label class="xo-check"><input type="checkbox"> Reconnexion automatique</label>
              </fieldset>
            </div>
          </details>
        </section>

        <section class="xo-panel xo-panel--pad xo-col-6">
          <h2 class="xo-panel__title">Terminal</h2>
          <pre class="xo-pre xo-pre--terminal">$ php -S localhost:8000
[Tue Aug  4 18:24:01 2026] PHP 8.3.0 Development Server started
[Tue Aug  4 18:24:07 2026] 127.0.0.1:52233 [200]: GET /demo.php
$ _</pre>
        </section>
      </div>
    </section>

    <!-- ------------------------------------------------ Onglet 3 -->
    <section id="tab-code" role="tabpanel" class="xo-tabpanel" hidden>
      <section class="xo-panel xo-panel--pad">
        <h2 class="xo-panel__title">Diff — libs/css/xoshui.css</h2>
        <div class="xo-diff">
          <div class="xo-diff__line"><span class="xo-diff__num">12</span><span>.xo-panel {</span></div>
          <div class="xo-diff__line xo-diff__line--del"><span class="xo-diff__num">13</span><span>-  border-radius: 4px;</span></div>
          <div class="xo-diff__line xo-diff__line--add"><span class="xo-diff__num">13</span><span>+  border-radius: 0;</span></div>
          <div class="xo-diff__line xo-diff__line--add"><span class="xo-diff__num">14</span><span>+  border: 1px solid var(--xo-border);</span></div>
          <div class="xo-diff__line"><span class="xo-diff__num">15</span><span>}</span></div>
        </div>
      </section>
      <section class="xo-panel" style="margin-top: 8px">
        <h2 class="xo-panel__title">Stash</h2>
        <div class="xo-empty">
          <pre class="xo-empty__art" aria-hidden="true">┌───────────┐
│   vide    │
└───────────┘</pre>
          <p class="xo-empty__msg">Aucune modification remisée.</p>
          <button class="xo-btn">Créer un stash</button>
        </div>
      </section>
    </section>

  </main>

  <!-- Raccourcis -->
  <div class="xo-keys">
    <span><kbd>↑↓</kbd> naviguer</span>
    <span><kbd>←→</kbd> onglet</span>
    <span><kbd>Entrée</kbd> activer</span>
    <span><kbd>Échap</kbd> fermer</span>
    <span class="xo-spacer"></span>
    <span class="xo-faint">xoshui.test</span>
  </div>

</div>

<dialog class="xo-dialog" id="confirm">
  <p class="xo-dialog__title">Confirmer</p>
  <p>Supprimer la branche sélectionnée ? Cette action est définitive.</p>
  <div class="xo-dialog__actions">
    <button class="xo-btn" data-xo-close>Annuler</button>
    <button class="xo-btn xo-btn--danger" data-xo-close>Supprimer</button>
  </div>
</dialog>

<script type="module" src="/libs/js/xoshui.js"></script>
</body>
</html>
