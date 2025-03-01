#!/bin/sh

echo "Starting application"

if [ ! -f "vendor/autoload.php" ]; then
    composer install --no-progress --no-interaction
fi

if [ ! -f ".env" ]; then
    echo "Creating .env file"
    cp .env.example .env
    php artisan key:generate
else
    echo ".env file already exists"
fi

role=${APP_ROLE:-app}


if [ "$role" = "app" ]; then
  php artisan migrate
  php artisan key:generate
  php artisan cache:clear
  php artisan config:clear
  php artisan route:clear
  php-fpm
elif [ "$role" = "horizon" ]; then
  echo "Stating horizon"
  php artisan horizon
elif [ "$role" = "worker" ]; then
  echo "Starting worker"
  php artisan queue:work
elif [ "$role" = "scheduler" ]; then
  echo "Stating scheduler"
  while true
  do
    php artisan schedule:run --verbose --no-interaction &
    sleep 60
  done
elif [ "$role" = "websocket" ]; then
  echo "Stating websocket"
  php artisan reverb:start --host="0.0.0.0" --port=6001
else
  echo "Invalid role"
  exit 1
fi


