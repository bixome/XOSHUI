<?php
declare(strict_types=1);
require __DIR__ . '/_page.php';

xo_compo_debut('feedback', 'Tout ce qui informe l’utilisateur d’un état. Règle commune : la couleur ne porte jamais seule le message — elle est toujours doublée d’un glyphe ou d’un mot.');

xo_specimen('Alertes', <<<'HTML'
<div class="xo-stack xo-stack--tight">
  <div class="xo-alert" role="status">
    <span aria-hidden="true">i</span>
    <span class="xo-alert__body">La connexion sera testée avant l’enregistrement.</span>
  </div>
  <div class="xo-alert xo-alert--success" role="status">
    <span aria-hidden="true">✓</span>
    <span class="xo-alert__body"><span class="xo-alert__title">Déploiement terminé.</span> Version 1.4.2 en ligne.</span>
  </div>
  <div class="xo-alert xo-alert--warning" role="status">
    <span aria-hidden="true">▲</span>
    <span class="xo-alert__body"><span class="xo-alert__title">Température élevée.</span> Le CPU dépasse 70 °C.</span>
  </div>
  <div class="xo-alert xo-alert--danger" role="alert">
    <span aria-hidden="true">✗</span>
    <span class="xo-alert__body"><span class="xo-alert__title">redis injoignable.</span> Bascule sur la base.</span>
    <button class="xo-btn xo-btn--danger">Relancer</button>
  </div>
</div>
HTML, 'role="status" pour une information, role="alert" pour ce qui bloque — le second interrompt un lecteur d’écran, le premier non.');

xo_specimen('Notifications', <<<'HTML'
<div class="xo-toast xo-toast--success" role="status" data-xo-toast="0">
  <span aria-hidden="true">✓</span>
  <span class="xo-toast__body"><span class="xo-toast__title">Enregistré.</span> 4 fichiers écrits.</span>
  <button class="xo-toast__close" aria-label="Fermer">×</button>
</div>
HTML, 'En usage réel, les empiler dans un conteneur xo-toasts, fixé en bas à droite. data-xo-toast="4000" les fait disparaître après 4 s.');

xo_specimen('Badges et étiquettes', <<<'HTML'
<div class="xo-row">
  <span class="xo-badge xo-badge--success">✓ READY</span>
  <span class="xo-badge xo-badge--warning">▲ M</span>
  <span class="xo-badge xo-badge--danger">✗ FAIL</span>
  <span class="xo-badge xo-badge--info">● 3</span>
  <span class="xo-badge">??</span>
  <span class="xo-badge xo-badge--solid xo-badge--danger">bloqué</span>
</div>

<div class="xo-row" style="margin-top: 8px">
  <span class="xo-tag xo-tag--accent">api</span>
  <span class="xo-tag">css</span>
  <span class="xo-tag xo-tag--warning">
    non suivi <button class="xo-tag__remove" aria-label="Retirer">×</button>
  </span>
</div>
HTML, 'Le badge décrit un état, l’étiquette classe un objet. --solid se combine avec une variante de couleur.');

xo_specimen('Infobulle', <<<'HTML'
<span class="xo-muted" data-xo-tip="Dernier commit il y a 4 minutes" tabindex="0">survolez-moi</span>
HTML, 'Pur CSS, et déclenchée aussi au focus clavier — une infobulle réservée à la souris est inaccessible.');

xo_specimen('État vide', <<<'HTML'
<div class="xo-empty">
  <pre class="xo-empty__art" aria-hidden="true">┌───────────┐
│   vide    │
└───────────┘</pre>
  <p class="xo-empty__msg">Aucune modification remisée.</p>
  <button class="xo-btn">Créer un stash</button>
</div>
HTML, 'Un état vide propose toujours l’action qui le remplit.');

xo_compo_fin([
    'xo-alert'        => 'message inline ; --success --warning --danger',
    'xo-alert__title' => 'première phrase, en gras',
    'xo-toast'        => 'notification ; data-xo-toast = délai en ms',
    'xo-toasts'       => 'conteneur fixe, en bas à droite',
    'xo-badge'        => 'état court ; --solid pour un fond plein',
    'xo-tag'          => 'étiquette ; xo-tag__remove facultatif',
    'data-xo-tip'     => 'infobulle au survol et au focus',
    'xo-empty'        => 'état vide, avec cadre ASCII',
]);
