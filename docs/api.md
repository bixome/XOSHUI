# XOSHUI — aide-mémoire

```html
<link rel="stylesheet" href="/libs/css/xoshui.css">
<script type="module" src="/libs/js/xoshui.js"></script>
```

Tout est en monospace, sans arrondi, sans ombre. La sélection est une barre en vidéo
inverse.

- **[demo.php](../demo.php)** — l'écran de contrôle : les 238 classes en une page,
  sans commentaire. Pour juger la densité et la cohésion d'un coup d'œil.
- **[layouts/](../layouts/)** — des pages entières à copier : tableau de bord,
  maître-détail, table, explorateur, formulaire, console, article, connexion.
  Partir de là coûte moins cher que d'assembler les composants un à un.
- **[components/](../components/)** — un composant par page, isolé, avec ses variantes
  et sa source à déplier.
- **[modals/](../modals/)** — les boîtes de message : information, confirmation, invite,
  formulaire, progression, plein écran.
- **[foundations.php](../foundations.php)** — les tokens, avec les contrastes calculés.
- **[icons.php](../icons.php)** — le pack de glyphes, tous mesurés dans la police.

## Mise en page

| Classe | Rôle |
|---|---|
| `xo-app` | Colonne pleine hauteur (statusbar / main / keys) |
| `xo-main` | Zone centrale, remplit l'espace |
| `xo-grid` + `xo-col-{2,3,4,5,6,8,9,12}` | Grille 12 colonnes ; pleine largeur < 720px |
| `xo-row` | Flex horizontal, gouttière `1ch` |
| `xo-stack` | Flex vertical, gouttière `16px` ; `--tight` (`8px`) à l'intérieur d'un panneau |
| `xo-spacer` | Pousse le reste à droite |

## Panneau

```html
<section class="xo-panel xo-panel--active">
  <h2 class="xo-panel__title">Titre</h2>
  …
  <span class="xo-panel__count">1 of 11</span>
</section>
```

`--active` = bordure et titre en accent. Par défaut le contenu est **à fleur de bord**
(pour que les lignes sélectionnées aillent d'un bord à l'autre) ; ajouter `--pad` pour du
texte libre, un formulaire ou des boutons.

**Un panneau ne défile jamais lui-même** : son titre et son compteur débordent de la
bordure, et le moindre `overflow` les couperait en deux. Faire défiler son corps :

```html
<section class="xo-panel">
  <h2 class="xo-panel__title">Titre</h2>
  <div class="xo-panel__body" style="--xo-max-h: 40vh">…</div>
</section>
```

## Liste

```html
<ul class="xo-list" data-xo-list role="listbox">
  <li class="xo-list__item" role="option" aria-selected="true" data-value="x">
    <span class="xo-list__icon" aria-hidden="true">├</span>
    <span>Libellé</span>
    <span class="xo-list__meta">meta</span>
  </li>
</ul>
```

`data-xo-list` active ↑↓, `Home`/`End`, `Entrée`, le clic, et émet `xo:select` /
`xo:activate` (`event.detail.value`). Ajouter `data-xo-list="horizontal"` pour ←→.
Arbre : `xo-list--tree` sur le `<ul>` + `style="--xo-depth: 2"` sur l'item.

## Tableau

```html
<div class="xo-table-wrap">
  <table class="xo-table" data-xo-list>
    <thead><tr><th>PID</th><th class="xo-num">CPU%</th></tr></thead>
    <tbody><tr aria-selected="true"><td>1</td><td class="xo-num">4.0</td></tr></tbody>
  </table>
</div>
```

Lignes zébrées, `xo-num` pour aligner les nombres à droite. `data-xo-list` rend les lignes
navigables. L'en-tête ne devient collant que si la hauteur est contrainte :
`<div class="xo-table-wrap" style="--xo-max-h: 40vh">`.

## Onglets

```html
<div class="xo-tabs" data-xo-tabs role="tablist">
  <button class="xo-tabs__tab" role="tab" aria-selected="true" aria-controls="p1">[1] Un</button>
</div>
<section id="p1" role="tabpanel" class="xo-tabpanel">…</section>
<section id="p2" role="tabpanel" class="xo-tabpanel" hidden>…</section>
```

## Boutons

`xo-btn` · `--primary` · `--danger` · `--ghost` · `[disabled]` · `xo-btn-group`
Transparent au repos, plein au survol et au focus — le remplissage signale l'interaction,
pas l'existence. Bouton bascule : `aria-pressed`. Bouton réduit à un glyphe : `aria-label`
obligatoire. Pleine largeur : `style="width: 100%; justify-content: center"`, sans quoi le
libellé reste collé à gauche.

