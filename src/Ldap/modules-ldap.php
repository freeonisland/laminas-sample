<?php

return [
    'LaminasManager' => new \Ldap\Manager\LaminasManager(
        $config->get('LDAP_SERVER'), $config->get('LDAP_DN'), $config->get('LDAP_PASSWORD')
    )/*,

    'SimpleManager' => new \Ldap\Manager\SimpleManager(
        $config->get('LDAP_SERVER'), $config->get('LDAP_DN'), $config->get('LDAP_PASSWORD')
    )*/
];