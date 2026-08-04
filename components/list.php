<?php
declare(strict_types=1);
require __DIR__ . '/_page.php';

xo_compo_debut('list', 'La liste est le composant le plus chargé de sens du framework : c’est elle qui porte la sélection en vidéo inverse, d’un bord à l’autre. Ajouter data-xo-list suffit à la rendre navigable au clavier.');

xo_specimen('Liste simple', <<<'HTML'
<ul class="xo-list" data-xo-list role="listbox" aria-label="Branches">
  <li class="xo-list__item" role="option" aria-selected="true" data-value="main">
    <span class="xo-list__icon" aria-hidden="true">├</span>
    <span>main</span>
    <span class="xo-list__meta xo-success">✓</span>
  </li>
  <li class="xo-list__item" role="option" aria-selected="false" data-value="feat">
    <span class="xo-list__icon" aria-hidden="true">├</span>
    <span>feat/tokens</span>
    <span class="xo-list__meta">1d</span>
  </li>
  <li class="xo-list__item" role="option" aria-selected="false" data-value="fix">
    <span class="xo-list__icon" aria-hidden="true">├</span>
    <span>fix/contrast</span>
    <span class="xo-list__meta">1w</span>
  </li>
</ul>
HTML, 'Cliquez, ou donnez le focus à la liste et utilisez les flèches. La sélection va d’un bord à l’autre : c’est la signature du rendu terminal.', true);

xo_specimen('Libellé long', <<<'HTML'
<div style="width: 34ch; border: 1px solid var(--xo-border)">
  <ul class="xo-list">
    <li class="xo-list__item">
      <span class="xo-list__icon" aria-hidden="true">#</span>
      <span>Timeout sur /api/export au-delà de 50 000 lignes</span>
      <span class="xo-list__meta xo-danger">ouvert</span>
    </li>
  </ul>
</div>
HTML, 'C’est le libellé qui se tronque, jamais la méta. Sans min-width: 0, un enfant flex refuse de rétrécir et pousse l’état hors du cadre.');

xo_specimen('Arbre', <<<'HTML'
<ul class="xo-list xo-list--tree" data-xo-list role="tree" aria-label="Dossiers">
  <li class="xo-list__item" role="treeitem" aria-expanded="true" style="--xo-depth: 0">
    <span class="xo-list__icon" aria-hidden="true">▾</span><span class="xo-info">libs</span>
  </li>
  <li class="xo-list__item" role="treeitem" aria-expanded="true" style="--xo-depth: 1">
    <span class="xo-list__icon" aria-hidden="true">▾</span><span class="xo-info">css</span>
  </li>
  <li class="xo-list__item" role="treeitem" style="--xo-depth: 2">
    <span class="xo-list__icon" aria-hidden="true"> </span><span>xoshui.css</span>
  </li>
  <li class="xo-list__item" role="treeitem" style="--xo-depth: 0">
    <span class="xo-list__icon" aria-hidden="true">▸</span><span class="xo-info">docs</span>
  </li>
</ul>
HTML, 'L’indentation vient de --xo-depth, en multiples de 2 caractères. Le chevron reste du texte : ▾ ouvert, ▸ fermé.', true);

xo_specimen('Ligne désactivée', <<<'HTML'
<ul class="xo-list" data-xo-list role="listbox" aria-label="Actions">
  <li class="xo-list__item" role="option" aria-selected="true"><span>Ouvrir</span></li>
  <li class="xo-list__item" role="option" aria-disabled="true"><span>Renommer</span></li>
  <li class="xo-list__item" role="option"><span>Supprimer</span></li>
</ul>
HTML, 'aria-disabled sort la ligne du parcours des flèches, sans la masquer.', true);

xo_compo_fin([
    'xo-list'         => 'le conteneur',
    'xo-list__item'   => 'une ligne',
    'xo-list__icon'   => 'glyphe de tête, largeur fixe',
    'xo-list__meta'   => 'valeur poussée à droite, jamais tronquée',
    'xo-list--tree'   => 'indentation par --xo-depth',
    'data-xo-list'    => 'active le clavier et les événements',
    'aria-selected'   => 'la ligne sélectionnée — pas une classe',
    'aria-disabled'   => 'ligne inerte',
], [
    '↑ ↓'    => 'déplacer la sélection',
    'Début'  => 'première ligne',
    'Fin'    => 'dernière ligne',
    'Entrée' => 'active la ligne, émet xo:activate',
]);
