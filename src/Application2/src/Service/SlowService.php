<?php

namespace Application\Service;

class SlowService
{
    function __construct()
    {
        echo 'SLOW... instantiation';
    }

    function init()
    {
        return 'ok';
    }
}