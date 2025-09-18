# 🚗🌱 EcoRide – Plateforme de covoiturage 

**EcoRide** est une application web développée dans le cadre de l’**Évaluation en Cours de Formation (ECF) – Titre Professionnel Développeur Front-end**.  

Conçue dans une démarche écoresponsable, elle vise à **réinventer la mobilité** en proposant une alternative moderne, simple et fiable au transport individuel.  

### 🌟 Notre vision
EcoRide n’est pas seulement une plateforme de covoiturage : c’est un projet qui place **l’écologie, l’économie et l’humain** au cœur de chaque trajet.  

### 🎯 Nos objectifs
- 🌍 **Réduire l’empreinte environnementale** en diminuant le nombre de voitures en circulation.  
- 💶 **Proposer une solution économique** et accessible à tous les usagers.  
- 🤝 **Favoriser la convivialité et le partage** entre conducteurs et passagers.  

### 🚀 Notre engagement
À travers une interface intuitive et sécurisée, EcoRide combine **innovation technologique** et **responsabilité sociétale**, afin d’offrir une expérience de covoiturage durable et agréable.


## ⚙️ Déploiement en local

### 1) Prérequis
- PHP 8+
- Serveur Apache (XAMPP, WAMP, MAMP ou équivalent)
- MySQL
- Git
- Navigateur moderne (Chrome, Firefox, Edge)

### 2) Base de données
**Import via phpMyAdmin (facile)**  
1. Lancer XAMPP → démarrer **Apache** et **MySQL**  
2. Ouvrir : [http://localhost/phpmyadmin]
3. Créer une base nommée **ecoride** (utf8mb4_general_ci)  
4. Onglet **Importer** → choisir le fichier **`sql/ecoride.sql`** → Valider  

### 3) Configuration
Éditer le fichier **`db.php`** et vérifier les identifiants :  
php
$host = "localhost";
$dbname = "ecoride";
$user = "root";
$password = ""; // sous XAMPP par défaut

### 4) Lancement
1)Démarrer Apache et MySQL dans XAMPP
2)Ouvrir l’application : 👉 http://localhost/Ecoride/


## 🔑 Comptes de test
| Rôle           | Identifiant                                       | Mot de passe |
| -------------- | ------------------------------------------------- | ------------ |
| Administrateur | Joelsonrita6@gamil.com                            | Joelson123   |
| Employé        | Joelsonrita6@gamil.com                            | Joelson123   |
| Utilisateur    | Joelsonrita07@gamil.com                           | Joelson@7    |


## 🌍 Déploiement en ligne
👉 [Lien vers l’application déployée]((https://ecoride.icu))

---

## 📊 Gestion de projet
- Méthodologie : **Agile / Kanban**  
- Outil utilisé : **Trello**  
👉 [Lien vers le tableau Trello](https://trello.com/b/NFavOE9h)

---

## 🌱 Workflow Git appliqué

| Branche                | Rôle et utilisation                                                                 |
|-------------------------|-------------------------------------------------------------------------------------|
| **`main`**              | Branche principale → contient la version stable et livrable du projet.              |
| **`dev`**               | Branche de développement → intégration et tests des fonctionnalités.                |
| **`feature/...`**       | Branches dédiées à une fonctionnalité (ex: `feature/US3-recherche`). Après validation, elles sont mergées dans `dev`. |

✅ Une fois la branche `dev` testée et stable, elle est fusionnée dans `main` pour créer une version finale prête au déploiement.

## 🛠️ Stack technique

| Domaine              | Technologies utilisées                                                     |
|----------------------|----------------------------------------------------------------------------|
| **Front-end**        | HTML5, CSS3 (Bootstrap), JavaScript (DOM + Fetch API)                      |
| **Back-end**         | PHP 8 avec PDO (sécurisation contre les injections SQL)                    |
| **Base relationnelle** | MySQL (utilisateurs, trajets, véhicules, crédits)                        |
| **Déploiement**      | Hostinger (serveur Apache + PHP + MySQL)                                   |
| **Outils**           | Git (gestion de versions), Trello (gestion de projet en Kanban)            |


## 🛠️ Dépannage (FAQ)

| Problème                          | Solution                                                                 |
|-----------------------------------|---------------------------------------------------------------------------|
| ❌ **Erreur “Table inconnue”**     | Importer correctement `sql/ecoride.sql` dans la base **ecoride**.         |
| 🔑 **“Access denied” MySQL**       | Vérifier le fichier `db.php` (utilisateur/mot de passe).                  |
| ⚠️ **PDOException (driver)**       | Activer `pdo_mysql` dans `php.ini`, puis redémarrer Apache.               |
| 🎨 **CSS/JS non chargés**          | Vérifier les chemins (`<link>`, `<script>`) dans les fichiers HTML/PHP.   |


## 📌 Version finale

✅ Projet livré avec :  
- Code source (front-end & back-end)  
- Script SQL (`sql/ecoride.sql`)  
- Documentation utilisateur et technique  
- Charte graphique + maquettes (desktop & mobile)  
- Gestion de projet (Kanban Trello)  

**Commit final : `EcoRide`**

