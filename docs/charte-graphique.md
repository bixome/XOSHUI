# XOSHUI — Charte graphique

> **Version** 2.0 · **Date** 04/08/2026
> **Statut** : source de vérité du design. Remplace la v1.1 (`moodboard/charte-graphique-…md`),
> conservée comme archive.
> **Périmètre** : framework de design réutilisable, PHP / MySQL / JS vanilla, sans build.

---

## 1. Ce que dit réellement le moodboard

10 références analysées (bpytop/zenith, bagels, SuperFile, nnn, Catppuccin TUI kit,
lazygit ×2, un TUI SQL, un dashboard termbox, Claude Code).

### 1.1 Le constat qui change tout

La v1.1 décrivait un **BIOS phosphore** : `#00FF00` sur `#000000`. **Ce n'est pas ce que
montrent les images.** 7 références sur 10 sont des **TUI modernes** :

- fond **bleu-nuit désaturé** (`#1E1E2E`, `#1A1B26`, `#232323`) — jamais du noir pur ;
- palette **16 couleurs pastel** (mauve, teal, pêche, rose, bleu ciel) et non un vert unique ;
- couleur **porteuse de sens** (statut git, type de fichier, sévérité), jamais décorative.

Les 3 références restantes (lazygit sur fond noir, démo termbox) sont du **ANSI saturé
rétro**. Elles ne définissent pas le défaut : elles définissent un **second thème**.

> **Décision AD** : le thème par défaut est `mocha` (TUI moderne). Le look BIOS/phosphore
> devient le thème `phosphor`, optionnel. Un seul jeu de tokens, deux jeux de valeurs.
> Aucun composant ne connaît le thème.

### 1.2 La grammaire commune (invariante, tous thèmes confondus)

C'est elle, plus que la couleur, qui fait « TUI ». Sept règles :

| # | Règle | Traduction technique |
|---|---|---|
| 1 | Tout vit sur une **grille de caractères** | unités `ch` en horizontal, `line-height` fixe en vertical |
| 2 | Les panneaux sont des **boîtes tracées en 1 trait** | `border: 1px solid`, **jamais** d'ombre ni de dégradé |
| 3 | Le **titre est incrusté dans la bordure haute**, à gauche | `legend` / pseudo-élément posé sur la bordure |
| 4 | Le panneau **actif** se signale par la **couleur de sa bordure** ; les autres sont éteints | 2 tokens : `--xo-border` / `--xo-border-active` |
| 5 | La sélection est une **barre pleine largeur en vidéo inverse**, pas un contour | `background` + `color` inversés, `outline: none` |
| 6 | Compteurs et méta sont **incrustés dans la bordure basse**, à droite (`1 of 5`) | même mécanisme que le titre |
| 7 | Une **barre de raccourcis** ferme toujours l'écran (`q: quit  ↑↓: navigate`) | composant `keyhints` obligatoire sur chaque vue |

### 1.3 Ambiance

Dense, calme, informative. Pas de décor. Pas d'animation au-delà du curseur.
Le seul « effet » toléré est le passage en vidéo inverse.

---

## 2. Couleur

### 2.1 Modèle à deux couches

**Ne jamais écrire un hex dans un composant.** Un composant ne consomme que des tokens
sémantiques ; seuls les thèmes définissent des primitives.

```
primitives  --xo-c-mauve, --xo-c-base …   ← définis par le thème, jamais utilisés directement
     ↓
sémantiques --xo-accent, --xo-bg-panel …  ← seule couche autorisée dans les composants
```

### 2.2 Thème `mocha` (défaut)

**Surfaces**

| Token sémantique | Valeur | Rôle |
|---|---|---|
| `--xo-bg` | `#1E1E2E` | fond de l'application |
| `--xo-bg-panel` | `#181825` | intérieur des panneaux (légèrement plus sombre = creusé) |
| `--xo-bg-raise` | `#313244` | modale, barre de statut, onglet actif |
| `--xo-bg-subtle` | `#252537` | ligne paire de tableau, survol |
| `--xo-bg-inverse` | `#1E1E2E` | texte posé **sur** une sélection |

**Texte** — contrastes calculés, et vérifiables sur [foundations.php](../foundations.php).