## Formulaire

`xo-field` (bloc label + champ) · `xo-label` · `xo-input` · `xo-select` · `xo-textarea` ·
`xo-check` · `xo-hint` · `xo-error`
Erreur : `aria-invalid="true"` sur le champ + `<span class="xo-error">`.
`xo-hint` pour un texte d'aide ; `xo-help` est la **modale** des raccourcis, à ne pas confondre.

## Barres

```html
<div class="xo-statusbar"><span class="xo-statusbar__label">CPU:</span> 29%</div>
<div class="xo-keys"><span><kbd>↑↓</kbd> naviguer</span></div>
```

`xo-keys` va en bas de chaque écran : c'est ce qui rend l'interface auto-documentée.

## Indicateurs

```html
<span class="xo-badge xo-badge--success">✓ OK</span>
<span class="xo-spark">▁▂▃▅▇█▆▄</span>
```

Badge : `--success` `--warning` `--danger` `--info`. `--solid` se **combine** avec une
variante : `class="xo-badge xo-badge--solid xo-badge--danger"`.

Pour une jauge (CPU, mémoire, disque), utiliser **`xo-progress`** avec `role="meter"` :
c'est le même objet. Seuils d'usage : `--warning` ≥ 70 %, `--danger` ≥ 90 %, et toujours
la valeur chiffrée à côté.

## Code, terminal, diff

`xo-pre` · `xo-pre--terminal`
`xo-diff` > `xo-diff__line` (`--add` / `--del`) > `xo-diff__num` + contenu.

## Modale

```html
<button class="xo-btn" data-xo-open="#id">Ouvrir</button>

<dialog class="xo-dialog" id="id">
  <p class="xo-dialog__title">Titre</p>
  …
  <div class="xo-dialog__actions"><button class="xo-btn" data-xo-close>Fermer</button></div>
</dialog>
```

`<dialog>` natif : `Échap` ferme, focus piégé, sans JS supplémentaire.

Variantes : `--narrow` `--wide` `--full`, et la sévérité
`--success` `--warning` `--danger` (titre et bordure, jamais le fond).
`xo-dialog__body` est la zone qui défile entre titre et actions.

Deux hooks propres aux boîtes :

```html
<button data-xo-key="o">Écraser</button>          <!-- la touche O l'active -->
<input data-xo-guard="XOSHUI">                     <!-- texte à recopier -->
<button data-xo-guard-ok>Supprimer</button>        <!-- inerte tant que ça ne correspond pas -->
```

## Navigation

```html
<nav class="xo-nav" aria-label="Principale">
  <span class="xo-nav__brand">XOSHUI</span>
  <ul class="xo-nav__list">
    <li><a class="xo-nav__link" href="/" aria-current="page">Accueil</a></li>
  </ul>
  <span class="xo-spacer"></span>
</nav>

<nav class="xo-breadcrumb" aria-label="Fil d'Ariane">
  <span class="xo-breadcrumb__sep" aria-hidden="true">/</span><a href="#">libs</a>
  <span class="xo-breadcrumb__sep" aria-hidden="true">/</span><span aria-current="page">css</span>
</nav>
```

Le lien courant se marque avec `aria-current="page"` (vidéo inverse), pas une classe.
`xo-breadcrumb` est une barre à part entière : sa place est **sous** la nav, pas dedans.

## Barre d'outils

```html
<div class="xo-toolbar">
  <div class="xo-btn-group" role="group" aria-label="Tri">
    <button class="xo-btn" aria-pressed="true">CPU</button>
    <button class="xo-btn" aria-pressed="false">MEM</button>
  </div>
  <span class="xo-toolbar__sep" aria-hidden="true"></span>
  <button class="xo-btn xo-btn--ghost">[/] filtrer</button>
  <span class="xo-spacer"></span>
</div>
```

`xo-btn-group` accole les boutons (bordures fusionnées). L'état actif d'un bouton bascule
se déclare avec `aria-pressed="true"`.

## Pagination

```html
<div class="xo-pagination">
  <button class="xo-btn" aria-label="Page précédente">‹</button>
  <span class="xo-pagination__info">page 1 / 30</span>
  <button class="xo-btn" aria-label="Page suivante">›</button>
</div>
```

## Alerte

