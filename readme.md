# Pokedex Website

Ce projet est un site web permettant de naviguer et de rechercher à travers un pokedex du célèbre jeu Pokémon !

## Développeurs

- Pomolokoki   => HUBERT Tom\
- Natisrt      => LESPLINGUIES Tristan\
- JusDeFruits1 => CHANFI MARI Yram\
- Eloups       => TISSIER Elouan\
- Cherifaaa    => SAFI Cherifa

## Installation

Pour commencer, vous devez cloner le projet de GitHub:
```bash
git clone https://github.com/Pomolokoki/Pokedex-WebSite.git
```

Ensuite, accédez au dossier du projet:
```bash
cd Pokedex-WebSite
```

Une fois dans le bon dossier, lancez l'installation des dépendances Composer:
```bash
composer install
```

Puis celles de NPM:
```bash
npm install
```

Une fois fait, vous pouvez lancer les conteneurs Docker:
```bash
docker compose up -d --build
```

Attendez que les machines démarrent, puis, vous pouvez insérer les données dans la base de données:
```bash
docker exec -i pokedex-website-db-1 sh -c "mysql -u root -proot -D pokedex -e 'source /pokedex.sql'"
```

Vous pouvez maintenant accéder au site web via le lien suivant:\
[http://127.0.0.1](http://127.0.0.1)

## Notes complémentaires
### Identifiants de connexion à un compte de test

Voici les codes pour se connecter à un compte de test:
- identifiant: az
- mot de passe: azertyY444

### Volume Docker

La base de données mysql dans Docker possède un volume du nom `mysql_data`.\
Pensez à le supprimer si vous souhaitez remonter les machines de zéro.

### Fichier .env pour lancer sans Docker

Si vous souhaitez lancer le projet sans Docker, vous devez créer le fichier `.env` à partir de l'exemple [`.env.exemple`](./.env.exemple).
