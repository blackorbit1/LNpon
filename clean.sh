#!/usr/bin/env bash

docker-compose -f auth/docker-compose.yml rm -f -s -v
docker-compose -f groupes/docker-compose.yml rm -f -s -v
docker-compose -f images/docker-compose.yml rm -f -s -v
docker-compose -f posts/docker-compose.yml rm -f -s -v
docker-compose -f reactions/docker-compose.yml rm -f -s -v
docker-compose -f relations/docker-compose.yml rm -f -s -v
docker-compose -f users/docker-compose.yml rm -f -s -v
docker-compose -f gateway/docker-compose.yml rm -f -s -v
