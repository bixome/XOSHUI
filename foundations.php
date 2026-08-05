<?php
declare(strict_types=1);
require __DIR__ . '/libs/site.php';

/**
 * Les fondations : ce que le framework tient pour acquis.
 *
 * Les valeurs ne sont pas recopiées ici — elles sont lues dans xoshui.css.
 * Une page de référence qui duplique sa source finit par mentir ; celle-ci
 * ne peut pas diverger.
 *
 * Les contrastes sont calculés, pas annoncés : la charte affirmait « ≈ 12,4:1 »
 * sans que rien ne le vérifie.
 */

/** @return array<string,string> token => valeur, dans l'ordre du fichier */
function xo_tokens(): array
{
    $css = (string) file_get_contents(__DIR__ . '/libs/css/xoshui.css');
    // Le premier bloc :root porte les tokens.
    preg_match('/:root\s*\{(.*?)\}/s', $css, $bloc);
    preg_match_all('/(--xo-[a-z0-9-]+)\s*:\s*([^;]+);/i', $bloc[1] ?? '', $m, PREG_SET_ORDER);

    $out = [];
    foreach ($m as $t) {
        $out[$t[1]] = trim($t[2]);
    }
    return $out;
}

/** Luminance relative WCAG d'une couleur #rrggbb. */
function xo_luminance(string $hex): float
{
    $hex = ltrim($hex, '#');
    if (strlen($hex) === 3) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }
    $canaux = [];
    foreach ([0, 2, 4] as $i) {
        $c = hexdec(substr($hex, $i, 2)) / 255;
        $canaux[] = $c <= 0.03928 ? $c / 12.92 : (($c + 0.055) / 1.055) ** 2.4;
    }
    return 0.2126 * $canaux[0] + 0.7152 * $canaux[1] + 0.0722 * $canaux[2];
}

/** Rapport de contraste entre deux couleurs. */
function xo_contraste(string $a, string $b): float
{
    $la = xo_luminance($a);
    $lb = xo_luminance($b);
    return (max($la, $lb) + 0.05) / (min($la, $lb) + 0.05);
}

$tokens = xo_tokens();
$fond   = $tokens['--xo-bg'] ?? '#1E1E2E';

/** Les couleurs, dans l'ordre où elles comptent. */
$couleurs = array_filter($tokens, static fn (string $v, string $k): bool
    => str_starts_with($v, '#'), ARRAY_FILTER_USE_BOTH);

