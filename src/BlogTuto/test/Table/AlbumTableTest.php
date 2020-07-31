<?php

namespace BlogTuto\Table;

use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Laminas\Stdlib\Parameters;

// to Mock database
use BlogTuto\Table\AlbumTable;
use BlogTuto\Model\Album;
use Laminas\ServiceManager\ServiceManager;

class AlbumTableTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;

    const MODULE = 'BlogTuto';
    const ROUTE = '/album-tuto';

    public function setUp(): void
    {
        $this->setApplicationConfig(
            include __DIR__.'/../../../../config/application.config.php'
        );
        parent::setUp();

        $services = $this->getApplicationServiceLocator();
        //$config = $services->get('config');
        $this->albumTable = $services->get(AlbumTable::class);

        /* 
         * Mocking data
         */
        // Remove database connection for testing
        //$config['db'] = [];
        $this->mockAlbumTable = $this->prophesize(AlbumTable::class);
        
        $services->setAllowOverride(true);
        $services->setService(AlbumTable::class, $this->mockAlbumTable->reveal());
        $services->setAllowOverride(false);
    }

    public function testIndex()
    {
        // Dispatch
        $this->mockAlbumTable
            ->fetchAll()
            ->willReturn([
                (object)['id'=>'mocked Id', 'artist'=>'mocked Artist', 'title'=>'mocked Title']
            ]);
        
        $this->dispatch(self::ROUTE, 'GET', ['action' => 'index']);

        // test
        $this->assertResponseStatusCode(200);
        $this->assertModuleName(self::MODULE);
        $this->assertControllerName(self::MODULE.'\Controller\AlbumController');
        $this->assertControllerClass('AlbumController');
        $this->assertMatchedRouteName('album-tuto');

        $this->assertQueryContentRegex('table tbody','/mocked Artist/');
    }

    public function testEditActionAndRedirect()
    {
        $this->mockAlbumTable
            ->getAlbum(3)
            ->willReturn(new Album);
        
        $this->mockAlbumTable
            ->saveAlbum(\Prophecy\Argument::type(Album::class))
            ->shouldBeCalled();
        
        $postData = [
            'id' => 3,
            'title'=> 'mocked post data title',
            'artist' => 'mocked post data artist'
        ];

        $this->dispatch(self::ROUTE.'/edit/3', 'POST', $postData);
       // $this->assertResponseStatusCode(302);
       $this->assertRedirectTo(self::ROUTE);
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

        // filter
        $filter = $album->getInputFilter();
        $this->assertSame(2, count($filter));
    }

    public function testCreate()
    {
        // dispatch
        $this->dispatch(self::ROUTE . '/create', 'GET');

        // test
        $this->assertResponseStatusCode(200);
    }
}