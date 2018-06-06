#!/usr/bin/perl -w

use strict;
use SOAP::Lite;

my $uri  ='https://transferbgz.pl/bgz.blc.loader/WebService?wsdl';
my $proxy='https://transferbgz.pl/bgz.blc.loader/WebService';

my %conf=
(
'in0' => 'miroslaw.borodziuk', 
'in1' => 'Foto32Nika08', 
'in2' => '2030006138'
);
 
my $soap = SOAP::Lite
       -> uri($uri)
       -> proxy($proxy); 

my $result = $soap->getSystems(%conf);

print "$result \n";
