<?php
namespace orch\V1\Rpc\Mag;

class MagControllerFactory
{
    public function __invoke($controllers)
    {
        return new MagController();
    }
}
