<?php
declare(strict_types=1);
require __DIR__ . '/../libs/specimen.php';

xo_specimen_debut('prompt', 'Demander une valeur. Le champ prend le focus à l’ouverture, Entrée valide, Échap abandonne — c’est ce qu’attend quiconque a déjà utilisé un terminal.');

xo_specimen('Saisie simple', <<<'HTML'
<button class="xo-btn" data-xo-open="#p-text">Renommer</button>

<dialog class="xo-dialog xo-dialog--narrow" id="p-text" aria-labelledby="p-text-t">
  <form method="dialog">
    <p class="xo-dialog__title" id="p-text-t">Renommer la branche</p>
    <div class="xo-field">
      <label class="xo-label" for="p-text-in">Nouveau nom</label>
      <input class="xo-input" id="p-text-in" value="feat/tokens" autofocus autocomplete="off">
      <span class="xo-hint">Lettres, chiffres, tirets et barres obliques.</span>
    </div>
    <div class="xo-dialog__actions">
      <button class="xo-btn" value="annuler">Annuler</button>
      <button class="xo-btn xo-btn--primary" value="ok">Renommer</button>
    </div>
  </form>
</dialog>
HTML, 'method="dialog" ferme la boîte à la soumission et expose le bouton choisi dans returnValue — aucun JavaScript à écrire.');

xo_specimen('Mot de passe', <<<'HTML'
<button class="xo-btn" data-xo-open="#p-pass">Déverrouiller</button>

<dialog class="xo-dialog xo-dialog--narrow" id="p-pass" aria-labelledby="p-pass-t">
  <form method="dialog">
    <p class="xo-dialog__title" id="p-pass-t">Authentification requise</p>
    <p class="xo-muted">L’opération demande une élévation de privilèges.</p>
    <div class="xo-field" style="margin-top: 8px">
      <label class="xo-label" for="p-pass-in">Mot de passe</label>
      <input class="xo-input" id="p-pass-in" type="password" autocomplete="current-password" autofocus>
    </div>
    <label class="xo-check"><input type="checkbox"> Retenir 15 minutes</label>
    <div class="xo-dialog__actions">
      <button class="xo-btn" value="annuler">Annuler</button>
      <button class="xo-btn xo-btn--primary" value="ok">Déverrouiller</button>
    </div>
  </form>
</dialog>
HTML);

xo_specimen('Choix dans une liste', <<<'HTML'
<button class="xo-btn" data-xo-open="#p-list">Changer de branche</button>

<dialog class="xo-dialog" id="p-list" aria-labelledby="p-list-t">
  <p class="xo-dialog__title" id="p-list-t">Basculer sur…</p>
  <div class="xo-dialog__body" style="--xo-max-h: 12em">
    <ul class="xo-list" data-xo-list role="listbox" aria-label="Branches">
      <li class="xo-list__item" role="option" aria-selected="true" data-value="main">
        <span class="xo-list__icon" aria-hidden="true">├</span><span>main</span>
        <span class="xo-list__meta xo-success">à jour</span>
      </li>
      <li class="xo-list__item" role="option" data-value="feat/tokens">
        <span class="xo-list__icon" aria-hidden="true">├</span><span>feat/tokens</span>
        <span class="xo-list__meta">1d</span>
      </li>
      <li class="xo-list__item" role="option" data-value="fix/contrast">
        <span class="xo-list__icon" aria-hidden="true">├</span><span>fix/contrast</span>
        <span class="xo-list__meta">1w</span>
      </li>
    </ul>
  </div>
  <div class="xo-dialog__actions">
    <button class="xo-btn" data-xo-close>Annuler</button>
    <button class="xo-btn xo-btn--primary" data-xo-close>Basculer</button>
  </div>
</dialog>
HTML, 'La liste garde sa mécanique : flèches, Début, Fin. Le corps défile, jamais la boîte — sinon titre et actions disparaîtraient.');

xo_specimen('Choix multiple', <<<'HTML'
<button class="xo-btn" data-xo-open="#p-multi">Choisir les sources</button>

<dialog class="xo-dialog xo-dialog--narrow" id="p-multi" aria-labelledby="p-multi-t">
  <form method="dialog">
    <p class="xo-dialog__title" id="p-multi-t">Sources à suivre</p>
    <fieldset class="xo-fieldset">
      <legend>Services</legend>
      <div class="xo-stack xo-stack--tight">
        <label class="xo-check"><input type="checkbox" checked> app</label>
        <label class="xo-check"><input type="checkbox" checked> nginx</label>
        <label class="xo-check"><input type="checkbox"> mysql</label>
        <label class="xo-check"><input type="checkbox" checked> redis</label>
      </div>
    </fieldset>
    <div class="xo-dialog__actions">
      <button class="xo-btn" value="annuler">Annuler</button>
      <button class="xo-btn xo-btn--primary" value="ok" autofocus>Appliquer</button>
    </div>
  </form>
</dialog>
HTML);

xo_specimen('Invite de commande', <<<'HTML'
<button class="xo-btn xo-btn--primary" data-xo-open="#p-cmd">Exécuter…</button>

<dialog class="xo-dialog xo-dialog--wide" id="p-cmd" aria-label="Exécuter une commande">
  <form method="dialog">
    <label class="xo-prompt" style="padding: 0 1ch">
      <span class="xo-prompt__sign" aria-hidden="true">$</span>
      <input type="text" placeholder="git status" aria-label="Commande" autofocus autocomplete="off">
    </label>
    <div class="xo-keys" style="border-top: 1px solid var(--xo-border); border-bottom: 0">
      <span><kbd>Entrée</kbd> exécuter</span>
      <span><kbd>Échap</kbd> abandonner</span>
      <span class="xo-spacer"></span>
      <span class="xo-faint">exécutée dans /var/www</span>
    </div>
  </form>
</dialog>
HTML, 'Sans titre ni boutons : la boîte se réduit à la ligne de commande et à son rappel de touches.');

xo_specimen_fin([
    'method="dialog"'   => 'ferme la boîte et renseigne returnValue, sans JS',
    'autofocus'         => 'le champ prend le focus à l’ouverture',
    'xo-dialog__body'   => 'zone défilante ; --xo-max-h pour la borner',
    'autocomplete="off"'=> 'sur un champ de saisie ponctuel',
], [
    'Entrée' => 'valide le formulaire',
    'Échap'  => 'abandonne sans valider',
    '↑ ↓'    => 'parcourt une liste de choix',
]);
