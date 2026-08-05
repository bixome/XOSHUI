<?php
declare(strict_types=1);
require __DIR__ . '/libs/site.php';

/**
 * Le pack de glyphes.
 *
 * XOSHUI n'a pas d'icônes : il a des caractères. Aucun SVG, aucune police
 * d'icônes, aucune requête — mais une contrainte que les images n'ont pas :
 * un glyphe absent de JetBrains Mono est rendu par une police de secours, à
 * une autre chasse, et la ligne sort de la grille.
 *
 * Tous ceux listés ici ont été mesurés : ils tiennent la chasse.
 */

/** groupe => [glyphe => rôle] */
const XO_GLYPHES = [
    'Arborescence' => [
        '▾' => 'nœud ouvert',
        '▸' => 'nœud fermé',
        '├' => 'branche',
        '│' => 'filet vertical',
        '└' => 'dernière branche',
        '─' => 'filet horizontal',
        '┌' => 'coin haut gauche',
        '┐' => 'coin haut droit',
        '┘' => 'coin bas droit',
        '┴' => 'jonction basse',
        '┬' => 'jonction haute',
        '┼' => 'croisement',
    ],
    'États' => [
        '✓' => 'validé, réussi',
        '✗' => 'échoué, refusé',
        '▲' => 'avertissement',
        '●' => 'actif, en cours',
        '○' => 'inactif, à venir',
        '◆' => 'marqueur plein',
        '◇' => 'marqueur vide',
        '■' => 'sélection pleine',
        '□' => 'sélection vide',
        '◉' => 'favori, épinglé',
        '⊙' => 'favori vide',
        '!' => 'erreur, en préfixe',
        '?' => 'inconnu, aide',
    ],
    'Direction' => [
        '←' => 'gauche',
        '↑' => 'haut',
        '→' => 'droite',
        '↓' => 'bas',
        '↔' => 'horizontal',
        '↕' => 'vertical',
        '‹' => 'précédent',
        '›' => 'suivant',
        '«' => 'premier',
        '»' => 'dernier',
        '►' => 'étape suivante',
        '◄' => 'étape précédente',
    ],
    'Mesure' => [
        '█' => 'plein',
        '▉' => '7/8 — curseur',
        '▊' => '3/4',
        '▌' => '1/2',
        '▎' => '1/4',
        '░' => 'vide, trame légère',
        '▒' => 'trame moyenne',
        '▓' => 'trame dense',
        '▁' => 'sparkline 1/8',
        '▃' => 'sparkline 3/8',
        '▅' => 'sparkline 5/8',
        '▇' => 'sparkline 7/8',
    ],
    'Attente' => [
        '▖' => 'rotation 1/4',
        '▘' => 'rotation 2/4',
        '▝' => 'rotation 3/4',
        '▗' => 'rotation 4/4',
    ],
    'Ponctuation' => [
        '·' => 'séparateur discret',
        '•' => 'puce',
        '…' => 'suite, troncature',
        '—' => 'tiret cadratin',
        '–' => 'tiret demi-cadratin',
        '×' => 'fermer, multiplier',
        '±' => 'tolérance',
        '≈' => 'approximation',
        '≠' => 'différent',
        '≤' => 'inférieur ou égal',
        '≥' => 'supérieur ou égal',
        '°' => 'degré',
        '§' => 'section',
        '†' => 'note',
    ],
];

$total = array_sum(array_map('count', XO_GLYPHES));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Icônes — XOSHUI</title>
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="stylesheet" href="/libs/css/xoshui.css">
</head>
<body>
<div class="xo-app">

