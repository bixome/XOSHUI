<?php
declare(strict_types=1);
require __DIR__ . '/../libs/specimen.php';

xo_specimen_debut('etats', 'Ce qu’affiche un écran quand il n’a rien à montrer. Trois questions à chaque fois : que s’est-il passé, est-ce ma faute, que puis-je faire ? Un état qui ne répond pas à la troisième est une impasse.');

xo_specimen('Chargement', <<<'HTML'
<div class="xo-state" style="--xo-min-h: 16em">
  <span class="xo-spinner" aria-hidden="true"></span>
  <p class="xo-state__title">Chargement du tableau de bord…</p>
  <p class="xo-state__msg">Interrogation de 4 services.</p>
</div>
HTML, 'Sous une seconde, ne rien montrer : un indicateur qui clignote une demi-seconde donne l’impression d’une panne, pas d’une attente.');

xo_specimen('Chargement de la structure', <<<'HTML'
<div class="xo-stack xo-stack--tight" style="padding: 8px 1ch">
  <span class="xo-skeleton" style="width: 24ch">&nbsp;</span>
  <span class="xo-skeleton" style="width: 40ch">&nbsp;</span>
  <span class="xo-skeleton" style="width: 36ch">&nbsp;</span>
  <span class="xo-skeleton" style="width: 18ch">&nbsp;</span>
</div>
HTML, 'Quand la forme du contenu est connue d’avance, le squelette vaut mieux qu’un indicateur : la page ne saute pas au moment où les données arrivent.');

xo_specimen('Premier usage', <<<'HTML'
<div class="xo-state" style="--xo-min-h: 18em">
  <pre class="xo-state__art" aria-hidden="true">┌─────────────────┐
│                 │
│   rien encore   │
│                 │
└─────────────────┘</pre>
  <p class="xo-state__title">Aucun projet</p>
  <p class="xo-state__msg">
    Un projet regroupe vos écrans, vos données et vos accès. Créez le premier pour commencer.
  </p>
  <div class="xo-row">
    <button class="xo-btn xo-btn--primary">Créer un projet</button>
    <button class="xo-btn">Importer</button>
  </div>
</div>
HTML, 'Le vide de départ n’est pas une erreur : c’est le premier écran que verra l’utilisateur. Il explique à quoi sert la chose et propose l’action qui la remplit.');

xo_specimen('Aucun résultat', <<<'HTML'
<div class="xo-state" style="--xo-min-h: 14em">
  <p class="xo-state__title">Aucune commande ne correspond</p>
  <p class="xo-state__msg">
    Filtre : <code>client = « Dupont »</code> · <code>30 derniers jours</code>
  </p>
  <div class="xo-row">
    <button class="xo-btn xo-btn--primary">Effacer les filtres</button>
    <button class="xo-btn">Élargir à 90 jours</button>
  </div>
</div>
HTML, 'À distinguer du vide de départ : ici il y a des données, c’est le filtre qui ne trouve rien. L’écran rappelle donc le filtre appliqué et propose de le relâcher.');

xo_specimen('Introuvable', <<<'HTML'
<div class="xo-state" style="--xo-min-h: 16em">
  <p class="xo-state__code">404</p>
  <p class="xo-state__title">Page introuvable</p>
  <p class="xo-state__msg">
    <code>/layouts/tiroir.php</code> n’existe pas, ou n’existe plus.
  </p>
  <div class="xo-row">
    <a class="xo-btn xo-btn--primary" href="/">Accueil</a>
    <button class="xo-btn"><kbd>Ctrl+K</kbd> chercher une page</button>
  </div>
</div>
HTML, 'Rappeler le chemin demandé : neuf fois sur dix, l’utilisateur y verra sa propre faute de frappe.');

xo_specimen('Erreur serveur', <<<'HTML'
<div class="xo-state" style="--xo-min-h: 18em">
  <p class="xo-state__code xo-danger">500</p>
  <p class="xo-state__title">L’application n’a pas pu répondre</p>
  <p class="xo-state__msg">
    L’incident est enregistré. Si vous nous écrivez, donnez cet identifiant.
  </p>
  <p><code>err-4f21c8</code></p>
  <div class="xo-row">
    <button class="xo-btn xo-btn--primary">Réessayer</button>
    <a class="xo-btn" href="/">Accueil</a>
  </div>
</div>
HTML, 'Un identifiant de trace, jamais la trace elle-même : elle nomme des fichiers, des versions et parfois des identifiants de connexion.');

xo_specimen('Accès refusé', <<<'HTML'
<div class="xo-state" style="--xo-min-h: 16em">
  <p class="xo-state__code">403</p>
  <p class="xo-state__title">Accès refusé</p>
  <p class="xo-state__msg">
    Votre compte <code>romain</code> n’a pas le droit <code>ventes:lire</code>.
    Un administrateur peut vous l’accorder.
  </p>
  <div class="xo-row">
    <button class="xo-btn xo-btn--primary">Demander l’accès</button>
    <a class="xo-btn" href="/">Retour</a>
  </div>
</div>
HTML, 'Nommer le droit manquant : « accès refusé » seul oblige l’utilisateur à deviner ce qu’il doit demander.');

xo_specimen('Hors-ligne', <<<'HTML'
<div class="xo-alert xo-alert--warning" role="status">
  <span aria-hidden="true">▲</span>
  <span class="xo-alert__body">
    <span class="xo-alert__title">Hors-ligne.</span>
    Affichage des données de 09:32. Les modifications sont mises en attente.
  </span>
  <button class="xo-btn">Réessayer</button>
</div>
HTML, 'Le hors-ligne ne vide pas l’écran : il le date. Un bandeau persistant vaut mieux qu’une page blanche, tant qu’on dit clairement de quand datent les données.');

xo_specimen_fin([
    'xo-state'        => 'l’état occupe la vue ; --xo-min-h règle sa hauteur',
    'xo-state__code'  => 'le code HTTP, en grand',
    'xo-state__art'   => 'cadre ASCII',
    'xo-state__title' => 'ce qui s’est passé, en une phrase',
    'xo-state__msg'   => 'le détail, 60 caractères de large au plus',
    'xo-empty'        => 'le même dans un panneau, pas dans la page',
    'xo-skeleton'     => 'réserve la place du contenu attendu',
]);
