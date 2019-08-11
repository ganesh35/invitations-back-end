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
