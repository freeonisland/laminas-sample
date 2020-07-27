<?php

#SERVER
ob_start();
$response = $server->handle();
$c = ob_get_contents();
ob_end_flush();
//$request = $server->getResponse();
file_put_contents('server_request.log', var_export($c, true));