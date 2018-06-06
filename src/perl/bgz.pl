#!/usr/bin/perl -w

use strict;
use Frontier::Client;

# Make an object to represent the XML-RPC server.
my $url = 'https://transferbgz.pl/bgz.blc.loader/WebService?wsdl';
#$url= 'http://blc.bgz.max.com.pl';
my $client = Frontier::Client->new(url => $url);

# Call the remote server and get our result.
my $result = $client->call('getSystems', 'miroslaw.borodziuk', 'Foto32Nika08', '2030006138');

print "$result\n";
