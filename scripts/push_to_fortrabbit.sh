ssh www-template@deploy.eu2.frbit.com php artisan down
ssh www-template@deploy.eu2.frbit.com php artisan backup:run --only-db --filename $TRAVIS_JOB_NUMBER.zip
ssh www-template@deploy.eu2.frbit.com php artisan config:clear
ssh www-template@deploy.eu2.frbit.com php artisan route:clear
ssh www-template@deploy.eu2.frbit.com php artisan view:clear
ssh www-template@deploy.eu2.frbit.com php artisan cache:clear
git remote add fortrabbit www-template@deploy.eu2.frbit.com:www-template.git
git push fortrabbit master
scp -r www-template@deploy.eu2.frbit.com:/srv/app/www-template/htdocs/public ./public
ssh www-template@deploy.eu2.frbit.com php artisan config:cache
ssh www-template@deploy.eu2.frbit.com php artisan route:cache
ssh www-template@deploy.eu2.frbit.com php artisan view:clear
ssh www-template@deploy.eu2.frbit.com php artisan cache:clear
ssh www-template@deploy.eu2.frbit.com php artisan migrate --force
ssh www-template@deploy.eu2.frbit.com php artisan up
