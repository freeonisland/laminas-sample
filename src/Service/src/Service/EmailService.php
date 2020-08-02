<?php

namespace Service\Service;

class EmailService 
{
    function send($body='body of email')
    {
        echo 'EMAIL SERVICE sending email: '.$body.'...<br/>';    
    }
}
