<?php
declare(strict_types=1);

/**
 * Squelette de page — dans le site XOSHUI.
 *
 * Copier ce fichier, renommer, remplir <main>. La barre, la sous-barre, la palette
 * Ctrl+K et l'aide « ? » viennent de xo_nav() : rien d'autre à câbler.
 *
 * Pour une page hors du site (une application qui ne fait qu'emprunter la feuille
 * et le module), partir de page-nue.php.
 */

require_once __DIR__ . '/../libs/site.php';

/* ---- Données : à remplacer par les vôtres ------------------------------- */

$titre = 'Titre de la page';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= xo_e($titre) ?> — XOSHUI</title>
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="stylesheet" href="/libs/css/xoshui.css">
</head>
<body>
<div class="xo-app">

<?php xo_nav('accueil'); /* le slug de la section : voir XO_PAGES dans libs/site.php */ ?>

  <main class="xo-main">

    <section class="xo-panel xo-panel--pad">
      <h1 class="xo-panel__title"><?= xo_e($titre) ?></h1>
      <p class="xo-muted">Le contenu de la page prend place ici.</p>
    </section>

  </main>

  <div class="xo-keys">
    <span><kbd>Tab</kbd> parcourir</span>
    <span><kbd>Ctrl+K</kbd> commandes</span>
    <span><kbd>?</kbd> aide</span>
    <span class="xo-spacer"></span>
    <span class="xo-faint">xoshui.test</span>
  </div>

</div>
<script type="module" src="/libs/js/xoshui.js"></script>
</body>
</html>
