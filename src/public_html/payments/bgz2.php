#!/usr/bin/php -q
<?php
include "func/config.php";

$client = new SoapClient("https://transferbgz.pl/bgz.blc.loader/WebService?wsdl", 
    array(
    'trace' => 1,
    'soap_version' => SOAP_1_1,
    'style' => SOAP_DOCUMENT,
    'encoding' => SOAP_LITERAL,
    'location' => 'https://transferbgz.pl/bgz.blc.loader/WebService'
));
						
$files = $client->getDocuments(array('in0' => $bgz[user], 'in1' => $bgz[pass], 'in2' => $bgz[iden]));
//print_r($files);

foreach ($files->out->Document as $v)
{	
	$state=$v->state;
	$id=$v->id;
	$name=$v->name;
	if ( $state == 5 )
	{
	print "Downloading file: $id $state $name \n";
	$file=$client->getDocument(array('in0'=>$id, 'in1' => $bgz[user], 'in2' => $bgz[pass], 'in3' => $bgz[iden]));
	$data=print_r($file, true);
	$d=substr($data, 31, -6);
	$p = "/home/szmsk3/feed/2013/08/$name";
	file_put_contents($p,$d);
	}
}

?>
