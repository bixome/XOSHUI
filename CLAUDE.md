# XOSHUI

Bootstrap maison au look **TUI** : monospace, fond sombre, panneaux à bordure fine,
sélection en vidéo inverse. PHP / MySQL / JS vanilla — **aucun build, aucune dépendance,
aucune ressource externe**.

Servi par Laragon (**nginx**, pas Apache) depuis `D:\laragon\www\XOSHUI` → http://xoshui.test

## Utilisation

```html
<link rel="stylesheet" href="/libs/css/xoshui.css">
<script type="module" src="/libs/js/xoshui.js"></script>
```

**[docs/api.md](docs/api.md)** — l'aide-mémoire des classes. À lire avant d'écrire du HTML.
**[demo.php](demo.php)** — toutes les classes sur une page.
**[layouts/](layouts/)** — des pages entières à copier. Y aller **avant** d'assembler des
composants un à un : c'est le chemin le plus court vers un écran correct.
**[components/](components/)** — un composant isolé, ses variantes et sa source, quand il
faut comprendre un comportement précis.

## Fichiers

| Chemin | Rôle |
|---|---|
| `libs/css/xoshui.css` | Feuille unique : tokens + reset + composants |
| `libs/fonts/` | JetBrains Mono auto-hébergée — voir le README du dossier |
| `libs/js/xoshui.js` | Module unique : clavier, onglets, modale, palette, aide |
| `libs/site.php` | Navigation du site : `xo_nav($slug)` émet barre, sous-barre, palette et aide |
| `docs.php` | Lecture des documents dans le framework (liste blanche XO_DOCS) |
| `docs/api.md` | Aide-mémoire des classes |
| `docs/charte-graphique.md` | Référence design (palette, grammaire, a11y) — consultation, pas lecture par défaut |
| `demo.php` | L'écran de contrôle : les 213 classes en une page, sans commentaire |
| `foundations.php` | Tokens lus dans `xoshui.css`, contrastes calculés |
| `icons.php` | Pack de glyphes — n'en utiliser aucun qui n'y figure |
| `favicon.svg` | Seul fichier où des couleurs sont écrites hors de `xoshui.css` |
| `layouts/` | Recettes : des pages entières à copier |
| `components/` | Un composant par page, isolé, avec sa source |
| `modals/` | Boîtes de message : confirmation, invite, progression, tiroir |
| `libs/specimen.php` | Socle des catalogues : un exemple rendu **et** montré en source |
| `index.php` | Page d'accueil |
| `tools/lint.php` | Vérifie les règles ci-dessous — `php tools/lint.php` |
| `docs/deploiement.md` | Ce qui ne doit pas être servi (nginx / Apache) |
| `moodboard/` | Références visuelles (archives) |

## Règles

Elles sont vérifiées automatiquement : `php tools/lint.php` (sortie 1 s'il reste une
erreur, `/tools/lint.php` pour la même analyse en navigateur). Une ligne portant
`xo-lint-ignore` est exclue de l'analyse.

- **Aucun hex en dur.** Utiliser un token `--xo-*`, ou en ajouter un dans `xoshui.css`.
- Préfixe de classe unique `xo-`, en BEM (`xo-panel__title`, `xo-btn--danger`).
- Les états ayant un équivalent ARIA sont ciblés par attribut (`[aria-selected="true"]`),
  pas par classe.
- `border-radius: 0`, aucune ombre, aucun dégradé. Monospace partout.
- Les glyphes viennent de `icons.php`. Un caractère absent de la police sort de la grille.
- Comportements déclarés en HTML (`data-xo-list`, `data-xo-tabs`, `data-xo-open`,
  `data-xo-palette`, `data-xo-help`, `data-xo-split`, `data-xo-toast`, `data-xo-tip`,
  `data-xo-key`, `data-xo-guard`) — pas d'appel JS à écrire.
- Tout navigable au clavier, focus toujours visible. `xo-keys` en bas de chaque écran.
- `--xo-faint` a un contraste < 4,5:1 : décor uniquement, jamais de texte utile.
- PHP : `declare(strict_types=1)`, PDO + requêtes préparées, `htmlspecialchars` en sortie.
