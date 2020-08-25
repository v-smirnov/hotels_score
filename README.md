# hotels_score
Task for providing hotels score endpoint

docker exec -it hotels_score_app bin/console  doctrine:migration:migrate --no-interaction

docker exec -it hotels_score_app bin/console doctrine:fixtures:load --no-interaction

docker exec -it hotels_score_app php -d memory_limit=2048M bin/console doctrine:fixtures:load --no-interaction