| Token | Valeur | Contraste /`--xo-bg` | Usage |
|---|---|---|---|
| `--xo-fg` | `#CDD6F4` | 11,34:1 | texte principal |
| `--xo-fg-muted` | `#A6ADC8` | 7,37:1 | labels, méta, colonnes secondaires |
| `--xo-fg-faint` | `#6C7086` | 3,36:1 | **décor uniquement** — bordures, filets, glyphes désactivés. Sous 4,5:1 : interdit pour du texte porteur d'information |
| `--xo-fg-inverse` | `#1E1E2E` | — | texte sur fond accent |

**Accents sémantiques** — chacun a **un** sens, à ne pas détourner.

| Token | Valeur | Sens imposé |
|---|---|---|
| `--xo-accent` | `#89B4FA` (bleu) | focus, panneau actif, sélection, lien |
| `--xo-success` | `#A6E3A1` (vert) | validé, ajouté, connecté |
| `--xo-warning` | `#F9E2AF` (jaune) | attention, modifié, non suivi |
| `--xo-danger` | `#F38BA8` (rouge) | erreur, supprimé, destructif |
| `--xo-info` | `#94E2D5` (teal) | information, chemin, en cours |
| `--xo-special` | `#CBA6F7` (mauve) | identifiant, hash, mot-clé |
| `--xo-alt` | `#FAB387` (pêche) | catégorisation secondaire, nombre |

**Bordures**

| Token | Valeur | Usage |
|---|---|---|
| `--xo-border` | `#45475A` | panneau au repos |
| `--xo-border-active` | `#89B4FA` | panneau focalisé |
| `--xo-rule` | `#313244` | filet interne, séparateur de ligne |

### 2.3 Thème `phosphor` (rétro ANSI, opt-in)

Mêmes tokens, valeurs saturées. `data-theme="phosphor"`.

| Token | Valeur |
|---|---|
| `--xo-bg` / `--xo-bg-panel` | `#000000` |
| `--xo-bg-raise` / `--xo-bg-subtle` | `#001100` / `#000C00` |
| `--xo-fg` / `--xo-fg-muted` / `--xo-fg-faint` | `#00FF00` / `#00C000` / `#007700` |
| `--xo-accent` | `#00FF00` |
| `--xo-success` / `--xo-warning` / `--xo-danger` | `#00FF00` / `#FFFF00` / `#FF0000` |
| `--xo-info` / `--xo-special` / `--xo-alt` | `#00FFFF` / `#FF00FF` / `#FFAA00` |
| `--xo-border` / `--xo-border-active` | `#008800` / `#00FF00` |

### 2.4 Règles d'usage

1. La couleur **ne porte jamais seule** une information : toujours doublée d'un glyphe,
   d'un préfixe ou d'une position (`M `, `??`, `+`, `-`, `✓`).
2. Maximum **4 accents visibles simultanément** dans une même vue.
3. Le rouge et le vert n'apparaissent jamais **côte à côte** comme seul différenciateur
   (deutéranopie) — le diff utilise en plus les préfixes `+` / `-`.
4. Aucune couleur hors tokens. Un besoin non couvert = ajout d'un token sémantique, pas
   d'un hex local.

---

## 3. Typographie

Une seule famille : **JetBrains Mono**, auto-hébergée dans `libs/fonts/`, avec repli sur
la pile monospace du système. Pas de police proportionnelle, jamais de CDN.

> La v1.1 chargeait `Consolas` depuis Google Fonts : **cette police n'y existe pas**.
> Le chargement échouait silencieusement. La règle est donc devenue absolue :
> **aucune ressource réseau**, polices comprises — le linter le vérifie.

```css
--xo-font: "JetBrains Mono", ui-monospace, "Cascadia Mono", Consolas,
           "DejaVu Sans Mono", "Courier New", monospace;
```

Ligatures désactivées : aucun terminal ne fusionne `!=` ou `->`.

**Tout glyphe décoratif doit exister dans la police.** Absent, il est rendu par une police
de secours à une autre chasse, et la ligne sort de la grille. Le pack vérifié — 67 glyphes,
6 groupes — est dans `icons.php` : ne rien prendre en dehors sans avoir mesuré sa largeur
contre celle de `M`. Écartés faute de chasse : le braille (`⣾`), `⎇`, les étoiles (`★ ☆`),
les cœurs, les touches Mac et l'ensemble des emoji.

### 3.1 Échelle

