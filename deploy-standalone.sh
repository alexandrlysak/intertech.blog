#!/bin/bash

lastCommitSha=`git rev-parse HEAD`

git pull origin master

newCommitSha=`git rev-parse HEAD`

changedFiles=`git diff --name-only $lastCommitSha $newCommitSha`

if [[ $changedFiles == *"backend/composer.lock"* ]]
then
    cd backend
    composer install --no-dev --optimize-autoloader
    cd ../
fi

if [[ $changedFiles == *"version.yaml"* ]]
then
    cd backend
    php artisan october:up
    cd ../
fi

if [[ $changedFiles == *"frontend/composer.lock"* ]]
then
    cd frontend
    composer install --no-dev --optimize-autoloader
    cd ../
fi

cd frontend
php artisan laraveloctober:routes
mv storage/app/routes.json ../backend/storage/cms/routes.json

if [[ $changedFiles == *"frontend/package-lock.json"* ]]
then
    npm i --no-save
fi

if [[ $changedFiles == *".scss"* ]] || [[ $changedFiles == *".js"* ]] || [[ $changedFiles == *".sass"* ]] || [[ $changedFiles == *".css"* ]] || [[ $changedFiles == *".vue"* ]]
then
    npm run production
fi

php artisan cache:clear

cd ../


