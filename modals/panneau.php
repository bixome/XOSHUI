<?php
declare(strict_types=1);
require __DIR__ . '/../libs/specimen.php';

xo_specimen_debut('panneau', 'Quand le contenu déborde d’une boîte centrée. Toujours une <dialog> — donc Échap, focus piégé et restitué — mais occupant tout l’écran.');

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
    'xo-dialog--full' => 'plein écran, sans bordure',
    'xo-dialog__body' => 'la zone défilante ; borner avec --xo-max-h',
], [
    'Échap' => 'ferme — le seul geste à connaître',
    'Tab'   => 'reste piégé dans le panneau',
]);
