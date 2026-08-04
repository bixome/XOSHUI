<?php
declare(strict_types=1);
require __DIR__ . '/_nav.php';

$sommaire = [
    ['#pourquoi',  'Pourquoi une grille de caractères'],
    ['#selection', 'La sélection en vidéo inverse'],
    ['#clavier',   'Le clavier d’abord'],
    ['#limites',   'Ce que le style ne sait pas faire'],
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Écrire une interface TUI — XOSHUI</title>
<link rel="stylesheet" href="/libs/css/xoshui.css">
</head>
<body>
<div class="xo-app">

<?php xo_layout_nav('article'); ?>

  <nav class="xo-breadcrumb" aria-label="Fil d’Ariane">
    <span class="xo-breadcrumb__sep" aria-hidden="true">/</span><a href="#">docs</a>
    <span class="xo-breadcrumb__sep" aria-hidden="true">/</span><a href="#">design</a>
    <span class="xo-breadcrumb__sep" aria-hidden="true">/</span><span aria-current="page">interface-tui</span>
  </nav>

  <div class="xo-layout">

    <!-- Sommaire -->
    <nav class="xo-sidebar" aria-label="Sommaire">
      <div class="xo-sidebar__group">Sur cette page</div>
      <?php foreach ($sommaire as $i => [$ancre, $titre]): ?>
      <a class="xo-sidebar__link" href="<?= xo_e($ancre) ?>"<?= $i === 0 ? ' aria-current="page"' : '' ?>>
        <?= xo_e($titre) ?>
      </a>
      <?php endforeach; ?>
      <div class="xo-sidebar__group">Voir aussi</div>
      <a class="xo-sidebar__link" href="/docs/api.md">Aide-mémoire</a>
      <a class="xo-sidebar__link" href="/demo.php">Démo</a>
    </nav>

    <main class="xo-main">
      <article class="xo-prose">

        <h1>Écrire une interface TUI pour le web</h1>

        <p class="xo-muted">
          Publié le 4 août 2026 · Romain Lamboley · 6 min de lecture
        </p>

        <div class="xo-row">
          <span class="xo-tag xo-tag--accent">design</span>
          <span class="xo-tag">css</span>
          <span class="xo-tag">accessibilité</span>
        </div>

        <p>
          Un terminal n’est pas seulement une palette sombre et une police à chasse fixe.
          C’est un ensemble de contraintes qui, prises au sérieux, produisent une interface
          dense et lisible — et qui, prises à moitié, produisent un site sombre déguisé.
        </p>

        <h2 id="pourquoi">Pourquoi une grille de caractères</h2>

        <p>
          En monospace, chaque signe occupe la même largeur. L’unité <code>ch</code> vaut
          exactement cette largeur : une gouttière de <code>1ch</code> correspond donc à une
          colonne du terminal, et les colonnes s’alignent sans effort.
        </p>

        <blockquote>
          Le pixel mesure l’écran ; le caractère mesure le texte. Dans une interface faite
          de texte, la seconde unité est la bonne.
        </blockquote>

        <h2 id="selection">La sélection en vidéo inverse</h2>

        <p>
          Dans un terminal, la ligne sélectionnée s’inverse entièrement — d’un bord à l’autre.
          C’est la différence la plus visible avec une liste web, qui se contente souvent
          d’un fond légèrement teinté ou d’un liseré à gauche.
        </p>

        <ul>
          <li>La sélection va d’un bord à l’autre du panneau, sans marge.</li>
          <li>Le survol utilise un fond discret, jamais l’inversion.</li>
          <li>Sélection et focus sont deux choses distinctes.</li>
        </ul>

        <h2 id="clavier">Le clavier d’abord</h2>

        <p>
          L’ordre habituel s’inverse : le clavier est le mode principal, la souris
          l’accessoire. Trois conséquences pratiques :
        </p>

        <ol>
          <li>Un seul élément tabbable par groupe, les flèches déplacent la sélection.</li>
          <li>Tout raccourci actif est affiché — sinon il n’existe pas.</li>
          <li>Le focus reste visible en permanence.</li>
        </ol>

        <table>
          <thead>
            <tr><th>Touche</th><th>Action</th></tr>
          </thead>
          <tbody>
            <tr><td>↑ ↓</td><td>Déplacer la sélection</td></tr>
            <tr><td>Tab</td><td>Panneau suivant</td></tr>
            <tr><td>Ctrl+K</td><td>Palette de commandes</td></tr>
            <tr><td>?</td><td>Aide</td></tr>
          </tbody>
        </table>

        <h2 id="limites">Ce que le style ne sait pas faire</h2>

        <p>
          Une grille de 80 colonnes réclame environ 640 pixels à 12 px. En dessous, il faut
          renoncer : passer en flux vertical, réduire la barre de raccourcis, empiler les
          volets. Prétendre conserver la grille sur mobile produit une page illisible.
        </p>

        <pre class="xo-pre"><code>@media (max-width: 719px) {
  .xo-split { grid-template-columns: 1fr; }
  .xo-split__handle { display: none; }
}</code></pre>

        <p>
          Le reste — dégradés, ombres, coins arrondis, animations — n’a simplement pas sa
          place. Ce n’est pas une préférence esthétique : aucun de ces effets n’existe dans
          un terminal, et chacun d’eux éloigne le rendu de sa référence.
        </p>

      </article>
    </main>

  </div>

  <footer class="xo-footer">
    <span>XOSHUI 1.0</span>
    <span class="xo-spacer"></span>
    <a href="#">Article précédent</a>
    <a href="#">Article suivant</a>
  </footer>

</div>
<script type="module" src="/libs/js/xoshui.js"></script>
</body>
</html>
