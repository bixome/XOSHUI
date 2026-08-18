<?php
declare(strict_types=1);
require __DIR__ . '/libs/site.php';

/* ---- Données : un outil de console fictif -------------------------------- */

/** Arbre de fichiers : [guide, chevron, nom, classe, méta]. Le guide est écrit
 *  ici parce que lui seul sait quelle branche se poursuit plus bas. */
$arbre = [
    ['',          '▾', 'xoshui',      'xo-info',    ''],
    ['├─',        '▾', 'libs',        'xo-info',    ''],
    ['│  ├─',     ' ', 'xoshui.css',  '',           '38K'],
    ['│  ├─',     ' ', 'xoshui.js',   '',           '12K'],
    ['│  └─',     ' ', 'site.php',    '',           '7K'],
    ['├─',        '▸', 'layouts',     'xo-info',    '10'],
    ['├─',        '▸', 'components',  'xo-info',    '13'],
    ['├─',        '▾', 'templates',   'xo-info',    ''],
    ['│  ├─',     ' ', 'page.php',    '',           '1K'],
    ['│  └─',     ' ', 'page-nue.php','',           '1K'],
    ['└─',        ' ', 'index.php',   '',           '3K'],
];

/** Processus : [pid, utilisateur, cpu, mém, état, commande]. */
$procs = [
    [1,    'root',   0.0,  0.4, 'S',  'systemd'],
    [312,  'root',   1.2,  2.1, 'S',  'nginx: master'],
    [400,  'romain', 7.5,  1.2, 'R',  'php-fpm'],
    [881,  'romain', 23.8, 8.9, 'R',  'xoshui-watch'],
    [1204, 'romain', 0.3,  0.6, 'S',  'sshd'],
];

/**
 * Les rangées d'un graphe temporel, en blocs.
 *
 * Une colonne par valeur, la rangée du bas remplie la première. Chaque cellule
 * reçoit la part de hauteur qui lui revient, arrondie sur les huit blocs
 * ▁▂▃▄▅▆▇█ — d'où la résolution de 8 sous-niveaux par ligne.
 *
 * @param list<float> $valeurs entre 0 et 1
 * @param int         $hauteur nombre de rangées
 * @return list<string>
 */
function xo_plot_rangees(array $valeurs, int $hauteur): array
{
    $blocs   = [' ', '▁', '▂', '▃', '▄', '▅', '▆', '▇', '█'];
    $rangees = array_fill(0, $hauteur, '');

    foreach ($valeurs as $v) {
        $rempli = max(0.0, min(1.0, $v)) * $hauteur;
        for ($r = 0; $r < $hauteur; $r++) {
            // Ce qui déborde dans CETTE rangée, comptée depuis le bas.
            $part = max(0.0, min(1.0, $rempli - ($hauteur - 1 - $r)));
            $rangees[$r] .= $blocs[(int) round($part * 8)];
        }
    }

    return $rangees;
}

/* Graphe — série figée : la page doit se lire pareil à chaque rechargement. */
$serie = [];
for ($i = 0; $i < 72; $i++) {
    $serie[] = max(0.0, min(1.0, 0.45 + 0.34 * sin($i / 7) + 0.16 * sin($i / 2.3)));
}
$pic = (int) round(max($serie) * 100);

/* Carte de chaleur — 7 jours × 24 heures, cinq niveaux. */
$heat = [];
foreach (['lun', 'mar', 'mer', 'jeu', 'ven', 'sam', 'dim'] as $d => $jour) {
    $ligne = [];
    for ($h = 0; $h < 24; $h++) {
        $charge = sin(max(0.0, ($h - 6) / 16) * M_PI);   // creux la nuit, pic l'après-midi
        $charge *= $d >= 5 ? 0.35 : 1.0;                 // week-end calme
        $ligne[] = max(0, min(4, (int) round($charge * 4)));
    }
    $heat[$jour] = $ligne;
}
$niveaux = [0 => '·', 1 => '░', 2 => '▒', 3 => '▓', 4 => '█'];

/* Calendrier — le mois est figé pour que la page se lise toujours pareil. */
$mois       = new DateTimeImmutable('2026-08-01');
$nbJours    = (int) $mois->format('t');
$decalage   = (int) $mois->format('N') - 1;   // 0 = lundi
$aujourdhui = 14;
$jourSel    = 21;
$charges    = [3, 12, 14, 21, 28];

