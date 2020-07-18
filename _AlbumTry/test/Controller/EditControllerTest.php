<?php

namespace AlbumTryTest;

use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class EditControllerTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;

    public function setUp(): void
    {
        $this->setApplicationConfig(
            include 'config/application.config.php'
        );
        parent::setUp();
    }

    public function testEdit()
    {
        $this->dispatch('/albumtry/edit/8', 'GET');

        $this->assertResponseStatusCode(200);
    }
}