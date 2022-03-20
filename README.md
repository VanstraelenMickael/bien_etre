# Annuaire "Bien-Être"

Projet du cours "Projet web dynamique".

## Installation

### 1. Cloner le repository

`git clone https://github.com/VanstraelenMickael/bien_etre`

### 2. Installer les dépendances

`composer install`

### 3. Configurer le .env

Vous devez configurer votre base de donnée et votre Mailer_DSN

### 4. Setup la base de donnée

`php bin/console doctrine:database:create`
`php bin/console doctrine:migrations:migrate`

### 5. Créer les données de base

`php bin/console doctrine:fixtures:load`

### 6. Accéder au site

`symfony server:start`
Navigate to http://localhost:8000/

## Outils et Technologies utilisées

- Symfony 4.26.6
- PHP 7.4.9
- PHPMyAdmin 5.1.1
- MySQL
- SaSS
