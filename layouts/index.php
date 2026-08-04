<?php
declare(strict_types=1);
require __DIR__ . '/_nav.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>XOSHUI — layouts</title>
<link rel="stylesheet" href="/libs/css/xoshui.css">
</head>
<body>
<div class="xo-app">

<?php xo_layout_nav('index'); ?>

  <main class="xo-main">

    <div class="xo-banner" style="margin-bottom: 16px">
      <p class="xo-banner__art">┌─ L A Y O U T S ─┐</p>
      <p class="xo-banner__tagline">
        Des pages entières, pas des composants. Copiez le fichier, remplacez les données.
      </p>
    </div>

    <div class="xo-grid">
      <?php foreach (XO_LAYOUTS as $slug => [$label, $desc]):
          if ($slug === 'index') { continue; } ?>
      <section class="xo-panel xo-panel--pad xo-col-4">
        <h2 class="xo-panel__title"><?= xo_e($label) ?></h2>
        <p class="xo-muted" style="margin-bottom: 8px"><?= xo_e($desc) ?></p>
        <div class="xo-row">
          <a class="xo-btn xo-btn--primary" href="<?= xo_e($slug) ?>.php">Ouvrir</a>
          <span class="xo-faint">layouts/<?= xo_e($slug) ?>.php</span>
        </div>
      </section>
      <?php endforeach; ?>
    </div>

    <div class="xo-rule xo-rule--start" style="margin: 16px 0">Mode d’emploi</div>

    <section class="xo-panel xo-panel--pad">
      <h2 class="xo-panel__title">Comment s’en servir</h2>
      <ol class="xo-kv">
        <?php foreach ([
            'Choisir'  => 'la mise en page la plus proche du besoin',
            'Copier'   => 'le fichier entier dans votre projet',
            'Brancher' => 'vos données à la place des tableaux d’exemple',
            'Ajuster'  => 'les classes avec docs/api.md sous la main',
        ] as $k => $v): ?>
        <li class="xo-kv__row">
          <dt><?= xo_e($k) ?></dt>
          <span class="xo-kv__leader" aria-hidden="true"></span>
          <dd class="xo-muted"><?= xo_e($v) ?></dd>
        </li>
        <?php endforeach; ?>
      </ol>
    </section>

  </main>

  <div class="xo-keys">
    <span><kbd>Tab</kbd> parcourir</span>
    <span><kbd>Entrée</kbd> ouvrir</span>
    <span class="xo-spacer"></span>
    <span class="xo-faint">XOSHUI 1.0</span>
  </div>

</div>
<script type="module" src="/libs/js/xoshui.js"></script>
</body>
</html>