| Token | Taille | Line-height | Usage |
|---|---|---|---|
| `--xo-fs-xs` | `11px` | 1.2 | barre de raccourcis, compteurs incrustés |
| `--xo-fs-sm` | `12px` | 1.3 | tableaux denses, méta |
| `--xo-fs-md` | `14px` | **1.35** | **défaut** — corps, listes, formulaires |
| `--xo-fs-lg` | `16px` | 1.25 | titre de panneau, en-tête d'écran |
| `--xo-fs-xl` | `20px` | 1.2 | titre d'application (rare, 1 par écran) |

`1.35` plutôt que le `1.2` de la v1.1 : à 14px, `1.2` (16,8px) rend les listes illisibles
en usage prolongé. `1.2` reste réservé aux blocs `pre` et à l'art ASCII, où l'alignement
vertical prime.

### 3.2 Graisses

Deux seulement : `400` (normal) et `700` (titre de panneau, ligne sélectionnée, clé de
raccourci). **Pas d'italique** — irrégulier en monospace, et culturellement absent des TUI.

### 3.3 Casse

Titres de panneau en **Capitale initiale** (`Local Branches`), pas en majuscules —
conforme au moodboard. Les majuscules sont réservées aux badges d'état (`NORMAL`, `READY`).

---

## 4. Grille, espacement, densité

### 4.1 Deux axes, deux unités

