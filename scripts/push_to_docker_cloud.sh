docker login --username $DOCKER_USERNAME --password $DOCKER_PASSWORD
docker-compose --project-name template push workspace apache2 mailhog php-fpm php-worker mysql redis elasticsearch kibana