```html
<div class="xo-alert xo-alert--warning" role="status">
  <span aria-hidden="true">▲</span>
  <span class="xo-alert__body">
    <span class="xo-alert__title">Titre.</span> Détail du message.
  </span>
</div>
```

`--success` `--warning` `--danger` ; sans modificateur = information (teal).
`role="status"` pour un message informatif, `role="alert"` pour une erreur bloquante.

## Clé-valeur

```html
<dl class="xo-kv">
  <div class="xo-kv__row">
    <dt>Version</dt>
    <span class="xo-kv__leader" aria-hidden="true"></span>
    <dd>1.0</dd>
  </div>
</dl>
```

Les trois éléments sont nécessaires : `xo-kv__leader` est la ligne de pointillés qui relie
la clé à la valeur.

## État vide

```html
<div class="xo-empty">
  <pre class="xo-empty__art" aria-hidden="true">┌───────┐
│ vide  │
└───────┘</pre>
  <p class="xo-empty__msg">Aucun élément.</p>
  <button class="xo-btn">Créer</button>
</div>
```

## Menu déroulant

```html
<details class="xo-dropdown">
  <summary class="xo-btn">Actions ▾</summary>
  <div class="xo-dropdown__menu" role="menu">
    <button class="xo-dropdown__item" role="menuitem">
      Rafraîchir <span class="xo-dropdown__key">r</span>
    </button>
    <div class="xo-dropdown__sep" role="separator"></div>
    <button class="xo-dropdown__item" role="menuitem" aria-disabled="true">Tuer</button>
  </div>
</details>
```

Bâti sur `<details>` : ouvre et ferme sans JS. Le module ajoute `Échap`, le clic extérieur
et la fermeture après un choix. `--right` sur le menu pour l'aligner à droite.

## Menu contextuel

```html
<ul class="xo-list" data-xo-list data-xo-menu="#menu-fil">
  <li class="xo-list__item" data-value="42" data-libelle="Ce que vise le menu">…</li>
</ul>

<div class="xo-menu" id="menu-fil" role="menu" hidden>
  <div class="xo-menu__titre"></div>
  <button class="xo-menu__item" role="menuitem" data-action="ouvrir">Ouvrir</button>
  <div class="xo-menu__sep" role="separator"></div>
  <button class="xo-menu__item" role="menuitem" data-action="suivre">Suivre</button>
</div>
```

Le clic droit sur un élément portant `data-value` ouvre le menu au curseur et émet
`xo:menu` sur le conteneur — `event.detail.{action, value, item}`. Le menu se rabat s'il
déborde du bas ou de la droite, et se ferme au clic extérieur, à `Échap` et au défilement.

Un seul menu sert toute la liste : `xo-menu__titre`, s'il est présent, reçoit le
`data-libelle` de la ligne visée (ou son texte). Le module ne décide d'aucune action.

## Recherche

```html
<label class="xo-search">
  <span class="xo-search__prefix" aria-hidden="true">/</span>
  <input type="search" placeholder="filtrer…" aria-label="Filtrer">
</label>
```

`xo-mark` pour surligner les correspondances dans les résultats.

## Métrique

```html
<div class="xo-stat">
  <span class="xo-stat__value">537</span>
  <span class="xo-stat__label">Tâches</span>
  <span class="xo-stat__delta xo-stat__delta--up">+12</span>
</div>
```

`--up` (vert) / `--down` (rouge) sur le delta ; sans modificateur il reste neutre.

## Progression

```html
<div class="xo-progress">
  <span class="xo-progress__label">archive</span>
  <div class="xo-progress__track" role="progressbar"
       aria-valuenow="64" aria-valuemin="0" aria-valuemax="100" aria-label="archive">
    <div class="xo-progress__fill" style="width: 64%"></div>
  </div>
  <span class="xo-progress__value">64%</span>
</div>

<span class="xo-spinner" aria-hidden="true"></span>
```

La barre est découpée en cellules d'un caractère (rendu `████░░░░`) par le CSS : rien à
générer côté serveur. `--success` `--warning` `--danger` changent la couleur du remplissage.
`xo-spinner` anime `▖▘▝▗`, figé sous `prefers-reduced-motion`.

## Journal

```html
<div class="xo-log" style="--xo-max-h: 12em">
  <div class="xo-log__line xo-log__line--warn">
    <span class="xo-log__time">14:01:02</span>
    <span class="xo-log__level">warn</span>
    <span class="xo-log__msg">Requête lente…</span>
  </div>
</div>
```

Niveaux : `--ok` `--info` `--warn` `--error`.

## Accordéon

