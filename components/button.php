<?php
declare(strict_types=1);
require __DIR__ . '/../libs/specimen.php';

xo_specimen_debut('button', 'Transparent au repos, plein au survol et au focus. C’est l’inverse d’un bouton web classique, et c’est ce qui le rattache au terminal : le remplissage signale l’interaction, pas l’existence.');

xo_specimen('Variantes', <<<'HTML'
<div class="xo-row">
  <button class="xo-btn">Neutre</button>
  <button class="xo-btn xo-btn--primary">Principal</button>
  <button class="xo-btn xo-btn--danger">Destructif</button>
  <button class="xo-btn xo-btn--ghost">Discret</button>
</div>
HTML, 'Une seule action principale par écran. Le destructif se signale par sa couleur, jamais par sa place : il reste à sa position logique.');

xo_specimen('États', <<<'HTML'
<div class="xo-row">
  <button class="xo-btn">Au repos</button>
  <button class="xo-btn" disabled>Désactivé</button>
  <button class="xo-btn" aria-pressed="true">Enfoncé</button>
  <button class="xo-btn" aria-pressed="false">Relâché</button>
</div>
HTML, 'Le survol et le focus passent en vidéo inverse — on ne peut donc pas les distinguer à l’œil. C’est voulu : dans une interface au clavier, le focus est le survol.');

xo_specimen('Avec glyphe', <<<'HTML'
<div class="xo-row">
  <button class="xo-btn"><span aria-hidden="true">✓</span> Valider</button>
  <button class="xo-btn xo-btn--danger"><span aria-hidden="true">✗</span> Supprimer</button>
  <button class="xo-btn"><span aria-hidden="true">▾</span> Déplier</button>
  <button class="xo-btn xo-btn--ghost" aria-label="Fermer"><span aria-hidden="true">×</span></button>
</div>
HTML, 'Le glyphe double le mot, il ne le remplace pas. Seul, il exige un aria-label — et le pack de glyphes, jamais un caractère pris au hasard.');

xo_specimen('Raccourci affiché', <<<'HTML'
<div class="xo-row">
  <button class="xo-btn xo-btn--ghost">[/] filtrer</button>
  <button class="xo-btn xo-btn--ghost">[r] rafraîchir</button>
  <button class="xo-btn"><kbd>Ctrl+K</kbd> aller à…</button>
</div>
HTML, 'La convention du terminal : la touche entre crochets, dans le libellé. Un raccourci qui n’est affiché nulle part n’existe pas.');

xo_specimen('Groupe', <<<'HTML'
<div class="xo-btn-group" role="group" aria-label="Tri">
  <button class="xo-btn" aria-pressed="true">CPU</button>
  <button class="xo-btn" aria-pressed="false">MEM</button>
  <button class="xo-btn" aria-pressed="false">PID</button>
</div>
HTML, 'Les bordures fusionnent : un seul trait entre deux boutons. L’état actif se déclare avec aria-pressed, pas une classe.');

xo_specimen('Pleine largeur', <<<'HTML'
<button class="xo-btn xo-btn--primary" style="width: 100%; justify-content: center">
  Se connecter
</button>
HTML, 'Le bouton est un flex : sans justify-content, son libellé resterait collé à gauche une fois étiré.');

xo_specimen('Lien qui agit comme un bouton', <<<'HTML'
<div class="xo-row">
  <a class="xo-btn" href="/components/">Parcourir les composants</a>
  <a class="xo-btn xo-btn--primary" href="/foundations.php">Voir les fondations</a>
</div>
HTML, 'Ce qui navigue est un lien, ce qui agit est un bouton — même habillage, sémantique différente. Un <a> sans href n’est pas focalisable.');

xo_specimen_fin([
    'xo-btn'          => 'le bouton',
    'xo-btn--primary' => 'action principale, bordure en accent',
    'xo-btn--danger'  => 'action destructive',
    'xo-btn--ghost'   => 'sans bordure, pour une barre',
    'xo-btn-group'    => 'boutons accolés, bordures fusionnées',
    '[disabled]'      => 'inerte, hors du parcours clavier',
    'aria-pressed'    => 'bouton bascule — pas une classe',
    'aria-label'      => 'obligatoire si le bouton n’a qu’un glyphe',
], [
    'Tab'    => 'bouton suivant',
    'Entrée' => 'active',
    'Espace' => 'active aussi',
]);
