<?php
declare(strict_types=1);

/**
 * Squelette de page — hors du site XOSHUI.
 *
 * Aucune dépendance à libs/site.php : la page n'emprunte que la feuille et le
 * module. C'est le point de départ d'une application qui utilise le framework
 * sans reprendre la navigation de la vitrine.
 *
 * Adapter les deux chemins /libs/… si le framework n'est pas servi à la racine.
 */

/** Échappement de sortie — l'équivalent local de xo_e(). */
function e(string|int|float $v): string
{
    return htmlspecialchars((string) $v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/* ---- Données : à remplacer par les vôtres ------------------------------- */

$titre = 'Titre de la page';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($titre) ?></title>
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="stylesheet" href="/libs/css/xoshui.css">
</head>
<body>
<div class="xo-app">

  <div class="xo-statusbar">
    <strong><?= e($titre) ?></strong>
    <span class="xo-spacer"></span>
    <span class="xo-faint">votre application</span>
  </div>

  <main class="xo-main">

    <section class="xo-panel xo-panel--pad">
      <h1 class="xo-panel__title"><?= e($titre) ?></h1>
      <p class="xo-muted">Le contenu de la page prend place ici.</p>
    </section>

  </main>

  <div class="xo-keys">
    <span><kbd>Tab</kbd> parcourir</span>
    <span class="xo-spacer"></span>
    <span class="xo-faint">votre application</span>
  </div>

</div>
<script type="module" src="/libs/js/xoshui.js"></script>
</body>
</html>
