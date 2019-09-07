#!/bin/bash

rm -rf .git

echo Enter project name:
read name

echo Enter repository name:
read repository

if [ ! -z "$name" ]
then
    sed -i '' 's/intertech_/'"$name"'_/g' docker-compose.yml
    sed -i '' 's/intertech_/'"$name"'_/g' deploy-docker.sh

    cp .env.example .env
    sed -i '' 's/intertech/'"$name"'/g' .env

    cp frontend/.env.example.laraveloctober frontend/.env
    sed -i '' 's/APP_NAME=/APP_NAME='"$name"'/g' frontend/.env
    sed -i '' 's/APP_KEY=/APP_KEY=base64:B2dxIPFLR6wHt0w+GiclWlf+b\/hE5+1kThr+rNZSCJw=/g' frontend/.env
    sed -i '' 's/APP_URL=/APP_URL=http:\/\/'"$name"'.localhost/g' frontend/.env
    sed -i '' 's/CACHE_PREFIX=/CACHE_PREFIX='"$name"'/g' frontend/.env

    cp backend/.env.example backend/.env
    sed -i '' 's/APP_NAME=/APP_NAME='"$name"'/g' backend/.env
    sed -i '' 's/APP_KEY=/APP_KEY=base64:B2dxIPFLR6wHt0w+GiclWlf+b\/hE5+1kThr+rNZSCJw=/g' backend/.env
    sed -i '' 's/APP_URL=/APP_URL=http:\/\/backend.'"$name"'.localhost/g' backend/.env
    sed -i '' 's/CACHE_PREFIX=/CACHE_PREFIX='"$name"'/g' backend/.env

    docker stop $(docker ps -aq)

    docker-compose up -d --build
    
    sleep 20

    docker exec "$name"_backend_php composer install
    docker exec "$name"_backend_php php artisan october:up
    docker exec "$name"_backend_php php artisan project:up --force
    docker exec "$name"_frontend_php composer install

    cd frontend && npm i && npm run dev && cd ../

    cd backend && find ./bootstrap -type d -exec chmod 775 {} \; && find ./storage -type d -exec chmod 775 {} \; && cd ../
    cd frontend && find ./bootstrap -type d -exec chmod 775 {} \; && find ./storage -type d -exec chmod 775 {} \; && cd ../
    
    git init
    git remote add origin "$repository"
    git add -A
    git commit -am "Initial commit"
    git push origin master
else
    echo Please enter project name
fi