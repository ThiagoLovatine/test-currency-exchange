## Backend => dev setup

- INSTALL => docker & docker-compose
- RUN => cp ./api/.env.example ./api/.env
- REPLACE => YOUR_API_KEY_GOES_HERE with your Fixer(https://fixer.io/) api key inside .env
- RUN => docker-compose up -d
- RUN => docker exec test_currency_exchange_php composer install
- RUN => docker exec test_currency_exchange_php php artisan key:generate
- RUN => docker exec test_currency_exchange_php php artisan migrate:refresh --seed
- RUN => docker exec test_currency_exchange_php php artisan config:cache
- RUN => docker restart test_currency_exchange_php
- API usage instructions (Swagger) => http://localhost:8080/api/documentation 
- Database GUI: http://localhost:8081/

## Backend => Testing

docker exec test_currency_exchange_php php artisan test --coverage  --min=80
