ssh pokemon-friends@deploy.eu2.frbit.com php artisan down
ssh pokemon-friends@deploy.eu2.frbit.com php artisan backup:run --only-db --filename $TRAVIS_JOB_NUMBER.zip
ssh pokemon-friends@deploy.eu2.frbit.com php artisan config:clear
ssh pokemon-friends@deploy.eu2.frbit.com php artisan route:clear
ssh pokemon-friends@deploy.eu2.frbit.com php artisan view:clear
ssh pokemon-friends@deploy.eu2.frbit.com php artisan cache:clear
git remote add fortrabbit pokemon-friends@deploy.eu2.frbit.com:pokemon-friends.git
git push fortrabbit master
scp -r ./public pokemon-friends@deploy.eu2.frbit.com:/srv/app/pokemon-friends/htdocs
ssh pokemon-friends@deploy.eu2.frbit.com php artisan config:cache
ssh pokemon-friends@deploy.eu2.frbit.com php artisan route:cache
ssh pokemon-friends@deploy.eu2.frbit.com php artisan view:clear
ssh pokemon-friends@deploy.eu2.frbit.com php artisan cache:clear
ssh pokemon-friends@deploy.eu2.frbit.com php artisan migrate --force
ssh pokemon-friends@deploy.eu2.frbit.com php artisan up
