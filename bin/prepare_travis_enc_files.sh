#!/bin/sh

if [ -e deploy_rsa ]
then
    echo "[OK] deploy_rsa"
else
    echo "[KO] deploy_rsa"
    exit
fi

tar cvf travis.tar deploy_rsa
travis encrypt-file travis.tar -r pokemon-friends-com/www
