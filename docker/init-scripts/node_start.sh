#!/bin/sh

set -e

echo 'running prestart node script'
echo 'running npm install'
npm install

npm run build

echo 'initialization done, start watching'
npm run watch-poll