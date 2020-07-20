global.php
```
return [
    // ...
    'db' => [
        'driver' => 'PDO', #for providing adapter interface drivers
        'dsn' => sprintf('sqlite:%s/data/sqlite/album.db', realpath(getcwd()))
    ]
];
```

development.config.php
```
return [
    // Additional modules to include when in development mode
    'modules' => [
        'Laminas\DeveloperTools'
    ],
    // Configuration overrides during development mode
    'module_listener_options' => [
        'config_glob_paths' => [realpath(__DIR__) . '/autoload/{,*.}{global,local}-development.php'],
        'config_cache_enabled' => false,
        'module_map_cache_enabled' => false,
    ],
];
```



TESTING (mock)

```
<?php
namespace AlbumTest\Table;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Laminas\Stdlib\Parameters;
#mock database
use Album\Table\AlbumTable;
use Laminas\ServiceManager\ServiceManager;
class AlbumTableTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;
    public function setUp(): void
    {
        $this->setApplicationConfig(
            include 'config/application.config.php'
        );
        parent::setUp();
        
        $services = $this->getApplicationServiceLocator();
        $config = $services->get('config');
        #remove database connection for testing
        unset($config['db']); 
        $services->setAllowOverride(true);
        $services->setService('config', $config);
        $services->setAllowOverride(false);
        #new config
        $this->configureServiceManager($services);
    }
    protected function configureServiceManager(ServiceManager $services)
    {
        $services->setAllowOverride(true);
        $services->setService('config', $this->updateConfig($services->get('config')));
        $services->setService(AlbumTable::class, $this->mockAlbumTable()->reveal());
        $services->setAllowOverride(false);
    }
    protected function updateConfig($config)
    {
        $config['db'] = [];
        return $config;
    }
    protected function mockAlbumTable()
    {
        $this->albumTable = $this->prophesize(AlbumTable::class);
        return $this->albumTable;
    }
    public function testIndex()
    {
        $this->albumTable->fetchAll()->willReturn([
            (object)['id'=>1, 'artist'=>'Ratke_mocked_value', 'title'=>'azerty']
        ]);
        # dispatch
        $this->getRequest()
            ->setMethod('POST')
            ->setPost(new Parameters(['argument' => 'value']));
        $this->dispatch('/album', 'GET', ['action' => 'index']);
        # test
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('album');
        $this->assertControllerName('album\controller\indexcontroller');
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('album');
        $this->assertQueryContentRegex('table','/Ratke_mocked_value/');
    }
    public function testCreate()
    {
        # dispatch
        $this->dispatch('/album/create', 'GET');
        # test
        $this->assertResponseStatusCode(200);
    }
}
```


tests
```
public function setUp(): void
    {
        $this->setApplicationConfig(
            include 'config/application.config.php'
        );
        parent::setUp();
        

        $services = $this->getApplicationServiceLocator();
        $config = $services->get('config');
        $this->realAlbumTable = $services->get(AlbumTable::class);

        #remove database connection for testing
        unset($config['db']); 
        $config['db'] = [];

        $services->setAllowOverride(true);
        $services->setService('config', $config);
        
        #new config
        //$this->configureServiceManager($services);
        //$services->setService('config', $this->updateConfig($services->get('config')));

        $this->albumTable = $this->prophesize(AlbumTable::class);
        $services->setService(AlbumTable::class, $this->albumTable->reveal());

        $services->setAllowOverride(false);
    }


 public function testEditActionAndRedirect()
    {
        $this->albumTable
            ->getAlbum(3)
            ->willReturn(new Album);
        
        $this->albumTable
            ->saveAlbum(Argument::type(Album::class))
            ->shouldBeCalled();
        
        $postData = [
            'id' => 3,
            'title'=> 'postedDataMocktitle',
            'artist' => 'postDataMockartist'
        ];
        $this->dispatch('/album/edit/3', 'POST', $postData);
        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/album');
    }
    public function testInitialAlbumValue()
    {
        $album = new Album;
        $this->assertNull($album->title);
    }
    public function testExchangeArray()
    {
        $album = new Album;
        $data = [
            'id'=>9999,
            'artist' => 'someone',
            'title' => 'something'
        ];
        $album->exchangeArray($data);
        $this->assertSame(
            $album->title,
            $data['title'],
            'title was not set properly'
        );
        $album->exchangeArray([]);
        $this->assertSame($album->title, null);
        #filter
        $filter = $album->getInputFilter();
        $this->assertSame(3, count($filter));
    }
```