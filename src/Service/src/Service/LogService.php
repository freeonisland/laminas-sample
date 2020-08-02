<?php

namespace Service\Service;

class LogService 
{
    function log(string $msg, int $level=0)
    {
        echo 'LOG SERVICE - LOGGING of level: '.$level.' : '.$msg.'<br/>';    
    }
}
