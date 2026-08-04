<?php
declare(strict_types=1);

/**
 * Les recettes utilisent la navigation du site.
 * Ce fichier n'existe que pour garder l'appel court dans chaque recette.
 */

require_once __DIR__ . '/../libs/site.php';

function xo_layout_nav(string $current): void
{
    xo_nav($current);
}
