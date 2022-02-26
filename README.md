## Backend => dev setup

- cd docker_dev && docker-compose up -d && cd ..
- cd api && cp .env.example .env
- docker exec test_currency_exchange_php php artisan key:generate
- Replace YOUR_API_KEY_GOES_HERE with your Fixer api key inside .env
- docker exec test_currency_exchange_php php artisan migrate:refresh --seed
- docker exec test_currency_exchange_php php artisan config:cache
- See http://localhost:8080/api/documentation for API usage instructions
- Database GUI: http://localhost:8081/

## Backend => Testing

docker exec test_currency_exchange_php php artisan test --coverage  --min=80
