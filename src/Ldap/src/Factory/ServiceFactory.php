<?php

namespace Ldap\Factory;

use Symfony\Component\Yaml\Yaml;

class ServiceFactory
{
    public static function getConfig()
    {
        $reader = new \Laminas\Config\Reader\Yaml(function($val){
            return Yaml::parse($val);
        });
        return $reader->fromFile(__DIR__ . '/../../config/config.yml');
    }

    public static function createLdapManager()
    {
        $c = self::getConfig();
        return new \Ldap\Manager\LdapManager($c['LDAP_SERVER'], $c['LDAP_DN'], $c['LDAP_PASSWORD']);
    }
}