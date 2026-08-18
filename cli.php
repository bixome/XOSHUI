<?php
declare(strict_types=1);
require __DIR__ . '/libs/site.php';

/* ---- Données : le transcrit d'un déploiement fictif ---------------------- */

/** Arbre de dépendances, façon `npm ls` : [guide, nom, version, classe]. */
$deps = [
    ['',       'xoshui', '1.0.0', 'xo-info'],
    ['├─',     'jetbrains-mono', '2.304', ''],
    ['├─',     'php-fpm', '8.3.30', ''],
    ['│  └─',  'opcache', 'intégré', 'xo-muted'],
    ['└─',     'nginx', '1.25.3', ''],
];

/** Fichiers traités : [état, chemin, taille, classe]. */
$fichiers = [
    ['✓', 'libs/css/xoshui.css', '41.2K', 'xo-success'],
    ['✓', 'libs/js/xoshui.js',   '12.8K', 'xo-success'],
    ['✓', 'libs/site.php',        '7.4K', 'xo-success'],
    ['⚠', 'templates/page-nue.php', '1.1K', 'xo-warning'],
    ['✓', 'tui.php',             '11.6K', 'xo-success'],
];

/** Journal : [heure, niveau, message]. */
$flux = [
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
<title>Flux CLI — XOSHUI</title>
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="stylesheet" href="/libs/css/xoshui.css">
</head>
<body>
<div class="xo-app">

<?php xo_nav('cli'); ?>

  <main class="xo-main">

    <p class="xo-muted" style="margin-bottom: 16px">
      Même méthode qu’en <a href="/tui.php">mode console</a>, autre grammaire.
      Le mode console simule un <strong>écran</strong> : des panneaux encadrés, une
      sélection, une grille. Le mode CLI simule un <strong>flux</strong> : une seule
      colonne, aucun cadre, rien qui défile en interne, et la sélection réduite à un
      marqueur de ligne.
    </p>

    <!-- ================================================================== -->
    <!-- Le transcrit                                                       -->
    <!-- ================================================================== -->

    <div class="xo-cli">
      <div class="xo-main">

        <div class="xo-prompt" style="margin-bottom: 16px">
          <span class="xo-prompt__sign" aria-hidden="true">$</span>
          <span>xoshui deploy --cible xoshui.test</span>
        </div>

        <!-- La grille est déclarée comme partout ailleurs : le mode la rend
             en empilement, et les xo-col-* n'ont plus d'effet. -->
        <div class="xo-grid">

          <section class="xo-panel xo-col-6">
            <h2 class="xo-panel__title">Dépendances</h2>
            <ul class="xo-list xo-list--tree" role="tree" aria-label="Dépendances">
              <?php foreach ($deps as [$guide, $nom, $ver, $classe]): ?>
              <li class="xo-list__item" role="treeitem" style="--xo-depth: 0">
                <span class="xo-list__guide" aria-hidden="true"><?= xo_e($guide) ?></span>
                <span class="<?= xo_e($classe) ?>"><?= xo_e($nom) ?></span>
                <span class="xo-muted"><?= xo_e($ver) ?></span>
              </li>
              <?php endforeach; ?>
            </ul>
          </section>

          <section class="xo-panel xo-col-6">
            <h2 class="xo-panel__title">Fichiers</h2>
            <table class="xo-table">
              <thead>
                <tr><th>ÉTAT</th><th>CHEMIN</th><th class="xo-num">TAILLE</th></tr>
              </thead>
              <tbody>
                <?php foreach ($fichiers as [$etat, $chemin, $taille, $classe]): ?>
                <tr>
                  <td class="<?= xo_e($classe) ?>"><?= xo_e($etat) ?></td>
                  <td><?= xo_e($chemin) ?></td>
                  <td class="xo-num"><?= xo_e($taille) ?></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            <span class="xo-panel__count">5 fichiers, 74,1K</span>
          </section>

          <section class="xo-panel xo-col-12">
            <h2 class="xo-panel__title">Transfert</h2>
            <?php foreach ([['Envoi', 100, 'success'], ['Vérification', 100, 'success'], ['Bascule', 62, '']] as [$nom, $val, $ton]): ?>
            <div class="xo-progress<?= $ton !== '' ? ' xo-progress--' . xo_e($ton) : '' ?>">
              <span class="xo-progress__label"><?= xo_e($nom) ?></span>
              <div class="xo-progress__track" role="progressbar" aria-valuenow="<?= xo_e($val) ?>"
                   aria-valuemin="0" aria-valuemax="100" aria-label="<?= xo_e($nom) ?>">
                <div class="xo-progress__fill" style="width: <?= xo_e($val) ?>%"></div>
              </div>
              <span class="xo-progress__value"><?= xo_e($val) ?>%</span>
            </div>
            <?php endforeach; ?>
          </section>

          <section class="xo-panel xo-col-12">
            <h2 class="xo-panel__title">Journal</h2>
            <div class="xo-log">
              <?php foreach ($flux as [$heure, $niveau, $message]): ?>
              <div class="xo-log__line xo-log__line--<?= xo_e($niveau) ?>">
                <span class="xo-log__time"><?= xo_e($heure) ?></span>
                <span class="xo-log__level"><?= xo_e($niveau) ?></span>
                <span class="xo-log__msg"><?= xo_e($message) ?></span>
              </div>
              <?php endforeach; ?>
            </div>
          </section>

          <section class="xo-panel xo-col-12">
            <h2 class="xo-panel__title">Résultat</h2>

            <div class="xo-alert xo-alert--success" role="status">
              <span aria-hidden="true">✓</span>
              <span class="xo-alert__body">
                <span class="xo-alert__title">Déployé.</span>
                44 fichiers en 12,4 s — 1 avertissement.
              </span>
            </div>

            <dl class="xo-kv" style="margin-top: 8px">
              <?php foreach ([
                  'Cible'   => 'xoshui.test',
                  'Durée'   => '12,4 s',
                  'Révision' => 'ffdb5ef',
              ] as $k => $v): ?>
              <div class="xo-kv__row">
                <dt><?= xo_e($k) ?></dt>
                <span class="xo-kv__leader" aria-hidden="true"></span>
                <dd><?= xo_e($v) ?></dd>
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

        <div class="xo-prompt" style="margin-top: 16px">
          <span class="xo-prompt__sign" aria-hidden="true">$</span>
          <span class="xo-cursor" aria-hidden="true"></span>
        </div>

      </div>
    </div>

    <!-- ================================================================== -->
    <!-- Le même balisage, trois grammaires                                 -->
    <!-- ================================================================== -->

    <h2 style="margin: 32px 0 16px">Le même balisage, trois grammaires</h2>
    <p class="xo-muted" style="margin-bottom: 16px">
      Le fragment est écrit une seule fois et rendu trois fois. Seule la classe du
      conteneur change : rien, <code>xo-console</code>, <code>xo-cli</code>.
    </p>

    <?php
    $fragment = <<<'HTML'
    <section class="xo-panel xo-panel--pad">
      <h3 class="xo-panel__title">Cibles</h3>
      <ul class="xo-list" role="listbox" aria-label="Cibles %s">
        <li class="xo-list__item" role="option" aria-selected="true"><span>production</span></li>
        <li class="xo-list__item" role="option" aria-selected="false"><span>recette</span></li>
      </ul>
      <div class="xo-field" style="margin-top: 8px">
        <label class="xo-label" for="%s-b">Branche</label>
        <input class="xo-input" id="%s-b" value="main">
      </div>
      <div class="xo-row" style="margin-top: 8px">
        <button class="xo-btn xo-btn--primary">Déployer</button>
        <button class="xo-btn">Annuler</button>
      </div>
      <span class="xo-panel__count">2 cibles</span>
    </section>
    HTML;
    ?>

    <div class="xo-grid">
      <div class="xo-col-4">
        <p class="xo-muted" style="margin-bottom: 8px">Mode normal</p>
        <?= sprintf($fragment, 'normale', 'n', 'n') ?>
      </div>

      <div class="xo-col-4 xo-console">
        <p class="xo-muted" style="margin-bottom: 8px">Mode console</p>
        <?= sprintf($fragment, 'console', 'c', 'c') ?>
      </div>

      <div class="xo-col-4 xo-cli">
        <p class="xo-muted" style="margin-bottom: 8px">Mode CLI</p>
        <?= sprintf($fragment, 'cli', 'l', 'l') ?>
      </div>
    </div>

    <!-- ================================================================== -->

    <section class="xo-panel xo-panel--pad" style="margin-top: 32px">
      <h2 class="xo-panel__title">Ce que le mode CLI traduit</h2>
      <dl class="xo-kv">
        <?php foreach ([
            'Grille'    => 'redevient un empilement — un flux n’a qu’une colonne, les xo-col-* n’ont plus d’effet',
            'Panneau'   => 'perd sa bordure ; son titre devient une ligne de section « ==> Titre »',
            'Défilement' => '--xo-max-h est neutralisé : dans un transcrit, rien ne défile en interne',
            'Sélection' => 'la vidéo inverse cède au marqueur de ligne : « * » au lieu de « - »',
            'Liste'     => 'une ligne, un marqueur ; l’arbre garde ses guides, comme npm ls',
            'Tableau'   => 'des colonnes alignées, aucun filet, aucun zébrage',
            'Bouton'    => 'un mot précédé de « » », en surbrillance au survol et au focus',
            'Champ'     => 'une invite : « ? Branche main »',
            'Barres'    => 'la ligne d’état et les raccourcis deviennent du texte muet',
        ] as $quoi => $comment): ?>
        <div class="xo-kv__row">
          <dt><?= xo_e($quoi) ?></dt>
          <span class="xo-kv__leader" aria-hidden="true"></span>
          <dd class="xo-muted"><?= xo_e($comment) ?></dd>
        </div>
        <?php endforeach; ?>
      </dl>
      <p class="xo-muted" style="margin-top: 8px">
        Non traduits volontairement : <code>xo-check</code> et <code>xo-radio</code>, que le
        socle dessine déjà en caractères — et tout ce que le mode ne couvre pas, qui garde
        sa grammaire plutôt que de se tasser.
      </p>
    </section>

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
