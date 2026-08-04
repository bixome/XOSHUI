<?php
declare(strict_types=1);
require __DIR__ . '/_page.php';

xo_compo_debut('nav', 'Toutes les barres suivent la même règle : l’élément courant se marque avec aria-current, ce qui le passe en vidéo inverse. Jamais une classe « active ».');

xo_specimen('Barre de navigation', <<<'HTML'
<nav class="xo-nav" aria-label="Exemple">
  <span class="xo-nav__brand">XOSHUI</span>
  <ul class="xo-nav__list">
    <li><a class="xo-nav__link" href="#" aria-current="page">Accueil</a></li>
    <li><a class="xo-nav__link" href="#">Layouts</a></li>
    <li><a class="xo-nav__link" href="#">Démo</a></li>
  </ul>
  <span class="xo-spacer"></span>
  <span class="xo-muted">1.0</span>
</nav>
HTML, 'Ajouter xo-nav--sub pour une sous-barre : même mécanique, poids visuel moindre.', true);

xo_specimen('Fil d’Ariane', <<<'HTML'
<nav class="xo-breadcrumb" aria-label="Chemin">
  <span class="xo-breadcrumb__sep" aria-hidden="true">/</span><a href="#">libs</a>
  <span class="xo-breadcrumb__sep" aria-hidden="true">/</span><a href="#">css</a>
  <span class="xo-breadcrumb__sep" aria-hidden="true">/</span><span aria-current="page">xoshui.css</span>
</nav>
HTML, 'C’est une barre à part entière : sa place est sous la navigation, pas dedans.', true);

xo_specimen('Onglets', <<<'HTML'
<div class="xo-tabs" data-xo-tabs role="tablist">
  <button class="xo-tabs__tab" role="tab" aria-selected="true" aria-controls="d-p1">[1] Un</button>
  <button class="xo-tabs__tab" role="tab" aria-selected="false" aria-controls="d-p2">[2] Deux</button>
</div>
<section id="d-p1" role="tabpanel" class="xo-tabpanel" style="padding: 0 1ch">Premier panneau.</section>
<section id="d-p2" role="tabpanel" class="xo-tabpanel" style="padding: 0 1ch" hidden>Second panneau.</section>
HTML, 'Numéroter les onglets documente le raccourci correspondant.', true);

xo_specimen('Barre d’outils', <<<'HTML'
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
  <span class="xo-spacer"></span>
  <span class="xo-muted">537 tâches</span>
</div>
HTML, 'xo-btn-group fusionne les bordures. Un bouton bascule porte aria-pressed.', true);

xo_specimen('Barres de statut et de raccourcis', <<<'HTML'
<div class="xo-statusbar">
  <strong>production</strong>
  <span><span class="xo-statusbar__label">CPU:</span> <span class="xo-success">29%</span></span>
  <span class="xo-spacer"></span>
  <span class="xo-badge xo-badge--danger">1 incident</span>
</div>

<div class="xo-keys">
  <span><kbd>↑↓</kbd> naviguer</span>
  <span><kbd>Entrée</kbd> ouvrir</span>
  <span class="xo-spacer"></span>
  <span class="xo-faint">xoshui.test</span>
</div>
HTML, 'xo-keys ferme chaque écran : c’est ce qui rend l’interface auto-documentée. Un raccourci qui n’y figure pas n’existe pas.', true);

xo_specimen('Pagination', <<<'HTML'
<div class="xo-pagination">
  <button class="xo-btn" aria-label="Première page">«</button>
  <button class="xo-btn" aria-label="Page précédente">‹</button>
  <span class="xo-pagination__info">page 3 / 42</span>
  <button class="xo-btn" aria-label="Page suivante">›</button>
  <button class="xo-btn" aria-label="Dernière page">»</button>
</div>
HTML);

xo_compo_fin([
    'xo-nav'          => 'barre principale ; --sub pour une sous-barre',
    'xo-nav__brand'   => 'nom de l’application',
    'xo-nav__link'    => 'lien ; aria-current="page" pour le courant',
    'xo-breadcrumb'   => 'fil d’Ariane, en barre',
    'xo-tabs'         => 'onglets ; data-xo-tabs pour le clavier',
    'xo-toolbar'      => 'barre d’actions',
    'xo-btn-group'    => 'boutons accolés',
    'xo-search'       => 'champ de filtre préfixé',
    'xo-statusbar'    => 'informations d’état',
    'xo-keys'         => 'raccourcis, en pied d’écran',
    'xo-pagination'   => 'navigation entre pages',
], [
    '← →' => 'changer d’onglet',
    'Tab' => 'élément suivant',
]);
