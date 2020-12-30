<?php

namespace Application\Service;

class DepositService
{
    private $depot;

    function __construct()
    {
        echo 'DepotService instantiation';
    }

    function setDepot($depot)
    {
        $this->depot = $depot;
    }

    function getDepot()
    {
        return $this->depot;
    }
}