```html
<details class="xo-accordion">
  <summary>Options avancées</summary>
  <div class="xo-accordion__body">…</div>
</details>
```

Chevron `▸`/`▾` automatique, aucun JS.

## Étiquettes

```html
<span class="xo-tag xo-tag--warning">
  non suivi <button class="xo-tag__remove" aria-label="Retirer">×</button>
</span>
```

`--accent` `--success` `--warning` `--danger`. Le bouton de retrait est facultatif.

## Fieldset

```html
<fieldset class="xo-fieldset">
  <legend>Connexion</legend>
  …
</fieldset>
```

La légende s'incruste dans la bordure, comme le titre d'un panneau — mais en natif.

## Palette de commandes

```html
<dialog class="xo-palette" id="palette" data-xo-palette aria-label="Palette">
  <label class="xo-search">
    <span class="xo-search__prefix" aria-hidden="true">&gt;</span>
    <input type="text" placeholder="Tapez une commande…" aria-label="Commande">
  </label>
  <ul class="xo-palette__list xo-list" data-xo-list role="listbox">
    <li class="xo-list__item" role="option" aria-selected="true" data-value="open">
      <span class="xo-palette__label">Ouvrir un fichier</span>
      <span class="xo-list__meta">Ctrl+O</span>
    </li>
  </ul>
  <p class="xo-palette__empty" hidden>Aucune commande ne correspond.</p>
  <div class="xo-keys"><span><kbd>↑↓</kbd> naviguer</span></div>
</dialog>
```

Sur ce site, la palette et l'aide sont émises par `xo_nav()` (voir `libs/site.php`) :
une seule ligne PHP par page suffit à obtenir la navigation complète.

`Ctrl+K` (ou `Cmd+K`) l'ouvre. La frappe filtre les lignes et surligne la correspondance ;
`↑↓` circulent dans les lignes **visibles** ; `Entrée` émet `xo:activate` et referme.
`xo-palette__label` est obligatoire sur le libellé : c'est là que le surlignage est inséré.
Pour naviguer, mettre un `<a href>` dans `xo-palette__label` : `Entrée` le clique, aucun JS
à écrire. Pour exécuter une commande, écouter `xo:activate` sur le dialogue
(`event.detail.value`).

## Aide des raccourcis

```html
<dialog class="xo-help" id="help" data-xo-help aria-label="Raccourcis">
  <p class="xo-help__title">Raccourcis</p>
  <dl class="xo-help__grid">
    <dt class="xo-help__group">Navigation</dt>
    <dt>↑ ↓</dt><dd>Déplacer la sélection</dd>
  </dl>
</dialog>
```

`?` l'ouvre — sauf pendant une saisie. `xo-help__group` occupe toute la largeur.

## Notifications

```html
<div class="xo-toasts">
  <div class="xo-toast xo-toast--success" role="status" data-xo-toast="4000">
    <span aria-hidden="true">✓</span>
    <span class="xo-toast__body"><span class="xo-toast__title">Enregistré.</span> 4 fichiers.</span>
    <button class="xo-toast__close" aria-label="Fermer">×</button>
  </div>
</div>
```

`data-xo-toast` = délai avant disparition en ms ; `0` ou absent = permanent.
Variantes : `--success` `--warning` `--danger`.

## Infobulle

```html
<span data-xo-tip="Dernier commit il y a 4 minutes" tabindex="0">survolez-moi</span>
```

Pur CSS, apparaît au survol **et** au focus clavier.

## Case, radio, curseur, fichier

```html
<label class="xo-check"><input type="checkbox" checked> Journal</label>
<label class="xo-radio"><input type="radio" name="env"> Recette</label>

<div class="xo-range">
  <input type="range" min="0" max="9" value="3" aria-label="Verbosité">
  <span class="xo-range__value">3</span>
</div>

<div class="xo-file"><input type="file" aria-label="Fichier"></div>
```

`xo-check` rend `[ ]` / `[x]`, `xo-radio` rend `( )` / `(•)`. La case native est masquée
mais reste la source de vérité — focus, état coché, soumission du formulaire. Aucun
élément à ajouter : le marqueur est un `::before` du label.
`xo-field--inline` met le label à gauche du champ.

## Colonne latérale, menus, pied

```html
<div class="xo-layout">
  <nav class="xo-sidebar" aria-label="Sections">
    <div class="xo-sidebar__group">Projet</div>
    <a class="xo-sidebar__link" href="#" aria-current="page">Vue d'ensemble</a>
  </nav>
  <main class="xo-main">…</main>
</div>

<div class="xo-menubar">
  <button class="xo-menubar__item"><span class="xo-menubar__key">F1</span>Aide</button>
</div>

<footer class="xo-footer"><span>XOSHUI 1.0</span></footer>
```

