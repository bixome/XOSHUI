<?php
declare(strict_types=1);

/**
 * Navigation partagée des mises en page.
 *
 * Chaque recette est un fichier complet, copiable tel quel : le squelette HTML
 * y est répété volontairement. Seule cette navigation est mutualisée, parce
 * qu'elle sert à circuler entre les recettes.
 */

/** Échappement de sortie — à reprendre dans toute page qui affiche des données. */
function xo_e(string|int|float|null $v): string
{
    return htmlspecialchars((string) $v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** slug => [libellé, description] */
const XO_LAYOUTS = [
    'index'         => ['Sommaire',        'La liste des mises en page'],
    'dashboard'     => ['Tableau de bord', 'Métriques, panneaux, journal — la vue de supervision'],
    'master-detail' => ['Maître-détail',   'Liste à gauche, détail à droite, séparateur réglable'],
    'table'         => ['Table',           'Données, tri, filtre, pagination'],
    'explorer'      => ['Explorateur',     'Trois volets : arbre, contenu, aperçu'],
    'form'          => ['Formulaire',      'Champs groupés, validation, actions'],
    'console'       => ['Console',         'Journal défilant et invite de commande'],
    'article'       => ['Article',         'Lecture : sommaire, texte, largeur mesurée'],
    'login'         => ['Connexion',       'Panneau centré, écran d’entrée'],
];

/** Barre de navigation des layouts. */
function xo_layout_nav(string $current): void
{
    echo '<nav class="xo-nav" aria-label="Layouts">' . "\n";
    echo '  <span class="xo-nav__brand">XOSHUI</span>' . "\n";
    echo '  <span class="xo-muted">layouts</span>' . "\n";
    echo '  <ul class="xo-nav__list">' . "\n";

    foreach (XO_LAYOUTS as $slug => [$label, $_]) {
        $href = $slug === 'index' ? './' : $slug . '.php';
        $curr = $slug === $current ? ' aria-current="page"' : '';
        printf('    <li><a class="xo-nav__link" href="%s"%s>%s</a></li>' . "\n",
            xo_e($href), $curr, xo_e($label));
    }

    echo '  </ul>' . "\n";
    echo '  <span class="xo-spacer"></span>' . "\n";
    echo '  <a class="xo-nav__link" href="/demo.php">Démo</a>' . "\n";
    echo '</nav>' . "\n";
}
