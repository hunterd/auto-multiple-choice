# WP-AMC Plugin

WP-AMC est un plugin WordPress visant à apporter toutes les fonctionnalités principales du logiciel **Auto Multiple Choice** (AMC) directement depuis l'interface d'administration WordPress. Le but est de disposer d'un outil de QCM complet avec une expérience utilisateur modernisée et adaptée au web.

## Fonctionnalités prévues

- **Création et gestion de QCM** : organisation des questions, réponses et paramétrages depuis le tableau de bord.
- **Génération de PDF** pour les sujets et feuilles réponses via `TCPDF` ou `dompdf`.
- **Import de copies scannées** et détection automatique des réponses grâce à `Tesseract.js` ou à une API OCR.
- **Notation automatique** avec possibilité de correction manuelle assistée.
- **Exports CSV et PDF** des résultats, bulletins et statistiques.
- **Gestion multi-utilisateurs** (enseignants, correcteurs) en s'appuyant sur les rôles WordPress.
- **Hooks et filtres** pour l'extension future du plugin et la désactivation de modules.

## Architecture

Le code est organisé dans le dossier `wp-amc` avec une structure inspirée de Laravel :

```
wp-amc/
├── app/
│   ├── Http/Controllers
│   ├── Models
│   └── Views
├── composer.json
├── routes.php
└── wp-amc.php
```

- Les routes (simulées via les hooks WordPress) sont définies dans `routes.php`.
- Les contrôleurs regroupent la logique de chaque vue (préparation, scan, notation, export...).
- Les vues se trouvent dans `app/Views` et peuvent être thémées facilement.
- Le chargement automatique des classes utilise Composer avec l'espace de noms `App\`.

## Installation

1. Se placer dans le dossier du plugin puis installer les dépendances PHP&nbsp;:
   ```bash
   composer install
   ```
2. Copier le dossier `wp-amc` dans `wp-content/plugins/` puis activer le plugin depuis l'administration WordPress.

## Dépendances principales

- **Composer** pour l'autoloading et les bibliothèques PHP.
- **NPM** pour la gestion des assets modernes (scripts, styles, composants UI). Un build Webpack/Vite peut être ajouté au besoin.
- **ACF** ou **CMB2** pour les champs personnalisés.
- **TCPDF** ou **dompdf** pour la production des PDF.
- **Tesseract.js** (ou un service OCR) pour la reconnaissance des copies scannées.
- **Intervention/Image** pour le traitement d'images si nécessaire.

## Interface et UX

L'interface se veut moderne et responsive&nbsp;:

- Stepper clair permettant de suivre l'avancement (préparation, impression, réponses, notation, etc.).
- Tableaux de réponses et aperçus des sujets/feuilles.
- Récapitulatifs de scores et bulletins exportables.

## Sécurité et bonnes pratiques

- Respect des exigences de sécurité WordPress (vérification des permissions, nonces, sanitization et validation des données).
- Code modulable pour permettre la désactivation d'une fonctionnalité sans perturber l'ensemble.
- Possibilité d'extension grâce aux hooks prévus.

## Statut

Cette version initiale contient la structure de base du plugin et des vues d'administration factices. Les futures versions implémenteront progressivement l'ensemble des fonctionnalités d'Auto Multiple Choice, en s'appuyant sur les technologies mentionnées ci-dessus.


## Hooks

The plugin exposes several action hooks allowing extensions to run custom code at key points:

- `wp_amc_prepare_exam` fires when the **Prepare Exam** page is loaded.
- `wp_amc_scan_sheets` fires when the **Scan Sheets** page is loaded.
- `wp_amc_mailing` fires when the **Mailing** page is loaded (if the module is enabled).
- `wp_amc_manual_grading` fires when the **Manual Grading** page is loaded.
- `wp_amc_export_results` fires when the **Export Results** page is loaded.
- `wp_amc_preferences` fires when the **Preferences** page is loaded.

Developers can hook into these actions to modify the behaviour of the plugin or inject additional content.

## Tests

Des tests unitaires basés sur **PHPUnit** se trouvent dans le répertoire `tests`.
Après installation des dépendances avec Composer, exécutez :

```bash
composer install
vendor/bin/phpunit
```

Le fichier `phpunit.xml` fournit la configuration minimale pour lancer ces tests.
