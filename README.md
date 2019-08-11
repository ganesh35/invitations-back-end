# Setting up Symfony 3.4

## Installation

- Install symfony client
from https://symfony.com/download

- Create empty project
```sh
symfony new api --version=3.4
cd api
composer require annotations

```

- dev dependencies
```sh
composer require symfony/maker-bundle --dev
```


- Run server
```sh
composer require server --dev
php bin/console server:run
```


## Doctrine / ORM
- Installation
```sh
composer require orm
```

- Create entity
To create Invitation Entity
```sh
php bin/console make:entity
```


- Create migrations
Migrations will be created in "src/Migrations" folder
```sh
php bin/console make:migration
```

- Execute migrations
This will update (mysql) database
```sh
php bin/console doctrine:migrations:migrate
```




- Execute Data Fixtures
It stores the mock data to database
```sh
composer require --dev orm-fixtures
php bin/console doctrine:fixtures:load
```


- Create new controller

```sh
php bin/console make:controller
```


- JSON Serializer
We need a serializer. A serializer is responsible for turning our objects - in our case our Album entity - into a different format - again, in our case, JSON.

- installation
```sh
composer require symfony/serializer-pack
```

- usage
```php
//File: src/Controller/InvitationsController.php
use Symfony\Component\Serializer\SerializerInterface;
class InvitationsController extends Controller
{
 	public function __construct(
        SerializerInterface $serializer
    ){
        $this->serializer = $serializer;
    }
     public function list(Request $request)
    {
        $paginator = new Paginator($request, $this->container);
        list($count, $res)   = $this->invitationRepository->getResultAndCount( $where, $sort, $paginator->getRecordsPerPage(), $paginator->getCurrentPage() );
        $paginator->setTotalPages($count);

        return $this->json([
            'items' => $this->serializer->serialize($res, 'json')
        ]);
    }
}    

```







## CORS
Installation
```sh
composer req cors
```


##  Decode and verify Amazon Cognito JWT tokens 
Installation
```sh
// composer require web-token/jwt-framework
// composer require web-token/jwt-bundle
// composer require firebase/php-jwt
composer require adhocore/jwt
```

Cognito jwks keys:
https://cognito-idp.eu-central-1.amazonaws.com/eu-central-1_zminrYkRy/.well-known/jwks.json