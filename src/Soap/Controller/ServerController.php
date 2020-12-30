<?php

namespace Soap\Controller;

// on indique au serveur à quel fichier de description il est lié
/*$serveurSOAP = new \SoapServer(__DIR__.'/../Envelope/request.xml');
// ajouter la fonction getHello au serveur
$serveurSOAP->addFunction('getHello');
// lancer le serveur
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $serveurSOAP->handle();
}
else
{
    echo 'désolé, je ne comprends pas les requêtes GET, veuillez seulement utiliser POST';
}
function getHello($prenom, $nom)
{
    return 'Hello ' . $prenom . ' ' . $nom;
}
die();*/
/** 
 * ref: http://www.w3.org/2001/12/soap-envelope
 *      http://www.w3.org/2001/12/soap-encoding
 * 
 * SOAP
 *  Envelope
 *  Header
 *  Body
 *  (Fault)
 *
 */
class ServerController
{
    public function indexAction()
    {
        ini_set("soap.wsdl_cache_enabled", "0");
        
        $options = [
            'location' => "http://192.168.99.100/soap/server",
            'uri'      => "http://192.168.99.100/soap/server",  
            'soap_version' => SOAP_1_2,
            'cache_wsdl'    =>  WSDL_CACHE_NONE
        ];
        try {
            $server = new \SoapServer('http://192.168.99.100/soap/server/getwsdl', $options);
            $server->setClass('\Soap\Manager\ServerManager'); 
          //  $server->addFunction('getMessage');
            //var_dump('rt');
            //$server->addSoapHeader(new \SoapServer(NULL, "Header", "value"));
            $server->handle();
            die();
        } catch(\SOAPFault $f) {
            print $f->faultString();
        }
    }

    public function getwsdlAction()
    {
        $autodiscover = new \Laminas\Soap\AutoDiscover();
        $autodiscover
            ->setClass('\Soap\Manager\ServerManager')
            ->setUri('http://192.168.99.100/soap/server')
            ->setBindingStyle();
            //->setServiceName('MySoapService');
            
        header('Content-Type: text/xml');
        $wsdl = $autodiscover->generate();
        //var_dump(get_class_methods($wsdl));
        
        //echo $autodiscover->toXml();
        echo $wsdl->toXML();
        
        die();
    }
}
