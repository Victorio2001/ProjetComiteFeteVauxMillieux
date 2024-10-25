"php bin/console asset-map:compile" => pour reload les assets [ChartJS]

[
    Si nouvelles migration:
    -> docker compose exec app php bin/console make:migration
    -> docker compose exec app php bin/console doctrine:...:...
    -> Si problème
         Migrations === delete toutes migrations "migration/{...}"
    -> Si probleme table dossier
         /usr/app/var/cache/dev/ === delete Dossier log "Var/log"
]
composer install
docker compose up
symfony serve
docker compose exec app php bin/console doctrine:fixtures:load
[
  Si Problèmes bytes => "docker compose exec app php -d memory_limit=256M bin/console doctrine:fixtures:load"
]