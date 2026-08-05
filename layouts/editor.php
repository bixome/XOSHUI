<?php
declare(strict_types=1);
require __DIR__ . '/_nav.php';

/**
 * Éditeur — texte, markdown, brut.
 *
 * L'édition se fait dans une <textarea> : c'est le seul élément qui donne
 * gratuitement le curseur, la sélection, l'annulation et le collage. On ne
 * colore donc pas la saisie — on colore l'aperçu, à côté.
 *
 * C'est le compromis d'un éditeur sans dépendance : colorer la saisie
 * demanderait un contenteditable et de réécrire tout ce que la <textarea>
 * fait déjà, pour un résultat plus fragile.
 */

/* ---- Le document en cours d'édition ------------------------------------ */

$modes = [
    'markdown' => 'Markdown',
    'texte'    => 'Texte',
    'brut'     => 'Brut',
];
$mode = isset($_GET['mode'], $modes[$_GET['mode']]) ? (string) $_GET['mode'] : 'markdown';

$source = <<<'MD'
# Écrire une interface TUI

Un terminal n'est pas seulement une palette sombre et une police à
chasse fixe. C'est un ensemble de **contraintes** qui, prises au
sérieux, produisent une interface dense et lisible.

## La grille de caractères

En monospace, chaque signe occupe la même largeur. L'unité `ch` vaut
exactement cette largeur : une gouttière de `1ch` correspond donc à
une colonne du terminal.

> Le pixel mesure l'écran ; le caractère mesure le texte.

- La sélection va d'un bord à l'autre du panneau.
- Le survol utilise un fond discret, jamais l'inversion.
- Sélection et focus sont deux choses distinctes.

Voir la [charte graphique](/docs.php?f=charte) pour le détail.

```css
.xo-panel {
  border: 1px solid var(--xo-border);
}
```

---

Fin du document.
MD;

$lignes = explode("\n", $source);

/* ---- Coloration de la source ------------------------------------------- */

/**
 * Colore une ligne de markdown.
 *
 * Chaque couleur porte le sens que lui donne la charte : l'accent pour la
 * structure, le teal pour ce qui est littéral, le mauve pour ce qui pointe
 * ailleurs. Aucune couleur n'est décorative.
 *
 * @param bool $dansBloc la ligne est-elle à l'intérieur d'un bloc de code
 */
function xo_colorer(string $ligne, bool $dansBloc): string
{
    $t = xo_e($ligne);

    // Un bloc de code se prend tel quel : rien n'y est interprété.
    if ($dansBloc) {
        return '<span class="xo-info">' . $t . '</span>';
    }

    if (str_starts_with($ligne, '```')) {
        return '<span class="xo-faint">' . $t . '</span>';
    }
    if (preg_match('/^(#{1,6})(\s.*)$/', $ligne, $m)) {
        return '<span class="xo-faint">' . xo_e($m[1]) . '</span>'
             . '<span class="xo-accent xo-bold">' . xo_e($m[2]) . '</span>';
    }
    if (preg_match('/^\s*>/', $ligne)) {
        return '<span class="xo-muted">' . $t . '</span>';
    }
    if (preg_match('/^-{3,}\s*$/', $ligne)) {
        return '<span class="xo-faint">' . $t . '</span>';
    }
    if (preg_match('/^(\s*)([-*]|\d+\.)(\s.*)$/', $ligne, $m)) {
        $t = xo_e($m[1]) . '<span class="xo-alt">' . xo_e($m[2]) . '</span>' . xo_e($m[3]);
    }

    // En ligne : code, gras, liens. L'échappement est déjà fait.
    $t = preg_replace('/`([^`]+)`/', '<span class="xo-info">`$1`</span>', $t) ?? $t;
    $t = preg_replace('/\*\*([^*]+)\*\*/', '<span class="xo-bold">**$1**</span>', $t) ?? $t;
    $t = preg_replace(
        '/\[([^\]]*)\]\(([^)]*)\)/',
        '<span class="xo-special">[$1]</span><span class="xo-faint">($2)</span>',
        $t,
    ) ?? $t;

    return $t;
}

