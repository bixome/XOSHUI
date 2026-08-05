<?php
declare(strict_types=1);

/**
 * Socle des pages de catalogue — composants et modales.
 *
 * Un spécimen se déclare une seule fois, dans un heredoc nowdoc : la même
 * chaîne est affichée telle quelle (rendu) puis échappée (source). Aucune
 * duplication, donc aucun risque que l'exemple montré diverge du rendu.
 *
 *   require __DIR__ . '/_page.php';
 *   xo_compo_debut('panel', 'Le cadre à titre incrusté.');
 *   xo_specimen('Par défaut', <<<'HTML'
 *   <section class="xo-panel">…</section>
 *   HTML);
 *   xo_specimen_fin(['xo-panel' => 'le cadre']);
 */

require_once __DIR__ . '/site.php';

/**
 * Ouvre la page : squelette, navigation, titre.
 * Le libellé et le fil d'Ariane viennent du registre auquel le slug appartient.
 */
function xo_specimen_debut(string $slug, string $intro): void
{
    $section = xo_section($slug);
    $racine  = $section === 'modales' ? '/modals/' : '/components/';
    $libelle = $section === 'modales' ? 'modales' : 'composants';
    [$label] = (XO_COMPOSANTS[$slug] ?? XO_MODALES[$slug] ?? ['Catalogue']);
    ?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= xo_e($label) ?> — XOSHUI</title>
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="stylesheet" href="/libs/css/xoshui.css">
</head>
<body>
<div class="xo-app">

<?php xo_nav($slug); ?>

  <nav class="xo-breadcrumb" aria-label="Fil d’Ariane">
    <span class="xo-breadcrumb__sep" aria-hidden="true">/</span><a href="<?= xo_e($racine) ?>"><?= xo_e($libelle) ?></a>
    <span class="xo-breadcrumb__sep" aria-hidden="true">/</span><span aria-current="page"><?= xo_e($slug) ?></span>
  </nav>

  <main class="xo-main">
    <p class="xo-muted" style="margin-bottom: 16px"><?= xo_e($intro) ?></p>
    <div class="xo-stack">
<?php
}

/**
 * Un spécimen : le rendu, puis sa source repliée.
 *
 * @param string $titre  ce que montre l'exemple
 * @param string $html   le markup, tel qu'il sera copié
 * @param string $note   pourquoi c'est fait ainsi (facultatif)
 * @param bool   $fleur  contenu à fleur de bord (liste, tableau)
 */
function xo_specimen(string $titre, string $html, string $note = '', bool $fleur = false): void
{
    $html = trim($html);
    ?>
      <section class="xo-panel<?= $fleur ? '' : ' xo-panel--pad' ?>">
        <h2 class="xo-panel__title"><?= xo_e($titre) ?></h2>
        <?php if ($note !== ''): ?>
        <p class="xo-hint" style="<?= $fleur ? 'padding: 0 1ch; ' : '' ?>margin-bottom: 8px"><?= xo_e($note) ?></p>
        <?php endif; ?>

        <?= $html ?>

        <details class="xo-accordion" style="margin-top: 8px">
          <summary>Source</summary>
          <div class="xo-accordion__body">
            <pre class="xo-pre"><code><?= xo_e($html) ?></code></pre>
          </div>
        </details>
      </section>
<?php
}

/**
 * Ferme la page : récapitulatif des classes, puis pied.
 *
 * @param array<string,string> $classes classe => rôle
 * @param array<string,string> $clavier touche => action
 */
function xo_specimen_fin(array $classes = [], array $clavier = []): void
{
    ?>
      <?php if ($classes): ?>
      <section class="xo-panel xo-panel--pad">
        <h2 class="xo-panel__title">Classes</h2>
        <dl class="xo-kv">
          <?php foreach ($classes as $classe => $role): ?>
          <div class="xo-kv__row">
            <dt><code><?= xo_e($classe) ?></code></dt>
            <span class="xo-kv__leader" aria-hidden="true"></span>
            <dd class="xo-muted"><?= xo_e($role) ?></dd>
          </div>
          <?php endforeach; ?>
        </dl>
      </section>
      <?php endif; ?>

      <?php if ($clavier): ?>
      <section class="xo-panel xo-panel--pad">
        <h2 class="xo-panel__title">Clavier</h2>
        <dl class="xo-kv">
          <?php foreach ($clavier as $touche => $action): ?>
          <div class="xo-kv__row">
            <dt><kbd><?= xo_e($touche) ?></kbd></dt>
            <span class="xo-kv__leader" aria-hidden="true"></span>
            <dd class="xo-muted"><?= xo_e($action) ?></dd>
          </div>
          <?php endforeach; ?>
        </dl>
      </section>
      <?php endif; ?>
    </div>
  </main>

  <div class="xo-keys">
    <span><kbd>Ctrl+K</kbd> aller à…</span>
    <span><kbd>?</kbd> aide</span>
    <span class="xo-spacer"></span>
    <span class="xo-faint">déplier « Source » pour copier</span>
  </div>

</div>
<script type="module" src="/libs/js/xoshui.js"></script>
</body>
</html>
<?php
}
