<?php
declare(strict_types=1);

/**
 * Lecture des documents du projet, rendus avec le framework.
 *
 * Le fichier n'est jamais pris dans l'URL : le paramètre est un slug validé
 * contre XO_DOCS, et le chemin vient du registre. Sans cela, ?f=../config
 * suffirait à lire n'importe quel fichier du disque.
 */

require __DIR__ . '/libs/site.php';

$slug = (string) ($_GET['f'] ?? 'api');
if (!isset(XO_DOCS[$slug])) {
    $slug = 'api';
}
[$chemin, $titre] = XO_DOCS[$slug];

$source = (string) file_get_contents(__DIR__ . '/' . $chemin);

/* ---------------------------------------------------------------- Markdown */

/** Identifiant d'ancre à partir d'un titre. */
function xo_md_ancre(string $texte): string
{
    $s = strtolower(strip_tags($texte));
    $s = preg_replace('/[^\p{L}\p{N}]+/u', '-', $s) ?? '';
    return trim($s, '-');
}

/**
 * Rendu en ligne : gras, code, liens.
 * L'échappement est fait en premier ; les segments de code sont mis de côté
 * pour qu'un `**` à l'intérieur ne soit pas interprété.
 */
function xo_md_inline(string $texte): string
{
    $codes = [];
    $texte = preg_replace_callback('/`([^`]+)`/', static function (array $m) use (&$codes): string {
        $codes[] = '<code>' . xo_e($m[1]) . '</code>';
        return "\x00" . (count($codes) - 1) . "\x00";
    }, $texte) ?? $texte;

    $texte = xo_e($texte);
    $texte = preg_replace('/\*\*([^*]+)\*\*/', '<strong>$1</strong>', $texte) ?? $texte;

    // Liens : les .md du projet pointent vers ce lecteur, le reste tel quel.
    $texte = preg_replace_callback('/\[([^\]]+)\]\(([^)]+)\)/', static function (array $m): string {
        $url = $m[2];
        foreach (XO_DOCS as $s => [$f, $_]) {
            if (str_ends_with($url, basename($f))) {
                $url = '/docs.php?f=' . $s;
                break;
            }
        }
        return '<a href="' . xo_e($url) . '">' . $m[1] . '</a>';
    }, $texte) ?? $texte;

    return preg_replace_callback('/\x00(\d+)\x00/', static fn (array $m): string => $codes[(int) $m[1]], $texte) ?? $texte;
}

/**
 * Rendu du document.
 *
 * @return array{html: string, sommaire: list<array{0:string,1:string}>}
 */
