#! /bin/sh

echo "Mise en PROD de IA-SYMFONY"

BASEDIR=$(dirname $0)
cd $BASEDIR

php console cache:clear --env=prod --no-debug
php console assetic:dump --env=prod --no-debug
