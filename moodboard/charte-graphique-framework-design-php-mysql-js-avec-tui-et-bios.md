# Charte Graphique - Framework Design (PHP/MySQL/JS) avec TUI et BIOS

> **Version** : 1.1  
> **Date** : 04/08/2026  
> **Auteur** : Romain Lamboley (avec assistance IA)  
> **Description** : Charte graphique complète pour un framework réutilisable en PHP/MySQL/JS (vanilla), incluant des styles inspirés des **interfaces TUI (Text User Interface)** et des **écrans BIOS/UEFI**.

---

## 📌 **Table des Matières**
1. [Analyse des Inspirations Visuelles](#1-analyse-des-inspirations-visuelles)
2. [Palette de Couleurs](#2-palette-de-couleurs)
3. [Typographie](#3-typographie)
4. [Espacement et Disposition](#4-espacement-et-disposition)
5. [Composants UI Réutilisables](#5-composants-ui-réutilisables)
6. [Styles Spécifiques pour TUI et BIOS](#6-styles-spécifiques-pour-tui-et-bios)
7. [Exemple de Structure HTML](#7-exemple-de-structure-html)
8. [Bonnes Pratiques pour les Développeurs](#8-bonnes-pratiques-pour-les-développeurs)
9. [Exemple de Code JavaScript](#9-exemple-de-code-javascript)
10. [Ressources Complémentaires](#10-ressources-complémentaires)

---

## 1. Analyse des Inspirations Visuelles

Les images partagées montrent des interfaces utilisateur avec les caractéristiques suivantes :

### **Thèmes Communs**
- **Couleurs dominantes** : Noirs profonds, gris anthracite, et accents en vert, jaune, orange, et bleu.
- **Typographie** : Polices monospace pour le code, sans-serif pour les interfaces.
- **Éléments UI** : Bordures fines, ombres légères, boutons plats, barres de progression colorées.
- **Disposition** : Grilles flexibles, espacement cohérent, panneaux avec bordures arrondies.
- **Ambiance** : Cyberpunk/Neon (noirs + couleurs vives) et minimaliste.

### **Composants Clés**
- **Éditeurs de code** : Fond noir, syntaxe colorée.
- **Terminaux** : Fond noir, texte vert ou blanc.
- **Tableaux** : En-têtes gris foncé, lignes alternées.
- **Graphiques** : Couleurs vives sur fond sombre.

### **Inspirations TUI et BIOS**
Les images incluent également des **interfaces en mode texte (TUI)** et des **écrans BIOS/UEFI**, qui ont les caractéristiques suivantes :
- **Couleurs limitées** : Principalement du texte vert (#4CAF50) ou blanc (#FFFFFF) sur fond noir (#000000).
- **Polices monospace** : Utilisation exclusive de polices comme `Consolas`, `Courier New`, ou `Fira Code`.
- **Disposition en blocs** : Organisation en sections claires, avec des bordures en ASCII ou des lignes simples.
- **Éléments interactifs** : Surbrillance (reverse video) pour les éléments sélectionnés.
- **Statuts et informations système** : Affichage de données techniques (ex: température CPU, utilisation mémoire).

---

## 2. Palette de Couleurs

### **Palette Générale**
<mui:table-metadata title="Palette de Couleurs Générale" />

| **Nom**               | **Code Hex** | **Utilisation**                          | **Exemple**                          |
|-----------------------|--------------|-----------------------------------------|--------------------------------------|
| Noir                  | `#000000`    | Arrière-plan des éditeurs de code       | Fond du terminal                     |
| Gris très foncé       | `#121212`    | Arrière-plan principal                 | Fond de l'interface                 |
| Gris foncé            | `#1E1E1E`    | Panneaux, en-têtes                     | Fond des panneaux latéraux           |
| Gris moyen            | `#2D2D2D`    | Lignes alternées dans les tableaux      | Lignes paires des tableaux           |
| Gris clair            | `#444444`    | Bordures, texte secondaire              | Bordures des sections               |
| Vert accent           | `#4CAF50`    | Boutons "Valider", barres de progression | Bouton "Enregistrer"                 |
| Vert clair            | `#8BC34A`    | Survol des boutons verts               | Bouton "Valider" au survol           |
| Jaune                 | `#FFC107`    | Avertissements, badges                  | Badge "Nouveau"                      |
| Orange                | `#FF9800`    | Statuts "Attention"                     | Barre de progression à 80%           |
| Bleu                  | `#2196F3`    | Liens, éléments interactifs             | Lien "Modifier"                       |
| Rouge                 | `#F44336`    | Boutons "Supprimer", erreurs            | Bouton "Supprimer"                  |
| Blanc                 | `#FFFFFF`    | Texte principal                        | Texte dans les panneaux             |
| Gris texte            | `#CCCCCC`    | Texte secondaire                       | Description des éléments             |

### **Palette Spécifique pour TUI et BIOS**
<mui:table-metadata title="Palette de Couleurs pour TUI et BIOS" />

| **Nom**               | **Code Hex** | **Utilisation**                          | **Exemple**                          |
|-----------------------|--------------|-----------------------------------------|--------------------------------------|
| Noir                  | `#000000`    | Fond de l'interface TUI/BIOS           | Fond de l'écran                      |
| Vert BIOS             | `#00FF00`    | Texte principal dans les TUI/BIOS       | Texte des menus BIOS                 |
| Vert clair            | `#4CAF50`    | Texte secondaire ou surbrillance       | Élément sélectionné                  |
| Gris BIOS             | `#AAAAAA`    | Texte désactivé ou informations secondaires | Options non sélectionnables |
| Blanc                 | `#FFFFFF`    | Texte alternatif (si pas de vert)      | Texte dans certains TUI              |
| Rouge BIOS            | `#FF0000`    | Erreurs ou avertissements critiques    | Messages d'erreur                    |

---

## 3. Typographie

### **Typographie Générale**
<mui:table-metadata title="Typographie Générale" />

| **Type**          | **Police**          | **Taille** | **Poids** | **Couleur**       | **Utilisation**                     |
|-------------------|---------------------|------------|-----------|-------------------|-------------------------------------|
| Titre principal   | `Roboto`            | 24px       | Bold      | `#FFFFFF`         | Titres des sections                |
| Titre secondaire  | `Roboto`            | 18px       | Semi-Bold | `#CCCCCC`         | Sous-titres                        |
| Texte principal   | `Roboto`            | 14px       | Regular   | `#FFFFFF`         | Contenu principal                  |
| Texte secondaire  | `Roboto`            | 12px       | Regular   | `#CCCCCC`         | Descriptions, labels                |
| Code              | `Fira Code`         | 12px       | Regular   | `#4CAF50` (strings), `#FF9800` (mots-clés), `#CCCCCC` (texte) | Éditeurs de code |
| Terminal          | `Consolas`          | 14px       | Regular   | `#4CAF50`         | Sortie du terminal                 |

### **Typographie pour TUI et BIOS**
<mui:table-metadata title="Typographie pour TUI et BIOS" />

| **Type**          | **Police**          | **Taille** | **Poids** | **Couleur**       | **Utilisation**                     |
|-------------------|---------------------|------------|-----------|-------------------|-------------------------------------|
| Texte TUI/BIOS    | `Consolas` ou `Courier New` | 14px-16px | Regular   | `#00FF00` ou `#FFFFFF` | Texte principal dans les TUI/BIOS |
| Titre TUI/BIOS    | `Consolas` ou `Courier New` | 16px-18px | Bold      | `#00FF00`         | Titres ou en-têtes                  |
| Texte désactivé   | `Consolas` ou `Courier New` | 14px       | Regular   | `#AAAAAA`         | Options non disponibles             |

> **Note** : Pour un look authentique BIOS/TUI, utilisez une police **monospace** avec un espacement fixe. Exemple d'intégration :
> ```html
> <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Fira+Code&family=Consolas&display=swap" rel="stylesheet">
> ```

---

## 4. Espacement et Disposition

### **Espacement Général**
<mui:table-metadata title="Espacement Général" />

| **Éléments**               | **Valeur**       | **Description**                          |
|----------------------------|------------------|------------------------------------------|
| Marge externe (margin)     | `8px`            | Entre les éléments (boutons, panneaux)   |
| Marge interne (padding)    | `12px`           | À l'intérieur des panneaux               |
| Bordure (border)           | `1px solid #444444` | Séparation des sections              |
| Rayon des bordures         | `4px`            | Coins arrondis pour les panneaux         |
| Largeur max des panneaux   | `1200px`         | Largeur maximale pour les contenus       |
| Hauteur des en-têtes       | `40px`           | Hauteur des barres de titre              |

### **Espacement pour TUI et BIOS**
<mui:table-metadata title="Espacement pour TUI et BIOS" />

| **Éléments**               | **Valeur**       | **Description**                          |
|----------------------------|------------------|------------------------------------------|
| Espacement entre lignes    | `1.2`            | `line-height` pour le texte TUI/BIOS     |
| Marge interne des blocs    | `4px-8px`        | Espacement à l'intérieur des sections TUI |
| Bordure des blocs          | `1px solid #00FF00` | Bordures vertes pour les sections TUI |

---

## 5. Composants UI Réutilisables

### **A. Boutons**
```css
/* Bouton principal (vert) */
.btn-primary {
  background-color: #4CAF50;
  color: #FFFFFF;
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  font-family: 'Roboto', sans-serif;
  font-size: 14px;
  cursor: pointer;
  transition: background-color 0.3s;
}
.btn-primary:hover {
  background-color: #8BC34A;
}

/* Bouton secondaire (gris) */
.btn-secondary {
  background-color: #444444;
  color: #FFFFFF;
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  font-family: 'Roboto', sans-serif;
  font-size: 14px;
  cursor: pointer;
}
.btn-secondary:hover {
  background-color: #555555;
}

/* Bouton dangereux (rouge) */
.btn-danger {
  background-color: #F44336;
  color: #FFFFFF;
  border: none;
  padding: 8px 16px;
  border-radius: 4px;
  font-family: 'Roboto', sans-serif;
  font-size: 14px;
  cursor: pointer;
}
.btn-danger:hover {
  background-color: #E53935;
}
```

### **B. Panneaux**
```css
.panel {
  background-color: #1E1E1E;
  border: 1px solid #444444;
  border-radius: 4px;
  padding: 12px;
  margin-bottom: 8px;
  font-family: 'Roboto', sans-serif;
}

.panel-header {
  color: #CCCCCC;
  font-size: 18px;
  font-weight: 500;
  margin-bottom: 8px;
  padding-bottom: 8px;
  border-bottom: 1px solid #444444;
}
```

### **C. Éditeur de Code**
```css
.code-editor {
  background-color: #000000;
  color: #CCCCCC;
  font-family: 'Fira Code', monospace;
  font-size: 12px;
  line-height: 1.5;
  padding: 12px;
  border-radius: 4px;
  overflow-x: auto;
}

/* Syntaxe colorée */
.code-keyword { color: #FF9800; }
.code-string { color: #4CAF50; }
.code-comment { color: #666666; }
.code-function { color: #2196F3; }
```

### **D. Terminal**
```css
.terminal {
  background-color: #000000;
  color: #4CAF50;
  font-family: 'Consolas', monospace;
  font-size: 14px;
  line-height: 1.5;
  padding: 12px;
  border-radius: 4px;
  overflow-x: auto;
  white-space: pre;
}
```

---

## 6. Styles Spécifiques pour TUI et BIOS

### **A. Style BIOS/TUI de Base**
```css
/* Conteneur principal pour les interfaces TUI/BIOS */
.tui-container {
  background-color: #000000;
  color: #00FF00;
  font-family: 'Consolas', monospace;
  font-size: 14px;
  line-height: 1.2;
  padding: 16px;
  border: 1px solid #00FF00;
  border-radius: 0; /* Pas de bordures arrondies pour un look authentique */
  overflow: hidden;
  white-space: pre;
}

/* Titre ou en-tête dans les TUI/BIOS */
.tui-header {
  color: #00FF00;
  font-size: 18px;
  font-weight: bold;
  margin-bottom: 8px;
  border-bottom: 1px solid #00FF00;
  padding-bottom: 4px;
}

/* Texte désactivé ou secondaire */
.tui-disabled {
  color: #AAAAAA;
}

/* Élément sélectionné (surbrillance) */
.tui-selected {
  background-color: #00FF00;
  color: #000000;
  padding: 2px 4px;
}

/* Lignes de séparation dans les TUI */
.tui-divider {
  border: none;
  border-top: 1px solid #00FF00;
  margin: 8px 0;
}
```

### **B. Tableaux TUI/BIOS**
```css
/* Tableau pour les interfaces TUI/BIOS */
.tui-table {
  width: 100%;
  border-collapse: collapse;
  font-family: 'Consolas', monospace;
  font-size: 14px;
  color: #00FF00;
}

.tui-table th {
  text-align: left;
  padding: 4px 8px;
  border-bottom: 1px solid #00FF00;
}

.tui-table td {
  padding: 4px 8px;
  border-bottom: 1px solid #003300; /* Vert très foncé pour les lignes */
}

.tui-table tr:nth-child(even) {
  background-color: #001100; /* Fond légèrement vert pour les lignes paires */
}

.tui-table tr:hover {
  background-color: #002200; /* Surbrillance au survol */
}
```

### **C. Barres de Statut TUI/BIOS**
```css
/* Barre de statut pour les informations système */
.tui-status-bar {
  background-color: #001100;
  color: #00FF00;
  font-family: 'Consolas', monospace;
  font-size: 12px;
  padding: 4px 8px;
  border-top: 1px solid #00FF00;
  display: flex;
  justify-content: space-between;
}

/* Élément de statut (ex: température, mémoire) */
.tui-status-item {
  margin: 0 8px;
}

.tui-status-item label {
  color: #AAAAAA;
  margin-right: 4px;
}

.tui-status-item value {
  color: #00FF00;
}
```

### **D. Menus TUI/BIOS**
```css
/* Menu vertical pour les interfaces TUI/BIOS */
.tui-menu {
  list-style: none;
  padding: 0;
  margin: 0;
  font-family: 'Consolas', monospace;
  font-size: 14px;
}

.tui-menu li {
  padding: 4px 8px;
  cursor: pointer;
}

.tui-menu li:hover {
  background-color: #002200;
}

.tui-menu li.selected {
  background-color: #00FF00;
  color: #000000;
}

/* Menu horizontal (pour les onglets) */
.tui-tabs {
  display: flex;
  list-style: none;
  padding: 0;
  margin: 0;
  border-bottom: 1px solid #00FF00;
}

.tui-tabs li {
  padding: 4px 16px;
  cursor: pointer;
}

.tui-tabs li:hover {
  background-color: #002200;
}

.tui-tabs li.selected {
  background-color: #00FF00;
  color: #000000;
  border-bottom: 1px solid #000000;
}
```

### **E. Formulaires TUI/BIOS**
```css
/* Champ de formulaire pour les TUI/BIOS */
.tui-form {
  font-family: 'Consolas', monospace;
  font-size: 14px;
  color: #00FF00;
}

.tui-form label {
  display: block;
  margin-bottom: 4px;
}

.tui-form input {
  background-color: #000000;
  color: #00FF00;
  border: 1px solid #00FF00;
  padding: 4px 8px;
  font-family: 'Consolas', monospace;
  font-size: 14px;
  width: 100%;
}

.tui-form input:focus {
  outline: none;
  border-color: #4CAF50;
}

/* Bouton de formulaire */
.tui-form button {
  background-color: #002200;
  color: #00FF00;
  border: 1px solid #00FF00;
  padding: 4px 16px;
  font-family: 'Consolas', monospace;
  font-size: 14px;
  cursor: pointer;
}

.tui-form button:hover {
  background-color: #00FF00;
  color: #000000;
}
```

---

## 7. Exemple de Structure HTML

### **A. Exemple Général**
```html
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Framework Design</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Fira+Code&family=Consolas&display=swap" rel="stylesheet">
  <style>
    /* Insérer les styles CSS ci-dessus ici */
    body {
      background-color: #121212;
      color: #FFFFFF;
      font-family: 'Roboto', sans-serif;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 16px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="panel">
      <div class="panel-header">Éditeur de Code</div>
      <div class="code-editor">
        <span class="code-keyword">function</span> <span class="code-function">test</span>() {
          <span class="code-comment">// Exemple de code</span>
          <span class="code-string">"Hello World"</span>;
        }
      </div>
    </div>

    <div class="panel">
      <div class="panel-header">Terminal</div>
      <div class="terminal">
        $ ls -la<br>
        total 24<br>
        drwxr-xr-x  2 user user 4096 Jan 1 00:00 .
      </div>
    </div>

    <button class="btn-primary">Enregistrer</button>
    <button class="btn-secondary">Annuler</button>
    <button class="btn-danger">Supprimer</button>
  </div>
</body>
</html>
```

### **B. Exemple Spécifique pour TUI/BIOS**
```html
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Interface TUI/BIOS</title>
  <link href="https://fonts.googleapis.com/css2?family=Consolas&display=swap" rel="stylesheet">
  <style>
    /* Insérer les styles TUI/BIOS ici */
    body {
      background-color: #000000;
      color: #00FF00;
      font-family: 'Consolas', monospace;
      margin: 0;
      padding: 0;
    }
    
    .tui-container {
      padding: 16px;
    }
    
    .tui-header {
      margin-bottom: 16px;
    }
    
    .tui-menu {
      margin-bottom: 16px;
    }
    
    .tui-menu li.selected {
      background-color: #00FF00;
      color: #000000;
    }
  </style>
</head>
<body>
  <div class="tui-container">
    <div class="tui-header">Framework System - v03.05</div>
    
    <ul class="tui-menu">
      <li class="selected">Main</li>
      <li>Advanced</li>
      <li>Boot</li>
      <li>Security</li>
      <li>Exit</li>
    </ul>

    <div class="tui-divider"></div>

    <div class="tui-status-bar">
      <div class="tui-status-item">
        <span class="label">CPU:</span>
        <span class="value">29%</span>
      </div>
      <div class="tui-status-item">
        <span class="label">TEMP:</span>
        <span class="value">149°C</span>
      </div>
      <div class="tui-status-item">
        <span class="label">MEM:</span>
        <span class="value">17.07GB / 17.18GB</span>
      </div>
    </div>

    <table class="tui-table">
      <thead>
        <tr>
          <th>PID</th>
          <th>USER</th>
          <th>CPU%</th>
          <th>MEM%</th>
          <th>CMD</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>58406</td>
          <td>benjamin</td>
          <td>41.0</td>
          <td>0.9</td>
          <td>zoom.us</td>
        </tr>
        <tr>
          <td>400</td>
          <td>benjamin</td>
          <td>7.5</td>
          <td>1.2</td>
          <td>Finder</td>
        </tr>
      </tbody>
    </table>

    <form class="tui-form">
      <label for="command">Command:</label>
      <input type="text" id="command" name="command" value="">
      <button type="submit">Execute</button>
    </form>
  </div>
</body>
</html>
```

---

## 8. Bonnes Pratiques pour les Développeurs

### **A. Nommage des Classes**
- Utilisez des noms **descriptifs** (ex: `tui-menu`, `tui-status-bar`).
- Pour les TUI/BIOS, préférez des noms courts et clairs (ex: `header`, `menu`, `status`).

### **B. Accessibilité**
- **Contraste** : Assurez-vous que le texte vert (#00FF00) sur fond noir (#000000) a un ratio ≥ **4.5:1** (c'est le cas ici).
- **Navigation au clavier** : Les interfaces TUI/BIOS doivent être entièrement navigables avec le clavier. Utilisez `tabindex` pour les éléments interactifs.
  ```html
  <div class="tui-menu" tabindex="0">
    <li tabindex="0">Main</li>
    <li tabindex="0">Advanced</li>
  </div>
  ```

### **C. Responsive Design**
- Les interfaces TUI/BIOS sont souvent utilisées sur des écrans de taille fixe, mais prévoyez des adaptations pour les mobiles :
  ```css
  @media (max-width: 600px) {
    .tui-container {
      font-size: 12px;
    }
    .tui-menu li {
      padding: 2px 4px;
    }
  }
  ```

### **D. Performances**
- **Évitez les animations lourdes** : Les interfaces TUI/BIOS doivent être rapides et réactives.
- **Utilisez des polices système** : Pour un look authentique, utilisez des polices monospace déjà installées sur le système (ex: `Consolas`, `Courier New`).

### **E. Thème Sombre/Clair**
- Pour les TUI/BIOS, le thème sombre est souvent la seule option, mais vous pouvez ajouter un thème clair pour les utilisateurs qui préfèrent :
  ```css
  .tui-container.light-theme {
    background-color: #FFFFFF;
    color: #000000;
  }
  
  .tui-container.light-theme .tui-selected {
    background-color: #0000FF;
    color: #FFFFFF;
  }
  ```

---

## 9. Exemple de Code JavaScript

### **A. Navigation dans un Menu TUI**
```javascript
// Sélectionner les éléments du menu TUI
const menuItems = document.querySelectorAll('.tui-menu li');
let selectedIndex = 0;

// Mettre en surbrillance l'élément sélectionné
function highlightSelected() {
  menuItems.forEach((item, index) => {
    if (index === selectedIndex) {
      item.classList.add('selected');
    } else {
      item.classList.remove('selected');
    }
  });
}

// Gérer la navigation avec les flèches du clavier
document.addEventListener('keydown', (event) => {
  if (event.key === 'ArrowDown') {
    selectedIndex = (selectedIndex + 1) % menuItems.length;
    highlightSelected();
  } else if (event.key === 'ArrowUp') {
    selectedIndex = (selectedIndex - 1 + menuItems.length) % menuItems.length;
    highlightSelected();
  } else if (event.key === 'Enter') {
    // Exécuter l'action associée à l'élément sélectionné
    menuItems[selectedIndex].click();
  }
});

// Initialiser la surbrillance
highlightSelected();
```

### **B. Mise à Jour Dynamique des Statuts**
```javascript
// Mettre à jour les informations de statut (ex: CPU, mémoire)
function updateStatus() {
  const cpuPercent = Math.floor(Math.random() * 100);
  const tempCelsius = Math.floor(Math.random() * 100) + 50;
  const memUsed = (Math.random() * 16 + 1).toFixed(2);
  const memTotal = 17.18;

  document.querySelector('.tui-status-item:nth-child(1) .value').textContent = `${cpuPercent}%`;
  document.querySelector('.tui-status-item:nth-child(2) .value').textContent = `${tempCelsius}°C`;
  document.querySelector('.tui-status-item:nth-child(3) .value').textContent = `${memUsed}GB / ${memTotal}GB`;
}

// Mettre à jour les statuts toutes les 2 secondes
setInterval(updateStatus, 2000);
```

### **C. Gestion des Onglets TUI**
```javascript
// Sélectionner les onglets et les contenus associés
const tabs = document.querySelectorAll('.tui-tabs li');
const tabContents = document.querySelectorAll('.tui-tab-content');

// Changer d'onglet au clic
tabs.forEach((tab, index) => {
  tab.addEventListener('click', () => {
    // Retirer la classe 'selected' de tous les onglets et contenus
    tabs.forEach(t => t.classList.remove('selected'));
    tabContents.forEach(c => c.classList.remove('active'));

    // Ajouter la classe 'selected' à l'onglet cliqué
    tab.classList.add('selected');

    // Afficher le contenu correspondant
    tabContents[index].classList.add('active');
  });
});
```

---

## 10. Ressources Complémentaires

### **A. Polices**
- [Google Fonts - Roboto](https://fonts.google.com/specimen/Roboto)
- [Google Fonts - Fira Code](https://fonts.google.com/specimen/Fira+Code)
- [Google Fonts - Consolas](https://fonts.google.com/specimen/Consolas) (alternative : `Courier New`)

### **B. Couleurs**
- **Outil de test de contraste** : [WebAIM Contrast Checker](https://webaim.org/resources/contrastchecker/)
- **Générateur de palettes** : [Coolors](https://coolors.co/)

### **C. Icônes**
- [Font Awesome](https://fontawesome.com/) (gratuite pour un usage basique)
- [Material Icons](https://material.io/resources/icons/) (Google)

### **D. Bibliothèques pour les TUI en JavaScript**
- [Blessed](https://github.com/chjj/blessed) : Bibliothèque pour créer des interfaces TUI en Node.js.
- [Ink](https://github.com/vadimdemes/ink) : Bibliothèque React pour les interfaces TUI.
- [Ncurses](https://www.gnu.org/software/ncurses/) : Bibliothèque C pour les TUI (inspiration pour les styles).

### **E. Outils de Développement**
- **Éditeurs de code** : [VS Code](https://code.visualstudio.com/), [Sublime Text](https://www.sublimetext.com/)
- **Validation HTML/CSS** : [W3C Validator](https://validator.w3.org/)

---

## 📥 **Téléchargement**

Vous pouvez télécharger cette charte graphique au format **Markdown** pour une utilisation hors ligne :

[**Télécharger la charte graphique**](sandbox/charte-graphique-framework-tui-bios.md)

---

## 🔄 **Prochaines Étapes**

1. **Valider la Charte** :
   - Vérifiez que les couleurs, polices et composants correspondent à votre vision.
   - Testez les exemples de code dans votre environnement.

2. **Implémentation** :
   - Créez un fichier `styles.css` avec les styles de base.
   - Utilisez les composants UI et TUI pour construire vos pages.

3. **Tests** :
   - Testez l'interface sur différents navigateurs (Chrome, Firefox, Edge).
   - Vérifiez l'accessibilité avec des outils comme [axe DevTools](https://www.deque.com/axe/).

4. **Itérations** :
   - Ajustez les couleurs ou espacements si nécessaire après les retours utilisateurs.

---

## 💡 **Besoin d'Ajustements ?**

Si vous souhaitez :
- **Modifier la palette de couleurs** (ex: ajouter du bleu électrique pour les TUI).
- **Ajouter des composants spécifiques** (ex: fenêtres modales pour les TUI).
- **Adapter le design pour un cas d'usage précis** (ex: émulateur de terminal).

N'hésitez pas à me le demander ! Je peux affiner cette charte en fonction de vos besoins. 🎨