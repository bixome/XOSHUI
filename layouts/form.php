<?php
declare(strict_types=1);
require __DIR__ . '/_nav.php';

/* ---- Erreurs de validation : renvoyées par le contrôleur ---------------- */

$erreurs = ['port' => 'Valeur numérique attendue (1–65535).'];
$valeurs = ['hote' => 'db.interne', 'port' => '33O6', 'base' => 'xoshui', 'user' => 'app'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Formulaire — XOSHUI</title>
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="stylesheet" href="/libs/css/xoshui.css">
</head>
<body>
<div class="xo-app">

<?php xo_layout_nav('form'); ?>

  <main class="xo-main">

    <div class="xo-steps" style="margin-bottom: 16px">
      <span class="xo-steps__step xo-steps__step--done">✓ Serveur</span>
      <span class="xo-steps__sep" aria-hidden="true">─►</span>
      <span class="xo-steps__step" aria-current="step">● Base de données</span>
      <span class="xo-steps__sep" aria-hidden="true">─►</span>
      <span class="xo-steps__step">○ Compte admin</span>
      <span class="xo-steps__sep" aria-hidden="true">─►</span>
      <span class="xo-steps__step">○ Terminé</span>
    </div>

    <?php if ($erreurs): ?>
    <div class="xo-alert xo-alert--danger" role="alert" style="margin-bottom: 16px">
      <span aria-hidden="true">!</span>
      <span class="xo-alert__body">
        <span class="xo-alert__title">Formulaire incomplet.</span>
        <?= count($erreurs) ?> champ à corriger avant de continuer.
      </span>
    </div>
    <?php endif; ?>

    <form method="post" action="">
      <div class="xo-grid">

        <section class="xo-panel xo-panel--pad xo-col-8">
          <h2 class="xo-panel__title">Connexion</h2>

          <fieldset class="xo-fieldset" style="margin-bottom: 16px">
            <legend>Serveur</legend>

            <div class="xo-field xo-field--inline">
              <label class="xo-label" for="f-hote">Hôte</label>
              <input class="xo-input" id="f-hote" name="hote" value="<?= xo_e($valeurs['hote']) ?>">
            </div>

            <div class="xo-field xo-field--inline">
              <label class="xo-label" for="f-port">Port</label>
              <div style="flex: 1">
                <input class="xo-input" id="f-port" name="port" value="<?= xo_e($valeurs['port']) ?>"
                       <?= isset($erreurs['port']) ? 'aria-invalid="true" aria-describedby="f-port-err"' : '' ?>>
                <?php if (isset($erreurs['port'])): ?>
                <span class="xo-error" id="f-port-err">! <?= xo_e($erreurs['port']) ?></span>
                <?php endif; ?>
              </div>
            </div>

            <div class="xo-field xo-field--inline">
              <label class="xo-label" for="f-base">Base</label>
              <input class="xo-input" id="f-base" name="base" value="<?= xo_e($valeurs['base']) ?>">
            </div>
          </fieldset>

          <fieldset class="xo-fieldset" style="margin-bottom: 16px">
            <legend>Authentification</legend>

            <div class="xo-field xo-field--inline">
              <label class="xo-label" for="f-user">Utilisateur</label>
              <input class="xo-input" id="f-user" name="user" value="<?= xo_e($valeurs['user']) ?>">
            </div>

            <div class="xo-field xo-field--inline">
              <label class="xo-label" for="f-pass">Mot de passe</label>
              <div style="flex: 1">
                <input class="xo-input" id="f-pass" name="pass" type="password" aria-describedby="f-pass-help">
                <span class="xo-hint" id="f-pass-help">Stocké chiffré dans config.local.php.</span>
              </div>
            </div>
          </fieldset>

          <fieldset class="xo-fieldset">
            <legend>Options</legend>

            <div class="xo-stack xo-stack--tight">
              <label class="xo-check">
                <input type="checkbox" name="ssl" checked>
                <span>Forcer TLS</span>
              </label>
              <label class="xo-check">
                <input type="checkbox" name="log">
                <span>Journaliser les requêtes lentes</span>
              </label>

              <div class="xo-rule">Jeu de caractères</div>
              <?php foreach (['utf8mb4' => 'utf8mb4 (recommandé)', 'utf8' => 'utf8', 'latin1' => 'latin1'] as $v => $lib): ?>
              <label class="xo-radio">
                <input type="radio" name="charset" value="<?= xo_e($v) ?>" <?= $v === 'utf8mb4' ? 'checked' : '' ?>><span><?= xo_e($lib) ?></span>
              </label>
              <?php endforeach; ?>

              <div class="xo-range">
                <span class="xo-muted" style="min-width: 16ch">Connexions max</span>
                <input type="range" name="pool" min="1" max="64" value="16" aria-label="Connexions max">
                <span class="xo-range__value">16</span>
              </div>
            </div>
          </fieldset>
        </section>

        <section class="xo-panel xo-panel--pad xo-col-4">
          <h2 class="xo-panel__title">Récapitulatif</h2>
          <dl class="xo-kv">
            <?php foreach ([
                'Hôte'   => $valeurs['hote'],
                'Base'   => $valeurs['base'],
                'Compte' => $valeurs['user'],
                'TLS'    => 'activé',
            ] as $k => $v): ?>
            <div class="xo-kv__row">
              <dt><?= xo_e($k) ?></dt>
              <span class="xo-kv__leader" aria-hidden="true"></span>
              <dd><?= xo_e($v) ?></dd>
            </div>
            <?php endforeach; ?>
          </dl>

          <div class="xo-alert" role="status" style="margin-top: 16px">
            <span aria-hidden="true">i</span>
            <span class="xo-alert__body">La connexion sera testée avant l’enregistrement.</span>
          </div>
        </section>

      </div>

      <div class="xo-toolbar" style="margin-top: 16px; border: 0">
        <button class="xo-btn" type="button">‹ Précédent</button>
        <span class="xo-spacer"></span>
        <button class="xo-btn" type="reset">Réinitialiser</button>
        <button class="xo-btn xo-btn--primary" type="submit">Tester et continuer ›</button>
      </div>
    </form>

  </main>

  <div class="xo-keys">
    <span><kbd>Tab</kbd> champ suivant</span>
    <span><kbd>Espace</kbd> cocher</span>
    <span><kbd>Entrée</kbd> valider</span>
    <span class="xo-spacer"></span>
    <span class="xo-faint">étape 2 / 4</span>
  </div>

</div>
<script type="module" src="/libs/js/xoshui.js"></script>
</body>
</html>
