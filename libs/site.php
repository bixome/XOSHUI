<?php
declare(strict_types=1);

/**
 * Navigation du site — une seule barre, partout la même.
 *
 *   require __DIR__ . '/libs/site.php';
 *   xo_nav('demo');     // barre principale + sous-barre + palette Ctrl+K
 *
 * La palette est émise par xo_nav() : toute page qui a la barre a la palette,
 * et Ctrl+K permet d'atteindre n'importe quelle page en trois frappes.
 */

/** Échappement de sortie. */
function xo_e(string|int|float|null $v): string
{
    return htmlspecialchars((string) $v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Niveau 1 — slug => [url, libellé, description]. */
const XO_PAGES = [
    'accueil' => ['/',               'Accueil', 'Point d’entrée'],
    'layouts' => ['/layouts/',       'Layouts', 'Pages entières à copier'],
    'compos'  => ['/components/',    'Composants', 'Un composant par page, isolé'],
    'modales' => ['/modals/',        'Modales', 'Boîtes de message, invites, confirmations'],
    'demo'    => ['/demo.php',       'Démo',    'Chaque classe isolée'],
    'docs'    => ['/docs.php',       'Docs',    'Aide-mémoire, charte, déploiement'],
    'lint'    => ['/tools/lint.php', 'Lint',    'Vérification des règles'],
];

/**
 * Documents lisibles — slug => [chemin, libellé].
 * Liste blanche : docs.php ne lit jamais un chemin venu de l'URL.
 */
const XO_DOCS = [
    'api'         => ['docs/api.md',               'Aide-mémoire'],
    'charte'      => ['docs/charte-graphique.md',  'Charte graphique'],
    'deploiement' => ['docs/deploiement.md',       'Déploiement'],
];

/** Niveau 2 — sous-pages de « modales ». */
const XO_MODALES = [
    'index'    => ['Sommaire',      'La liste des boîtes'],
    'message'  => ['Message',       'Information, succès, avertissement, erreur'],
    'confirm'  => ['Confirmation',  'Oui / non, destructif, saisie de garde'],
    'prompt'   => ['Invite',        'Saisie, mot de passe, choix dans une liste'],
    'formulaire' => ['Formulaire',  'Plusieurs champs, étapes, validation'],
    'progress' => ['Progression',   'Tâche longue, attente bloquante, résultat'],
    'panneau'  => ['Panneau',       'Boîte occupant tout l’écran'],
];

/** Niveau 2 — sous-pages de « composants ». */
const XO_COMPOSANTS = [
    'index'    => ['Sommaire',   'La liste des composants'],
    'panel'    => ['Panneau',    'Le cadre à titre incrusté'],
    'list'     => ['Liste',      'Sélection, arbre, navigation clavier'],
    'table'    => ['Tableau',    'En-tête collant, zébrage, tri'],
    'form'     => ['Formulaire', 'Champs, cases, radio, curseur'],
    'nav'      => ['Navigation', 'Barres, onglets, fil d’Ariane, pagination'],
    'feedback' => ['Retour',     'Alertes, notifications, badges, étiquettes'],
    'data'     => ['Données',    'Clé-valeur, métriques, jauges, chronologie'],
    'code'     => ['Code',       'Bloc, terminal, diff, invite'],
    'overlay'  => ['Surcouches', 'Modale, menu, palette, aide'],
    'layout'   => ['Mise en page', 'Grille, pile, séparateur, texte'],
];

/** Niveau 2 — sous-pages de « layouts ». */
const XO_LAYOUTS = [
    'index'         => ['Sommaire',        'La liste des mises en page'],
    'dashboard'     => ['Tableau de bord', 'Métriques, panneaux, journal'],
    'master-detail' => ['Maître-détail',   'Liste à gauche, détail à droite'],
    'table'         => ['Table',           'Données, tri, filtre, pagination'],
    'explorer'      => ['Explorateur',     'Trois volets : arbre, contenu, aperçu'],
    'form'          => ['Formulaire',      'Champs groupés, validation, actions'],
    'console'       => ['Console',         'Journal défilant et invite'],
    'article'       => ['Article',         'Lecture : sommaire, texte'],
    'login'         => ['Connexion',       'Panneau centré'],
];

/**
 * Le slug de niveau 1 auquel appartient une page.
 * « index » appartient à deux registres : les sommaires passent donc le slug
 * de leur section (« layouts », « compos »), pas « index ».
 */
function xo_section(string $current): string
{
    if (isset(XO_PAGES[$current])) { return $current; }
    if (isset(XO_DOCS[$current]))       { return 'docs'; }
    if (isset(XO_LAYOUTS[$current]))    { return 'layouts'; }
    if (isset(XO_COMPOSANTS[$current])) { return 'compos'; }
    if (isset(XO_MODALES[$current]))    { return 'modales'; }
    return 'accueil';
}

/**
 * Barre principale, sous-barre éventuelle, et palette de commandes.
 *
 * @param string $current slug de niveau 1, ou slug de layout ('explorer'…)
 */
function xo_nav(string $current = ''): void
{
    $section = xo_section($current);
    ?>
  <nav class="xo-nav" aria-label="Principale">
    <a class="xo-nav__brand" href="/">XOSHUI</a>
    <ul class="xo-nav__list">
      <?php foreach (XO_PAGES as $slug => [$url, $label, $_]): ?>
      <li><a class="xo-nav__link" href="<?= xo_e($url) ?>"
             <?= $slug === $section ? 'aria-current="page"' : '' ?>><?= xo_e($label) ?></a></li>
      <?php endforeach; ?>
    </ul>
    <span class="xo-spacer"></span>
    <button class="xo-btn xo-btn--ghost" data-xo-open="#xo-palette">
      <kbd>Ctrl+K</kbd> aller à…
    </button>
  </nav>

    <?php if ($section === 'layouts'): ?>
  <nav class="xo-nav xo-nav--sub" aria-label="Layouts">
    <ul class="xo-nav__list">
      <?php foreach (XO_LAYOUTS as $slug => [$label, $_]):
          $url  = $slug === 'index' ? '/layouts/' : '/layouts/' . $slug . '.php';
          $ici  = $slug === $current || ($slug === 'index' && $current === $section); ?>
      <li><a class="xo-nav__link" href="<?= xo_e($url) ?>"
             <?= $ici ? 'aria-current="page"' : '' ?>><?= xo_e($label) ?></a></li>
      <?php endforeach; ?>
    </ul>
  </nav>
    <?php elseif ($section === 'compos'): ?>
  <nav class="xo-nav xo-nav--sub" aria-label="Composants">
    <ul class="xo-nav__list">
      <?php foreach (XO_COMPOSANTS as $slug => [$label, $_]):
          $url  = $slug === 'index' ? '/components/' : '/components/' . $slug . '.php';
          $ici  = $slug === $current || ($slug === 'index' && $current === $section); ?>
      <li><a class="xo-nav__link" href="<?= xo_e($url) ?>"
             <?= $ici ? 'aria-current="page"' : '' ?>><?= xo_e($label) ?></a></li>
      <?php endforeach; ?>
    </ul>
  </nav>
    <?php elseif ($section === 'modales'): ?>
  <nav class="xo-nav xo-nav--sub" aria-label="Modales">
    <ul class="xo-nav__list">
      <?php foreach (XO_MODALES as $slug => [$label, $_]):
          $url  = $slug === 'index' ? '/modals/' : '/modals/' . $slug . '.php';
          $ici  = $slug === $current || ($slug === 'index' && $current === $section); ?>
      <li><a class="xo-nav__link" href="<?= xo_e($url) ?>"
             <?= $ici ? 'aria-current="page"' : '' ?>><?= xo_e($label) ?></a></li>
      <?php endforeach; ?>
    </ul>
  </nav>
    <?php elseif ($section === 'docs'): ?>
  <nav class="xo-nav xo-nav--sub" aria-label="Documents">
    <ul class="xo-nav__list">
      <?php foreach (XO_DOCS as $slug => [$_, $label]): ?>
      <li><a class="xo-nav__link" href="/docs.php?f=<?= xo_e($slug) ?>"
             <?= $slug === $current ? 'aria-current="page"' : '' ?>><?= xo_e($label) ?></a></li>
      <?php endforeach; ?>
    </ul>
  </nav>
    <?php endif;

    xo_palette($current);
    xo_help();
}

/** Aide des raccourcis, ouverte par « ? » — disponible sur toutes les pages. */
function xo_help(): void
{
    ?>
<dialog class="xo-help" id="xo-help" data-xo-help aria-label="Raccourcis clavier">
  <p class="xo-help__title">Raccourcis</p>
  <dl class="xo-help__grid">
    <dt class="xo-help__group">Circuler</dt>
    <dt>Ctrl+K</dt><dd>Aller à une page</dd>
    <dt>Tab</dt><dd>Élément suivant</dd>
    <dt>?</dt><dd>Cette aide</dd>
    <dt class="xo-help__group">Dans une liste</dt>
    <dt>↑ ↓</dt><dd>Déplacer la sélection</dd>
    <dt>Début / Fin</dt><dd>Premier / dernier</dd>
    <dt>Entrée</dt><dd>Activer</dd>
    <dt class="xo-help__group">Ailleurs</dt>
    <dt>← →</dt><dd>Onglet, séparateur</dd>
    <dt>Échap</dt><dd>Fermer</dd>
  </dl>
  <div class="xo-dialog__actions">
    <button class="xo-btn" data-xo-close>Fermer</button>
  </div>
</dialog>
<?php
}

/** Palette : toutes les pages du site, atteignables au clavier. */
function xo_palette(string $current = ''): void
{
    // [url, libellé, section] — l'ordre est celui de la navigation.
    $entrees = [];
    foreach (XO_PAGES as $slug => [$url, $label, $desc]) {
        $entrees[] = [$url, $label, $desc];
    }
    foreach (XO_LAYOUTS as $slug => [$label, $desc]) {
        $url = $slug === 'index' ? '/layouts/' : '/layouts/' . $slug . '.php';
        $entrees[] = [$url, 'Layouts › ' . $label, $desc];
    }
    foreach (XO_COMPOSANTS as $slug => [$label, $desc]) {
        $url = $slug === 'index' ? '/components/' : '/components/' . $slug . '.php';
        $entrees[] = [$url, 'Composants › ' . $label, $desc];
    }
    foreach (XO_MODALES as $slug => [$label, $desc]) {
        $url = $slug === 'index' ? '/modals/' : '/modals/' . $slug . '.php';
        $entrees[] = [$url, 'Modales › ' . $label, $desc];
    }
    foreach (XO_DOCS as $slug => [$chemin, $label]) {
        $entrees[] = ['/docs.php?f=' . $slug, 'Docs › ' . $label, $chemin];
    }
    ?>
<dialog class="xo-palette" id="xo-palette" data-xo-palette aria-label="Aller à…">
  <label class="xo-search">
    <span class="xo-search__prefix" aria-hidden="true">&gt;</span>
    <input type="text" placeholder="Aller à…" aria-label="Page">
  </label>
  <ul class="xo-palette__list xo-list" data-xo-list role="listbox" aria-label="Pages">
    <?php foreach ($entrees as $i => [$url, $label, $desc]): ?>
    <li class="xo-list__item" role="option" aria-selected="<?= $i === 0 ? 'true' : 'false' ?>">
      <a class="xo-palette__label" href="<?= xo_e($url) ?>"><?= xo_e($label) ?></a>
      <span class="xo-list__meta"><?= xo_e($desc) ?></span>
    </li>
    <?php endforeach; ?>
  </ul>
  <p class="xo-palette__empty" hidden>Aucune page ne correspond.</p>
  <div class="xo-keys">
    <span><kbd>↑↓</kbd> naviguer</span>
    <span><kbd>Entrée</kbd> ouvrir</span>
    <span><kbd>Échap</kbd> fermer</span>
  </div>
</dialog>
<?php
}
