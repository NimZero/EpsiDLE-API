#!/bin/bash

SERVER_NAME=epsidle.nimzero.fr \
HTTP_PORT=15021 \
HTTPS_PORT=15022 \
HTTP3_PORT=15022 \
APP_SECRET=ChangeMe \
CADDY_MERCURE_JWT_SECRET=ChangeThisMercureHubJWTSecretKey \
docker compose -f compose.yaml -f compose.prod.yaml up -d --wait