Sous 720 px, `xo-layout` passe en colonne : la barre latérale se place **au-dessus** du
contenu, en pleine largeur, plafonnée à `40vh` et défilable.

## Bannière, filet titré, avatar

```html
<div class="xo-banner">
  <pre class="xo-banner__art">…art ASCII…</pre>
  <p class="xo-banner__tagline">Sous-titre</p>
</div>

<div class="xo-rule">Section</div>          <!-- filet ─── Section ─── -->
<div class="xo-rule xo-rule--start">Section</div>  <!-- titre à gauche -->

<span class="xo-avatar">RL</span>
```

## Chronologie, étapes

```html
<ul class="xo-timeline">
  <li class="xo-timeline__item">
    <span class="xo-timeline__marker" aria-hidden="true">●</span>
    <div class="xo-timeline__body">
      <div>Dépôt initialisé</div>
      <div class="xo-timeline__time">14:00</div>
    </div>
  </li>
</ul>

<div class="xo-steps">
  <span class="xo-steps__step xo-steps__step--done">✓ Analyse</span>
  <span class="xo-steps__sep" aria-hidden="true">─►</span>
  <span class="xo-steps__step" aria-current="step">● Compilation</span>
</div>
```

## Graphe en barres, squelette, invite

```html
<div class="xo-bars">
  <span class="xo-bars__label">CSS</span>
  <span class="xo-bars__bar" aria-hidden="true">████████████████████</span>
  <span class="xo-bars__value">62%</span>
</div>

<span class="xo-skeleton" style="width: 32ch">&nbsp;</span>

<label class="xo-prompt">
  <span class="xo-prompt__sign" aria-hidden="true">$</span>
  <input type="text" aria-label="Commande">
</label>
<span class="xo-cursor" aria-hidden="true"></span>
```

La barre est du texte : `str_repeat('█', round($pct / 3))`. Trois éléments par ligne, la
grille aligne les colonnes.

## Séparateur redimensionnable

```html
<div class="xo-split" data-xo-split>
  <div class="xo-scroll">…gauche…</div>
  <button class="xo-split__handle" role="separator" aria-orientation="vertical"
          aria-label="Redimensionner" aria-valuenow="50" aria-valuemin="15" aria-valuemax="85"></button>
  <div class="xo-scroll">…droite…</div>
</div>
```

Glisser à la souris, ← → au clavier. La largeur vit dans `--xo-split` (15 % à 85 %).
Sous 720 px les deux volets s'empilent et la poignée disparaît — elle sort donc aussi du
parcours clavier.

## Éditeur

```html
<div class="xo-editor" style="--xo-max-h: 40vh">
  <div class="xo-editor__gutter" aria-hidden="true">  1
  2
  3</div>
  <textarea class="xo-editor__area" wrap="off" rows="3">…</textarea>
</div>
```

C'est le **conteneur** qui défile, pas la zone de saisie : sans quoi il faudrait
synchroniser deux défilements en JavaScript pour garder les numéros en face des lignes.
La zone doit donc être aussi haute que son contenu — `rows` = nombre de lignes — et
`wrap="off"` pour qu'une ligne reste une ligne.

Voir [layouts/editor.php](../layouts/editor.php) : la saisie reste une `<textarea>`, la
coloration se fait dans l'aperçu à côté.

## Texte de lecture

```html
<article class="xo-prose">
  <h1>Titre</h1>
  <p>Paragraphe…</p>
</article>
```

Seule zone du framework qui ne remplit pas l'écran : largeur plafonnée à `80ch`. Rétablit
les marges que le reset supprime, préfixe les titres de `##` / `###`, et style les listes,
citations, `code` et tableaux. À réserver au contenu rédigé — jamais à une interface.

## Icônes

```html
<span class="xo-icon" aria-hidden="true">▾</span>
```

`xo-icon` réserve une cellule et centre le glyphe : les colonnes restent alignées même
quand un élément n'a pas d'icône. **Prendre les glyphes dans [icons.php](../icons.php)** :
un caractère absent de JetBrains Mono est rendu par une police de secours, à une autre
chasse, et la ligne sort de la grille.

## États d'écran

