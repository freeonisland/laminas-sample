#!/bin/bash
eval "$(docker-machine env default)"
docker-compose -f "docker-compose.yml" down
docker-compose -f "docker-compose.yml" up -d --build