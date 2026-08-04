<?php
declare(strict_types=1);
require __DIR__ . '/_page.php';

xo_compo_debut('layout', 'Deux axes, deux unités : l’horizontal se mesure en caractères (ch), le vertical en multiples de 4 px. C’est ce qui aligne les colonnes sans effort.');

xo_specimen('Grille', <<<'HTML'
<div class="xo-grid">
  <div class="xo-panel xo-panel--pad xo-col-3">xo-col-3</div>
  <div class="xo-panel xo-panel--pad xo-col-3">xo-col-3</div>
  <div class="xo-panel xo-panel--pad xo-col-6">xo-col-6</div>
  <div class="xo-panel xo-panel--pad xo-col-8">xo-col-8</div>
  <div class="xo-panel xo-panel--pad xo-col-4">xo-col-4</div>
</div>
HTML, '12 colonnes. L’interligne vertical est doublé, parce que titres et compteurs de panneau débordent de leur bordure. Sous 720 px, tout passe en pleine largeur.');

xo_specimen('Ligne et pile', <<<'HTML'
<div class="xo-row">
  <button class="xo-btn">Un</button>
  <button class="xo-btn">Deux</button>
  <span class="xo-spacer"></span>
  <span class="xo-muted">poussé à droite</span>
</div>

<div class="xo-stack xo-stack--tight" style="margin-top: 8px">
  <span>Empilé</span>
  <span>avec une gouttière serrée</span>
</div>
HTML, 'xo-stack espace de 16 px, xo-stack--tight de 8 px. Le second à l’intérieur d’un panneau, le premier entre panneaux.');

xo_specimen('Séparateur redimensionnable', <<<'HTML'
<div class="xo-split" data-xo-split style="min-height: 8em; border: 1px solid var(--xo-border)">
  <div class="xo-scroll" style="padding: 8px 1ch">Volet gauche</div>
  <button class="xo-split__handle" role="separator" aria-orientation="vertical"
          aria-label="Redimensionner" aria-valuenow="50" aria-valuemin="15" aria-valuemax="85"></button>
  <div class="xo-scroll" style="padding: 8px 1ch">Volet droit — glissez la poignée, ou ← → au clavier.</div>
</div>
HTML, 'Sous 720 px les volets s’empilent et la poignée passe en display: none, ce qui la sort aussi du parcours clavier.');

xo_specimen('Colonne latérale', <<<'HTML'
<div class="xo-layout" style="min-height: 8em; border: 1px solid var(--xo-border)">
  <nav class="xo-sidebar" aria-label="Sections">
    <div class="xo-sidebar__group">Projet</div>
    <a class="xo-sidebar__link" href="#" aria-current="page">Vue d’ensemble</a>
    <a class="xo-sidebar__link" href="#">Fichiers</a>
  </nav>
  <div class="xo-scroll" style="padding: 8px 1ch; flex: 1">Contenu de la section.</div>
</div>
HTML, 'Sous 720 px la colonne repasse au-dessus du contenu, en pleine largeur et plafonnée à 40vh.');

xo_specimen('Filet titré et bannière', <<<'HTML'
<div class="xo-rule">Au centre</div>
<div class="xo-rule xo-rule--start" style="margin-top: 8px">À gauche</div>

<div class="xo-banner" style="margin-top: 8px">
  <pre class="xo-banner__art">┌─ X O S H U I ─┐</pre>
  <p class="xo-banner__tagline">Sous-titre</p>
</div>
HTML);

xo_specimen('Texte de lecture', <<<'HTML'
<article class="xo-prose">
  <h2>Un titre</h2>
  <p>Seule zone du framework qui ne remplit pas l’écran : la largeur est plafonnée à
  80 caractères, au-delà l’œil décroche en fin de ligne.</p>
  <ul>
    <li>Les marges que le reset supprime sont rétablies ici.</li>
    <li>Et seulement ici : une interface n’est pas un texte.</li>
  </ul>
</article>
HTML);

xo_compo_fin([
    'xo-app'        => 'colonne pleine hauteur',
    'xo-main'       => 'zone centrale',
    'xo-grid'       => 'grille 12 colonnes',
    'xo-col-*'      => '2, 3, 4, 5, 6, 8, 9, 12',
    'xo-row'        => 'flex horizontal, gouttière 1ch',
    'xo-stack'      => 'flex vertical ; --tight à l’intérieur d’un panneau',
    'xo-spacer'     => 'pousse le reste à droite',
    'xo-layout'     => 'colonne latérale + contenu',
    'xo-sidebar'    => 'la colonne latérale',
    'xo-split'      => 'deux volets réglables ; data-xo-split',
    'xo-rule'       => 'filet titré ; --start pour aligner à gauche',
    'xo-banner'     => 'bandeau à art ASCII',
    'xo-prose'      => 'texte rédigé, 80ch',
    'xo-footer'     => 'pied de page',
], [
    '← →' => 'déplacer le séparateur',
]);
