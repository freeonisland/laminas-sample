<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace LdapTest\Manager;

use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Ldap\Manager\LaminasManager;

class LdapManagerTest extends AbstractHttpControllerTestCase
{
    public function setUp() : void
    {
        $this->setApplicationConfig(
            include __DIR__ . '/../../../../config/application.config.php'
        );

        parent::setUp();
    }

    public function testCanConnect()
    {
        $laminas = \Ldap\Factory\ServiceFactory::createLaminasManager();
        $conn = $laminas->connect();
        $this->assertTrue($conn);
    }
}
