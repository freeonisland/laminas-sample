<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-skeleton for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-skeleton/blob/master/LICENSE.md New BSD License
 */

namespace orch\V1\Rpc\Mag\FakeData;


class FakeOrdersTest extends \PHPUnit\Framework\TestCase
{
    public function testGetOrderData()
    {
        $fakeData = FakeOrders::getOrderData();
        $this->assertStringContainsString('Commande',$fakeData);
    }

    public function testExceptions()
    {
        
    }
}
