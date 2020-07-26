<?php

namespace Console;

include __DIR__.'/../../vendor/autoload.php';

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
            '<module_name>' => 'Module where to put the generated create controller. (max 20 chars)',
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


CliConsole::run($routes);

final class CliConsole
{
    private $console;
    private $routes;

    public static function run(array $routes)
    {
        (new self($routes))->handle();
    }

    public function __construct(array $routes)
    {
        $this->routes = $routes;

        try {
            $this->console = Console::getInstance();
        } catch (ConsoleException $e) {
            echo $e->getMessage();
            die();
        }
    }

    /*
     * $console->write(string $text, $color = null, $bgColor = null)
        $console->writeLine(string $text, $color = null, $bgColor = null)
        $console->writeAt(string $text, int $x, int $y, $color = null, $bgColor = null)

        $console->clear()
        $console->clearLine()
     */
    /*
     * $console->readChar(string $mask = null)
        $console->readLine(int $maxLength = 2048)
     */
    public function handle()
    {
        $request = $this->getRequest();
        $this->dispatchRoutes($request);
    }

    
    /**
     * callable
     * function (\ZF\Console\Route $route, \Zend\Console\Adapter\AdapterInterface $console) {}
     */
    /*
     * Initialize the application
     *
     * Creates a RouteCollection and populates it with the $routes provided.
     *
     * Sets the banner to call showVersion().
     *
     * If no help command is defined, defines one.
     *
     * If no version command is defined, defines one.
     *
     * @param string $name Application name
     * @param string $version Application version
     * @param array|Traversable $routes Routes/route specifications to use for the application
     * @param Console $console Console adapter to use within the application
     * @param DispatcherInterface $dispatcher Configured dispatcher mapping routes to callables
     *
    public function __construct(
        $name,
        $version,
        $routes,
        Console $console = null,
        DispatcherInterface $dispatcher = null
    ) {
     */
    private function dispatchRoutes(array $request)
    {
        $dispatcher = new \ZF\Console\Dispatcher;
       // $dispatcher->map('self-update', new SelfUpdate($version));
       // $dispatcher->map('build', 'My\Build');
        $dispatcher->map('test', function (Route $route, AdapterInterface $console) {
            //var_dump($route);
            echo '*** You just said '."\n";
        });

        $application = new \ZF\Console\Application(
            'Builder',
            VERSION,
            $this->routes,
            Console::getInstance(),
            $dispatcher
        );

        $application->setBanner('Some ASCI art for a banner!'); // string
        $application->setBanner(function ($console) {           // callable
            $console->writeLine(
                $console->colorize('Builder', ColorInterface::BLUE)
                . ' - for building deployment packages'
            );
            $console->writeLine('');
            $console->writeLine('Usage:', ColorInterface::GREEN);
            $console->writeLine(' ' . basename(__FILE__) . ' command [options]');
            $console->writeLine('');
        });

        $application->setFooter('Generate console');
        $application->setDebug(true);

        $exit = $application->run();
        exit($exit);
    }

    /*
    Request

    * ring(9) "setParams"
  [2]=>
  string(9) "getParams"
  [3]=>
  string(8) "getParam"
  [4]=>
  string(6) "params"
  [5]=>
  string(6) "setEnv"
  [6]=>
  string(6) "getEnv"
  [7]=>
  string(3) "env"
  [8]=>
  string(8) "toString"
  [9]=>
  string(10) "__toString"
  [10]=>
  string(13) "setScriptName"
  [11]=>
  string(13) "getScriptName"
  [12]=>
  string(11) "setMetadata"
  [13]=>
  string(11) "getMetadata"
  [14]=>
  string(10) "setContent"
  [15]=>
  string(10) "getContent"
    */
    private function getRequest(): array
    {
        $r = new Request; #read from args
       // var_dump(get_class_methods($this->console));
       
        return $r->getContent();
    }

    
// class Router extends \Laminas\Console\RouteMatcher\DefaultRouteMatcher
// {
//     /**
//      * @param string $route
//      * @param array $constraints
//      * @param array $defaults
//      * @param array $aliases
//      * @param array $filters
//      * @param ValidatorInterface[] $validators
//      * @throws Exception\InvalidArgumentException
//      */
//     public function __construct(
//         $route,
//         array $constraints = [],
//         array $defaults = [],
//         array $aliases = [],
//         array $filters = null,
//         array $validators = null
//     ) {

//     }
// }
/*************************
 * ROUTER
 * interface RouteMatcherInterface
 * public function match($params);
 * 
 * GET ONLY PARAMETERS!!! -> alpha [all] : all, and not alpha
 
 * 
    Literal parameters (e.g. create object (external|internal))
    Literal flags (e.g. --verbose --direct [-d] [-a])
    Positional value parameters (e.g. create <modelName> [<destination>])
    Value flags (e.g. --name=NAME [--method=METHOD])
    Named literal alternative groups (e.g., (all|some|none):filter)
    Catch-all parameters (e.g. [...params])
 */
    private function processSingleRoute(array $params)
    {
        return;
        /**
         * ROUTE: alpha trust [all]
         * php source/console.php alpha trust all
         * ['all'=>true]
         * 
         * ROUTE: say [loudly|softly]:volume [...words]
         * php source/console.php say loudly I am here
         */
        $say = new DefaultRouteMatcher(
            'say [loudly|softly]:volume [...words]',
            [], [], [], [
                'volume' => new \Laminas\I18n\Filter\Alpha
            ]
        );   
        $res = $say->match($params);   //(["create", 'object', 'external']);

    }

    /* CONFIRM | LINE | CHAR | SELECT | PASSWORD
        $confirm = new Laminas\Console\Prompt\Confirm('Are you sure you want to continue?');
        $result = $confirm->show();
        if ($result)
    */
    private function prompt()
    {

    }

    private function displayHelp()
    {

    }
}


/**
 * Generate
 */
class Generate
{
    public function __invoke(): int
    {
        var_dump('********Generate');
        return 0;
    }

    
}