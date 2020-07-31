<?php

namespace BlogTuto\Controller;

use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Laminas\Stdlib\Parameters;

class BlogControllerTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;

    const MODULE = 'BlogTuto';
    const ROUTE = '/blog-tuto';

    public function setUp(): void
    {
        $this->setApplicationConfig(
            include __DIR__.'/../../../../config/application.config.php'
        );
        parent::setUp();

    }

    public function testIndex()
    {
        // Dispatch
        $this->dispatch(self::ROUTE, 'GET', ['action' => 'index']);

        // test
        $this->assertResponseStatusCode(200);
        $this->assertQueryContentRegex('body','/BLOG/');
    }
}