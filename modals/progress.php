<?php
declare(strict_types=1);
require __DIR__ . '/../libs/specimen.php';

xo_specimen_debut('progress', 'Rendre compte d’une tâche longue. Règle : ce qui peut être annulé propose un bouton d’annulation ; ce qui ne peut pas l’être ne doit pas faire semblant.');

xo_specimen('Progression annulable', <<<'HTML'
<button class="xo-btn xo-btn--primary" data-xo-open="#g-run">Exporter</button>

<dialog class="xo-dialog" id="g-run" aria-labelledby="g-run-t">
  <p class="xo-dialog__title" id="g-run-t">Export en cours</p>

  <div class="xo-progress" style="margin-bottom: 8px">
    <div class="xo-progress__track" role="progressbar"
         aria-valuenow="64" aria-valuemin="0" aria-valuemax="100" aria-label="Export">
      <div class="xo-progress__fill" style="width: 64%"></div>
    </div>
    <span class="xo-progress__value">64%</span>
  </div>

  <dl class="xo-kv">
    <div class="xo-kv__row">
      <dt>Lignes</dt><span class="xo-kv__leader" aria-hidden="true"></span><dd>32 000 / 50 000</dd>
    </div>
    <div class="xo-kv__row">
      <dt>Restant</dt><span class="xo-kv__leader" aria-hidden="true"></span><dd>environ 40 s</dd>
    </div>
  </dl>

  <div class="xo-dialog__actions">
    <button class="xo-btn xo-btn--danger" data-xo-close>Annuler l’export</button>
  </div>
</dialog>
HTML, 'Toujours donner une unité en plus du pourcentage : « 64 % » seul ne dit pas si l’attente se compte en secondes ou en heures.');

xo_specimen('Attente indéterminée', <<<'HTML'
<button class="xo-btn" data-xo-open="#g-wait">Connexion…</button>

<dialog class="xo-dialog xo-dialog--narrow" id="g-wait" aria-labelledby="g-wait-t">
  <p class="xo-dialog__title" id="g-wait-t">Connexion au serveur</p>
  <div class="xo-row">
    <span class="xo-spinner" aria-hidden="true"></span>
    <span class="xo-muted">Négociation TLS…</span>
  </div>
  <div class="xo-dialog__actions">
    <button class="xo-btn" data-xo-close autofocus>Annuler</button>
  </div>
</dialog>
HTML, 'Quand la durée est inconnue, l’indicateur tourne sans jamais afficher de pourcentage inventé. Le spinner se fige sous prefers-reduced-motion.');

xo_specimen('Tâches multiples', <<<'HTML'
<button class="xo-btn" data-xo-open="#g-multi">Déployer</button>

<dialog class="xo-dialog" id="g-multi" aria-labelledby="g-multi-t">
  <p class="xo-dialog__title" id="g-multi-t">Déploiement 1.4.2</p>

  <div class="xo-stack xo-stack--tight">
    <div class="xo-progress xo-progress--success">
      <span class="xo-progress__label">Build</span>
      <div class="xo-progress__track" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" aria-label="Build">
        <div class="xo-progress__fill" style="width: 100%"></div>
      </div>
      <span class="xo-progress__value">✓</span>
    </div>
    <div class="xo-progress">
      <span class="xo-progress__label">Envoi</span>
      <div class="xo-progress__track" role="progressbar" aria-valuenow="41" aria-valuemin="0" aria-valuemax="100" aria-label="Envoi">
        <div class="xo-progress__fill" style="width: 41%"></div>
      </div>
      <span class="xo-progress__value">41%</span>
    </div>
    <div class="xo-progress">
      <span class="xo-progress__label xo-faint">Migration</span>
      <div class="xo-progress__track" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" aria-label="Migration">
        <div class="xo-progress__fill" style="width: 0%"></div>
      </div>
      <span class="xo-progress__value xo-faint">—</span>
    </div>
  </div>

  <div class="xo-dialog__body" style="--xo-max-h: 8em; margin-top: 8px">
    <div class="xo-log">
      <div class="xo-log__line xo-log__line--ok">
        <span class="xo-log__time">09:14:02</span><span class="xo-log__level">ok</span>
        <span class="xo-log__msg">build terminé en 34 s</span>
      </div>
      <div class="xo-log__line xo-log__line--info">
        <span class="xo-log__time">09:14:03</span><span class="xo-log__level">info</span>
        <span class="xo-log__msg">envoi de 128 fichiers…</span>
      </div>
    </div>
  </div>

  <div class="xo-dialog__actions">
    <button class="xo-btn xo-btn--danger" data-xo-close>Interrompre</button>
  </div>
</dialog>
HTML, 'Les étapes à venir restent visibles mais éteintes : on sait ce qui reste, sans confondre avec ce qui tourne.');

xo_specimen('Résultat', <<<'HTML'
<button class="xo-btn" data-xo-open="#g-done">Voir le résultat</button>

<dialog class="xo-dialog xo-dialog--warning" id="g-done" aria-labelledby="g-done-t">
  <p class="xo-dialog__title" id="g-done-t">▲ Terminé avec avertissements</p>
  <dl class="xo-kv">
    <div class="xo-kv__row">
      <dt>Traitées</dt><span class="xo-kv__leader" aria-hidden="true"></span><dd>50 000</dd>
    </div>
    <div class="xo-kv__row">
      <dt>Ignorées</dt><span class="xo-kv__leader" aria-hidden="true"></span>
      <dd class="xo-warning">37</dd>
    </div>
    <div class="xo-kv__row">
      <dt>Durée</dt><span class="xo-kv__leader" aria-hidden="true"></span><dd>2 min 08 s</dd>
    </div>
  </dl>
  <div class="xo-dialog__actions">
    <button class="xo-btn" data-xo-close>Fermer</button>
    <button class="xo-btn xo-btn--primary" data-xo-close autofocus>Voir les 37 lignes</button>
  </div>
</dialog>
HTML, 'Une fin partielle n’est ni un succès ni un échec : le compte des anomalies mène à leur détail.');

xo_specimen_fin([
    'role="progressbar"' => 'tâche qui avance',
    'role="meter"'       => 'mesure instantanée — ce n’est pas la même chose',
    'xo-spinner'         => 'durée inconnue, aucun pourcentage inventé',
    'xo-progress__label' => 'nom de l’étape, largeur fixe',
], [
    'Échap' => 'à ne laisser fermer que si la tâche est annulable',
]);
