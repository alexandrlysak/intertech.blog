git clone    
cp .env.example .env    
настройка названий контейнеров в docker-composer.yml    
настройка названий контейнеров в deploy-docker.sh        
настройка переменных APP_SERVER_NAME_FRONTEND APP_SERVER_NAME_BACKEND

find ./backend/storage* -type d -exec chmod 775 {} \;    
find ./frontend/storage* -type d -exec chmod 775 {} \;    
find ./frontend/bootstrap/cache -type d -exec chmod 775 {} \;    


cp backend/.env.example backend/.env    
установка APP_URL и APP_KEY    
docker exec intertech_backend_php composer install --no-dev --optimize-autoloader    
docker exec intertech_backend_php php artisan october:up    

установка нужных языковых версий    
docker exec intertech_backend_php php artisan project:up    

cp frontend/.env.example.laraveloctober frontend/.env    
установка APP_URL и APP_KEY    
docker exec intertech_frontend_php composer install --no-dev --optimize-autoloader    

cd frontend && npm i --no-save    
npm run production    