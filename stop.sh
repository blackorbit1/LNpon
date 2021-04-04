#!/usr/bin/env bash

docker-compose -f auth/docker-compose.yml stop
docker-compose -f groupes/docker-compose.yml stop
docker-compose -f images/docker-compose.yml stop
docker-compose -f posts/docker-compose.yml stop
docker-compose -f reactions/docker-compose.yml stop
docker-compose -f relations/docker-compose.yml stop
docker-compose -f users/docker-compose.yml stop
docker-compose -f gateway/docker-compose.yml stop
