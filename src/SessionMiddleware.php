<?php
/**
 * Slim Framework session handler middleware (https://github.com/juliangut/zf-maintenance)
 *
 * @link https://github.com/juliangut/slim-session-middleware for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/slim-session-middleware/master/LICENSE
 */

namespace Jgut\Slim\Middleware;

use Slim\Middleware;

class SessionMiddleware extends Middleware
{
    /**
     * PHP Session name.
     *
     * @var string $name
     */
    protected $name = 'JgutSession';

    /**
     * Session session cookies lifetime.
     *
     * @var int $lifetime
     */
    protected $lifetime = 1800; //30 minutes

    /**
     * Session session cookies base path.
     *
     * @var string $path
     */
    protected $path = '/';

    /**
     * Session session cookies domain.
     *
     * @var string $domain
     */
    protected $domain;

    /**
     * Session session cookies marked as secure.
     *
     * @var bool $secure
     */
    protected $secure = false;

    /**
     * Session session cookies httponly attribute.
     *
     * @var bool $httponly
     */
    protected $httponly = true;

    /**
     * Get PHP Session name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set PHP Session name.
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get session cookies lifetime.
     *
     * @return int
     */
    public function getLifetime()
    {
        return $this->lifetime;
    }

    /**
     * Set session cookies lifetime.
     *
     * @param int $lifetime
     */
    public function setLifetime($lifetime)
    {
        $this->lifetime = (int) $lifetime;

        return $this;
    }

    /**
     * Get session cookies base path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set session cookies base path.
     *
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get session cookies domain.
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Set session cookies domain.
     *
     * @param string $domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Get session cookies marked as secure.
     *
     * @return bool
     */
    public function isSecure()
    {
        return $this->secure;
    }

    /**
     * Set session cookies marked as secure.
     *
     * @param bool $secure
     */
    public function setSecure($secure)
    {
        $this->secure = (bool) $secure;

        return $this;
    }

    /**
     * Get session cookies httponly attribute.
     *
     * @return bool
     */
    public function isHttponly()
    {
        return $this->httponly;
    }

    /**
     * Set session cookies httponly attribute.
     *
     * @param bool $httponly
     */
    public function setHttponly($httponly)
    {
        $this->httponly = (bool) $httponly;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function call()
    {
        $this->start();

        $this->next->call();
    }

    /**
     * Initialize PHP Session.
     */
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

    /**
     * Get session cookie parameters.
     *
     * @return array
     */
    public function getSessionCookieParams()
    {
        $sessParams = session_get_cookie_params();

        return [
            'lifetime' => $this->getLifetime() ?: $sessParams['lifetime'],
            'path'     => $this->getPath() ?: $sessParams['path'],
            'domain'   => $this->getDomain() ?: $sessParams['domain'],
            'secure'   => $this->isSecure(),
            'httponly' => $this->isHttponly(),
        ];
    }
}
