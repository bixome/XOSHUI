<?php
declare(strict_types=1);
require __DIR__ . '/../libs/specimen.php';

xo_specimen_debut('data', 'Afficher des chiffres sans quitter la grille de caractères. Les barres sont découpées en cellules d’un caractère : elles ressemblent à un terminal, pas à une barre de progression web.');

xo_specimen('Clé-valeur', <<<'HTML'
<dl class="xo-kv">
  <div class="xo-kv__row">
    <dt>Version</dt>
    <span class="xo-kv__leader" aria-hidden="true"></span>
    <dd>1.4.2</dd>
  </div>
  <div class="xo-kv__row">
    <dt>Base</dt>
    <span class="xo-kv__leader" aria-hidden="true"></span>
    <dd>MySQL 8.0.36</dd>
  </div>
  <div class="xo-kv__row">
    <dt>Déploiement</dt>
    <span class="xo-kv__leader" aria-hidden="true"></span>
    <dd>il y a 3 h</dd>
  </div>
</dl>
HTML, 'Les trois éléments sont nécessaires : le leader est la ligne de pointillés qui relie la clé à sa valeur. Omniprésent dans les écrans BIOS.');

xo_specimen('Métriques', <<<'HTML'
<div class="xo-row" style="gap: 2ch">
  <div class="xo-stat">
    <span class="xo-stat__value">12 480</span>
    <span class="xo-stat__label">Requêtes</span>
    <span class="xo-stat__delta xo-stat__delta--up">+8%</span>
  </div>
  <div class="xo-stat">
    <span class="xo-stat__value">37</span>
    <span class="xo-stat__label">Erreurs</span>
    <span class="xo-stat__delta xo-stat__delta--down">−12%</span>
  </div>
  <div class="xo-stat">
    <span class="xo-stat__value">84 ms</span>
    <span class="xo-stat__label">Latence</span>
    <span class="xo-stat__delta">p95</span>
  </div>
</div>
HTML, 'Un delta sans direction reste neutre : « p95 » n’est ni une hausse ni une baisse.');

xo_specimen('Jauges et progression', <<<'HTML'
<div class="xo-stack xo-stack--tight">
  <div class="xo-progress xo-progress--success">
    <span class="xo-progress__label">CPU</span>
    <div class="xo-progress__track" role="meter" aria-valuenow="29" aria-valuemin="0" aria-valuemax="100" aria-label="CPU">
      <div class="xo-progress__fill" style="width: 29%"></div>
    </div>
    <span class="xo-progress__value">29%</span>
  </div>
  <div class="xo-progress xo-progress--warning">
    <span class="xo-progress__label">Mémoire</span>
    <div class="xo-progress__track" role="meter" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" aria-label="Mémoire">
      <div class="xo-progress__fill" style="width: 78%"></div>
    </div>
    <span class="xo-progress__value">78%</span>
  </div>
  <div class="xo-progress xo-progress--danger">
    <span class="xo-progress__label">Disque</span>
    <div class="xo-progress__track" role="meter" aria-valuenow="94" aria-valuemin="0" aria-valuemax="100" aria-label="Disque">
      <div class="xo-progress__fill" style="width: 94%"></div>
    </div>
    <span class="xo-progress__value">94%</span>
  </div>
  <div class="xo-row">
    <span class="xo-spinner" aria-hidden="true"></span>
    <span class="xo-muted">Indexation en cours…</span>
  </div>
</div>
HTML, 'Jauge et barre de progression sont le même objet : role="meter" pour une mesure, role="progressbar" pour une tâche. Seuils d’usage : --warning ≥ 70 %, --danger ≥ 90 %.');

xo_specimen('Graphe en barres et sparkline', <<<'HTML'
<div class="xo-bars">
  <span class="xo-bars__label">CSS</span>
  <span class="xo-bars__bar" aria-hidden="true">████████████████████</span>
  <span class="xo-bars__value">62%</span>
  <span class="xo-bars__label">JS</span>
  <span class="xo-bars__bar" aria-hidden="true">███████</span>
  <span class="xo-bars__value">21%</span>
  <span class="xo-bars__label">PHP</span>
  <span class="xo-bars__bar" aria-hidden="true">████</span>
  <span class="xo-bars__value">12%</span>
</div>

<div class="xo-row" style="margin-top: 8px">
  <span class="xo-muted">Trafic</span>
  <span class="xo-spark" aria-hidden="true">▁▂▄▇█▆▄▃▂▄▆█▇▅▃▂▁▂▄</span>
</div>
HTML, 'La barre est du texte : str_repeat(\'█\', round($pct / 3)). Aucun canvas, aucune dépendance.');

xo_specimen('Chronologie et étapes', <<<'HTML'
<div class="xo-steps" style="margin-bottom: 8px">
  <span class="xo-steps__step xo-steps__step--done">✓ Analyse</span>
  <span class="xo-steps__sep" aria-hidden="true">─►</span>
  <span class="xo-steps__step" aria-current="step">● Compilation</span>
  <span class="xo-steps__sep" aria-hidden="true">─►</span>
  <span class="xo-steps__step">○ Envoi</span>
</div>

<ul class="xo-timeline">
  <li class="xo-timeline__item">
    <span class="xo-timeline__marker" aria-hidden="true">●</span>
    <div class="xo-timeline__body">
      <div>Dépôt initialisé</div>
      <div class="xo-timeline__time">14:00</div>
    </div>
  </li>
  <li class="xo-timeline__item">
    <span class="xo-timeline__marker" aria-hidden="true">●</span>
    <div class="xo-timeline__body">
      <div>Premier lot de composants</div>
      <div class="xo-timeline__time">14:12</div>
    </div>
  </li>
</ul>
HTML);

xo_specimen('Chargement', <<<'HTML'
<div class="xo-stack xo-stack--tight">
  <span class="xo-skeleton" style="width: 32ch">&nbsp;</span>
  <span class="xo-skeleton" style="width: 24ch">&nbsp;</span>
</div>
HTML, 'Le squelette occupe la place du contenu à venir, pour que la page ne saute pas quand il arrive.');

xo_specimen_fin([
    'xo-kv'          => 'liste clé-valeur à pointillés',
    'xo-kv__leader'  => 'la ligne de pointillés — élément obligatoire',
    'xo-stat'        => 'métrique : valeur, libellé, delta',
    'xo-progress'    => 'jauge ou progression, en cellules',
    'xo-spinner'     => 'attente animée, figée sous prefers-reduced-motion',
    'xo-bars'        => 'graphe en barres de caractères',
    'xo-spark'       => 'courbe compacte en blocs',
    'xo-timeline'    => 'suite d’événements datés',
    'xo-steps'       => 'progression par étapes',
    'xo-skeleton'    => 'réservation de place pendant le chargement',
]);
