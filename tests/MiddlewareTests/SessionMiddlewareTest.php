<?php

namespace Jgut\Slim\MiddlewareTests;

use Jgut\Slim\Middleware\SessionMiddleware;

class SessionMiddlewareTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (in_array(session_status(), [PHP_SESSION_DISABLED, PHP_SESSION_ACTIVE])) {
            session_destroy();
        }
    }

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
        $this->assertEquals(true, $session->getSecure());
        $this->assertEquals(true, $session->getHttponly());
    }

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
            'lifetime' => 7200,
            'path'     => '/',
            'domain'   => 'mydomain.com',
            'secure'   => false,
            'httponly' => true,
        ];
        $this->assertEquals($params, session_get_cookie_params());
    }

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
