<?php

namespace Soap\Controller;

/**
 * ref: http://www.w3.org/2001/12/soap-envelope
 *      http://www.w3.org/2001/12/soap-encoding
 * 
 * SOAP
 *  Envelope
 *  Header
 *  Body
 *  (Fault)
 */
class IndexController
{
    public function indexAction($params)
    {  
        ini_set("soap.wsdl_cache_enabled", "0");
        
        try {
            $client = new \SoapClient(
                'http://192.168.99.100/soap/server/getwsdl', 
                array(
                    'soap_version'   => SOAP_1_2,
                    'compression'    => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP
                )
            );
        } catch(\SOAPFault $f) {
            echo 'ERROR CLIENT';
            var_dump($f->getMessage());
            die();
        }
        
        try {
            $return = $client->getMessageWsdl(implode(',',$params));
            echo($return);
        } catch(\SoapFault $f) {
            echo 'FAULT FUNCTION';
            var_dump(($f->getMessage()));
        } catch(\Exception $e){
            echo 'EXCEPTION FUNCTION';
            var_dump( $e->getMessage() );
        }
    }
    /*
        $autodiscover = new Laminas\Soap\AutoDiscover();
        // Defaults are
        // - 'use' => 'encoded'
        // - 'encodingStyle' => 'http://schemas.xmlsoap.org/soap/encoding/'
        $autodiscover->setOperationBodyStyle([
            'use'       => 'literal',
            'namespace' => 'https://getlaminas.org',
        ]);
        // Defaults are:
        // - 'style' => 'rpc'
        // - 'transport' => 'http://schemas.xmlsoap.org/soap/http'
        $autodiscover->setBindingStyle([
            'style'     => 'document',
            'transport' => 'https://getlaminas.org',
        ]);
        $autodiscover->addFunction('myfunc1');
        $wsdl = $autodiscover->generate();
    */
    public function nowsdlAction($params=null)
    {  
        try {
            $client = new \SoapClient(null, array(
                'location' => "http://192.168.99.100/soap/server",
                'uri'      => "soap",
                'wsdl_cache' => 0,
                'trace'    => 1,
                "soap_version" => SOAP_1_2
            ));
        } catch(\SOAPFault $f) {
            echo 'ERROR CLIENT';
            var_dump($f->faultString());
        }
        
        try {
            $return = $client->__soapCall("getMessage", [implode(',',$params)]);
            $return = $client->getMessage(implode(',',$params));
            echo($return);
        } catch(\SoapFault $f) {
            var_dump(($f->getMessage()));
            var_dump( $client->__getLastResponse() );
        } catch(\Exception $e){
            var_dump( $e->getMessage() );
        }
    }
}
