# <u>SAE 4.01 Développement Web</u>

## <u>Sommaire</u>

- [Sommaire](#sommaire)
- [Présentation](#présentation)
- [Installation](#installation)
  - [Prérequis](#prérequis)
  - [Exécution de l'application](#exécution-de-lapplication)
- [Se connecter à l'application](#se-connecter-à-lapplication)
  - [Comptes de test](#comptes-de-test)
- [Structure de l'application](#structure-de-lapplication)
  - [Répertoire `Classes`](#répertoire-classes)
  - [Répertoire `Cli`](#répertoire-cli)
  - [Répertoire `Data`](#répertoire-data)
  - [Répertoire `Documents`](#répertoire-documents)
- [Équipe de développement](#équipe-de-développement)

## <u>Présentation</u>

Sound IUT'O est une application web permettant de consulter un catalogue d'albums musicaux. L'application permet de consulter les albums et les artiste et les utilisateurs peuvent ajouter des albums à leur playlist. Quant à eux, les administrateurs peuvent ajouter, modifier et supprimer des albums et des artistes. Vous pouvez consulter le projet sur [GitHub](https://github.com/ValRom28/SAE-PHP.git).

## <u>Installation</u>

### Prérequis

- PHP version 8.3 (ou une verion antérieure)
- git (optionnel)

### Exécution de l'application

- Pour installer l'application, il suffit de cloner le dépôt git et de se placer dans le répertoire de l'application :

    ```bash
    git clone https://github.com/ValRom28/SAE-PHP.git
    cd SAE-PHP
    ```

- Si vous possédez une archive zip de l'application, il suffit de la décompresser et de se placer dans le répertoire de l'application :

    ```bash
    # Linux
    unzip SAE-PHP.zip
    cd SAE-PHP

    # Windows
    # Décompressez l'archive SAE-PHP.zip
    cd SAE-PHP
    ```

- Pour créer la base de données et lancer l'application, il suffit de lancer un script qui dépend de votre OS (la base de données sera prérémplie avec des données de test disponibles dans le dossier `SAE-PHP/Data`):

    ```bash
    ./start.sh # Linux
    # ou
    start.bat # Windows
    ```

L'applicaion est maintenant accessible à l'adresse `http://localhost:5000`.

## <u>Se connecter à l'application</u>

Pour se connecter à l'application, il faut cliquer sur le bouton connexion et entrer les identifiants d'un compte utilisateur.

### Comptes de test

Différents comptes de test sont disponibles pour tester l'application :

| Identifiant | Mot de passe | Rôle |
| ----------- | ------------ | ---- |
| bob@gmail.com       | bob        | Administrateur |
| utilisateur2@example.com | motdepasse2 | Utilisateur |
| utilisateur3@example.com | motdepasse3 | Utilisateur |


## <u>Structure de l'application</u>

### Répertoire `Classes`

- Le répertoire `Classes` contient l'ensemble des classes de l'application.
- Le répertoire `Classes/Database` contient l'ensemble des classes de gestion de la base de données de l'application.
- Le répertoire `Classes/Controller` contient l'ensemble des classes de contrôle de l'application.
- Le répertoire `Classes/Provider` contient l'ensemble des classes de gestion des données de l'application.
- Le répertoire `Classes/View` contient la classe de gestion de la vue de l'application.

### Répertoire `Cli`

- Le répertoire `Cli` contient le fichier de l'interface en ligne de commande de l'application.

### Répertoire `Data`

- Le répertoire `Data` contient l'ensemble des données de test de l'application.

### Répertoire `Documents`

- Le répertoire `Documents` contient l'ensemble des documents de l'application comme des schémas.


## <u>Équipe de développement</u>

- Arthur Villette ([GitHub](https://github.com/ArthurVillette))
- Hugo Sainson ([GitHub](https://github.com/Norikokonut))
- Valentin Romanet ([GitHub](https://github.com/ValRom28))