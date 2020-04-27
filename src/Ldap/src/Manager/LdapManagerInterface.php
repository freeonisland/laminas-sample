<?php

namespace Ldap\Manager;

interface LdapManagerInterface
{
    function connect(): bool;
}