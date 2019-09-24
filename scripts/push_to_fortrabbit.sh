ssh obsessioncity@deploy.eu2.frbit.com php artisan down
#ssh obsessioncity@deploy.eu2.frbit.com php artisan backup:run --only-db --filename $TRAVIS_JOB_NUMBER.zip
ssh obsessioncity@deploy.eu2.frbit.com php artisan config:clear
ssh obsessioncity@deploy.eu2.frbit.com php artisan route:clear
ssh obsessioncity@deploy.eu2.frbit.com php artisan view:clear
ssh obsessioncity@deploy.eu2.frbit.com php artisan cache:clear
git remote add fortrabbit obsessioncity@deploy.eu2.frbit.com:obsessioncity.git
git push fortrabbit master
#echo "<?php return ['version' => '$TRAVIS_JOB_NUMBER'];" > config/versiongenerated.php
#scp obsessioncity@deploy.eu2.frbit.com:/srv/app/obsessioncity/htdocs/config/versiongenerated.php ./config/versiongenerated.php
scp -r obsessioncity@deploy.eu2.frbit.com:/srv/app/obsessioncity/htdocs/public ./public
#sentry-cli releases new --project obsession-city $TRAVIS_JOB_NUMBER
#sentry-cli releases set-commits --auto $TRAVIS_JOB_NUMBER
ssh obsessioncity@deploy.eu2.frbit.com php artisan config:cache
ssh obsessioncity@deploy.eu2.frbit.com php artisan route:cache
ssh obsessioncity@deploy.eu2.frbit.com php artisan view:clear
ssh obsessioncity@deploy.eu2.frbit.com php artisan cache:clear
ssh obsessioncity@deploy.eu2.frbit.com php artisan migrate --force
ssh obsessioncity@deploy.eu2.frbit.com php artisan up