$roles = [
    '--xo-bg'      => 'fond de l’application',
    '--xo-panel'   => 'intérieur d’un panneau',
    '--xo-subtle'  => 'ligne paire, survol',
    '--xo-raise'   => 'modale, barre de statut, onglet actif',
    '--xo-fg'      => 'texte principal',
    '--xo-muted'   => 'label, méta, colonne secondaire',
    '--xo-faint'   => 'décor seulement — filets, glyphes éteints',
    '--xo-inverse' => 'texte posé sur un accent',
    '--xo-accent'  => 'focus, actif, sélection, lien',
    '--xo-success' => 'validé, ajouté, connecté',
    '--xo-warning' => 'attention, modifié, non suivi',
    '--xo-danger'  => 'erreur, supprimé, destructif',
    '--xo-info'    => 'information, chemin, en cours',
    '--xo-special' => 'identifiant, hash, mot-clé',
    '--xo-alt'     => 'catégorisation secondaire',
    '--xo-border'  => 'bordure de panneau',
    '--xo-rule'    => 'filet interne',
    '--xo-add'     => 'fond d’une ligne ajoutée',
    '--xo-del'     => 'fond d’une ligne retirée',
    '--xo-term'    => 'fond terminal',
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Fondations — XOSHUI</title>
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="stylesheet" href="/libs/css/xoshui.css">
</head>
<body>
<div class="xo-app">

<?php xo_nav('tokens'); ?>

  <main class="xo-main">

    <p class="xo-muted" style="margin-bottom: 16px">
      Ce que le framework tient pour acquis. Les valeurs ci-dessous sont <strong>lues dans
      <code>libs/css/xoshui.css</code></strong> — cette page ne peut pas diverger de sa
      source. Les contrastes sont calculés, pas recopiés.
    </p>

    <!-- ------------------------------------------------------- Couleur -->
    <section class="xo-panel" style="margin-bottom: 16px">
      <h2 class="xo-panel__title">Couleur</h2>
      <div class="xo-table-wrap">
        <table class="xo-table">
          <thead>
            <tr>
              <th>Token</th><th>Valeur</th><th></th>
              <th class="xo-num">Contraste /fond</th><th>Usage</th><th>Rôle</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($couleurs as $token => $valeur):
                $ratio = xo_contraste($valeur, $fond);
                $texte = $token !== '--xo-bg' && !str_contains($token, 'panel')
                      && !str_contains($token, 'raise') && !str_contains($token, 'subtle')
                      && !str_contains($token, 'add') && !str_contains($token, 'del')
                      && !str_contains($token, 'term') && $token !== '--xo-inverse';
                // Deux niveaux seulement : le framework n'a pas de « gros texte »
                // dont on pourrait se servir pour rattraper un contraste faible.
                if (!$texte)            { $verdict = ['surface', 'xo-muted']; }
                elseif ($ratio >= 4.5)  { $verdict = ['texte courant', 'xo-success']; }
                else                    { $verdict = ['décor uniquement', 'xo-faint']; }
            ?>
            <tr>
              <td><code><?= xo_e($token) ?></code></td>
              <td class="xo-muted"><?= xo_e(strtoupper($valeur)) ?></td>
              <td><span style="display: inline-block; width: 6ch; background: <?= xo_e($valeur) ?>">&nbsp;</span></td>
              <td class="xo-num"><?= xo_e(number_format($ratio, 2, ',', ' ')) ?>:1</td>
              <td class="<?= xo_e($verdict[1]) ?>"><?= xo_e($verdict[0]) ?></td>
              <td class="xo-muted"><?= xo_e($roles[$token] ?? '') ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <span class="xo-panel__count"><?= count($couleurs) ?> couleurs</span>
    </section>

    <div class="xo-grid">

      <!-- ---------------------------------------------------- Texte -->
      <section class="xo-panel xo-panel--pad xo-col-6">
        <h2 class="xo-panel__title">Texte</h2>
        <dl class="xo-kv">
          <?php foreach ([
              'Famille'   => 'JetBrains Mono, auto-hébergée',
              'Repli'     => 'ui-monospace, Cascadia Mono, Consolas…',
              'Taille'    => $tokens['--xo-fs'] ?? '14px',
              'Interligne'=> $tokens['--xo-lh'] ?? '1.35',
              'Graisses'  => '400 et 700 — aucune italique',
              'Ligatures' => 'désactivées',
          ] as $k => $v): ?>
          <div class="xo-kv__row">
            <dt><?= xo_e($k) ?></dt>
            <span class="xo-kv__leader" aria-hidden="true"></span>
            <dd><?= xo_e($v) ?></dd>
          </div>
          <?php endforeach; ?>
        </dl>

        <div class="xo-rule xo-rule--start" style="margin-top: 8px">La chasse</div>
        <pre class="xo-pre" style="margin-top: 8px">0123456789 ABCDEFGHIJ
|||||||||| ||||||||||
1lI0O ,.;: !?&amp;#@ -_=+</pre>
        <p class="xo-hint" style="margin-top: 8px">
          Les barres se posent sous chaque caractère : si elles glissent, la grille est
          rompue. La ligne du bas montre les paires qu’une police de code doit distinguer.
        </p>
      </section>

      <!-- ---------------------------------------------- Espacement -->
      <section class="xo-panel xo-panel--pad xo-col-6">
        <h2 class="xo-panel__title">Espacement</h2>
        <p class="xo-hint" style="margin-bottom: 8px">
          Horizontal en caractères, vertical en multiples de 4 px. C’est ce qui aligne les
          colonnes sans effort.
        </p>
        <?php foreach ([
            ['1ch',  'gouttière — xo-row, padding de ligne', '1ch'],
            ['2ch',  'indentation d’un niveau d’arbre',      '2ch'],
            ['4px',  'interligne serré dans une ligne',      '4px'],
            ['8px',  'padding de panneau, xo-stack--tight',  '8px'],
            ['16px', 'entre panneaux — xo-grid, xo-stack',   '16px'],
        ] as [$nom, $role, $largeur]): ?>
        <div class="xo-row" style="gap: 2ch">
          <span class="xo-muted" style="min-width: 6ch"><?= xo_e($nom) ?></span>
          <span style="display: inline-block; height: 1em; width: <?= xo_e($largeur) ?>; background: var(--xo-accent)"></span>
          <span class="xo-faint"><?= xo_e($role) ?></span>
        </div>
        <?php endforeach; ?>

        <div class="xo-rule xo-rule--start" style="margin-top: 8px">Formes</div>
        <dl class="xo-kv" style="margin-top: 8px">
          <?php foreach ([
              'Bordure'    => '1px solid — une seule épaisseur',
              'Arrondi'    => '0, sans exception',
              'Ombre'      => 'aucune',
              'Dégradé'    => 'aucun',
              'Profondeur' => 'par la teinte de surface, jamais par une ombre',
          ] as $k => $v): ?>
          <div class="xo-kv__row">
            <dt><?= xo_e($k) ?></dt>
            <span class="xo-kv__leader" aria-hidden="true"></span>
            <dd class="xo-muted"><?= xo_e($v) ?></dd>
          </div>
          <?php endforeach; ?>
        </dl>
      </section>

      <!-- -------------------------------------------------- Grille -->
      <section class="xo-panel xo-panel--pad xo-col-6">
        <h2 class="xo-panel__title">Grille</h2>
        <div class="xo-grid" style="margin-bottom: 8px">
          <?php for ($i = 0; $i < 12; $i++): ?>
          <span class="xo-col-2" style="background: var(--xo-subtle); text-align: center">&nbsp;</span>
          <?php endfor; ?>
        </div>
        <p class="xo-hint">
          Douze colonnes ; <code>xo-col-2</code> à <code>xo-col-12</code>. Sous 720 px,
          tout passe en pleine largeur.
        </p>
        <dl class="xo-kv" style="margin-top: 8px">
          <?php foreach ([
              '≥ 1200 px' => 'multi-colonnes, tous les panneaux visibles',
              '720–1199'  => 'colonnes empilées, volets repliés',
              '< 720 px'  => 'flux vertical, taille à 12 px, séparateurs désactivés',
          ] as $k => $v): ?>
          <div class="xo-kv__row">
            <dt><?= xo_e($k) ?></dt>
            <span class="xo-kv__leader" aria-hidden="true"></span>
            <dd class="xo-muted"><?= xo_e($v) ?></dd>
          </div>
          <?php endforeach; ?>
        </dl>
      </section>

      <!-- ------------------------------------------------ Mouvement -->
      <section class="xo-panel xo-panel--pad xo-col-6">
        <h2 class="xo-panel__title">Mouvement</h2>
        <dl class="xo-kv">
          <?php foreach ([
              'Sélection'  => '0 ms — instantané, c’est ce qui fait « terminal »',
              'Modale'     => '80 ms d’opacité, aucune translation',
              'Curseur'    => '1 s, en pas discrets',
              'Attente'    => '800 ms, quatre positions',
              'Interdits'  => 'parallaxe, fondu au scroll, spinner tournant',
          ] as $k => $v): ?>
          <div class="xo-kv__row">
            <dt><?= xo_e($k) ?></dt>
            <span class="xo-kv__leader" aria-hidden="true"></span>
            <dd class="xo-muted"><?= xo_e($v) ?></dd>
          </div>
          <?php endforeach; ?>
        </dl>
        <div class="xo-row" style="margin-top: 8px">
          <span class="xo-spinner" aria-hidden="true"></span>
          <span class="xo-muted">attente</span>
          <span class="xo-spacer"></span>
          <span class="xo-muted">curseur</span>
          <span class="xo-cursor" aria-hidden="true"></span>
        </div>
        <p class="xo-hint" style="margin-top: 8px">
          Tout se fige sous <code>prefers-reduced-motion</code>.
        </p>
      </section>

    </div>
  </main>

  <div class="xo-keys">
    <span><kbd>Ctrl+K</kbd> aller à…</span>
    <span><kbd>?</kbd> aide</span>
    <span class="xo-spacer"></span>
    <span class="xo-faint"><?= count($tokens) ?> tokens lus dans xoshui.css</span>
  </div>

</div>
<script type="module" src="/libs/js/xoshui.js"></script>
</body>
</html>
