# XOSHUI

Bootstrap maison au look **TUI** : monospace, fond sombre, panneaux à bordure fine,
sélection en vidéo inverse. PHP / MySQL / JS vanilla — **aucun build, aucune dépendance,
aucune ressource externe**.

Servi par Laragon depuis `D:\laragon\www\XOSHUI` → http://xoshui.test

## Utilisation

```html
<link rel="stylesheet" href="/libs/css/xoshui.css">
<script type="module" src="/libs/js/xoshui.js"></script>
```

**[docs/api.md](docs/api.md)** — l'aide-mémoire des classes. À lire avant d'écrire du HTML.
**[demo.php](demo.php)** — toutes les classes sur une page.
**[layouts/](layouts/)** — des pages entières à copier. Y aller **avant** d'assembler des
composants un à un : c'est le chemin le plus court vers un écran correct.

## Fichiers

| Chemin | Rôle |
|---|---|
| `libs/css/xoshui.css` | Feuille unique : tokens + reset + composants |
| `libs/js/xoshui.js` | Module unique : clavier, onglets, modale, palette, aide |
| `docs/api.md` | Aide-mémoire des classes |
| `docs/charte-graphique.md` | Référence design (palette, grammaire, a11y) — consultation, pas lecture par défaut |
| `demo.php` | Page de démonstration : chaque classe isolée |
| `layouts/` | Recettes : des pages entières à copier |
| `index.php` | Page d'accueil |
| `moodboard/` | Références visuelles (archives) |

## Règles

- **Aucun hex en dur.** Utiliser un token `--xo-*`, ou en ajouter un dans `xoshui.css`.
- Préfixe de classe unique `xo-`, en BEM (`xo-panel__title`, `xo-btn--danger`).
- Les états ayant un équivalent ARIA sont ciblés par attribut (`[aria-selected="true"]`),
  pas par classe.
- `border-radius: 0`, aucune ombre, aucun dégradé. Monospace partout.
- Comportements déclarés en HTML (`data-xo-list`, `data-xo-tabs`, `data-xo-open`,
  `data-xo-palette`, `data-xo-help`, `data-xo-split`, `data-xo-toast`, `data-xo-tip`) —
  pas d'appel JS à écrire.
- Tout navigable au clavier, focus toujours visible. `xo-keys` en bas de chaque écran.
- `--xo-faint` a un contraste < 4,5:1 : décor uniquement, jamais de texte utile.
- PHP : `declare(strict_types=1)`, PDO + requêtes préparées, `htmlspecialchars` en sortie.
