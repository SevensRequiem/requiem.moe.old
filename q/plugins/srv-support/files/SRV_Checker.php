<?php
class SRV_Checker {    
    
    function checkAddress($address) {
        
        $result = dns_get_record("_minecraft._tcp.$address", DNS_SRV);

        if ($result) {
            $lowest_priority = 0;
            $valid_record = false;

            foreach ($result as $record) {
                $record_type = $record['type'];
                $record_pri = $record['pri'];
                $record_port = $record['port'];
                $record_target = $record['target'];

                if ($record_type=="SRV" && ($valid_record==false || $record_pri <= $lowest_priority)){
                    $address = array('address' => $record_target, 'port' => $record_port);
                    $lowest_priority = $record_pri;
                    $valid_record = true;
                }
            }
        }
        
        return $address;
    }
    
    
}
?>