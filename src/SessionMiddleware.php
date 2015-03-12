<?php

namespace Jgut\Slim\Middleware;

use Slim\Middleware;

class SessionMiddleware extends Middleware
{
    protected $name = 'Juliangut/Session';

    protected $lifetime = 1800; //30 minutes

    protected $path = '/';

    protected $domain;

    protected $secure = false;

    protected $httponly = true;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getLifetime()
    {
        return $this->lifetime;
    }

    public function setLifetime($lifetime)
    {
        $this->lifetime = (int) $lifetime;

        return $this;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    public function getDomain()
    {
        return $this->domain;
    }

    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    public function getSecure()
    {
        return $this->secure;
    }

    public function setSecure($secure)
    {
        $this->secure = (bool) $secure;

        return $this;
    }

    public function getHttponly()
    {
        return $this->httponly;
    }

    public function setHttponly($httponly)
    {
        $this->httponly = (bool) $httponly;

        return $this;
    }

    public function call()
    {
        $this->start();

        $this->next->call();
    }

    public function start()
    {
        if (in_array(session_status(), [PHP_SESSION_DISABLED, PHP_SESSION_ACTIVE])) {
            return;
        }

        session_name($this->getName());
        call_user_func_array('session_set_cookie_params', $this->getSessionCookieParams());

        if (PHP_SAPI === 'cli') {
            @session_start(); //Silence headers sent warning
        } else {
            session_start();
        }
    }

    public function getSessionCookieParams()
    {
        $sessParams = session_get_cookie_params();

        return [
            'lifetime' => $this->getLifetime() ?: $sessParams['lifetime'],
            'path'     => $this->getPath() ?: $sessParams['path'],
            'domain'   => $this->getDomain() ?: $sessParams['domain'],
            'secure'   => $this->getSecure(),
            'httponly' => $this->getHttponly(),
        ];
    }
}
