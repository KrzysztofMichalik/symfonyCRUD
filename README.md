Few step to run app.

1. docker-compose up *
2. docker-compose exec php /bin/bash *
   1. symfony console make:migration
   2. symfony console doctrine:migrations:migrate
3. Open browser & open this address http://127.0.0.1:8080/
4. First you need to create some category, then you can add new products.

* The commands with star may require administrator privileges