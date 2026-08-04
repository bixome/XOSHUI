<?php
declare(strict_types=1);
require __DIR__ . '/../libs/specimen.php';

xo_specimen_debut('confirm', 'Demander avant d’agir. Trois niveaux de friction selon ce qu’on risque : la question simple, la confirmation destructive dont le focus part sur Annuler, et la garde de saisie qu’aucun réflexe ne franchit.');

xo_specimen('Question simple', <<<'HTML'
<button class="xo-btn" data-xo-open="#c-simple">Quitter</button>

<dialog class="xo-dialog xo-dialog--narrow" id="c-simple" aria-labelledby="c-simple-t">
  <p class="xo-dialog__title" id="c-simple-t">Quitter sans enregistrer ?</p>
  <p>Trois modifications ne sont pas enregistrées.</p>
  <div class="xo-dialog__actions">
    <button class="xo-btn" data-xo-close autofocus>Rester</button>
    <button class="xo-btn xo-btn--primary" data-xo-close>Quitter</button>
  </div>
</dialog>
HTML, 'Des verbes sur les boutons, jamais « OK » et « Annuler » : on doit pouvoir répondre sans relire la question.');

xo_specimen('Confirmation destructive', <<<'HTML'
<button class="xo-btn xo-btn--danger" data-xo-open="#c-danger">Supprimer la branche</button>

<dialog class="xo-dialog xo-dialog--danger xo-dialog--narrow" id="c-danger" aria-labelledby="c-danger-t">
  <p class="xo-dialog__title" id="c-danger-t">Supprimer feat/tokens ?</p>
  <p>12 commits non fusionnés seront perdus. Cette action est définitive.</p>
  <div class="xo-dialog__actions">
    <button class="xo-btn" data-xo-close autofocus>Annuler</button>
    <button class="xo-btn xo-btn--danger" data-xo-close>Supprimer</button>
  </div>
</dialog>
HTML, 'Le focus va sur Annuler : une frappe réflexe sur Entrée ne doit jamais détruire. Et Échap fait la même chose que le bouton de retrait.');

xo_specimen('Garde de saisie', <<<'HTML'
<button class="xo-btn xo-btn--danger" data-xo-open="#c-guard">Supprimer le dépôt</button>

<dialog class="xo-dialog xo-dialog--danger" id="c-guard" aria-labelledby="c-guard-t">
  <p class="xo-dialog__title" id="c-guard-t">Supprimer XOSHUI ?</p>
  <p>Le dépôt, son historique et ses 42 tickets seront détruits. Rien ne pourra
  être restauré.</p>

  <div class="xo-field" style="margin-top: 8px">
    <label class="xo-label" for="c-guard-in">Saisir <code>XOSHUI</code> pour confirmer</label>
    <input class="xo-input" id="c-guard-in" data-xo-guard="XOSHUI" autocomplete="off">
  </div>

  <div class="xo-dialog__actions">
    <button class="xo-btn" data-xo-close autofocus>Annuler</button>
    <button class="xo-btn xo-btn--danger" data-xo-guard-ok data-xo-close>Supprimer</button>
  </div>
</dialog>
HTML, 'Le bouton reste inerte tant que le texte n’est pas recopié — la friction est proportionnelle à ce qu’on perd.');

xo_specimen('Confirmation au clavier', <<<'HTML'
<button class="xo-btn" data-xo-open="#c-keys">Écraser le fichier</button>

<dialog class="xo-dialog xo-dialog--warning xo-dialog--narrow" id="c-keys" aria-labelledby="c-keys-t">
  <p class="xo-dialog__title" id="c-keys-t">Le fichier existe déjà</p>
  <p><code>export-2026-08.csv</code> sera écrasé.</p>
  <div class="xo-dialog__keys" style="margin-top: 8px">
    <span><kbd>O</kbd> écraser</span>
    <span><kbd>R</kbd> renommer</span>
    <span><kbd>N</kbd> annuler</span>
  </div>
  <div class="xo-dialog__actions">
    <button class="xo-btn" data-xo-key="n" data-xo-close autofocus>Annuler</button>
    <button class="xo-btn" data-xo-key="r" data-xo-close>Renommer</button>
    <button class="xo-btn xo-btn--primary" data-xo-key="o" data-xo-close>Écraser</button>
  </div>
</dialog>
HTML, 'data-xo-key rend la touche équivalente au bouton, comme dans une confirmation en mode texte. Les touches restent inertes pendant une saisie, sinon on ne pourrait plus taper la lettre.');

xo_specimen_fin([
    'data-xo-guard'    => 'texte à recopier ; posé sur le champ',
    'data-xo-guard-ok' => 'bouton libéré quand la saisie correspond',
    'data-xo-key'      => 'touche qui active ce bouton, dans la boîte ouverte',
    'xo-dialog__keys'  => 'rappel visuel des touches disponibles',
], [
    'O R N'  => 'répondre sans la souris',
    'Entrée' => 'active le bouton focalisé — jamais le destructif',
    'Échap'  => 'annule',
]);
