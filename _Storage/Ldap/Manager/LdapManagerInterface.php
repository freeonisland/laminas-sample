<?php

namespace App\Storage\Ldap\Manager;

interface LdapManagerInterface
{
    function connect(): bool;
}