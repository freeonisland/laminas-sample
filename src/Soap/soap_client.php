<?php

#CLIENT
SoapClient(trace=>true);
$client->getMessageWsdl(implode(',',$params));
file_put_contents('client_request.log', var_export($client->__getLastRequest(), true));