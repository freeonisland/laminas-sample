#!/bin/bash
eval "$(docker-machine env default)"
WEBSERVER=/Users/camillemaurice/web-server
docker-compose -f "docker-compose.yml" down
docker-compose -f "docker-compose.yml" up -d --build