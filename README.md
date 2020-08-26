# Hotels_score task implementation

##To be able to run task you should run following commands:

* ```composer install``` - to install all dependencies (you should have composer installed on your machine)
* ```docker-compose up -d``` - to run service
* ```docker exec -it hotels_score_app bin/console  doctrine:migration:migrate --no-interaction``` - to apply migrations
(normally should be executed only first time)
* ```docker exec -it hotels_score_app php -d memory_limit=2048M bin/console doctrine:fixtures:load --no-interaction``` - to load the fixtures
(every execution of this command remove all records from DB and creates new)


##To call endpoint you should use following url:
```http://localhost:5555/hotels/61/score/from/2018-04-03%2015:16:17/to/2020-09-01%2015:16:17?offset=0&limit=10```

Offset and limit is optional parameters (if they are not presented will be used default values)

To find out what hotel ids are available you can run following command:

```docker exec -i hotels_score_mysql mysql -uroot -proot  <<< "use hotels_app; select * from hotel;"```

##Running tests
To run the tests you can use ```./bin/phpunit``` command
