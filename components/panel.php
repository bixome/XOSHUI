<?php
declare(strict_types=1);
require __DIR__ . '/_page.php';

xo_compo_debut('panel', 'Le cadre à titre incrusté — l’atome du framework. Son titre et son compteur vivent dans la bordure et débordent de part et d’autre : c’est ce qui donne le trait coupé des interfaces en mode texte.');

xo_specimen('Par défaut', <<<'HTML'
<section class="xo-panel xo-panel--pad">
  <h2 class="xo-panel__title">Titre</h2>
  <p>Le contenu du panneau.</p>
</section>
HTML, 'Sans --pad, le contenu va d’un bord à l’autre. C’est le défaut, parce qu’on y met le plus souvent une liste ou un tableau.');

xo_specimen('Actif', <<<'HTML'
<section class="xo-panel xo-panel--pad xo-panel--active">
  <h2 class="xo-panel__title">Panneau focalisé</h2>
  <p>Bordure et titre passent en accent.</p>
</section>
HTML, 'Le panneau qui a le focus se signale par la couleur de sa bordure — jamais par un fond différent.');

xo_specimen('Compteur incrusté', <<<'HTML'
<section class="xo-panel">
  <h2 class="xo-panel__title">Branches</h2>
  <ul class="xo-list">
    <li class="xo-list__item" aria-selected="true"><span>main</span></li>
    <li class="xo-list__item"><span>feat/tokens</span></li>
    <li class="xo-list__item"><span>fix/contrast</span></li>
  </ul>
  <span class="xo-panel__count">1 of 3</span>
</section>
HTML, 'Le compteur se pose dans la bordure basse, à droite. Prévoir un interligne double entre deux panneaux empilés, sinon il touche le titre du suivant.', true);

xo_specimen('Corps défilant', <<<'HTML'
<section class="xo-panel">
  <h2 class="xo-panel__title">Journal</h2>
  <div class="xo-panel__body" style="--xo-max-h: 6em">
    <ul class="xo-list">
      <li class="xo-list__item"><span>09:31:02 worker#3 démarré</span></li>
      <li class="xo-list__item"><span>09:31:04 file d’attente vidée</span></li>
      <li class="xo-list__item"><span>09:31:20 GET /api/orders — 41 ms</span></li>
      <li class="xo-list__item"><span>09:31:44 cache: 61 % sur 5 min</span></li>
      <li class="xo-list__item"><span>09:32:01 POST /api/orders — 128 ms</span></li>
      <li class="xo-list__item"><span>09:32:40 worker#3 sain</span></li>
    </ul>
  </div>
</section>
HTML, 'Un panneau ne défile jamais lui-même : un overflow poserait un ciseau sur son titre. C’est xo-panel__body qui défile.', true);

xo_compo_fin([
    'xo-panel'         => 'le cadre',
    'xo-panel--pad'    => 'padding horizontal, pour du texte ou un formulaire',
    'xo-panel--active' => 'bordure et titre en accent',
    'xo-panel__title'  => 'titre incrusté dans la bordure haute',
    'xo-panel__count'  => 'compteur incrusté dans la bordure basse',
    'xo-panel__body'   => 'zone défilante ; hauteur via --xo-max-h',
]);
