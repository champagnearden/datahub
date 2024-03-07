# Welcome to DataHub
If you want to join as a developper, feel free to fork this project !

## How to use DataHub ?
DataHub is a project that tends to be a platform where you can exchange files with anyone. No expiration, dedicated to CyberData.

Just login to your account and see your files with exchanged ones !

## What's the difference with anoter cloud storage provider ?
1. It's free to use
1. Dedicated to CyberData and made by a CyberData, you and your homies will know what is exchanged.
1. There are no limits of storage

Isn't it enough for you ?

## Scenarii d'utilisation
| N° | Page | Données envoyées | Fichier de destination | Fichier lu ou écrit | Description | Spécifications de droit |
|---|---|---|---|---|---|---|
| 1 | `login.php` | `username`, `motdepasse` | `check.php` | Lecture de `accounts.json` | Connexion à DataHub | Tout le monde |
| 2 | `gestion.php` | `username`, `prenom`, `nom`, `motdepasse`, `email`, `role`, `groupe` | `add_user.php` | Ecriture de `accounts.json` | Ajouter un utilisateur | Administrateurs & Modérateurs |
| 3 | `gestion.php` | `username` | `username` | Lecture et écriture de `accounts.json` | Supprimer un utilisateur | Administrateurs & Modérateurs |
| 4 | `gestion.php` | `nom_grp` | `add_group.php` | Lecture et écriture de `groupes.json` | Ajouter un groupe | Administrateurs & Modérateurs |
| 5 | `gestion.php` | `nom_grp` | `supprimer_groupe.php` | Lecture et écriture de `accounts.json`, Lecture et écriture de `groupes.json` | Supprimer un groupe | Administrateurs & Modérateurs |
| 6 | `login.php` |  | `functions.php` | Lecture et écriture de `banned_ip.json` | Se faire bannir par IP | Tout le monde |
| 7 | `gestion.php` | `ip` | `gestion.php` | Lecture et écriture de `banned_ip.json` | Débannir une IP | Administrateurs |
| 8 | `gestion.php` | `choix`, `ch_groupes`, `ch_roles`, `ch_users` | `gestion.php` | Lecture de `accounts.json` | Rechercher un ensemble d'utilisateurs | Tout le monde |
| 9 | `gestion.php` | `usernames`, `newgrp` | `gestion.php` | Lecture et écriture de `accounts.json` | Modifier les groupes d'un ensemble utilisateurs | Administrateurs & Modérateurs |
| 10 | `gestion.php` | `usernames`, `newrole` | `gestion.php` | Lecture et écriture de `accounts.json` | Modifier le rôle d'un ensemble d'utilisateur | Administrateurs & Modérateurs |
| 11 | `FTP/index.php` | `fic`, `role` | `FTP/index.php` | Lecture et écriture de `accounts.json`, Ecriture de `files.json` | Déposer un fichier | Tout le monde |
| 12 | `FTP/index.php` | `DelFic` | `FTP/index.php` | Lecture et écriture de `files.json` | Supprimer un fichier | Tout le monde (voir permissions du fichier) |
| 13 | `FTP/index.php` | `AddDoss`, `role` | `FTP/index.php` | Ecriture de `dossiers.json` | Créer un répertoire | Tout le monde |
| 14 | `FTP/index.php` | `DelDoss` | `FTP/index.php` | Lecture et écriture de `dossiers.json` | Supprimer un répertoire | Tout le monde (voir permissions du répertoire) |