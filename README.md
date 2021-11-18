# Hotels_score

### To be able to run task you should run following commands:

* ```git clone https://github.com/v-smirnov/hotels_score.git```
* ```composer install``` - to install all dependencies (you should have composer installed on your machine)
* ```docker-compose up -d``` - to run service
* ```docker exec -it hotels_score_app bin/console  doctrine:migration:migrate --no-interaction``` - to apply migrations
(normally should be executed only first time)
* ```docker exec -it hotels_score_app php -d memory_limit=2048M bin/console doctrine:fixtures:load --no-interaction``` - to load the fixtures
(every execution of this command remove all records from DB and creates new and it can take some time to load 100000 reviews)


### To call endpoint you should use following url:
```http://localhost:5555/hotels/1/score/from/2018-04-03%2015:16:17/to/2020-09-01%2015:16:17?offset=0&limit=10```

Offset and limit are optional parameters (if they are not presented will be used default values)

To find out what hotel ids are available you can run following command:

```docker exec -i hotels_score_mysql mysql -uroot -proot  <<< "use hotels_app; select * from hotel;"```

### Running tests
To run the tests you can use ```docker exec -it hotels_score_app ./bin/phpunit``` command


### Implementation notes
In many cases we use controllers with the same action flow:
 * transform http-request to request-object
 * validate it
 * use this request-object in some service, responsible for some business logic
 * getting response-object from this service
 * transform response-object to http response.

So, OperationController class stand exactly for this flow. It is configurable and can be
reused in other operations. It also brings us to small controller with just one action and small services, which basically
responsible for one thing. For sure, situations can be different, and this approach can't help in every situation, but in some
cases it can decrease development time and allows to focus on business logic implementation.
