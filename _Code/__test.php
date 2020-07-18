use Laminas\Code\Generator\{FileGenerator, ClassGenerator, MethodGenerator};

include __DIR__.'/../vendor/autoload.php';

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