<?php

namespace Console;

use Laminas\Code\Generator\{FileGenerator, ClassGenerator, MethodGenerator};
use Laminas\Code\Reflection\ClassReflection;

include __DIR__.'/../vendor/autoload.php';

class Lambda
{
    /**
     * @param int $par
     */
    public function settingUp(int $par): void
    {
        echo 'printed ';
    }
}

$file = new FileGenerator([
    'classes' => [
        new ClassGenerator(
            'Controller',  // name
            'Soap\\Controller',
            0, // flags
            null,
            null, // interfaces
            [
                ['pleusoiuersProperty',null,1]
            ], // properties
            [
                (new MethodGenerator(
                    'hello',                  // name
                    array(['name'=>'arg1','type'=>'int','defaultvalue'=>3],'arg2'),                  // parameters
                    0,                 // visibility
                    'echo \'Hello world!\';'  // body
                ))->setReturnType('void')
            ]
        )
    ]
]);

file_put_contents('source/_generated.php', $file->generate());











/*$file = new FileGenerator(array( #FileGenerator::fromArray([
    //'docblock' => DocBlockGenerator::fromArray([
    'classes' => array(
        new ClassGenerator(
            'World',  // name
            null,     // namespace
            null,     // flags
            null,     // extends
            array(),  // interfaces
            array(),  // properties
            array(
                new MethodGenerator(
                    'hello',                  // name
                    array(),                  // parameters
                    'public',                 // visibility
                    'echo \'Hello world!\';'  // body
                ),
            )
        ),
    ),
));*/




// Render the generated file
#echo $file->generate();

// or write it to a file:
#file_put_contents('World.php', $file->generate());

// OR

// Configuring after instantiation
/*$method = new MethodGenerator();
$method->setName('hello')
       ->setBody('echo \'Hello world!\';');

$class = new ClassGenerator();
$docblock = DocBlockGenerator::fromArray([
    'shortDescription' => 'Sample generated class',
    'longDescription'  => 'This is a class generated with Laminas\Code\Generator.',
    'tags'             => [
        [
            'name'        => 'version',
            'description' => '$Rev:$',
        ],
        [
            'name'        => 'license',
            'description' => 'New BSD',
        ],
    ],
]);
$class->setName('World')
        ->setDocblock($docblock)
        ->addProperties([
            ['_bar', 'baz', PropertyGenerator::FLAG_PROTECTED],
            ['baz',  'bat', PropertyGenerator::FLAG_PUBLIC]
        ])
        ->addConstants([
                ['bat',  'foobarbazbat']
        ])
        ->addMethods([
            // Method passed as array
            MethodGenerator::fromArray([
                'name'       => 'setBar',
                'parameters' => ['bar'],
                'body'       => '$this->_bar = $bar;' . "\n" . 'return $this;',
                'docblock'   => DocBlockGenerator::fromArray([
                    'shortDescription' => 'Set the bar property',
                    'longDescription'  => null,
                    'tags'             => [
                        new Tag\ParamTag([
                            'paramName' => 'bar',
                            'datatype'  => 'string'
                        ]),
                        new Tag\ReturnTag([
                            'datatype'  => 'string',
                        ]),
                    ],
                ]),
            ]),
            // Method passed as concrete instance
            new MethodGenerator(
                'getBar',
                [],
                MethodGenerator::FLAG_PUBLIC,
                'return $this->_bar;',
                DocBlockGenerator::fromArray([
                    'shortDescription' => 'Retrieve the bar property',
                    'longDescription'  => null,
                    'tags'             => [
                        new Tag\ReturnTag([
                            'datatype'  => 'string|null',
                        ]),
                    ],
                ])
            ),
        ])
        ->addMethodFromGenerator($method);

$file = new FileGenerator();
$file->setClass($class);*/

// Render the generated file
#echo $file->generate();

// or write it to a file:
#file_put_contents('World.php', $file->generate());