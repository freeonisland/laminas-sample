<?php
namespace orch\V1\Rpc\Mag;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Soap\Server as SoapServer;

if(!preg_match('/\:85$/',$_SERVER['HTTP_HOST'])) die('Wrong port, use 85');

final class MagController extends AbstractActionController
{
    /**
     * @throw SOAPFault
     */
    public function magAction()
    {
        if (isset($_REQUEST['wsdl'])) {
            $this->getStatWsdlAction();
            return;
        }

        ini_set("soap.wsdl_cache_enabled", "0");
        
        $options = [
            'location' => \orch\V1\Rpc\Mag\Manager\StatManager::$URL,
            'uri'      => \orch\V1\Rpc\Mag\Manager\StatManager::$NS,
            'soap_version' => SOAP_1_2,
            'cache_wsdl'    =>  WSDL_CACHE_NONE
        ];
        
        $server = new SoapServer(\orch\V1\Rpc\Mag\Manager\StatManager::$URL . '?wsdl', $options);
        $server->setClass(\orch\V1\Rpc\Mag\Manager\StatManager::class);
        
        try {
            $response = $server->handle();
        } catch(\SOAPFault $f) {
            error_log($f->getMessage(),3,__DIR__.'/log');

        } catch(\Exception $f) {
            error_log($f->getMessage(),3,__DIR__.'/log');
        } 
    }


    protected function getStatWsdlAction(): void
    {
        $autodiscover = new \Laminas\Soap\AutoDiscover();

        $autodiscover
            ->setClass('\orch\V1\Rpc\Mag\Manager\StatManager' )
            ->setUri(\orch\V1\Rpc\Mag\Manager\StatManager::$URL);
         //   ->setBindingStyle();
            
        header('Content-Type: text/xml');
        $wsdl = $autodiscover->generate();
        echo $wsdl->toXML();

        die(); 
    }
    
}