<?php xo_nav('icones'); ?>

  <main class="xo-main">

    <p class="xo-muted" style="margin-bottom: 16px">
      Pas d’icônes : des caractères. Aucun SVG, aucune police d’icônes, aucune requête —
      mais une contrainte que les images n’ont pas. Un glyphe absent de JetBrains Mono est
      rendu par une police de secours, à une autre chasse, et la ligne sort de la grille.
      Les <?= (int) $total ?> ci-dessous ont été mesurés : ils tiennent la chasse.
    </p>

    <div class="xo-alert" role="status" style="margin-bottom: 16px">
      <span aria-hidden="true">i</span>
      <span class="xo-alert__body">
        <span class="xo-alert__title">Décoratif par défaut.</span>
        Un glyphe qui double un texte porte <code>aria-hidden="true"</code>. S’il porte seul
        l’information, lui donner un <code>aria-label</code> — ou mieux, ajouter le mot.
      </span>
    </div>

    <?php foreach (XO_GLYPHES as $groupe => $glyphes): ?>
    <section class="xo-panel xo-panel--pad" style="margin-bottom: 16px">
      <h2 class="xo-panel__title"><?= xo_e($groupe) ?></h2>
      <div class="xo-grid">
        <?php foreach ($glyphes as $g => $role): ?>
        <div class="xo-col-3 xo-row" style="gap: 2ch">
          <span class="xo-icon xo-accent" aria-hidden="true"><?= xo_e($g) ?></span>
          <span class="xo-muted"><?= xo_e($role) ?></span>
        </div>
        <?php endforeach; ?>
      </div>
      <span class="xo-panel__count"><?= count($glyphes) ?></span>
    </section>
    <?php endforeach; ?>

    <div class="xo-rule xo-rule--start" style="margin: 16px 0">Usage</div>

    <div class="xo-grid">
      <section class="xo-panel xo-panel--pad xo-col-6">
        <h2 class="xo-panel__title">En pratique</h2>
        <pre class="xo-pre"><code>&lt;span class="xo-icon" aria-hidden="true"&gt;▾&lt;/span&gt;

&lt;li class="xo-list__item"&gt;
  &lt;span class="xo-list__icon" aria-hidden="true"&gt;├&lt;/span&gt;
  &lt;span&gt;main&lt;/span&gt;
&lt;/li&gt;

&lt;span class="xo-badge xo-badge--success"&gt;✓ READY&lt;/span&gt;</code></pre>
        <p class="xo-hint" style="margin-top: 8px">
          <code>xo-icon</code> réserve une cellule et centre le glyphe : les colonnes
          restent alignées même quand un item n’a pas d’icône.
        </p>
      </section>

      <section class="xo-panel xo-panel--pad xo-col-6">
        <h2 class="xo-panel__title">Écartés</h2>
        <dl class="xo-kv">
          <?php foreach ([
              '⣾ ⣽ ⣻ (braille)' => 'absents de la police — remplacés par ▖▘▝▗',
              '⎇ (branche)'      => 'absent — remplacé par ├',
              '⌘ ⌥ (touches Mac)'=> 'hors chasse, et hors sujet sur ce clavier',
              'Emoji'            => 'chasse double, couleur imposée, rendu variable',
              '★ ☆ (étoiles)'    => 'hors chasse — remplacées par ◉ et ⊙',
              '♥ ✦ ❖ ⑂ ↳'        => 'hors chasse dans JetBrains Mono',
          ] as $k => $v): ?>
          <div class="xo-kv__row">
            <dt><?= xo_e($k) ?></dt>
            <span class="xo-kv__leader" aria-hidden="true"></span>
            <dd class="xo-muted"><?= xo_e($v) ?></dd>
          </div>
          <?php endforeach; ?>
        </dl>
        <p class="xo-hint" style="margin-top: 8px">
          Avant d’ajouter un glyphe : mesurer sa largeur contre celle de <code>M</code>.
          Si elle diffère, la police ne l’a pas.
        </p>
      </section>
    </div>

  </main>

  <div class="xo-keys">
    <span><kbd>Ctrl+K</kbd> aller à…</span>
    <span><kbd>?</kbd> aide</span>
    <span class="xo-spacer"></span>
    <span class="xo-faint"><?= (int) $total ?> glyphes · <?= count(XO_GLYPHES) ?> groupes</span>
  </div>

</div>
<script type="module" src="/libs/js/xoshui.js"></script>
</body>
</html>
