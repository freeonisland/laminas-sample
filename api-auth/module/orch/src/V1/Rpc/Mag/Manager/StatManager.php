<?php

namespace orch\V1\Rpc\Mag\Manager;

use orch\V1\Rpc\Mag\FakeData\FakeOrders;

/**
 * - Header get http_auth and validate
 * - get message
 * - return float
 * 
 * https://www.w3.org/TR/soap12-part1/#faultcodes
 * SOAPFault VersionMismatch, MustUnderstand, Sender, Receiver
 */
class StatManager 
{
    public static $URL = 'http://192.168.99.100:85/mag'; //http://192.168.99.100:82/soaps/index/getwsdl
    public static $NS = 'http://stats'; //must be http

    
    /**
     * @param string $alpha
     * @return string
     */
    public function getOrders(string $alpha): string 
    {
        return FakeOrders::getOrderData();
    }

} 
