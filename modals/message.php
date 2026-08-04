<?php
declare(strict_types=1);
require __DIR__ . '/../libs/specimen.php';

xo_specimen_debut('message', 'Une boîte qui informe et n’attend qu’un acquittement. Si l’utilisateur n’a rien à décider, une notification suffit souvent — la modale interrompt, il faut que ça se justifie.');

xo_specimen('Information', <<<'HTML'
<button class="xo-btn" data-xo-open="#m-info">Afficher</button>

<dialog class="xo-dialog xo-dialog--narrow" id="m-info" aria-labelledby="m-info-t">
  <p class="xo-dialog__title" id="m-info-t">Cache vidé</p>
  <p>2 310 entrées supprimées. Les prochaines requêtes seront plus lentes le temps
  que le cache se reconstitue.</p>
  <div class="xo-dialog__actions">
    <button class="xo-btn xo-btn--primary" data-xo-close autofocus>Fermer</button>
  </div>
</dialog>
HTML, 'aria-labelledby relie la boîte à son titre : sans lui, un lecteur d’écran annonce « dialogue » sans dire lequel.');

xo_specimen('Succès', <<<'HTML'
<button class="xo-btn" data-xo-open="#m-ok">Afficher</button>

<dialog class="xo-dialog xo-dialog--success xo-dialog--narrow" id="m-ok" aria-labelledby="m-ok-t">
  <p class="xo-dialog__title" id="m-ok-t">✓ Déploiement terminé</p>
  <p>La version 1.4.2 est en ligne depuis 3 secondes.</p>
  <dl class="xo-kv" style="margin-top: 8px">
    <div class="xo-kv__row">
      <dt>Durée</dt><span class="xo-kv__leader" aria-hidden="true"></span><dd>1 min 12 s</dd>
    </div>
    <div class="xo-kv__row">
      <dt>Fichiers</dt><span class="xo-kv__leader" aria-hidden="true"></span><dd>128</dd>
    </div>
  </dl>
  <div class="xo-dialog__actions">
    <button class="xo-btn" data-xo-close>Fermer</button>
    <button class="xo-btn xo-btn--primary" data-xo-close autofocus>Voir le site</button>
  </div>
</dialog>
HTML, 'La sévérité colore le titre et la bordure. Jamais le fond : un aplat rend le texte pénible.');

xo_specimen('Avertissement', <<<'HTML'
<button class="xo-btn" data-xo-open="#m-warn">Afficher</button>

<dialog class="xo-dialog xo-dialog--warning xo-dialog--narrow" id="m-warn" aria-labelledby="m-warn-t">
  <p class="xo-dialog__title" id="m-warn-t">▲ Espace disque faible</p>
  <p>Il reste 6 % sur <code>/var</code>. Les journaux seront tronqués sous 2 %.</p>
  <div class="xo-progress xo-progress--danger" style="margin-top: 8px">
    <div class="xo-progress__track" role="meter" aria-valuenow="94" aria-valuemin="0" aria-valuemax="100" aria-label="Disque">
      <div class="xo-progress__fill" style="width: 94%"></div>
    </div>
    <span class="xo-progress__value">94%</span>
  </div>
  <div class="xo-dialog__actions">
    <button class="xo-btn" data-xo-close autofocus>Plus tard</button>
    <button class="xo-btn xo-btn--primary" data-xo-close>Purger</button>
  </div>
</dialog>
HTML);

xo_specimen('Erreur avec détails', <<<'HTML'
<button class="xo-btn xo-btn--danger" data-xo-open="#m-err">Afficher</button>

<dialog class="xo-dialog xo-dialog--danger" id="m-err" aria-labelledby="m-err-t">
  <p class="xo-dialog__title" id="m-err-t">✗ Échec de la connexion</p>
  <p>La base <code>db.interne:3306</code> n’a pas répondu en 30 secondes.</p>

  <div class="xo-alert xo-alert--warning" role="status" style="margin-top: 8px">
    <span aria-hidden="true">▲</span>
    <span class="xo-alert__body">Les sessions basculent sur le disque en attendant.</span>
  </div>

  <details class="xo-accordion" style="margin-top: 8px">
    <summary>Détails techniques</summary>
    <div class="xo-accordion__body">
      <pre class="xo-pre"><code>PDOException: SQLSTATE[HY000] [2002] Connection timed out
  #0 /libs/core/Db.php(24): PDO-&gt;__construct()
  #1 /libs/core/Db.php(41): Db::get()
  #2 /api/orders.php(8): Db::all()</code></pre>
    </div>
  </details>

  <div class="xo-dialog__actions">
    <button class="xo-btn" data-xo-close autofocus>Fermer</button>
    <button class="xo-btn xo-btn--danger" data-xo-close>Réessayer</button>
  </div>
</dialog>
HTML, 'La trace est repliée : visible pour qui la cherche, invisible pour les autres. Ne jamais l’afficher en production sans filtrage.');

xo_specimen_fin([
    'xo-dialog--narrow'  => 'boîte étroite, pour un message court',
    'xo-dialog--wide'    => 'boîte large, pour un tableau ou du code',
    'xo-dialog--success' => 'titre et bordure en vert',
    'xo-dialog--warning' => 'titre et bordure en jaune',
    'xo-dialog--danger'  => 'titre et bordure en rouge',
    'aria-labelledby'    => 'relie la boîte à son titre — à ne pas oublier',
    'autofocus'          => 'le bouton qui reçoit le focus à l’ouverture',
], [
    'Échap' => 'ferme — équivaut toujours à annuler',
    'Tab'   => 'circule dans la boîte, jamais en dehors',
]);
