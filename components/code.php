<?php
declare(strict_types=1);
require __DIR__ . '/../libs/specimen.php';

xo_specimen_debut('code', 'Le seul endroit où l’interligne se resserre à 1.2 : dans un bloc préformaté, l’alignement vertical prime sur le confort de lecture.');

xo_specimen('Bloc de code', <<<'HTML'
<pre class="xo-pre"><code>.xo-panel {
  position: relative;
  border: 1px solid var(--xo-border);
  padding: calc(var(--xo-pad) + 2px) 0 var(--xo-pad);
}</code></pre>
HTML, 'Toujours échapper le contenu côté serveur. Le débordement horizontal défile, il ne passe jamais à la ligne.');

xo_specimen('Terminal', <<<'HTML'
<pre class="xo-pre xo-pre--terminal">$ php -S localhost:8000
[Tue Aug  4 18:24:01 2026] PHP 8.3.0 Development Server started
[Tue Aug  4 18:24:07 2026] 127.0.0.1:52233 [200]: GET /demo.php
$ _</pre>
HTML, '--terminal pose le seul noir pur du système, sur le token --xo-term.');

xo_specimen('Diff', <<<'HTML'
<div class="xo-diff">
  <div class="xo-diff__line"><span class="xo-diff__num">12</span><span>.xo-panel {</span></div>
  <div class="xo-diff__line xo-diff__line--del"><span class="xo-diff__num">13</span><span>-  border-radius: 4px;</span></div><!-- xo-lint-ignore : cité, pas appliqué -->
  <div class="xo-diff__line xo-diff__line--add"><span class="xo-diff__num">13</span><span>+  border-radius: 0;</span></div>
  <div class="xo-diff__line"><span class="xo-diff__num">14</span><span>}</span></div>
</div>
HTML, 'Les préfixes + et − doublent la couleur : rouge et vert côte à côte ne suffisent pas en cas de deutéranopie.');

xo_specimen('Invite de commande', <<<'HTML'
<label class="xo-prompt">
  <span class="xo-prompt__sign" aria-hidden="true">$</span>
  <input type="text" value="git status" aria-label="Commande">
</label>
<div style="margin-top: 8px">
  <span class="xo-muted">sortie</span> <span class="xo-cursor" aria-hidden="true"></span>
</div>
HTML, 'Le curseur clignote en pas discrets, jamais en fondu — et se fige sous prefers-reduced-motion.');

xo_specimen_fin([
    'xo-pre'            => 'bloc préformaté, défilant',
    'xo-pre--terminal'  => 'fond noir, texte vert',
    'xo-diff'           => 'conteneur de diff',
    'xo-diff__line'     => 'une ligne ; --add, --del',
    'xo-diff__num'      => 'numéro, non sélectionnable',
    'xo-prompt'         => 'invite de commande',
    'xo-cursor'         => 'bloc clignotant',
]);
