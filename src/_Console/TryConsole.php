<?php

namespace Console;

include __DIR__.'/../vendor/autoload.php';

use Laminas\Console\{
    Route, 
    Console, 
    Request,
    RouteMatcher, 
    ColorInterface,
    AdapterInterface, 
    ExceptionInterface,
    RouteMatcher\DefaultRouteMatcher
};
use Laminas\Filter\Callback as CallbackFilter;

define('VERSION', '1.0.0');

class TryConsole
{
    function try()
    {
        /*
        *  $route = new \ZF\Console\Route(
                $name,
                $route,
                $constraints, // optional
                $defaults,    // optional
                $aliases,     // optional
                $filters,     // optional
                $validators   // optional
            );
            $route->setDescription($description);
            $route->setShortDescription($shortDescription);
            $route->setOptionsDescription($optionsDescription);
        */

        $routes = [
            [
                'name'  => 'generate:create',
                'route' => 'generate:create <module_name> <entity>',
                'description' => 'Generate module -Create-, with controller, form and .phtml template, from <module_name> and doccomments <entity>.',
                'options_descriptions' => [
                    '<module_name>' => 'Module where to put the generated create controller.',
                    '<entity>' => 'Entity from which to get -doccomments- informations.'
                ],
                'defaults' => [
                    'target' => getcwd(), // default to current working directory
                ],
                'filters' => array(
                /* 'exclude' => new CallbackFilter(function ($value) {
                        var_dump($value);
                        if (! is_string($value)) {
                            return $value;
                        }
                        $exclude = explode(',', $value);
                        array_walk($exclude, 'trim');
                        return $exclude;
                    }),*/
                ),
                'validators' => [
                    'module_name' => new \Laminas\Validator\StringLength( ['min' => 0, 'max'=> 20])
                ],
                'handler' => 'Console\Generate'
            ],
            [
                'name'  => 'test',
                'route'  => 'test [loudly|softly]:volume [...words]',
                'description' => 'Try differents parameters and their results in console mode.',
                'short_description' => 'Try differents parameters',
                'options_descriptions' => [
                    '--target'  => 'Name of the application directory to package; defaults to current working directory',
                ],
            ]   
        ];
    }

}