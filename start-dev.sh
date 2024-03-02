#!/bin/bash

SERVER_NAME=epsidle.nimzero.fr \
HTTP_PORT=15012 \
HTTP3_PORT=15012 \
docker compose up -d --wait