```html
<div class="xo-state">
  <p class="xo-state__code">404</p>
  <p class="xo-state__title">Page introuvable</p>
  <p class="xo-state__msg">/layouts/tiroir.php n'existe pas.</p>
  <div class="xo-row"><a class="xo-btn xo-btn--primary" href="/">Accueil</a></div>
</div>
```

Occupe la vue ; `--xo-min-h` règle sa hauteur. `xo-empty` fait la même chose **dans un
panneau**. Un état répond toujours à trois questions : que s'est-il passé, est-ce ma faute,
que puis-je faire — le dernier point est le plus souvent oublié.

## Graphe temporel

Un `<pre>` de blocs, calculé côté serveur. Aucun canvas, aucune dépendance — comme
`xo-bars`, en deux dimensions. Une colonne par point, la rangée du bas remplie la
première, huit sous-niveaux par ligne (`▁▂▃▄▅▆▇█`).

| Classe | Rôle |
|---|---|
| `xo-plot` | Grille : échelle à gauche, tracé à droite |
| `xo-plot__scale` | Graduations, réparties sur la hauteur du tracé |
| `xo-plot__area` | Le `<pre>` — lui donner `role="img"` et un `aria-label` qui résume |
| `xo-plot__foot` | Bornes de l'axe du temps |
| `xo-plot--success` `--warning` `--danger` | Teinte du tracé |

L'échelle et le tracé partagent la rangée de grille : leurs hauteurs sont donc égales,
et `space-between` fait tomber les graduations en face des bonnes lignes.

```php
function xo_plot_rangees(array $valeurs, int $hauteur): array   // valeurs entre 0 et 1
{
    $blocs   = [' ', '▁', '▂', '▃', '▄', '▅', '▆', '▇', '█'];
    $rangees = array_fill(0, $hauteur, '');
    foreach ($valeurs as $v) {
        $rempli = max(0.0, min(1.0, $v)) * $hauteur;
        for ($r = 0; $r < $hauteur; $r++) {
            $part = max(0.0, min(1.0, $rempli - ($hauteur - 1 - $r)));
            $rangees[$r] .= $blocs[(int) round($part * 8)];
        }
    }
    return $rangees;
}
```

## Carte de chaleur

Une grille de caractères dont la **densité** porte la valeur (`·` `░` `▒` `▓` `█`) : elle
reste lisible en noir et blanc, et la couleur n'ajoute qu'un second signal.

| Classe | Rôle |
|---|---|
| `xo-heat` | Conteneur — `role="img"` et un `aria-label` qui résume la forme |
| `xo-heat__row` | Une rangée : libellé + cellules |
| `xo-heat__label` | Libellé de rangée, 4ch minimum, aligné à droite |
| `xo-heat__cells` | La suite de cellules — `white-space: pre` |
| `xo-heat__cell` + `--0` … `--4` | Une cellule et son niveau |
| `xo-heat--seuils` | La couleur double la densité (info → succès → avertissement → danger) |
| `xo-heat__foot` | La légende « moins ·░▒▓█ plus » |

Les cellules sont des caractères collés : **les émettre sans séparateur**, l'indentation
du gabarit deviendrait visible.

## Calendrier

La disposition de `cal` : sept colonnes de trois caractères, quantième aligné à droite,
troisième caractère laissé en gouttière. Les jours hors du mois sont **vides**, pas grisés.

| Classe | Rôle |
|---|---|
| `xo-cal` | Conteneur |
| `xo-cal__head` | Mois et navigation (deux `xo-btn--ghost`) |
| `xo-cal__month` | Le libellé du mois, centré |
| `xo-cal__grid` | Grille de 7 × 3ch. En poser deux : une pour les en-têtes, une pour les jours |
| `xo-cal__dow` | En-tête de colonne (`lu`, `ma`…) |
| `xo-cal__day` | Un jour — un `<button>` |
| `xo-cal__day--event` | Pastille `·` dans la gouttière, sans décaler le quantième |

