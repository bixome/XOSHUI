<?php
declare(strict_types=1);
require __DIR__ . '/../libs/site.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Composants — XOSHUI</title>
<link rel="stylesheet" href="/libs/css/xoshui.css">
</head>
<body>
<div class="xo-app">

<?php xo_nav('compos'); ?>

  <main class="xo-main">

    <div class="xo-banner" style="margin-bottom: 16px">
      <pre class="xo-banner__art">┌─ C O M P O S A N T S ─┐</pre>
      <p class="xo-banner__tagline">
        Un composant par page, isolé, avec sa source à déplier.
        Les <a href="/layouts/">layouts</a> les assemblent ; la <a href="/demo.php">démo</a> les montre tous d’un coup.
      </p>
    </div>

    <div class="xo-grid">
      <?php foreach (XO_COMPOSANTS as $slug => [$label, $desc]):
          if ($slug === 'index') { continue; } ?>
      <section class="xo-panel xo-panel--pad xo-col-4"
               style="display: flex; flex-direction: column; gap: 8px">
        <h2 class="xo-panel__title"><?= xo_e($label) ?></h2>
        <p class="xo-muted"><?= xo_e($desc) ?></p>
        <p class="xo-faint xo-nowrap" style="overflow: hidden; text-overflow: ellipsis">
          components/<?= xo_e($slug) ?>.php
        </p>
        <a class="xo-btn xo-btn--primary" href="<?= xo_e($slug) ?>.php"
           style="margin-top: auto; align-self: flex-start">Ouvrir</a>
      </section>
      <?php endforeach; ?>
    </div>

    <div class="xo-rule xo-rule--start" style="margin: 16px 0">Trois entrées, trois usages</div>

    <section class="xo-panel xo-panel--pad">
      <h2 class="xo-panel__title">Où aller</h2>
      <dl class="xo-kv">
        <?php foreach ([
            'Composants' => 'un composant isolé, ses variantes, sa source — pour comprendre',
            'Layouts'    => 'une page entière à copier — pour démarrer un écran',
            'Démo'       => 'toutes les classes sur une page — pour balayer du regard',
            'Docs'       => 'l’aide-mémoire, une ligne par classe — pour écrire vite',
        ] as $k => $v): ?>
        <div class="xo-kv__row">
          <dt><?= xo_e($k) ?></dt>
          <span class="xo-kv__leader" aria-hidden="true"></span>
          <dd class="xo-muted"><?= xo_e($v) ?></dd>
        </div>
        <?php endforeach; ?>
      </dl>
    </section>

  </main>

  <div class="xo-keys">
    <span><kbd>Tab</kbd> parcourir</span>
    <span><kbd>Ctrl+K</kbd> aller à…</span>
    <span class="xo-spacer"></span>
    <span class="xo-faint"><?= count(XO_COMPOSANTS) - 1 ?> composants</span>
  </div>

</div>
<script type="module" src="/libs/js/xoshui.js"></script>
</body>
</html>