/** Statistiques du document. */
$mots   = str_word_count(strip_tags($source));
$signes = mb_strlen($source);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Éditeur — XOSHUI</title>
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="stylesheet" href="/libs/css/xoshui.css">
</head>
<body>
<div class="xo-app">

<?php xo_layout_nav('editor'); ?>

  <nav class="xo-breadcrumb" aria-label="Chemin">
    <span class="xo-breadcrumb__sep" aria-hidden="true">/</span><a href="#">docs</a>
    <span class="xo-breadcrumb__sep" aria-hidden="true">/</span><a href="#">design</a>
    <span class="xo-breadcrumb__sep" aria-hidden="true">/</span><span aria-current="page">interface-tui.md</span>
  </nav>

  <form method="get" action="">
    <div class="xo-toolbar">
      <div class="xo-btn-group" role="group" aria-label="Mode">
        <?php foreach ($modes as $cle => $libelle): ?>
        <button class="xo-btn" name="mode" value="<?= xo_e($cle) ?>"
                aria-pressed="<?= $cle === $mode ? 'true' : 'false' ?>"><?= xo_e($libelle) ?></button>
        <?php endforeach; ?>
      </div>

      <span class="xo-toolbar__sep" aria-hidden="true"></span>

      <button class="xo-btn xo-btn--primary" type="button">
        <span class="xo-icon" aria-hidden="true">✓</span> Enregistrer
      </button>
      <button class="xo-btn" type="button">Formater</button>

      <details class="xo-dropdown">
        <summary class="xo-btn">Insérer ▾</summary>
        <div class="xo-dropdown__menu" role="menu">
          <button class="xo-dropdown__item" type="button" role="menuitem">
            Titre <span class="xo-dropdown__key">Ctrl+1</span>
          </button>
          <button class="xo-dropdown__item" type="button" role="menuitem">
            Gras <span class="xo-dropdown__key">Ctrl+B</span>
          </button>
          <button class="xo-dropdown__item" type="button" role="menuitem">
            Lien <span class="xo-dropdown__key">Ctrl+L</span>
          </button>
          <div class="xo-dropdown__sep" role="separator"></div>
          <button class="xo-dropdown__item" type="button" role="menuitem">
            Bloc de code <span class="xo-dropdown__key">Ctrl+K</span>
          </button>
        </div>
      </details>

      <span class="xo-spacer"></span>
      <span class="xo-muted xo-nowrap">
        <?= count($lignes) ?> lignes · <?= (int) $mots ?> mots · <?= (int) $signes ?> signes
      </span>
    </div>
  </form>

  <main class="xo-main">
    <div class="xo-split" data-xo-split style="--xo-split: 50%; min-height: 34em">

      <!-- ------------------------------------------------- Saisie -->
      <section class="xo-panel xo-panel--active" style="height: 100%; display: flex; flex-direction: column">
        <h2 class="xo-panel__title">interface-tui.md</h2>

        <div class="xo-editor" style="flex: 1">
          <div class="xo-editor__gutter" aria-hidden="true"><?php
            foreach (array_keys($lignes) as $i) {
                echo str_pad((string) ($i + 1), 3, ' ', STR_PAD_LEFT), "\n";
            }
          ?></div>
          <textarea class="xo-editor__area" aria-label="Contenu du document"
                    spellcheck="false" wrap="off"
                    rows="<?= count($lignes) ?>"><?= xo_e($source) ?></textarea>
        </div>

        <span class="xo-panel__count">modifié</span>
      </section>

      <button class="xo-split__handle" role="separator" aria-orientation="vertical"
              aria-label="Redimensionner" aria-valuenow="50" aria-valuemin="15" aria-valuemax="85"></button>

      <!-- ------------------------------------------------- Aperçu -->
      <section class="xo-panel" style="height: 100%; display: flex; flex-direction: column">
        <h2 class="xo-panel__title">Aperçu — <?= xo_e($modes[$mode]) ?></h2>

        <div class="xo-panel__body" style="flex: 1">
          <?php if ($mode === 'markdown'): ?>
          <!-- Source colorée : la structure prend l'accent, le littéral le
               teal, ce qui pointe ailleurs le mauve. -->
          <div class="xo-editor">
            <div class="xo-editor__gutter" aria-hidden="true"><?php
              foreach (array_keys($lignes) as $i) {
                  echo str_pad((string) ($i + 1), 3, ' ', STR_PAD_LEFT), "\n";
              }
            ?></div>
            <pre class="xo-pre" style="border: 0; background: none; flex: 1; min-width: 0"><?php
              $dansBloc = false;
              foreach ($lignes as $l) {
                  echo xo_colorer($l, $dansBloc), "\n";
                  if (str_starts_with($l, '```')) {
                      $dansBloc = !$dansBloc;
                  }
              }
            ?></pre>
          </div>

          <?php elseif ($mode === 'texte'): ?>
          <!-- Texte : les marques disparaissent, seule la lecture compte.
               Un lien garde son libellé et perd son URL ; un filet n'a plus
               de sens sans mise en forme, il disparaît. -->
          <article class="xo-prose" style="padding: 0 1ch">
            <?php foreach (preg_split('/\n{2,}/', $source) ?: [] as $bloc):
                $bloc = trim($bloc);
                if ($bloc === '' || str_starts_with($bloc, '```')
                    || preg_match('/^-{3,}$/', $bloc)) {
                    continue;
                }
                $nu = preg_replace('/\[([^\]]*)\]\([^)]*\)/', '$1', $bloc) ?? $bloc;
                $nu = preg_replace('/^#{1,6}\s*|^>\s*|^[-*]\s+/m', '', $nu) ?? $nu;
                $nu = str_replace(['**', '`'], '', $nu); ?>
            <p><?= xo_e($nu) ?></p>
            <?php endforeach; ?>
          </article>

          <?php else: ?>
          <!-- Brut : rien n'est interprété, les fins de ligne sont montrées. -->
          <div class="xo-editor">
            <div class="xo-editor__gutter" aria-hidden="true"><?php
              foreach (array_keys($lignes) as $i) {
                  echo str_pad((string) ($i + 1), 3, ' ', STR_PAD_LEFT), "\n";
              }
            ?></div>
            <pre class="xo-pre" style="border: 0; background: none; flex: 1; min-width: 0"><?php
              foreach ($lignes as $l) {
                  echo xo_e($l), '<span class="xo-faint">¶</span>', "\n";
              }
            ?></pre>
          </div>
          <?php endif; ?>
        </div>

        <span class="xo-panel__count"><?= xo_e($modes[$mode]) ?></span>
      </section>

    </div>
  </main>

  <div class="xo-statusbar" style="border-bottom: 0; border-top: 1px solid var(--xo-border)">
    <span class="xo-badge xo-badge--solid xo-badge--info">INSERT</span>
    <span><span class="xo-statusbar__label">ln</span> 14, <span class="xo-statusbar__label">col</span> 22</span>
    <span><span class="xo-statusbar__label">sél</span> 0</span>
    <span class="xo-spacer"></span>
    <span class="xo-muted">UTF-8</span>
    <span class="xo-muted">LF</span>
    <span class="xo-muted">markdown</span>
    <span class="xo-warning">● non enregistré</span>
  </div>

  <div class="xo-keys">
    <span><kbd>Ctrl+S</kbd> enregistrer</span>
    <span><kbd>Ctrl+B</kbd> gras</span>
    <span><kbd>Tab</kbd> indenter</span>
    <span><kbd>←→</kbd> séparateur</span>
    <span class="xo-spacer"></span>
    <span class="xo-faint">interface-tui.md · <?= count($lignes) ?> lignes</span>
  </div>

</div>
<script type="module" src="/libs/js/xoshui.js"></script>
</body>
</html>
