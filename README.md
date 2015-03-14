[![Build Status](https://travis-ci.org/juliangut/slim-session-middleware.svg?branch=master)](https://travis-ci.org/juliangut/slim-session-middleware)
[![Code Coverage](https://scrutinizer-ci.com/g/juliangut/slim-session-middleware/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/juliangut/slim-session-middleware/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/juliangut/slim-session-middleware/v/stable.svg)](https://packagist.org/packages/juliangut/zf-maintenance)
[![Total Downloads](https://poser.pugx.org/juliangut/slim-session-middleware/downloads.svg)](https://packagist.org/packages/juliangut/slim-session-middleware)

# Juliangut Slim Framework session handler middleware

Session handler middleware for Slim Framework.

## Installation

Best way to install is to using [Composer](https://getcomposer.org/):

```
composer require juliangut/slim-session-middleware
```

Then require_once the autoload file:

```php
require_once './vendor/autoload.php';
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
