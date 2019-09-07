#!/bin/bash

lastCommitSha=`git rev-parse HEAD`

git pull origin master

newCommitSha=`git rev-parse HEAD`

changedFiles=`git diff --name-only $lastCommitSha $newCommitSha`

if [[ $changedFiles == *"backend/composer.lock"* ]]
then
    docker exec intertech_backend_php composer install --no-dev --optimize-autoloader
fi

if [[ $changedFiles == *"version.yaml"* ]]
then
    docker exec intertech_backend_php php artisan october:up
fi

if [[ $changedFiles == *"frontend/composer.lock"* ]]
then
    docker exec intertech_frontend_php composer install --no-dev --optimize-autoloader
fi

docker exec intertech_frontend_php php artisan laraveloctober:routes

cd frontend
mv storage/app/routes.json ../backend/storage/cms/routes.json

if [[ $changedFiles == *"frontend/package-lock.json"* ]]
then
    npm i --no-save
fi

if [[ $changedFiles == *".scss"* ]] || [[ $changedFiles == *".js"* ]] || [[ $changedFiles == *".sass"* ]] || [[ $changedFiles == *".css"* ]] || [[ $changedFiles == *".vue"* ]]
then
    npm run production
fi

cd ../

docker exec intertech_frontend_php php artisan cache:clear
