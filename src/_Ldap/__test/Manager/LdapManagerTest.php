<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace LdapTest\Manager;

use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Ldap\Manager\LdapManager;

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
        $ldap = \Ldap\Factory\ServiceFactory::createLdapManager();
        $ldap->connect();
        $res=$ldap->search('cn={}');
        $this->assertEquals($res,[]);
    }

    public function testLdapCrud()
    {
        $ldap = \Ldap\Factory\ServiceFactory::createLdapManager();
        $ldap->connect();

        $name = 'unittest_user_cn';
        $ldap->add('person', ['cn'=>$name,'sn'=>'essai_user_sn']);
        $res=$ldap->search("cn={$name}");
        $ldap->update('person', $name, ['sn'=>'essai_user_sn2']);
        $res=$ldap->search('cn='.$name)[0];
        $this->assertArrayHasKey('sn',$res);
        $this->assertEquals($res['sn'][0],'essai_user_sn2');
        $ldap->delete($name);
    }

    public function testCanSimpleConnect()
    {
        $ldap = \Ldap\Factory\ServiceFactory::createSimpleManager();
        $conn = $ldap->connect();
        $this->assertTrue($conn);
    }
}
