# Annuaire "Bien-Être"

Projet du cours "Projet web dynamique".

## Installation

### 1. Cloner le repository

`git clone https://github.com/VanstraelenMickael/bien_etre`

### 2. Installer les dépendances

`composer install`

### 3. Créer la base de donnée

`php bin/console doctrine:database:create`

### 4. Configurer le .env

Vous devez configurer votre base de donnée (que vous venez de créer) et votre Mailer_DSN

### 5. Setup la base de donnée

`php bin/console doctrine:migrations:migrate`

### 6. Créer les données de base

`php bin/console doctrine:fixtures:load`

### 7. Accéder au site

`symfony server:start`
Navigate to http://localhost:8000/

## Outils et Technologies utilisées

- Symfony 4.26.6
- PHP 7.4.9
- PHPMyAdmin 5.1.1
- MySQL
- SaSS
