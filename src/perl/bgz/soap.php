#!/usr/bin/php -q

<?php

$client = new SoapClient("https://transferbgz.pl/bgz.blc.loader/WebService?wsdl", 
    array(
    'trace' => 1,
    'soap_version' => SOAP_1_1,
    'style' => SOAP_DOCUMENT,
    'encoding' => SOAP_LITERAL,
    'location' => 'https://transferbgz.pl/bgz.blc.loader/WebService'
));
						
$availableSystems = $client->getSystems(array('in0' => 'miroslaw.borodziuk', 'in1' => 'Foto32Nika08', 'in2' => '2030006138'));
						
print "Dostepne systemy: <br/>";
print_r($availableSystems);
?>
