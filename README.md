Few step to run app.

1. docker-compose up
2. docker-compose exec php /bin/bash
   1. symfony console make:migration
   2. symfony console doctrine:migrations:migrate
3. Open browser & connect to localhost whit port 8080
4. First you need to create some category, them you can add new products.