États par attribut : `aria-selected="true"` (vidéo inverse), `aria-current="date"`
(aujourd'hui — accent souligné), `aria-disabled="true"`.

```html
<div class="xo-cal__grid" data-xo-list="grid" role="listbox" aria-label="Août 2026">
  <span aria-hidden="true"></span>          <!-- décalage du 1er du mois -->
  <button type="button" role="option" class="xo-cal__day" aria-selected="false">1</button>
</div>
```

`data-xo-list="grid"` donne la navigation à deux dimensions : ←→ d'une case, ↑↓ d'une
rangée. Le nombre de colonnes est lu dans `grid-template-columns`, donc juste même quand
la première rangée est incomplète. Le mode sert toute grille, pas seulement le calendrier.

## Mouvement

Quatre utilitaires, en CSS seul — aucun JS à écrire. Ils servent surtout aux deux modes,
où une sortie **arrive**, mais rien ne les y limite.

| Classe | Rôle |
|---|---|
| `xo-appear` + `--xo-i` | Apparition échelonnée : la ligne `--xo-i: 3` apparaît 270 ms après la première |
| `xo-type` + `--xo-n` | La saisie se tape ; `--xo-n` = le nombre de caractères du texte |
| `xo-progress--busy` | Attente sans progression connue : un bloc traverse le rail |
| `xo-flash` | Confirmation d'un geste : une pulsation, **une seule**. `--success` `--warning` `--danger` |

```html
<div class="xo-log__line xo-appear" style="--xo-i: 4">…</div>
<span class="xo-type" style="--xo-n: 34">xoshui deploy --cible xoshui.test</span>
<li class="xo-list__item xo-flash--success">retenu</li>
```

`xo-flash` bat au fond, jamais sur le texte : rien ne saute à la lecture pendant
l'animation. À retirer après `animationend` — une classe laissée en place ne rejouerait
pas, mais mentirait sur l'état.

## Teinte et atténuation

Deux utilitaires pour dire un état sans ajouter ni glyphe ni colonne.

| Classe | Rôle |
|---|---|
| `xo-tint--*` | Fond teinté à 14 % — `accent` `success` `warning` `danger` `faint` |
| `xo-fade` + `--xo-fade` | Opacité de 1 (net) à 0 (effacé) |

```html
<li class="xo-list__item xo-tint--accent">suivi</li>
<span class="xo-fade" style="--xo-fade: .6">il y a 2 h</span>
```

La teinte reste basse pour ne pas passer devant la sélection, qui demeure le repère fort ;
survol et sélection gardent la main sur une ligne teintée.

`xo-fade` ne va que sur du **décor** — heure, source, séparateur. Sur du texte utile, une
opacité basse retombe sous le contraste minimum, exactement comme `--xo-faint`.

Ce n'est pas la durée qui fait l'effet — elle est d'une milliseconde — mais le **retard**,
pendant lequel `animation-fill-mode: both` maintient l'état de départ. Un terminal n'a pas
de fondu : la ligne s'affiche d'un coup.

Une animation ne tourne pas dans un conteneur en `display: none` : dans un onglet, la
sortie **rejoue** donc à chaque ouverture. C'est voulu.

`prefers-reduced-motion` annule durée **et retard** : tout s'affiche d'emblée, rien ne
reste invisible en attendant son tour.

## Mode console

`xo-console` sur un conteneur : à l'intérieur, les composants passent en rendu plein
caractère. **Aucun balisage à changer** — mêmes classes, mêmes `data-xo-*`, même module.
Voir **[tui.php](../tui.php)**.

```html
<div class="xo-console">…</div>          <!-- un panneau, une section -->
<div class="xo-app xo-console">…</div>   <!-- un écran entier -->
```

| Ce qui change | Comment |
|---|---|
| Grille | Tout tombe sur la cellule `--xo-cell` (= `--xo-fs` × 1.5) ; les écarts se comptent en `ch` |
| `xo-btn` | `[ Valider ]`, inversé au survol et au focus. `--ghost` perd ses crochets |
| `xo-input` `xo-select` `xo-textarea` | Bloc de saisie sans cadre ; vidéo inverse au focus |
| `xo-list__item` | Sélection pleine largeur, précédée d'un `▸` hors flux |
| `xo-panel__title` | Interrompt le filet : `──┤ Titre ├──` |
| `xo-table` | En-tête en vidéo inverse, zébrage retiré |
| `xo-tabs__tab` | L'onglet actif devient une étiquette pleine |
| `xo-badge` | `[libellé]` ; `--solid` reste un aplat |
| `xo-statusbar` `xo-keys` | Une cellule de haut, sans retour à la ligne |
| `xo-bars` `xo-progress` | Rangées sur la cellule ; la jauge perd son cadre |
| `xo-spark` | Perd son resserrement : un caractère vaut une chasse pleine |
| `xo-range` | Rail d'une cellule, curseur d'un caractère |
| `xo-cal` | Hauteurs sur la cellule ; la disposition est déjà celle de `cal` |
| `xo-plot` `xo-heat` | Interligne sur la cellule ; ils sont déjà en caractères |

`xo-check` et `xo-radio` ne sont **pas** retraduits : le socle les dessine déjà en
caractères (§22). Y ajouter un marqueur en afficherait deux.

Le mode ne touche pas `--xo-pad` : une soixantaine de composants s'en servent et le mode
n'en retraduit qu'une vingtaine. Ceux qu'il ne couvre pas (navigation, palette, aide,
modales, notifications, colonne latérale) gardent donc leur rembourrage et restent
lisibles — c'est ce qui permet d'appliquer `xo-console` à une page entière.

