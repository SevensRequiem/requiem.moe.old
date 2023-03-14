<?php
if(Plugin::get('srv-support', 'SRV_Checker.php')) include_once Plugin::get('srv-support', 'SRV_Checker.php');

$SRV_checker = new SRV_Checker;
$SRV_data = $SRV_checker->checkAddress($address);

$query_address = (!empty($SRV_data['address'])) ? $SRV_data['address'] : $query_address;
$query_port = (!empty($SRV_data['port'])) ? $SRV_data['port'] : $query_port;

?>