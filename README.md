[![Build Status](https://travis-ci.org/juliangut/slim-session-middleware.svg?branch=master)](https://travis-ci.org/juliangut/slim-session-middleware)
[![Code Climate](https://codeclimate.com/github/juliangut/slim-session-middleware/badges/gpa.svg)](https://codeclimate.com/github/juliangut/slim-session-middleware)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/juliangut/slim-session-middleware/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/juliangut/slim-session-middleware/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/juliangut/slim-session-middleware/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/juliangut/slim-session-middleware/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/juliangut/slim-session-middleware/v/stable.svg)](https://packagist.org/packages/juliangut/slim-session-middleware)
[![Total Downloads](https://poser.pugx.org/juliangut/slim-session-middleware/downloads.svg)](https://packagist.org/packages/juliangut/slim-session-middleware)

# Juliangut Slim Framework session handler middleware

Session handler middleware for Slim Framework.

## Installation

Best way to install is using [Composer](https://getcomposer.org/):

```
php composer.phar require juliangut/slim-session-middleware
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

## License

### Release under BSD-3-Clause License.

See file [LICENSE](https://github.com/juliangut/slim-session-middleware/blob/master/LICENSE) included with the source code for a copy of the license terms