/** Journal : [heure, niveau, message]. */
$flux = [
    ['09:31:02', 'info',  'xoshui-watch démarré, 42 fichiers surveillés'],
    ['09:31:44', 'ok',    'xoshui.css recompilé — 0 erreur'],
    ['09:32:12', 'warn',  'templates/page-nue.php : aucun xo-keys en bas d’écran'],
    ['09:33:05', 'error', 'lint : classe xo-panel--flat inconnue'],
    ['09:33:06', 'info',  'attente d’une modification…'],
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Console TUI — XOSHUI</title>
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="stylesheet" href="/libs/css/xoshui.css">
</head>
<body>
<div class="xo-app">

<?php xo_nav('tui'); ?>

  <main class="xo-main">

    <p class="xo-muted" style="margin-bottom: 16px">
      Tout ce qui suit la ligne d’état est dans un <code>xo-console</code>. Le balisage
      est celui des autres pages, au caractère près : mêmes classes, mêmes
      <code>data-xo-*</code>, même module. Seule la grammaire visuelle change.
    </p>

    <!-- ================================================================== -->
    <!-- Le terminal simulé                                                 -->
    <!-- ================================================================== -->

    <div class="xo-console">

      <div class="xo-statusbar">
        <strong>xoshui-top</strong>
        <span><span class="xo-statusbar__label">hôte:</span> laragon</span>
        <span><span class="xo-statusbar__label">charge:</span> <span class="xo-warning">1.84</span></span>
        <span class="xo-spacer"></span>
        <span class="xo-faint">09:33:06</span>
      </div>

      <div class="xo-main">
        <div class="xo-grid">

          <!-- Arbre : mêmes rôles, même data-xo-list, guides en caractères -->
          <section class="xo-panel xo-col-4">
            <h2 class="xo-panel__title">Fichiers</h2>
            <ul class="xo-list xo-list--tree" data-xo-list role="tree" aria-label="Fichiers">
              <?php foreach ($arbre as $i => [$guide, $chevron, $nom, $classe, $meta]): ?>
              <li class="xo-list__item" role="treeitem" style="--xo-depth: 0"
                  aria-selected="<?= $i === 2 ? 'true' : 'false' ?>">
                <span class="xo-list__guide" aria-hidden="true"><?= xo_e($guide) ?></span>
                <span class="xo-list__icon" aria-hidden="true"><?= xo_e($chevron) ?></span>
                <span class="<?= xo_e($classe) ?>"><?= xo_e($nom) ?></span>
                <?php if ($meta !== ''): ?>
                <span class="xo-list__meta"><?= xo_e($meta) ?></span>
                <?php endif; ?>
              </li>
              <?php endforeach; ?>
            </ul>
            <span class="xo-panel__count">11 entrées</span>
          </section>

          <!-- Tableau : en-tête en vidéo inverse, ligne courante pleine largeur -->
          <section class="xo-panel xo-col-8">
            <h2 class="xo-panel__title">Processus</h2>
            <table class="xo-table">
              <thead>
                <tr>
                  <th class="xo-num">PID</th><th>UTIL.</th>
                  <th class="xo-num">%CPU</th><th class="xo-num">%MÉM</th>
                  <th>S</th><th>COMMANDE</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($procs as $p): ?>
                <tr aria-selected="<?= $p[0] === 881 ? 'true' : 'false' ?>">
                  <td class="xo-num"><?= xo_e($p[0]) ?></td>
                  <td><?= xo_e($p[1]) ?></td>
                  <td class="xo-num"><?= xo_e(number_format($p[2], 1)) ?></td>
                  <td class="xo-num"><?= xo_e(number_format($p[3], 1)) ?></td>
                  <td class="<?= $p[4] === 'R' ? 'xo-success' : 'xo-muted' ?>"><?= xo_e($p[4]) ?></td>
                  <td><?= xo_e($p[5]) ?></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            <span class="xo-panel__count">5 / 187</span>
          </section>

          <!-- Jauges : déjà découpées en cellules, le cadre en moins -->
          <section class="xo-panel xo-panel--pad xo-col-4">
            <h2 class="xo-panel__title">Ressources</h2>
            <?php foreach ([
                ['CPU',     29, 'success'],
                ['Mémoire', 78, 'warning'],
                ['Disque',  94, 'danger'],
                ['Réseau',  12, 'success'],
            ] as [$nom, $val, $ton]): ?>
            <div class="xo-progress xo-progress--<?= xo_e($ton) ?>">
              <span class="xo-progress__label"><?= xo_e($nom) ?></span>
              <div class="xo-progress__track" role="meter" aria-valuenow="<?= xo_e($val) ?>"
                   aria-valuemin="0" aria-valuemax="100" aria-label="<?= xo_e($nom) ?>">
                <div class="xo-progress__fill" style="width: <?= xo_e($val) ?>%"></div>
              </div>
              <span class="xo-progress__value"><?= xo_e($val) ?>%</span>
            </div>
            <?php endforeach; ?>
          </section>

          <!-- Formulaire : aucun rectangle, que du texte sélectionnable -->
          <section class="xo-panel xo-panel--pad xo-col-8">
            <h2 class="xo-panel__title">Filtre</h2>

            <div class="xo-field">
              <label class="xo-label" for="t-cmd">Commande</label>
              <input class="xo-input" id="t-cmd" value="xoshui" placeholder="motif">
            </div>

            <div class="xo-field">
              <label class="xo-label" for="t-user">Utilisateur</label>
              <select class="xo-select" id="t-user">
                <option>tous</option><option selected>romain</option><option>root</option>
              </select>
            </div>

            <div class="xo-row">
              <label class="xo-check">
                <input type="checkbox" checked>
                <span>fils</span>
              </label>
              <label class="xo-check">
                <input type="checkbox">
                <span>inactifs</span>
              </label>
            </div>

            <div class="xo-row">
              <label class="xo-check">
                <input type="radio" name="tri" checked>
                <span>par CPU</span>
              </label>
              <label class="xo-check">
                <input type="radio" name="tri">
                <span>par mémoire</span>
              </label>
            </div>

            <div class="xo-row" style="margin-top: 8px">
              <button class="xo-btn xo-btn--primary"><span class="xo-btn__key">A</span>ppliquer</button>
              <button class="xo-btn"><span class="xo-btn__key">R</span>éinitialiser</button>
              <button class="xo-btn xo-btn--danger"><span class="xo-btn__key">T</span>uer</button>
              <button class="xo-btn" disabled>Épingler</button>
              <span class="xo-spacer"></span>
              <button class="xo-btn xo-btn--ghost">annuler</button>
            </div>
          </section>

          <!-- Graphe temporel : un <pre> de blocs, aucun canvas -->
          <section class="xo-panel xo-panel--pad xo-col-8">
            <h2 class="xo-panel__title">Charge</h2>

            <div class="xo-plot xo-plot--warning">
              <div class="xo-plot__scale" aria-hidden="true">
                <span>100%</span><span>75%</span><span>50%</span><span>25%</span><span>0%</span>
              </div>
              <pre class="xo-plot__area" role="img"
                   aria-label="Charge processeur sur 72 minutes, pic à <?= xo_e($pic) ?> %"><?php
                   echo xo_e(implode("\n", xo_plot_rangees($serie, 8))); ?></pre>
              <div class="xo-plot__foot">
                <span>-72m</span>
                <span class="xo-spacer"></span>
                <span>pic <?= xo_e($pic) ?>%</span>
                <span class="xo-spacer"></span>
                <span>maintenant</span>
              </div>
            </div>
          </section>

          <!-- Carte de chaleur : la densité porte la valeur, la couleur la double -->
          <section class="xo-panel xo-panel--pad xo-col-4">
            <h2 class="xo-panel__title">Activité</h2>

            <div class="xo-heat xo-heat--seuils" role="img"
                 aria-label="Activité par heure et par jour : creux la nuit, pic l’après-midi en semaine, week-end calme">
              <?php foreach ($heat as $jour => $heures): ?>
              <div class="xo-heat__row">
                <span class="xo-heat__label"><?= xo_e($jour) ?></span>
                <span class="xo-heat__cells" aria-hidden="true"><?php
                    foreach ($heures as $h => $n) {
                        $classe = 'xo-heat__cell xo-heat__cell--' . $n;
                        printf('<span class="%s" title="%s %02dh">%s</span>',
                            $classe, xo_e($jour), $h, $niveaux[$n]);
                    } ?></span>
              </div>
              <?php endforeach; ?>

              <div class="xo-heat__row">
                <span class="xo-heat__label"></span>
                <span class="xo-heat__cells xo-faint" aria-hidden="true">0h      6h      12h     18h  </span>
              </div>
            </div>

            <p class="xo-heat__foot" style="margin-top: 8px">
              <span>moins</span>
              <span aria-hidden="true"><?= implode('', $niveaux) ?></span>
              <span>plus</span>
            </p>
          </section>

          <!-- Calendrier : la disposition de `cal`, navigable en grille -->
          <section class="xo-panel xo-panel--pad xo-col-4">
            <h2 class="xo-panel__title">Planification</h2>

            <div class="xo-cal">
              <div class="xo-cal__head">
                <button class="xo-btn xo-btn--ghost" aria-label="Mois précédent">◂</button>
                <span class="xo-cal__month"><?= xo_e($mois->format('F Y')) ?></span>
                <button class="xo-btn xo-btn--ghost" aria-label="Mois suivant">▸</button>
              </div>

              <div class="xo-cal__grid" aria-hidden="true">
                <?php foreach (['lu', 'ma', 'me', 'je', 've', 'sa', 'di'] as $j): ?>
                <span class="xo-cal__dow"><?= xo_e($j) ?></span>
                <?php endforeach; ?>
              </div>

              <div class="xo-cal__grid" data-xo-list="grid" role="listbox"
                   aria-label="<?= xo_e($mois->format('F Y')) ?>">
                <?php for ($i = 0; $i < $decalage; $i++): ?>
                <span aria-hidden="true"></span>
                <?php endfor; ?>
                <?php for ($j = 1; $j <= $nbJours; $j++): ?>
                <button type="button" role="option"
                        class="xo-cal__day<?= in_array($j, $charges, true) ? ' xo-cal__day--event' : '' ?>"
                        aria-selected="<?= $j === $jourSel ? 'true' : 'false' ?>"
                        <?= $j === $aujourdhui ? 'aria-current="date"' : '' ?>><?= $j ?></button>
                <?php endfor; ?>
              </div>
            </div>

            <p class="xo-muted" style="margin-top: 8px">
              <span class="xo-alt">·</span> jour chargé · souligné : aujourd’hui
            </p>
          </section>

          <!-- Graphe en barres, sparkline, curseur : trois jauges de plus -->
          <section class="xo-panel xo-panel--pad xo-col-8">
            <h2 class="xo-panel__title">Répartition</h2>

            <div class="xo-bars">
              <?php foreach ([['CSS', 62], ['JS', 21], ['PHP', 12], ['MD', 5]] as [$nom, $pct]): ?>
              <span class="xo-bars__label"><?= xo_e($nom) ?></span>
              <span class="xo-bars__bar" aria-hidden="true"><?= str_repeat('█', (int) round($pct / 2)) ?></span>
              <span class="xo-bars__value"><?= xo_e($pct) ?>%</span>
              <?php endforeach; ?>
            </div>

            <div class="xo-row" style="margin-top: 8px">
              <span class="xo-muted">charge 24h</span>
              <span class="xo-spark" aria-hidden="true">▁▂▄▇█▆▄▃▂▄▆█▇▅▃▂▁▂▄▆</span>
              <span class="xo-muted">pic 94%</span>
            </div>

            <div class="xo-range" style="margin-top: 8px">
              <span class="xo-muted" style="min-width: 16ch">Rafraîchissement</span>
              <input type="range" min="1" max="60" value="5" aria-label="Rafraîchissement">
              <span class="xo-range__value">5s</span>
            </div>
          </section>

          <!-- Onglets et journal : data-xo-tabs inchangé -->
          <section class="xo-panel xo-panel--pad xo-col-12" data-xo-tabs>
            <h2 class="xo-panel__title">Sortie</h2>

            <div class="xo-tabs" role="tablist">
              <button class="xo-tabs__tab" role="tab" aria-selected="true"  aria-controls="t-log">1:journal</button>
              <button class="xo-tabs__tab" role="tab" aria-selected="false" aria-controls="t-etat">2:état</button>
            </div>

            <div class="xo-tabpanel" role="tabpanel" id="t-log">
              <div class="xo-log">
                <?php foreach ($flux as [$heure, $niveau, $message]): ?>
                <div class="xo-log__line xo-log__line--<?= xo_e($niveau) ?>">
                  <span class="xo-log__time"><?= xo_e($heure) ?></span>
                  <span class="xo-log__level"><?= xo_e($niveau) ?></span>
                  <span class="xo-log__msg"><?= xo_e($message) ?></span>
                </div>
                <?php endforeach; ?>
              </div>
            </div>

            <div class="xo-tabpanel" role="tabpanel" id="t-etat" hidden>
              <div class="xo-row">
                <span class="xo-badge xo-badge--success">surveillance</span>
                <span class="xo-badge xo-badge--warning">1 avertissement</span>
                <span class="xo-badge xo-badge--danger">1 erreur</span>
                <span class="xo-badge">42 fichiers</span>
                <span class="xo-spacer"></span>
                <span class="xo-spinner" aria-hidden="true"></span>
                <span class="xo-muted">en attente</span>
              </div>
            </div>
          </section>

        </div>
      </div>

      <div class="xo-keys">
        <span><kbd>↑↓</kbd> ligne</span>
        <span><kbd>Tab</kbd> volet</span>
        <span><kbd>1-2</kbd> onglet</span>
        <span><kbd>q</kbd> quitter</span>
        <span class="xo-spacer"></span>
        <span class="xo-faint">xoshui-top 1.0</span>
      </div>

    </div>

    <!-- ================================================================== -->
    <!-- La démonstration : le même HTML, les deux grammaires               -->
    <!-- ================================================================== -->

    <h2 style="margin: 32px 0 16px">Le même balisage, deux grammaires</h2>
    <p class="xo-muted" style="margin-bottom: 16px">
      Les deux colonnes ci-dessous contiennent des fragments identifiques au caractère
      près. Seule celle de droite est enveloppée dans un <code>xo-console</code>.
    </p>

    <div class="xo-grid">
      <?php
      /* Le fragment est écrit une seule fois, et rendu deux fois. */
      $fragment = <<<'HTML'
      <div class="xo-field">
        <label class="xo-label" for="%s-nom">Nom</label>
        <input class="xo-input" id="%s-nom" value="xoshui" placeholder="motif">
      </div>
      <label class="xo-check">
        <input type="checkbox" checked>
        <span>récursif</span>
      </label>
      <ul class="xo-list" role="listbox" aria-label="Cibles %s">
        <li class="xo-list__item" role="option" aria-selected="true"><span>libs/css</span></li>
        <li class="xo-list__item" role="option" aria-selected="false"><span>libs/js</span></li>
      </ul>
      <div class="xo-row" style="margin-top: 8px">
        <button class="xo-btn xo-btn--primary">Valider</button>
        <button class="xo-btn">Annuler</button>
      </div>
      HTML;
      ?>

      <section class="xo-panel xo-panel--pad xo-col-6">
        <h3 class="xo-panel__title">Mode normal</h3>
        <?= sprintf($fragment, 'n', 'n', 'normale') ?>
      </section>

      <div class="xo-col-6 xo-console">
        <section class="xo-panel xo-panel--pad">
          <h3 class="xo-panel__title">Mode console</h3>
          <?= sprintf($fragment, 'c', 'c', 'console') ?>
        </section>
      </div>
    </div>

    <!-- ================================================================== -->
    <!-- Ce que le mode traduit                                             -->
    <!-- ================================================================== -->

    <section class="xo-panel xo-panel--pad" style="margin-top: 32px">
      <h2 class="xo-panel__title">Ce que le mode traduit</h2>
      <dl class="xo-kv">
        <?php foreach ([
            'Bouton'      => 'un rectangle bordé → « [ Valider ] », inversé au survol et au focus',
            'Champ'       => 'un cadre → un bloc de saisie, qui passe en vidéo inverse quand le curseur y entre',
            'Case'        => 'la case native → « [x] » / « [ ] », le radio → « (•) » / « ( ) »',
            'Liste'       => 'la ligne courante prend toute la largeur et s’ouvre sur un « ▸ »',
            'Arbre'       => 'le retrait calculé peut céder la place aux branches ├─ └─ │ écrites dans le HTML',
            'Panneau'     => 'le titre interrompt le filet : « ──┤ Titre ├── »',
            'Tableau'     => 'l’en-tête passe en vidéo inverse, le zébrage disparaît',
            'Onglet'      => 'l’onglet actif devient une étiquette pleine, comme un tmux',
            'Jauge'       => 'la barre était déjà découpée en cellules — il ne reste qu’à retirer son cadre',
            'Grille'      => 'toutes les hauteurs tombent sur la cellule, tous les écarts se comptent en ch',
        ] as $quoi => $comment): ?>
        <div class="xo-kv__row">
          <dt><?= xo_e($quoi) ?></dt>
          <span class="xo-kv__leader" aria-hidden="true"></span>
          <dd class="xo-muted"><?= xo_e($comment) ?></dd>
        </div>
        <?php endforeach; ?>
      </dl>
      <p class="xo-muted" style="margin-top: 8px">
        Ce que le mode ne touche pas : le HTML, les rôles ARIA, les
        <code>data-xo-*</code>, le module JS. Un écran bascule en ajoutant une classe.
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
