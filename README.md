# Juliangut Slim Framework session handler middleware

Session handler middleware for Slim Framework.

## Installation

Best way to install is to using [Composer](https://getcomposer.org/):

```
composer require juliangut/slim-sess-middleware
```

Then require_once the autoload file:

```php
require_once 'vendor/autoload.php';
```

## Usage

Just add as any other middleware.

```php
use Slim\Slim;
use Jgut\Slim\Middleware\SessionMiddleware;

$app = new Slim();
$app->add((new SessionMiddleware())
    ->name('session')
    ->lifetime(4800)
);
```