function xo_md(string $source): array
{
    $lignes   = explode("\n", str_replace("\r\n", "\n", $source));
    $html     = '';
    $sommaire = [];
    $i        = 0;
    $n        = count($lignes);

    while ($i < $n) {
        $ligne = $lignes[$i];

        // --- Bloc de code
        if (str_starts_with($ligne, '```')) {
            $code = '';
            $i++;
            while ($i < $n && !str_starts_with($lignes[$i], '```')) {
                $code .= $lignes[$i] . "\n";
                $i++;
            }
            $i++;
            $html .= '<pre class="xo-pre"><code>' . xo_e(rtrim($code)) . '</code></pre>';
            continue;
        }

        // --- Titre
        if (preg_match('/^(#{1,4})\s+(.*)$/', $ligne, $m)) {
            $niveau = strlen($m[1]);
            $texte  = xo_md_inline($m[2]);
            $ancre  = xo_md_ancre($m[2]);
            if ($niveau === 2) {
                // $texte est déjà échappé : on décode avant de le stocker,
                // sinon la vue l'échappe une seconde fois (« d&#039;outils »).
                $sommaire[] = [$ancre, html_entity_decode(strip_tags($texte), ENT_QUOTES, 'UTF-8')];
            }
            $html .= "<h{$niveau} id=\"" . xo_e($ancre) . "\">{$texte}</h{$niveau}>";
            $i++;
            continue;
        }

        // --- Filet
        if (preg_match('/^-{3,}$/', trim($ligne))) {
            $html .= '<hr>';
            $i++;
            continue;
        }

        // --- Tableau : en-tête, séparateur, puis lignes
        if (str_starts_with(trim($ligne), '|') && isset($lignes[$i + 1])
            && preg_match('/^\s*\|[\s:|-]+\|\s*$/', $lignes[$i + 1])) {
            $cellules = static fn (string $l): array
                => array_map('trim', explode('|', trim(trim($l), '|')));

            $html .= '<div class="xo-table-wrap"><table class="xo-table"><thead><tr>';
            foreach ($cellules($ligne) as $c) {
                $html .= '<th>' . xo_md_inline($c) . '</th>';
            }
            $html .= '</tr></thead><tbody>';
            $i += 2;
            while ($i < $n && str_starts_with(trim($lignes[$i]), '|')) {
                $html .= '<tr>';
                foreach ($cellules($lignes[$i]) as $c) {
                    $html .= '<td>' . xo_md_inline($c) . '</td>';
                }
                $html .= '</tr>';
                $i++;
            }
            $html .= '</tbody></table></div>';
            continue;
        }

        // --- Citation
        if (str_starts_with($ligne, '>')) {
            $bloc = '';
            while ($i < $n && str_starts_with($lignes[$i], '>')) {
                $bloc .= ltrim(substr($lignes[$i], 1)) . ' ';
                $i++;
            }
            $html .= '<blockquote>' . xo_md_inline(trim($bloc)) . '</blockquote>';
            continue;
        }

        // --- Liste
        if (preg_match('/^\s*([-*]|\d+\.)\s+/', $ligne)) {
            $ordonnee = (bool) preg_match('/^\s*\d+\./', $ligne);
            $balise   = $ordonnee ? 'ol' : 'ul';
            $html    .= "<{$balise}>";
            while ($i < $n && preg_match('/^\s*([-*]|\d+\.)\s+(.*)$/', $lignes[$i], $m)) {
                $item = $m[2];
                $i++;
                // Continuation indentée d'un item.
                while ($i < $n && preg_match('/^\s{2,}\S/', $lignes[$i])
                       && !preg_match('/^\s*([-*]|\d+\.)\s+/', $lignes[$i])) {
                    $item .= ' ' . trim($lignes[$i]);
                    $i++;
                }
                $item = preg_replace('/^\[([ x])\]\s*/', '', $item, 1, $coche) ?? $item;
                $prefixe = $coche ? '<span class="xo-muted">[' . (str_contains($m[2], '[x]') ? 'x' : ' ') . ']</span> ' : '';
                $html .= '<li>' . $prefixe . xo_md_inline($item) . '</li>';
            }
            $html .= "</{$balise}>";
            continue;
        }

        // --- Paragraphe
        if (trim($ligne) !== '') {
            $bloc = '';
            while ($i < $n && trim($lignes[$i]) !== ''
                   && !preg_match('/^(#{1,4}\s|```|\||>|\s*([-*]|\d+\.)\s)/', $lignes[$i])) {
                $bloc .= $lignes[$i] . ' ';
                $i++;
            }
            $html .= '<p>' . xo_md_inline(trim($bloc)) . '</p>';
            continue;
        }

        $i++;
    }

    return ['html' => $html, 'sommaire' => $sommaire];
}

$doc = xo_md($source);
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

<?php xo_nav($slug); ?>

  <nav class="xo-breadcrumb" aria-label="Fil d’Ariane">
    <span class="xo-breadcrumb__sep" aria-hidden="true">/</span><a href="/docs.php">docs</a>
    <span class="xo-breadcrumb__sep" aria-hidden="true">/</span><span aria-current="page"><?= xo_e(basename($chemin)) ?></span>
  </nav>

  <div class="xo-layout">

    <nav class="xo-sidebar" aria-label="Sommaire">
      <div class="xo-sidebar__group">Sur cette page</div>
      <?php foreach ($doc['sommaire'] as [$ancre, $texte]): ?>
      <a class="xo-sidebar__link" href="#<?= xo_e($ancre) ?>"><?= xo_e($texte) ?></a>
      <?php endforeach; ?>

      <div class="xo-sidebar__group">Documents</div>
      <?php foreach (XO_DOCS as $s => [$f, $label]): ?>
      <a class="xo-sidebar__link" href="/docs.php?f=<?= xo_e($s) ?>"
         <?= $s === $slug ? 'aria-current="page"' : '' ?>><?= xo_e($label) ?></a>
      <?php endforeach; ?>

      <div class="xo-sidebar__group">Source</div>
      <a class="xo-sidebar__link" href="/<?= xo_e($chemin) ?>">Markdown brut</a>
    </nav>

    <main class="xo-main">
      <article class="xo-prose"><?= $doc['html'] ?></article>
    </main>

  </div>

  <div class="xo-keys">
    <span><kbd>Ctrl+K</kbd> aller à…</span>
    <span><kbd>?</kbd> aide</span>
    <span class="xo-spacer"></span>
    <span class="xo-faint"><?= xo_e($chemin) ?> · <?= number_format(strlen($source) / 1024, 1, ',', ' ') ?> K</span>
  </div>

</div>
<script type="module" src="/libs/js/xoshui.js"></script>
</body>
</html>
