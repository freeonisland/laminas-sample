<?php

namespace AlbumTest\Table;

use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Laminas\Stdlib\Parameters;

class AlbumTableTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;

    public function setUp(): void
    {
        $this->setApplicationConfig(
            include 'config/application.config.php'
        );
        parent::setUp();
    }

    public function testIndex()
    {
        # dispatch
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(new Parameters(['argument' => 'value']));
        $this->dispatch('/album', 'GET', ['action' => 'index']);

        # test
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('album');
        $this->assertControllerName('album\controller\indexcontroller');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('album');

        $this->assertQueryContentRegex('table','/Ratke/');
    }

    public function testCreate()
    {
        # dispatch
        $this->dispatch('/album/create', 'GET');

        # test
        $this->assertResponseStatusCode(200);
    }
}