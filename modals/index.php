<?php
declare(strict_types=1);
require __DIR__ . '/../libs/site.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Modales — XOSHUI</title>
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="stylesheet" href="/libs/css/xoshui.css">
</head>
<body>
<div class="xo-app">

<?php xo_nav('modales'); ?>

  <main class="xo-main">

    <div class="xo-banner" style="margin-bottom: 16px">
      <pre class="xo-banner__art">┌─ M O D A L E S ─┐</pre>
      <p class="xo-banner__tagline">
        Toutes bâties sur <code>&lt;dialog&gt;</code> : Échap ferme, le focus est piégé
        puis restitué. Aucune ne réimplémente ce que le navigateur fait déjà.
      </p>
    </div>

    <div class="xo-grid">
      <?php foreach (XO_MODALES as $slug => [$label, $desc]):
          if ($slug === 'index') { continue; } ?>
      <section class="xo-panel xo-panel--pad xo-col-4"
               style="display: flex; flex-direction: column; gap: 8px">
        <h2 class="xo-panel__title"><?= xo_e($label) ?></h2>
        <p class="xo-muted"><?= xo_e($desc) ?></p>
        <p class="xo-faint xo-nowrap" style="overflow: hidden; text-overflow: ellipsis">
          modals/<?= xo_e($slug) ?>.php
        </p>
        <a class="xo-btn xo-btn--primary" href="<?= xo_e($slug) ?>.php"
           style="margin-top: auto; align-self: flex-start">Ouvrir</a>
      </section>
      <?php endforeach; ?>
    </div>

    <div class="xo-rule xo-rule--start" style="margin: 16px 0">Choisir la bonne boîte</div>

    <div class="xo-grid">
      <section class="xo-panel xo-panel--pad xo-col-6">
        <h2 class="xo-panel__title">Règles</h2>
        <dl class="xo-kv">
          <?php foreach ([
              'Interrompre'  => 'seulement si la suite dépend de la réponse',
              'Sinon'        => 'une notification (xo-toast) suffit',
              'Titre'        => 'une question ou un constat, jamais « Attention »',
              'Boutons'      => 'des verbes : « Supprimer », pas « OK »',
              'Ordre'        => 'action principale à droite, retrait à gauche',
              'Destructif'   => 'le focus va sur Annuler, pas sur Supprimer',
              'Échap'        => 'doit toujours équivaloir à annuler',
          ] as $k => $v): ?>
          <div class="xo-kv__row">
            <dt><?= xo_e($k) ?></dt>
            <span class="xo-kv__leader" aria-hidden="true"></span>
            <dd class="xo-muted"><?= xo_e($v) ?></dd>
          </div>
          <?php endforeach; ?>
        </dl>
      </section>

      <section class="xo-panel xo-panel--pad xo-col-6">
        <h2 class="xo-panel__title">Hooks</h2>
        <dl class="xo-kv">
          <?php foreach ([
              'data-xo-open="#id"' => 'ouvre la boîte ciblée',
              'data-xo-close'      => 'ferme la boîte parente',
              'data-xo-key="y"'    => 'la touche active ce bouton',
              'data-xo-guard'      => 'exige la recopie d’un texte',
              'data-xo-guard-ok'   => 'bouton libéré par la garde',
          ] as $k => $v): ?>
          <div class="xo-kv__row">
            <dt><code><?= xo_e($k) ?></code></dt>
            <span class="xo-kv__leader" aria-hidden="true"></span>
            <dd class="xo-muted"><?= xo_e($v) ?></dd>
          </div>
          <?php endforeach; ?>
        </dl>
      </section>
    </div>

  </main>

  <div class="xo-keys">
    <span><kbd>Tab</kbd> parcourir</span>
    <span><kbd>Ctrl+K</kbd> aller à…</span>
    <span class="xo-spacer"></span>
    <span class="xo-faint"><?= count(XO_MODALES) - 1 ?> familles</span>
  </div>

</div>
<script type="module" src="/libs/js/xoshui.js"></script>
</body>
</html>
