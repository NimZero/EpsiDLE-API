#!/bin/bash

SERVER_NAME=http://epsidle.nimzero.fr \
HTTP_PORT=15012 \
HTTP3_PORT=15012 \
APP_SECRET=ChangeMe \
CADDY_MERCURE_JWT_SECRET=ChangeThisMercureHubJWTSecretKey \
docker compose -f compose.yaml -f compose.prod.yaml up -d --wait
