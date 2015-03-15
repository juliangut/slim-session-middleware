<?php
/**
 * Slim Framework session handler middleware (https://github.com/juliangut/slim-session-middleware)
 *
 * @link https://github.com/juliangut/slim-session-middleware for the canonical source repository
 * @license https://raw.githubusercontent.com/juliangut/slim-session-middleware/master/LICENSE
 */

namespace Jgut\Slim\MiddlewareTests;

use Jgut\Slim\Middleware\SessionMiddleware;

/**
 * @covers Jgut\Slim\Middleware\SessionMiddleware
 */
class SessionMiddlewareTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Remove previously started sessions.
     */
    public function setUp()
    {
        if (in_array(session_status(), [PHP_SESSION_DISABLED, PHP_SESSION_ACTIVE])) {
            session_destroy();
        }
    }

    /**
     * @covers Jgut\Slim\Middleware\SessionMiddleware::setName
     * @covers Jgut\Slim\Middleware\SessionMiddleware::setLifetime
     * @covers Jgut\Slim\Middleware\SessionMiddleware::setPath
     * @covers Jgut\Slim\Middleware\SessionMiddleware::setDomain
     * @covers Jgut\Slim\Middleware\SessionMiddleware::setSecure
     * @covers Jgut\Slim\Middleware\SessionMiddleware::setHttponly
     * @covers Jgut\Slim\Middleware\SessionMiddleware::getName
     * @covers Jgut\Slim\Middleware\SessionMiddleware::getLifetime
     * @covers Jgut\Slim\Middleware\SessionMiddleware::getPath
     * @covers Jgut\Slim\Middleware\SessionMiddleware::getDomain
     * @covers Jgut\Slim\Middleware\SessionMiddleware::isSecure
     * @covers Jgut\Slim\Middleware\SessionMiddleware::isHttponly
     */
    public function testGetterSetter()
    {
        $session = (new SessionMiddleware())
            ->setName('test')
            ->setLifetime(12)
            ->setPath('home')
            ->setDomain('mydomain.com')
            ->setSecure(true)
            ->setHttponly(true);

        $this->assertEquals('test', $session->getName());
        $this->assertEquals(12, $session->getLifetime());
        $this->assertEquals('home', $session->getPath());
        $this->assertEquals('mydomain.com', $session->getDomain());
        $this->assertEquals(true, $session->isSecure());
        $this->assertEquals(true, $session->isHttponly());
    }

    /**
     * @covers Jgut\Slim\Middleware\SessionMiddleware::setName
     * @covers Jgut\Slim\Middleware\SessionMiddleware::setDomain
     * @covers Jgut\Slim\Middleware\SessionMiddleware::start
     */
    public function testSessionParams()
    {
        $session = (new SessionMiddleware())
            ->setName('test')
            ->setDomain('mydomain.com');

        $this->assertEquals(PHP_SESSION_NONE, session_status());

        $session->start();

        $this->assertEquals(PHP_SESSION_ACTIVE, session_status());
        $this->assertEquals('test', session_name());

        $params = [
            'lifetime' => 1800,
            'path'     => '/',
            'domain'   => 'mydomain.com',
            'secure'   => false,
            'httponly' => true,
        ];
        $this->assertEquals($params, session_get_cookie_params());
    }

    /**
     * @covers Jgut\Slim\Middleware\SessionMiddleware::setName
     * @covers Jgut\Slim\Middleware\SessionMiddleware::start
     */
    public function testAlreadyStartedSession()
    {
        session_name('original');
        @session_start(); //Silence headers sent warning

        $this->assertEquals(PHP_SESSION_ACTIVE, session_status());

        $session = (new SessionMiddleware())
            ->setName('test');
        $session->start();

        $this->assertEquals('original', session_name());
    }
}
