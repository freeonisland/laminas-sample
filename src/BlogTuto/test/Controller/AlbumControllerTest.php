<?php

namespace BlogTuto\Controller;

use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Stdlib\Parameters;
use Laminas\Db\{Adapter\AdapterInterface, ResultSet\ResultSet};


/*************************
 * 
 *  Full Coverage for DEMO 100%
 * 
 */
class AlbumControllerTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;

    const MODULE = 'BlogTuto';
    const ROUTE = '/album-tuto';

    protected $mockTAble;

    public function setUp(): void
    {
        $config = include __DIR__.'/../../../../config/application.config.php';
        $config['controllers']['abstract_factories'] = '';
        $this->setApplicationConfig(
            $config
        );
        parent::setUp();
      
        $this->mockTable = $this->createMock(\BlogTuto\Table\AlbumTable::class);
        
        $services = $this->getApplicationServiceLocator();
        $config = $services->get('config');

        //var_dump($config['service_manager']);die();
        $mockTable = $this->mockTable;
        $config['service_manager']['factories'][\BlogTuto\Table\AlbumTable::class] = 
            function ($container) use ($mockTable) {
                return $mockTable;
            }
        ;

        $services->setAllowOverride(true);
        //unset($config['db']);
        $services->setService('config', $config);
        $services->setService(\BlogTuto\Table\AlbumTable::class, $this->mockTable);
        //$services->setService('config', $config);
        $services->setAllowOverride(false);

    }

    public function testIndex()
    {
        $this->mockTable->method('fetchAll')->willReturn(['artist'=>'mocked','title'=>'title mock','id'=>5]);

        // Dispatch
        $this->dispatch(self::ROUTE, 'GET', ['action' => 'index']);

        // test
        $this->assertResponseStatusCode(200);
        $this->assertModuleName(self::MODULE);
        $this->assertControllerName(self::MODULE.'\Controller\AlbumController');
        $this->assertControllerClass('AlbumController');
        $this->assertMatchedRouteName('album-tuto');

        $this->assertQueryContentRegex('table th','/Title/');
    }

    public function testCreatePage()
    {
        $this->mockTable->method('saveAlbum')->willReturn('ok create!');

        /***
         * POST
         */
        $csrf = (new \Laminas\Form\Element\Csrf('csrf'))->getCsrfValidator()->getHash();
        $this->dispatch(self::ROUTE.'/create', 'POST', [
            'title' => 'test',
            'artist' => 'test',
            'csrf'=>$csrf
        ]);

        // test
        $this->assertResponseStatusCode(302); //ok: redirect
    }

    public function testFailCreatePage()
    {
        /***
         * POST
         */
        $this->dispatch(self::ROUTE.'/create', 'POST', [
            'title' => 'test',
            'artist' => 'test',
            'csrf'=>'not_valid'
        ]);

        // test
        $this->assertResponseStatusCode(200); 
        $this->assertQueryContentRegex('h1','/Create/');
    }

    public function testEditPage()
    {
        $obj = $this->createMock(\ArrayObject::class);
        $obj->method('getArrayCopy')->willReturn(['artist'=>'mocked','title'=>'title mock','id'=>1]);

        $this->mockTable->method('getAlbum')->willReturn($obj);
        $this->mockTable->method('saveAlbum')->willReturn('ok edit!');

        // Dispatch
        $this->dispatch(self::ROUTE.'/edit/1');
        
        // test
        $this->assertResponseStatusCode(200);
        $this->assertQueryContentRegex('h1','/Edit/');
    }

    public function testFailEditPage()
    {
        $album = new \BlogTuto\Model\Album;
        $obj = $this->createMock(\BlogTuto\Model\Album::class);
        $obj->method('getArrayCopy')->willReturn(['artist'=>'mocked','title'=>'title mock','id'=>1]);
        $obj->method('getInputFilter')->willReturn($album->getInputFilter());

        $this->mockTable->method('getAlbum')->willReturn($obj);

        /***
         * POST
         */
        $this->dispatch(self::ROUTE.'/edit/1', 'POST', [
            'title' => 'test',
            'artist' => 'test',
            'csrf'=>'not_valid'
        ]);

        // test
        $this->assertResponseStatusCode(302); 
    }

    public function testNoIdEditPage()
    {
        /***
         * POST
         */
        $this->dispatch(self::ROUTE.'/edit');

        // test
        $this->assertResponseStatusCode(302); 
    }

    
    public function testNoValidEditPage()
    {
        $album = new \BlogTuto\Model\Album;
        $obj = $this->createMock(\BlogTuto\Model\Album::class);
        $obj->method('getArrayCopy')->willReturn(['artist'=>'mocked','title'=>'title mock','id'=>1]);
        $obj->method('getInputFilter')->willReturn($album->getInputFilter());

        $this->mockTable->method('getAlbum')->willReturn($obj);

        /***
         * POST
         */
        $this->dispatch(self::ROUTE.'/edit/1', 'POST', [
            'title' => '', #empty data
            'artist' => '',
            'csrf'=>'not_valid'
        ]);

        // test
        $this->assertResponseStatusCode(200); 
    }

    
    /**
     * for code coverage total
     *      with no @codeCoverageIgnoreStart 
     *      or @codeCoverageIgnoreEnd
     */
    public function testRedirectWhenExceptionEditPage()
    {
        // PHPUnit\Framework\MockObject\Builder\InvocationMocker::willThrowException()
        $this->mockTable->method('getAlbum')->willThrowException(new \Exception);

        //don't work:
        //$this->mockTable->method('getAlbum')->willThrow($this->throwException(new \Exception));

        $this->dispatch(self::ROUTE.'/edit/10');
        $this->assertResponseStatusCode(302); 
    }

    /**
     * delete
     */
    public function testDeletePage()
    {
        $obj = $this->createMock(\ArrayObject::class);
        $obj->method('getArrayCopy')->willReturn(['artist'=>'mocked','title'=>'title mock','id'=>1]);

        $this->mockTable->method('getAlbum')->willReturn($obj);
        $this->mockTable->method('deleteAlbum')->willReturn('ok delete!');

        /***
         * POST
         */
        $csrf = (new \Laminas\Form\Element\Csrf('csrf'))->getCsrfValidator()->getHash();
        $this->dispatch(self::ROUTE.'/delete/1', 'POST', [
            'title' => 'test',
            'artist' => 'test',
            'csrf'=>$csrf
        ]);


        // test
        $this->assertResponseStatusCode(302);
    }

    public function testDeleteNotIdPage()
    {
        /***
         * POST
         */
        $this->dispatch(self::ROUTE.'/delete');

        // test
        $this->assertResponseStatusCode(302); 
    }

    public function testDeletePostPage()
    {
        /***
         * POST
         */
        $this->dispatch(self::ROUTE.'/delete/1', 'POST', [
            'validate_delete' => true
        ]);

        // test
        $this->assertResponseStatusCode(302); 
    }

    public function testDeleteGetPage()
    {
        $obj = $this->createMock(\ArrayObject::class);
        $obj->method('getArrayCopy')->willReturn(['artist'=>'mocked','title'=>'title mock','id'=>1]);

        $this->mockTable->method('getAlbum')->willReturn($obj);

        $this->dispatch(self::ROUTE.'/delete/1', 'GET', [
            'validate_delete' => true
        ]);

        $this->assertResponseStatusCode(200); 
    }
}