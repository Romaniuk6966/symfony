### OpenAPI
##### Installation
- `composer require nelmio/api-doc-bundle`

### CSFixer / PHPStan
##### Installation
- `composer require --dev friendsofphp/php-cs-fixer`
- `composer require --dev phpstan/phpstan`
##### Using
- `./vendor/bin/php-cs-fixer fix`
- `./vendor/bin/phpstan analyse src tests`

### Routing
##### Debugging Routes
- `php bin/console debug:router`
- `php bin/console router:match /lucky/number/8`

### Logging
##### Installation
- `composer require symfony/monolog-bundle`

### Doctrine
##### Installation
- `composer require symfony/orm-pack`
- `composer require --dev symfony/maker-bundle`
- `php bin/console doctrine:database:create`
##### Creating an Entity Class
- `php bin/console make:entity`
- `php bin/console make:entity --regenerate`
##### Migrations: Creating the Database Tables/Schema
- `php bin/console make:migration`
- `php bin/console doctrine:migrations:migrate`

### DoctrineFixturesBundle
##### Installation
`composer require --dev orm-fixtures`
##### Loading Fixtures
`php bin/console doctrine:fixtures:load --purge-with-truncate`

### PHPUnit
##### Installation
- `composer require --dev orm-fixtures`
- `composer require --dev helmich/phpunit-json-assert`
##### Using
- `php bin/console doctrine:migrations:migrate --env=test`