#!/usr/bin/perl -w

use strict;
use Frontier::Client;

my $server_url = 'http://test.xmlrpc.wordtracker.com';
my $server = Frontier::Client->new('url' => $server_url);

my $result = $server->call('ping', 'guest');

if (${$result} == 1) 
{
    print "Successfully pinged test account \n";
    exit 0;
}