- **Horizontal** : `ch` (largeur d'un caractère). Une gouttière de `1ch` correspond à une
  colonne du terminal. C'est ce qui donne l'alignement caractère.
- **Vertical** : multiples de `4px`, alignés sur la hauteur de cellule.

| Token | Valeur | Usage |
|---|---|---|
| `--xo-sp-0` | `0` | collé |
| `--xo-sp-1` | `2px` | interligne d'un badge |
| `--xo-sp-2` | `4px` | padding vertical d'une ligne de liste / cellule |
| `--xo-sp-3` | `8px` | padding vertical d'un panneau, écart entre panneaux |
| `--xo-sp-4` | `12px` | respiration d'une section |
| `--xo-sp-5` | `16px` | marge d'écran |
| `--xo-gutter` | `1ch` | padding horizontal universel |
| `--xo-gutter-2` | `2ch` | indentation d'un niveau d'arbre |

### 4.2 Formes

| Token | Valeur | Note |
|---|---|---|
| `--xo-bw` | `1px` | **seule** épaisseur de bordure du système |
| `--xo-radius` | `0` | **aucun arrondi**, sans exception |
| `--xo-shadow` | `none` | aucune ombre — la profondeur passe par la teinte de surface |

### 4.3 Layout

| Token | Valeur |
|---|---|
| `--xo-header-h` | `40px` (en-tête d'écran, 1 ligne + bordure) |
| `--xo-statusbar-h` | `24px` |
| `--xo-max-w` | `none` — un TUI occupe **tout** le viewport |

La v1.1 imposait `max-width: 1200px`. Contradictoire avec toutes les références : elles
remplissent l'écran et répartissent en colonnes. La largeur max ne s'applique qu'aux vues
de **lecture** (documentation), via la classe utilitaire `.xo-prose`.

---

## 5. Composants

Préfixe de classe unique : **`xo-`**. Modificateurs suffixés (`xo-panel--active`), états
en attribut (`aria-selected`, `data-state`) plutôt qu'en classe quand la sémantique existe.

### 5.1 Panneau — `xo-panel`

L'atome du système. Titre incrusté à gauche dans la bordure haute, compteur incrusté à
droite dans la bordure basse.

```html
<section class="xo-panel xo-panel--active">
  <h2 class="xo-panel__title">Local Branches</h2>
  <div class="xo-panel__body">…</div>
  <span class="xo-panel__count">1 of 11</span>
</section>
```

- Bordure `--xo-border`, passant à `--xo-border-active` quand le panneau contient le focus
  (`:focus-within`).
- Le titre est un texte sur fond `--xo-bg` qui **chevauche** la bordure (`transform:
  translateY(-50%)`), reproduisant la coupure du trait ASCII.
- Le titre prend la couleur de bordure active quand le panneau est actif.

### 5.2 Liste / menu — `xo-list`

- Un `<ul role="listbox">`, items `role="option"`.
- Item sélectionné : `aria-selected="true"` → **vidéo inverse pleine largeur**
  (`background: var(--xo-accent)`, `color: var(--xo-fg-inverse)`).
- Survol : `--xo-bg-subtle` seulement. Le survol ne doit **jamais** ressembler à la sélection.
- Un seul `tabindex="0"` sur le conteneur ; les items ne sont pas tabbables (pattern
  *roving focus* — la navigation se fait aux flèches, cf. §7).
- Arbre : indentation par `--xo-gutter-2`, chevrons `▸`/`▾`, `role="tree"`.

### 5.3 Onglets — `xo-tabs`

Horizontaux, filet de séparation sous la barre. Onglet actif = fond `--xo-bg-raise` et
texte `--xo-fg` ; inactifs en `--xo-fg-muted`. Numérotation `[1]`…`[5]` optionnelle mais
recommandée : elle documente le raccourci clavier correspondant.

### 5.4 Tableau — `xo-table`

- En-tête : fond `--xo-bg-raise`, texte `--xo-fg-muted`, **une seule ligne**, non wrappé.
- Lignes paires `--xo-bg-subtle` — le zébrage est ce qui rend une table dense lisible.
- Colonnes numériques alignées à droite ; le reste à gauche. Pas de centrage.
- Colonne de tri marquée par `↓`/`↑` **collé** au libellé (`↓CPU%`).
- Ligne sélectionnée : vidéo inverse sur toute la largeur, en priorité sur le zébrage.
- Débordement horizontal : `overflow-x: auto` sur le wrapper, **jamais** de wrap de cellule.

### 5.5 Formulaire — `xo-form`

- Label **au-dessus** du champ, en `--xo-fg-muted`.
- Champ : fond `--xo-bg-panel`, bordure `--xo-border`, texte `--xo-fg`.
- `:focus` : bordure `--xo-accent` **et** `outline: 1px solid var(--xo-accent)` avec
  `outline-offset: -2px` — la bordure seule ne suffit pas en accessibilité.
- Curseur de saisie émulé optionnel : bloc `▉` clignotant, désactivé sous
  `prefers-reduced-motion`.
- Bouton : bordure 1px, fond transparent au repos, **vidéo inverse au survol/focus**.
  Les variantes reprennent les tokens sémantiques (`--xo-danger` pour destructif).
  Pas de bouton plein par défaut : le remplissage signale l'interaction, pas l'état de repos.

### 5.6 Barre de statut — `xo-statusbar`

Fond `--xo-bg-raise`, hauteur fixe, segments `label: valeur` séparés par des gouttières.
Le label est en `--xo-fg-muted`, la valeur en `--xo-fg` ou en couleur sémantique selon le
seuil. Badge de mode (`NORMAL`, `INSERT`) en vidéo inverse à gauche.

### 5.7 Barre de raccourcis — `xo-keys`

**Obligatoire en pied de chaque vue.** Format : `touche: action` séparés par ` | `.
La touche en `700` + `--xo-accent`, l'action en `--xo-fg-muted`. C'est le composant qui
rend l'interface auto-documentée — il n'y a pas de découvrabilité à la souris dans un TUI.

### 5.8 Modale — `xo-dialog`

`<dialog>` natif. Fond `--xo-bg-raise`, bordure `--xo-border-active`, titre incrusté comme
un panneau. Pas de flou d'arrière-plan (coûteux, hors ambiance) : un simple voile
`rgba(0,0,0,.5)`. Focus piégé, `Esc` ferme, focus restitué à l'ouvrant.

### 5.9 Jauge & sparkline — `xo-gauge`, `xo-spark`

- Jauge : barre pleine en caractères `█`/`░` **ou** en `<div>` de largeur `%`. Couleur par
  seuil : `--xo-success` < 70 % ≤ `--xo-warning` < 90 % ≤ `--xo-danger`. Valeur numérique
  **toujours** affichée à côté (la couleur ne porte pas seule).
- Sparkline : `▁▂▃▄▅▆▇█` en texte. Aucun canvas, aucune dépendance.

### 5.10 Diff — `xo-diff`

Ligne ajoutée : fond `--xo-c-diff-add` (vert très sombre) + préfixe `+`.
Ligne retirée : fond `--xo-c-diff-del` (rouge très sombre) + préfixe `-`.
Numéros de ligne en `--xo-fg-faint`, non sélectionnables (`user-select: none`).

### 5.11 Badge de statut — `xo-badge`

Un ou deux caractères, en tête de ligne, colonne fixe : `M` (modifié, warning),
`??` (non suivi, faint), `✓` (ok, success), `▲` (attention), `●` (actif).
Toujours suivi d'un `title`/`aria-label` explicite.

---

## 6. États

| État | Signal visuel | Ne jamais utiliser |
|---|---|---|
| repos | `--xo-fg` sur `--xo-bg-panel` | — |
| survol | fond `--xo-bg-subtle` | la vidéo inverse |
| focus (clavier) | `outline: 1px solid var(--xo-accent)`, `outline-offset: -2px` | `outline: none` seul |
| sélectionné | vidéo inverse pleine largeur | une simple couleur de texte |
| actif (panneau) | bordure + titre en `--xo-accent` | un fond différent |
| désactivé | `--xo-fg-faint`, `cursor: not-allowed` | l'opacité (rend le texte illisible) |
| erreur | bordure + message `--xo-danger`, préfixe `!` | la couleur seule |

Sélection et focus sont **deux choses distinctes** : dans une liste, le conteneur a le
focus, l'item a la sélection. Ne pas les fusionner.

---

## 7. Clavier — non négociable

Le clavier est le mode d'interaction **primaire**, la souris est l'accessoire inverse de
l'usage web habituel.

| Touche | Action |
|---|---|
| `↑` `↓` / `k` `j` | déplacer la sélection dans la liste active |
| `←` `→` / `h` `l` | changer de panneau, replier/déplier un nœud |
| `Tab` / `Maj+Tab` | passer au panneau suivant / précédent |
| `1`…`9` | sauter directement au panneau numéroté |
| `Entrée` | activer la sélection |
| `Esc` | fermer / annuler / remonter d'un niveau |
| `/` | filtrer la liste active |
| `?` | afficher l'aide des raccourcis |
| `q` | quitter la vue |

Règles d'implémentation :

1. **Roving tabindex** : un seul élément tabbable par groupe ; les flèches déplacent
   `tabindex="0"` et appellent `focus()`.
2. Tout raccourci utilisé est déclaré dans `xo-keys`. Un raccourci non affiché n'existe pas.
3. Ne jamais intercepter `Tab` pour autre chose que la navigation entre panneaux.
4. La sélection reste **visible** au scroll (`scrollIntoView({ block: 'nearest' })`).
5. Tout ce qui est atteignable au clavier est atteignable à la souris, et réciproquement.

---

## 8. Mouvement

| Élément | Durée | Note |
|---|---|---|
| changement de sélection | `0ms` | instantané — c'est ce qui donne la sensation « terminal » |
| ouverture de modale | `80ms` opacité | pas de translation, pas d'échelle |
| curseur de saisie | `1000ms` steps(2) | clignotement carré, jamais de fondu |

```css
@media (prefers-reduced-motion: reduce) { *, *::before, *::after {
  animation-duration: .01ms !important; transition-duration: .01ms !important; } }
```

Interdits : parallaxe, fondu au scroll, skeleton animé, spinner tournant.
Le chargement s'exprime en texte : `[ ▖ ] loading…` ou `[####----] 50%`.

---

## 8 bis. Impression

Le papier n'a ni focus, ni survol, ni défilement. On garde la grammaire — monospace,
filets d'un trait, titres incrustés — et on retire ce qui n'existe que parce qu'un écran
est interactif : barres de navigation et de raccourcis, onglets, colonne latérale.

- Fond blanc, encre noire. Les accents deviennent des gris ; là où la couleur portait du
  sens, c'est le gras qui prend le relais.
- La sélection en vidéo inverse deviendrait un aplat noir : gras et chevron `>`.
- Tout ce qui était replié ou défilant est déroulé — le papier ne défile pas.
- `break-inside: avoid` sur les panneaux et les lignes ; en-tête de tableau répété.
- Les liens de `xo-prose` sont suivis de leur URL, sauf les ancres.

## 9. Responsive

Les TUI supposent une grille large. Stratégie en 3 paliers :

| Palier | Largeur | Comportement |
|---|---|---|
| `wide` | ≥ 1200px | multi-colonnes, tous les panneaux visibles |
| `narrow` | 720–1199px | colonnes empilées 2 → 1, panneaux secondaires repliés |
| `mobile` | < 720px | **un panneau à la fois**, navigation par onglets ; `--xo-fs` → 12px ; `xo-keys` réduit aux 3 actions principales |

Ne pas tenter de conserver une grille de 80 colonnes sur mobile : il faut ~640px pour
80 caractères à 12px. Passer en flux vertical est la seule option honnête.

---

## 10. Accessibilité

- **Contraste** : tout texte porteur d'information ≥ 4,5:1. `--xo-fg-faint` (≈3,1:1) est
  réservé au décor. Vérifié pour `mocha` ; à revérifier à chaque nouveau thème.
- **Cible tactile** : ligne de liste ≥ 32px de haut en palier `mobile`.
- **Sémantique** : `role="listbox"/"option"`, `role="tree"/"treeitem"`,
  `aria-selected`, `aria-expanded`, `aria-current`. Ne pas se contenter de `<div>`.
- **Focus visible** : jamais supprimé. `:focus-visible` pour ne pas le montrer au clic souris.
- **Vidéo inverse** : penser à inverser aussi les couleurs sémantiques à l'intérieur d'une
  ligne sélectionnée (un `--xo-danger` sur fond `--xo-accent` devient illisible → forcer
  `color: var(--xo-fg-inverse)` sur toute la ligne sélectionnée).
- **Zoom 200 %** : aucune perte de contenu (pas de hauteur fixe sur les zones de texte).
- **Lecteur d'écran** : les glyphes décoratifs (`▸`, `█`, `─`) portent `aria-hidden="true"`.

---

## 11. Implémentation

Tout tient dans deux fichiers : `libs/css/xoshui.css` (tokens + reset + composants) et
`libs/js/xoshui.js` (clavier, onglets, modale, thème). Les classes et les hooks `data-xo-*`
sont listés dans **[api.md](api.md)** — c'est le document à consulter pour écrire du HTML ;
celui-ci ne sert qu'à comprendre *pourquoi* le système est ainsi.

Les noms de tokens diffèrent légèrement de ceux cités plus haut : la version livrée est
plate (`--xo-panel`, `--xo-muted`, `--xo-faint`) plutôt qu'à deux couches, la séparation
primitives/sémantiques ne se justifiant plus dans un fichier unique. `api.md` fait foi.

### Règles

1. **Aucun hex en dur.** Besoin non couvert ⇒ nouveau token dans `xoshui.css`.
2. Un composant lit des tokens, expose des classes `xo-*` et des attributs ARIA — il ne
   connaît ni le thème, ni son parent.
3. JS en modules ES, aucune dépendance, aucun global. Les comportements se déclarent en
   HTML (`data-xo-list`, `data-xo-tabs`, `data-xo-open`, `data-xo-theme`).
4. Le HTML reste **fonctionnel sans JS** ; le JS n'ajoute que le confort clavier.
5. PHP : `declare(strict_types=1)`, PDO + requêtes préparées, échappement systématique en
   sortie (`htmlspecialchars(..., ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')`).
6. Le thème vit dans `document.documentElement.dataset.theme`, persisté en `localStorage`,
   relu par un `<script>` inline en `<head>` pour éviter le flash au chargement.

### Checklist de revue

- [ ] Aucun hex hors `xoshui.css`
- [ ] `border-radius: 0`, aucune ombre
- [ ] Titre de panneau incrusté, compteur incrusté
- [ ] Sélection en vidéo inverse pleine largeur (penser à `xo-panel--flush`)
- [ ] `xo-keys` présent et à jour
- [ ] Navigable entièrement au clavier, focus toujours visible
- [ ] Rôles ARIA posés, glyphes décoratifs masqués
- [ ] Rendu vérifié dans les deux thèmes
- [ ] Contraste ≥ 4,5:1 sur tout texte informatif
- [ ] Testé aux 3 paliers responsive

---

## 12. Journal

| Version | Date | Changement |
|---|---|---|
| 1.1 | 04/08/2026 | Charte initiale, hypothèse « BIOS vert » |
| 2.0 | 04/08/2026 | Analyse du moodboard : bascule sur TUI moderne (`mocha`) par défaut, BIOS relégué au thème `phosphor`. Stack monospace système (suppression de Google Fonts). `line-height` 1.35. Suppression du `max-width` global. Ajout : grammaire structurelle, modèle clavier, états, mouvement, responsive, a11y. |
| 2.1 | 04/08/2026 | Recentrage « bootstrap maison » : deux fichiers au lieu d'une arborescence de composants, tokens à plat, `api.md` devient la porte d'entrée. Abandon de la couche de composants PHP. |
