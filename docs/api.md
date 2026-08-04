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
