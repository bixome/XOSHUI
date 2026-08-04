<?php
declare(strict_types=1);
require __DIR__ . '/../libs/specimen.php';

xo_specimen_debut('panneau', 'Quand le contenu déborde d’une boîte centrée. Toujours une <dialog> — donc Échap, focus piégé et restitué — mais collée à un bord ou occupant l’écran.');

xo_specimen('Tiroir latéral', <<<'HTML'
<button class="xo-btn" data-xo-open="#t-droite">Détails du ticket</button>

<dialog class="xo-dialog xo-dialog--drawer" id="t-droite" aria-labelledby="t-droite-t">
  <p class="xo-dialog__title" id="t-droite-t">#412</p>

  <div class="xo-dialog__body" style="--xo-max-h: calc(100vh - 8em)">
    <div class="xo-row" style="margin-bottom: 8px">
      <span class="xo-badge xo-badge--solid xo-badge--danger">ouvert</span>
      <span class="xo-tag">api</span>
      <span class="xo-tag xo-tag--warning">régression</span>
    </div>

    <dl class="xo-kv">
      <div class="xo-kv__row">
        <dt>Signalé par</dt><span class="xo-kv__leader" aria-hidden="true"></span><dd>romain</dd>
      </div>
      <div class="xo-kv__row">
        <dt>Assigné à</dt><span class="xo-kv__leader" aria-hidden="true"></span><dd>équipe API</dd>
      </div>
      <div class="xo-kv__row">
        <dt>Priorité</dt><span class="xo-kv__leader" aria-hidden="true"></span><dd>haute</dd>
      </div>
    </dl>

    <div class="xo-rule xo-rule--start" style="margin-top: 8px">Description</div>
    <p class="xo-muted" style="margin-top: 8px">L’export dépasse 30 s au-delà de
    50 000 lignes. Le pool de connexions sature et la requête est interrompue.</p>
  </div>

  <div class="xo-dialog__actions">
    <button class="xo-btn" data-xo-close>Fermer</button>
    <button class="xo-btn xo-btn--primary" data-xo-close>Prendre en charge</button>
  </div>
</dialog>
HTML, 'Les marges automatiques d’une <dialog> la centrent : il faut en neutraliser une pour la coller à un bord. --drawer-left pour l’autre côté.');

xo_specimen('Tiroir à gauche', <<<'HTML'
<button class="xo-btn" data-xo-open="#t-gauche">Ouvrir le menu</button>

<dialog class="xo-dialog xo-dialog--drawer xo-dialog--drawer-left" id="t-gauche" aria-label="Sections">
  <nav class="xo-sidebar" style="border: 0; width: auto">
    <div class="xo-sidebar__group">Projet</div>
    <a class="xo-sidebar__link" href="#" aria-current="page">Vue d’ensemble</a>
    <a class="xo-sidebar__link" href="#">Fichiers</a>
    <a class="xo-sidebar__link" href="#">Historique</a>
    <div class="xo-sidebar__group">Réglages</div>
    <a class="xo-sidebar__link" href="#">Général</a>
    <a class="xo-sidebar__link" href="#">Accès</a>
  </nav>
  <div class="xo-dialog__actions">
    <button class="xo-btn" data-xo-close autofocus>Fermer</button>
  </div>
</dialog>
HTML, 'Utile en dessous de 720 px, là où la colonne latérale prendrait tout l’écran.');

xo_specimen('Plein écran', <<<'HTML'
<button class="xo-btn" data-xo-open="#t-full">Comparer les versions</button>

<dialog class="xo-dialog xo-dialog--full" id="t-full" aria-labelledby="t-full-t">
  <div class="xo-statusbar">
    <strong id="t-full-t">xoshui.css</strong>
    <span class="xo-muted">1.4.1 → 1.4.2</span>
    <span class="xo-spacer"></span>
    <button class="xo-btn xo-btn--ghost" data-xo-close autofocus>[Échap] fermer</button>
  </div>

  <div class="xo-dialog__body" style="--xo-max-h: calc(100vh - 6em); padding: 8px 1ch">
    <div class="xo-diff">
      <div class="xo-diff__line"><span class="xo-diff__num">12</span><span>.xo-panel {</span></div>
      <div class="xo-diff__line xo-diff__line--del"><span class="xo-diff__num">13</span><span>-  padding: 8px 1ch;</span></div>
      <div class="xo-diff__line xo-diff__line--add"><span class="xo-diff__num">13</span><span>+  padding: calc(var(--xo-pad) + 2px) 0 var(--xo-pad);</span></div>
      <div class="xo-diff__line"><span class="xo-diff__num">14</span><span>  min-width: 0;</span></div>
      <div class="xo-diff__line"><span class="xo-diff__num">15</span><span>}</span></div>
    </div>
  </div>
</dialog>
HTML, 'Pour comparer, lire un journal complet ou éditer : tout ce qui réclame la largeur. La sortie est rappelée en toutes lettres dans la barre.');

xo_specimen_fin([
    'xo-dialog--drawer'      => 'tiroir collé à droite, pleine hauteur',
    'xo-dialog--drawer-left' => 'le même, à gauche',
    'xo-dialog--full'        => 'plein écran, sans bordure',
    'xo-dialog__body'        => 'la zone défilante ; borner avec --xo-max-h',
], [
    'Échap' => 'ferme — le seul geste à connaître',
    'Tab'   => 'reste piégé dans le panneau',
]);
