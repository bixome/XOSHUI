# Squelettes de page

Le point de départ d'un écran vierge : la structure que toutes les pages du projet
répètent (doctype, `<head>`, `xo-app`, `xo-main`, `xo-keys`, module JS), et rien d'autre.

| Fichier | Quand |
|---|---|
| [page.php](page.php) | Une page **dans** le site : `xo_nav()` fournit barre, sous-barre, palette Ctrl+K et aide |
| [page-nue.php](page-nue.php) | Une page **hors** du site : aucune dépendance à `libs/site.php`, seulement la feuille et le module |

Copier, renommer, remplir `<main>`. Les deux fichiers s'ouvrent tels quels dans le
navigateur — ce sont des pages valides, pas des fragments.

Pour un écran complet plutôt qu'une page vierge, aller d'abord dans [`layouts/`](../layouts/) :
tableau de bord, maître-détail, table, explorateur, formulaire, console, éditeur,
article, connexion.
