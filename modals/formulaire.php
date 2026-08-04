<?php
declare(strict_types=1);
require __DIR__ . '/../libs/specimen.php';

xo_specimen_debut('formulaire', 'Quand la saisie dépasse un champ. Au-delà d’une dizaine, la modale n’est plus le bon contenant : une page entière laisse respirer et survit au rechargement.');

xo_specimen('Formulaire court', <<<'HTML'
<button class="xo-btn xo-btn--primary" data-xo-open="#f-court">Nouvelle connexion</button>

<dialog class="xo-dialog" id="f-court" aria-labelledby="f-court-t">
  <form method="dialog">
    <p class="xo-dialog__title" id="f-court-t">Nouvelle connexion</p>

    <div class="xo-field xo-field--inline">
      <label class="xo-label" for="f-c-nom">Nom</label>
      <input class="xo-input" id="f-c-nom" autofocus autocomplete="off">
    </div>
    <div class="xo-field xo-field--inline">
      <label class="xo-label" for="f-c-hote">Hôte</label>
      <input class="xo-input" id="f-c-hote" value="localhost">
    </div>
    <div class="xo-field xo-field--inline">
      <label class="xo-label" for="f-c-port">Port</label>
      <input class="xo-input" id="f-c-port" value="3306">
    </div>
    <label class="xo-check"><input type="checkbox" checked> Forcer TLS</label>

    <div class="xo-dialog__actions">
      <button class="xo-btn" value="annuler">Annuler</button>
      <button class="xo-btn xo-btn--primary" value="ok">Créer</button>
    </div>
  </form>
</dialog>
HTML, 'Les champs en ligne alignent les libellés : dans une boîte étroite, ça vaut mieux que de les empiler au-dessus.');

xo_specimen('Formulaire en erreur', <<<'HTML'
<button class="xo-btn" data-xo-open="#f-err">Afficher avec erreurs</button>

<dialog class="xo-dialog" id="f-err" aria-labelledby="f-err-t">
  <form method="dialog">
    <p class="xo-dialog__title" id="f-err-t">Nouvelle connexion</p>

    <div class="xo-alert xo-alert--danger" role="alert" style="margin-bottom: 8px">
      <span aria-hidden="true">!</span>
      <span class="xo-alert__body">
        <span class="xo-alert__title">Deux champs à corriger.</span>
      </span>
    </div>

    <div class="xo-field xo-field--inline">
      <label class="xo-label" for="f-e-nom">Nom</label>
      <div style="flex: 1">
        <input class="xo-input" id="f-e-nom" aria-invalid="true" aria-describedby="f-e-nom-err" autofocus>
        <span class="xo-error" id="f-e-nom-err">! Obligatoire.</span>
      </div>
    </div>
    <div class="xo-field xo-field--inline">
      <label class="xo-label" for="f-e-port">Port</label>
      <div style="flex: 1">
        <input class="xo-input" id="f-e-port" value="33O6" aria-invalid="true" aria-describedby="f-e-port-err">
        <span class="xo-error" id="f-e-port-err">! Valeur numérique attendue (1–65535).</span>
      </div>
    </div>

    <div class="xo-dialog__actions">
      <button class="xo-btn" value="annuler">Annuler</button>
      <button class="xo-btn xo-btn--primary" value="ok">Créer</button>
    </div>
  </form>
</dialog>
HTML, 'Le résumé en tête donne le nombre, chaque champ porte son message. Le focus va sur le premier champ fautif, pas sur le résumé.');

xo_specimen('Assistant en étapes', <<<'HTML'
<button class="xo-btn" data-xo-open="#f-wiz">Assistant</button>

<dialog class="xo-dialog xo-dialog--wide" id="f-wiz" aria-labelledby="f-wiz-t">
  <p class="xo-dialog__title" id="f-wiz-t">Installation</p>

  <div class="xo-steps" style="margin-bottom: 8px">
    <span class="xo-steps__step xo-steps__step--done">✓ Serveur</span>
    <span class="xo-steps__sep" aria-hidden="true">─►</span>
    <span class="xo-steps__step" aria-current="step">● Base</span>
    <span class="xo-steps__sep" aria-hidden="true">─►</span>
    <span class="xo-steps__step">○ Compte</span>
    <span class="xo-steps__sep" aria-hidden="true">─►</span>
    <span class="xo-steps__step">○ Fin</span>
  </div>

  <div class="xo-dialog__body" style="--xo-max-h: 14em">
    <fieldset class="xo-fieldset">
      <legend>Base de données</legend>
      <div class="xo-field xo-field--inline">
        <label class="xo-label" for="f-w-base">Nom</label>
        <input class="xo-input" id="f-w-base" value="xoshui" autofocus>
      </div>
      <div class="xo-field xo-field--inline">
        <label class="xo-label" for="f-w-jeu">Jeu</label>
        <select class="xo-select" id="f-w-jeu">
          <option>utf8mb4</option><option>utf8</option>
        </select>
      </div>
    </fieldset>
  </div>

  <div class="xo-dialog__actions">
    <button class="xo-btn" data-xo-close>Abandonner</button>
    <span class="xo-spacer"></span>
    <button class="xo-btn">‹ Précédent</button>
    <button class="xo-btn xo-btn--primary">Suivant ›</button>
  </div>
</dialog>
HTML, 'Abandonner à gauche, progression à droite : la sortie ne se trouve pas au milieu des actions d’avancement.');

xo_specimen_fin([
    'xo-dialog--wide'  => 'boîte large, pour un assistant',
    'xo-dialog__body'  => 'la zone qui défile entre titre et actions',
    'xo-field--inline' => 'libellés alignés, plus lisible en boîte étroite',
    'xo-steps'         => 'progression de l’assistant',
], [
    'Tab'    => 'champ suivant',
    'Entrée' => 'soumet',
    'Échap'  => 'abandonne',
]);
