<?php

namespace Ldap\Manager;

abstract class AbstractLdapManager
{
    protected $ldapServer;
    protected $ldapDn;
    protected $ldapPass;

    protected $basedn;

    public function __construct($ldap_server, $ldap_dn, $ldap_pass)
    {
        $this->ldapServer = $ldap_server;
        $this->ldapDn = $ldap_dn;
        $this->ldapPass = $ldap_pass;

        $this->basedn = 'dc=my-company,dc=com';

        $this->connect();
    }

    public abstract function connect(): bool;
}