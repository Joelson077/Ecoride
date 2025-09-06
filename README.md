# 🚗🌱 EcoRide – Plateforme de covoiturage 

EcoRide est une application web développée dans le cadre de l’**Évaluation en Cours de Formation (ECF) – Titre Professionnel Développeur Front-end**.  

L’objectif principal est de promouvoir le covoiturage afin de :  
- **Réduire l’impact environnemental** 🌍 en limitant le nombre de véhicules sur la route.  
- **Proposer une alternative économique** 💶 aux déplacements individuels.  
- **Favoriser la convivialité** 🤝 entre les usagers.

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

###4) Lancement
1)Démarrer Apache et MySQL dans XAMPP
2)Ouvrir l’application : 👉 http://localhost/Ecoride/


🔑 ###Comptes de test
| Rôle           | Identifiant                                       | Mot de passe |
| -------------- | ------------------------------------------------- | ------------ |
| Administrateur | Joelsonrita6@gamil.com                            | Joelson123   |
| Employé        | Joelsonrita6@gamil.com                            | Joelson123   |
| Utilisateur    | Joelsonrita07@gamil.com                           | Joelson@7    |


###Déploiement en ligne
👉 Lien vers l’application déployée

📊 ###Gestion de projet
Méthodologie : Agile / Kanban
Outil utilisé : Trello
👉 Lien vers le tableau Trello

🛠️ ###Dépannage (FAQ courte)

Erreur “Table inconnue” → Importer correctement sql/ecoride.sql dans la base ecoride.

“Access denied” MySQL → Vérifier db.php (user/mot de passe).

PDOException (driver) → Activer pdo_mysql dans php.ini puis redémarrer Apache.

CSS/JS non chargés → Vérifier les chemins (<link>, <script>).



