# LNpon

Réseau social en micro services.

## Services:

- [x] users
- [ ] auth
- [x] posts
- [ ] images
- [x] reactions
- [ ] relations
- [ ] groupes
- [ ] gateway

## Installation

```
$ git clone https://github.com/blackorbit1/LNpon.git
$ cd LNpon
```

## Lancement

Pour lancer tous les services sur la même machine:

```
$ ./start.sh
```

Sinon, copier le dossier correspondant au service voulut sur la machine et lancer docker-compose.

Par exemple:

```
$ cd auth
$ docker-compose up
```

## Arret

Vous pouvez arrêter tous les services d'un coup en executant le script suivant:

```
$ ./stop.sh
```

Pour stopper un seul service, placez vous dans le dossier du service que vous souhaitez stopper et lancez la commande:

```
$ docker-compose stop
```
