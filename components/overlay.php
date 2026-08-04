<?php
declare(strict_types=1);
require __DIR__ . '/_page.php';

xo_compo_debut('overlay', 'Tout ce qui se superpose. Chaque composant s’appuie sur un élément natif — <dialog> ou <details> — pour hériter du piège à focus, d’Échap et du fonctionnement sans JavaScript.');

xo_specimen('Modale', <<<'HTML'
<button class="xo-btn xo-btn--danger" data-xo-open="#d-confirm">Supprimer</button>

<dialog class="xo-dialog" id="d-confirm">
  <p class="xo-dialog__title">Confirmer</p>
  <p>Supprimer la branche sélectionnée ? Cette action est définitive.</p>
  <div class="xo-dialog__actions">
    <button class="xo-btn" data-xo-close>Annuler</button>
    <button class="xo-btn xo-btn--danger" data-xo-close>Supprimer</button>
  </div>
</dialog>
HTML, '<dialog> natif : Échap ferme, le focus est piégé puis restitué à l’ouvrant. data-xo-open et data-xo-close évitent d’écrire la moindre ligne de JS.');

xo_specimen('Menu déroulant', <<<'HTML'
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
HTML, 'Bâti sur <details> : il s’ouvre sans JavaScript. Le module n’ajoute qu’Échap, le clic extérieur et la fermeture après un choix.');

xo_specimen('Accordéon', <<<'HTML'
<details class="xo-accordion">
  <summary>Options avancées</summary>
  <div class="xo-accordion__body">
    <label class="xo-check"><input type="checkbox"> Reconnexion automatique</label>
  </div>
</details>
HTML, 'Chevron ▸ / ▾ automatique. C’est ce composant qui replie la source sous chaque exemple de cette page.');

xo_specimen('Palette de commandes', <<<'HTML'
<button class="xo-btn xo-btn--primary" data-xo-open="#xo-palette">Ouvrir la palette</button>
HTML, 'La palette du site est émise par xo_nav() : Ctrl+K l’ouvre partout. Chaque entrée contient un <a href>, donc Entrée navigue sans une ligne de JS.');

xo_specimen('Aide des raccourcis', <<<'HTML'
<button class="xo-btn" data-xo-open="#xo-help">Ouvrir l’aide</button>
HTML, 'Ouverte par « ? », sauf pendant une saisie — sinon on ne pourrait plus taper de point d’interrogation.');

xo_compo_fin([
    'xo-dialog'          => 'modale, sur <dialog>',
    'xo-dropdown'        => 'menu, sur <details>',
    'xo-dropdown__key'   => 'raccourci, aligné à droite',
    'xo-accordion'       => 'section repliable, sur <details>',
    'xo-palette'         => 'palette de commandes',
    'xo-palette__label'  => 'libellé filtrable ; un <a> pour naviguer',
    'xo-help'            => 'aide des raccourcis',
    'data-xo-open'       => 'ouvre la <dialog> ciblée',
    'data-xo-close'      => 'ferme la <dialog> parente',
], [
    'Ctrl+K' => 'palette',
    '?'      => 'aide',
    '↑ ↓'    => 'parcourir la palette',
    'Échap'  => 'fermer',
]);
