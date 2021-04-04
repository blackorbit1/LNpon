#!/usr/bin/env bash

docker-compose -f auth/docker-compose.yml up -d
docker-compose -f groupes/docker-compose.yml up -d
docker-compose -f images/docker-compose.yml up -d
docker-compose -f posts/docker-compose.yml up -d
docker-compose -f reactions/docker-compose.yml up -d
docker-compose -f relations/docker-compose.yml up -d
docker-compose -f users/docker-compose.yml up -d
docker-compose -f gateway/docker-compose.yml up -d
