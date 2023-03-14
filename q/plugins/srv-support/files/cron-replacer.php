<?php
if(Plugin::get('srv-support', 'SRV_Checker.php')) include_once Plugin::get('srv-support', 'SRV_Checker.php');

$SRV_checker = new SRV_Checker;
$SRV_data = $SRV_checker->checkAddress($server->address);

$server->query_address = (!empty($SRV_data['address'])) ? $SRV_data['address'] : $server->query_address;
$server->query_port = (!empty($SRV_data['port'])) ? $SRV_data['port'] : $server->query_port;

?>