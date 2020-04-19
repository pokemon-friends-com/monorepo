ssh pkmn-friends@deploy.eu2.frbit.com php artisan config:clear
ssh pkmn-friends@deploy.eu2.frbit.com php artisan route:clear
git remote add fortrabbit pkmn-friends@deploy.eu2.frbit.com:pkmn-friends.git
git push fortrabbit master
ssh pkmn-friends@deploy.eu2.frbit.com php artisan config:cache
ssh pkmn-friends@deploy.eu2.frbit.com php artisan route:cache
ssh pkmn-friends@deploy.eu2.frbit.com php artisan view:clear
ssh pkmn-friends@deploy.eu2.frbit.com php artisan migrate --force
