<?php

namespace Soap\Manager;

class ServerManager 
{
    private $user_is_valid;
    
    /**
     * @param string
     * @return string
     */
    public function getMessage(string $strNom): string
    {
        //var_dump('zertzetzer');
        return 'Login(s) dates: ' . $strNom;
    }

    /**
     * @param string
     * @return string
     */
    public function getMessageWsdl(string $strNom): string
    {
        //var_dump('zertzetzer');
        return 'Login(s) WSDL dates: ' . $strNom;
    }

    /**
     * @return int
     */
    function header($header) 
    {
        if ((isset($header->Username)) && (isset($header->Password))) {
            if (ValidateUser($header->Username, $header->Password)) {
                $user_is_valid = true;
            }
        }
    }

    public function getting()
    {
        echo 'ERT';
        return 'AZE';
    }

    public function add($x, $y)
    {
        return $x + $y;
    }
    
    function soapRequest($request) 
    {
        if ($user_is_valid) {
            // process request
            echo 'ok';
        }
        else {
            throw new MyFault("MySoapRequest", "User not valid.");
        }
    }
} 
