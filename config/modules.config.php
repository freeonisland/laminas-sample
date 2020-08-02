<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

/**
 * List of enabled modules for this application.
 *
 * This should be an array of module namespaces used in the application.
 */

return [
    'Laminas\Mvc\Plugin\FlashMessenger',
    'Laminas\Session',
    'Laminas\I18n',
    'Laminas\Cache',
    'Laminas\Db',
    'Laminas\Di', #for services auto-injection
    'Laminas\Form',
    'Laminas\Filter',
    'Laminas\Hydrator',
    'Laminas\InputFilter',
    'Laminas\Router',
    'Laminas\Validator',
    'Laminas\Mvc\Plugin\FlashMessenger',

    'LmConsole',

    'Application',
    'BlogTuto',
    'Event',
    'Service'
    //'Ldap',
    //'Soap'
];
