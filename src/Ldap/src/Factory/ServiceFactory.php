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

    public static function createLaminasManager()
    {
        $c = self::getConfig();
        return new \Ldap\Manager\LaminasManager($c['LDAP_SERVER'], $c['LDAP_DN'], $c['LDAP_PASSWORD']);
    }
}