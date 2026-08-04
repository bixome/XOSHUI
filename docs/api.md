# XOSHUI — aide-mémoire

```html
<link rel="stylesheet" href="/libs/css/xoshui.css">
<script type="module" src="/libs/js/xoshui.js"></script>
```

Tout est en monospace, sans arrondi, sans ombre. La sélection est une barre en vidéo
inverse. Voir [demo.php](../demo.php) pour un exemple complet de chaque classe.

## Mise en page

| Classe | Rôle |
|---|---|
| `xo-app` | Colonne pleine hauteur (statusbar / main / keys) |
| `xo-main` | Zone centrale, remplit l'espace |
| `xo-grid` + `xo-col-{2,3,4,5,6,8,9,12}` | Grille 12 colonnes ; pleine largeur < 720px |
| `xo-row` | Flex horizontal, gouttière `1ch` |
| `xo-stack` | Flex vertical, gouttière `8px` |
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

## Liste

```html
<ul class="xo-list" data-xo-list role="listbox">
  <li class="xo-list__item" role="option" aria-selected="true" data-value="x">
    <span class="xo-list__icon" aria-hidden="true">⎇</span>
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

`xo-btn` · `--primary` · `--danger` · `--ghost` · `[disabled]`
Transparent au repos, plein au survol et au focus.

## Formulaire

`xo-field` (bloc label + champ) · `xo-label` · `xo-input` · `xo-select` · `xo-textarea` ·
`xo-check` · `xo-help` · `xo-error`
Erreur : `aria-invalid="true"` sur le champ + `<span class="xo-error">`.

## Barres

```html
<div class="xo-statusbar"><span class="xo-statusbar__label">CPU:</span> 29%</div>
<div class="xo-keys"><span><kbd>↑↓</kbd> naviguer</span></div>
```

`xo-keys` va en bas de chaque écran : c'est ce qui rend l'interface auto-documentée.

## Indicateurs

```html
<span class="xo-badge xo-badge--success">✓ OK</span>

<div class="xo-gauge xo-gauge--warning">
  <div class="xo-gauge__track" role="meter" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100">
    <div class="xo-gauge__fill" style="width:78%"></div>
  </div>
  <span class="xo-gauge__value">78%</span>
</div>

<span class="xo-spark">▁▂▃▅▇█▆▄</span>
```

Badge : `--success` `--warning` `--danger` `--info`. `--solid` se **combine** avec une
variante : `class="xo-badge xo-badge--solid xo-badge--danger"`.
Jauge : `--warning` ≥ 70 %, `--danger` ≥ 90 %. Toujours afficher la valeur à côté.

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
`xo-spinner` anime `⣾⣽⣻⢿⡿⣟⣯⣷`, figé sous `prefers-reduced-motion`.

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

## Utilitaires

`xo-muted` `xo-faint` `xo-success` `xo-warning` `xo-danger` `xo-info` `xo-special` `xo-alt`
`xo-bold` `xo-right` `xo-num` `xo-nowrap` `xo-scroll` `xo-sr` (masqué visuellement)

## Tokens

Couleurs : `--xo-bg` `--xo-panel` `--xo-subtle` `--xo-raise` · `--xo-fg` `--xo-muted`
`--xo-faint` `--xo-inverse` · `--xo-accent` `--xo-success` `--xo-warning` `--xo-danger`
`--xo-info` `--xo-special` `--xo-alt` · `--xo-border` `--xo-rule`
Autres : `--xo-font` `--xo-fs` `--xo-lh` `--xo-gap` (1ch) `--xo-pad` (8px)

**Jamais de hex en dur** : utiliser un token, ou en ajouter un.
`--xo-faint` a un contraste < 4,5:1 — décor uniquement, jamais de texte utile.
