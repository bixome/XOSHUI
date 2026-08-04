<?php
declare(strict_types=1);
require __DIR__ . '/../libs/specimen.php';

xo_specimen_debut('table', 'Le tableau partage la mécanique clavier de la liste : le même data-xo-list rend ses lignes navigables. Zébrage, alignement des nombres et en-tête collant font le reste.');

xo_specimen('Tableau simple', <<<'HTML'
<div class="xo-table-wrap">
  <table class="xo-table" data-xo-list aria-label="Processus">
    <thead>
      <tr><th>PID</th><th>USER</th><th class="xo-num">CPU%</th><th>CMD</th></tr>
    </thead>
    <tbody>
      <tr aria-selected="true"><td class="xo-special">58406</td><td>romain</td><td class="xo-num">41.0</td><td>php-fpm</td></tr>
      <tr aria-selected="false"><td class="xo-special">400</td><td>romain</td><td class="xo-num">7.5</td><td>mysqld</td></tr>
      <tr aria-selected="false"><td class="xo-special">578</td><td>root</td><td class="xo-num">3.6</td><td>httpd</td></tr>
    </tbody>
  </table>
</div>
HTML, 'xo-num aligne à droite : les nombres se comparent en colonne, chiffre par chiffre.', true);

xo_specimen('En-tête collant', <<<'HTML'
<div class="xo-table-wrap" style="--xo-max-h: 8em">
  <table class="xo-table">
    <thead><tr><th>Réf</th><th>Client</th><th class="xo-num">Total</th></tr></thead>
    <tbody>
      <tr><td>CMD-2041</td><td>Dupont SARL</td><td class="xo-num">1 240,50 €</td></tr>
      <tr><td>CMD-2040</td><td>Martin &amp; Cie</td><td class="xo-num">89,90 €</td></tr>
      <tr><td>CMD-2039</td><td>Atelier Nord</td><td class="xo-num">3 410,00 €</td></tr>
      <tr><td>CMD-2038</td><td>Leroy</td><td class="xo-num">15,00 €</td></tr>
      <tr><td>CMD-2037</td><td>Bureau Sud</td><td class="xo-num">742,30 €</td></tr>
      <tr><td>CMD-2036</td><td>Dupont SARL</td><td class="xo-num">210,00 €</td></tr>
    </tbody>
  </table>
</div>
HTML, 'position: sticky n’opère que si la hauteur est contrainte. Sans --xo-max-h, la déclaration existe mais ne fait rien.', true);

xo_specimen('Colonne triée', <<<'HTML'
<div class="xo-table-wrap">
  <table class="xo-table">
    <thead>
      <tr>
        <th><a href="?tri=ref&amp;sens=asc">Référence</a></th>
        <th><a href="?tri=date&amp;sens=desc">↓Date</a></th>
        <th class="xo-num"><a href="?tri=total&amp;sens=asc">Total</a></th>
      </tr>
    </thead>
    <tbody>
      <tr><td>CMD-2041</td><td>04/08</td><td class="xo-num">1 240,50 €</td></tr>
      <tr><td>CMD-2039</td><td>03/08</td><td class="xo-num">3 410,00 €</td></tr>
    </tbody>
  </table>
</div>
HTML, 'La flèche est collée au libellé, sans espace : ↓Date. Côté serveur, valider la colonne contre une liste blanche — jamais interpoler $_GET dans un ORDER BY.', true);

xo_specimen_fin([
    'xo-table'      => 'le tableau',
    'xo-table-wrap' => 'conteneur défilant ; --xo-max-h active l’en-tête collant',
    'xo-num'        => 'aligne une colonne de nombres à droite',
    'data-xo-list'  => 'rend les lignes navigables au clavier',
    'aria-selected' => 'la ligne sélectionnée, en vidéo inverse',
], [
    '↑ ↓'    => 'changer de ligne',
    'Entrée' => 'activer la ligne',
]);