## Mode CLI

`xo-cli` — même méthode, autre grammaire. Le mode console simule un **écran** ; le mode
CLI simule un **flux** : la sortie de `git status` ou de `npm install`, qui se lit de haut
en bas et qu'on ne pilote pas. Voir **[cli.php](../cli.php)**.

Trois différences portent tout le mode :

| | |
|---|---|
| **Aucune colonne** | `xo-grid` redevient un empilement, les `xo-col-*` n'ont plus d'effet |
| **Aucun cadre** | `xo-panel` perd sa bordure ; `xo-panel__title` sort du filet et devient une ligne `==> Titre` |
| **Aucun défilement interne** | `--xo-max-h` est neutralisé sur `xo-log`, `xo-panel__body` et `xo-table-wrap` |

| Ce qui change encore | Comment |
|---|---|
| Sélection | Plus de vidéo inverse : le marqueur de ligne passe de `-` à `*`, en gras |
| `xo-list--tree` | Garde ses guides, comme `npm ls` — pas de marqueur ajouté |
| `xo-table` | Colonnes alignées, aucun filet, aucun zébrage |
| `xo-btn` | Un mot précédé de `»`, en surbrillance au survol et au focus ; `--ghost` perd son préfixe |
| `xo-field` | Une invite sur une ligne : `? Branche main` |
| `xo-statusbar` `xo-keys` | Du texte muet, sans fond ni filet |

Mêmes réserves qu'en mode console : `xo-check` / `xo-radio` ne sont pas retraduits, et
`--xo-pad` n'est pas touché. Les deux modes sont exclusifs — poser les deux classes sur le
même conteneur donne un résultat indéfini.

Deux classes n'existent que pour ce mode :

| Classe | Rôle |
|---|---|
| `xo-list__guide` | Les branches d'un arbre écrites en caractères (`├─` `└─` `│  `) — seul le HTML sait quelle branche se poursuit. Se combine avec `--xo-depth: 0` |
| `xo-btn__key` | La lettre d'accès rapide, soulignée |

Le mode ne touche ni le HTML, ni les rôles ARIA, ni le JS. Un écran bascule en ajoutant
une classe, et revient en la retirant.

## Impression

Rien à faire : `@media print` est dans la feuille. Fond blanc, encre noire, chrome retiré
(nav, raccourcis, barre d'outils, onglets, colonne latérale), `<details>` dépliés, zones
défilantes déroulées, en-tête de tableau répété d'une page à l'autre, et l'URL ajoutée
derrière chaque lien de `xo-prose`. La sélection en vidéo inverse deviendrait un aplat noir :
elle passe en gras, précédée d'un chevron.

## Utilitaires

`xo-muted` `xo-faint` `xo-accent` `xo-success` `xo-warning` `xo-danger` `xo-info` `xo-special` `xo-alt`
`xo-bold` `xo-right` `xo-num` `xo-nowrap` `xo-scroll` `xo-sr` (masqué visuellement)

## Tokens

Couleurs : `--xo-bg` `--xo-panel` `--xo-subtle` `--xo-raise` · `--xo-fg` `--xo-muted`
`--xo-faint` `--xo-inverse` · `--xo-accent` `--xo-success` `--xo-warning` `--xo-danger`
`--xo-info` `--xo-special` `--xo-alt` · `--xo-border` `--xo-rule`
Autres : `--xo-font` `--xo-fs` `--xo-lh` `--xo-gap` (1ch) `--xo-pad` (8px)

Police : **JetBrains Mono**, auto-hébergée dans `libs/fonts/` (voir le README
qui s'y trouve), avec repli sur la pile monospace du système. Ligatures
désactivées. Aucune requête réseau.

**Jamais de hex en dur** : utiliser un token, ou en ajouter un.
`php tools/lint.php` le vérifie, ainsi que les arrondis, les ombres, les dégradés, les
ressources externes, les classes `xo-*` inexistantes et les `data-xo-*` non montés.
`--xo-faint` a un contraste < 4,5:1 — décor uniquement, jamais de texte utile.
