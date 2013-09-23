#! /bin/sh

BASEDIR=$(dirname $0)
cd $BASEDIR

phpunit.phar -c ./ 
