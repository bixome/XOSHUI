<?php
declare(strict_types=1);
require __DIR__ . '/../libs/specimen.php';

xo_specimen_debut('form', 'Les contrôles natifs restent la source de vérité — focus, état coché, soumission. Ils sont simplement masqués, et le label dessine [ ] ou ( ) à leur place.');

xo_specimen('Champs', <<<'HTML'
<div class="xo-field">
  <label class="xo-label" for="d-hote">Hôte</label>
  <input class="xo-input" id="d-hote" value="db.interne">
</div>

<div class="xo-field">
  <label class="xo-label" for="d-mode">Mode</label>
  <select class="xo-select" id="d-mode">
    <option>Développement</option>
    <option>Production</option>
  </select>
</div>

<div class="xo-field">
  <label class="xo-label" for="d-note">Notes</label>
  <textarea class="xo-textarea" id="d-note" placeholder="Optionnel…"></textarea>
  <span class="xo-hint">xo-hint pour un texte d’aide.</span>
</div>
HTML);

xo_specimen('Champ en erreur', <<<'HTML'
<div class="xo-field">
  <label class="xo-label" for="d-port">Port</label>
  <input class="xo-input" id="d-port" value="33O6" aria-invalid="true" aria-describedby="d-port-err">
  <span class="xo-error" id="d-port-err">! Valeur numérique attendue (1–65535).</span>
</div>
HTML, 'aria-invalid porte l’état, aria-describedby relie le message au champ. La couleur seule ne suffirait pas — d’où le préfixe « ! ».');

xo_specimen('Case et radio', <<<'HTML'
<div class="xo-stack xo-stack--tight">
  <label class="xo-check"><input type="checkbox" checked> Forcer TLS</label>
  <label class="xo-check"><input type="checkbox"> Journaliser les requêtes lentes</label>
  <label class="xo-check"><input type="checkbox" disabled> Option indisponible</label>

  <div class="xo-rule">Jeu de caractères</div>
  <label class="xo-radio"><input type="radio" name="d-charset" checked> utf8mb4</label>
  <label class="xo-radio"><input type="radio" name="d-charset"> utf8</label>
  <label class="xo-radio"><input type="radio" name="d-charset"> latin1</label>
</div>
HTML, 'Aucun élément à ajouter : le marqueur est un ::before du label, piloté par :has(input:checked).');

xo_specimen('Curseur et fichier', <<<'HTML'
<div class="xo-range">
  <span class="xo-muted" style="min-width: 16ch">Connexions max</span>
  <input type="range" min="1" max="64" value="16" aria-label="Connexions max">
  <span class="xo-range__value">16</span>
</div>

<div class="xo-file" style="margin-top: 8px">
  <input type="file" aria-label="Fichier de configuration">
</div>
HTML, 'Toujours afficher la valeur d’un curseur à côté : sa position seule n’est pas lisible.');

xo_specimen('Groupe et champ en ligne', <<<'HTML'
<fieldset class="xo-fieldset">
  <legend>Serveur</legend>
  <div class="xo-field xo-field--inline">
    <label class="xo-label" for="d-h2">Hôte</label>
    <input class="xo-input" id="d-h2" value="localhost">
  </div>
  <div class="xo-field xo-field--inline">
    <label class="xo-label" for="d-p2">Port</label>
    <input class="xo-input" id="d-p2" value="3306">
  </div>
</fieldset>
HTML, 'La légende du fieldset s’incruste dans la bordure nativement — contrairement au titre de panneau, qui demande du positionnement.');

xo_specimen_fin([
    'xo-field'          => 'bloc label + champ',
    'xo-field--inline'  => 'label à gauche du champ',
    'xo-label'          => 'libellé',
    'xo-input'          => 'saisie texte',
    'xo-select'         => 'liste déroulante',
    'xo-textarea'       => 'zone de texte',
    'xo-check'          => 'case [ ] / [x]',
    'xo-radio'          => 'radio ( ) / (•)',
    'xo-range'          => 'curseur + valeur',
    'xo-file'           => 'sélecteur de fichier',
    'xo-fieldset'       => 'groupe à légende incrustée',
    'xo-hint'           => 'aide d’un champ',
    'xo-error'          => 'message d’erreur',
], [
    'Tab'    => 'champ suivant',
    'Espace' => 'cocher, décocher',
    'Entrée' => 'soumettre',
]);
