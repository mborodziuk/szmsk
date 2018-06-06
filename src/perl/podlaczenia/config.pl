#!/usr/bin/perl -w

use DBI;
use Digest::MD5 qw(md5_hex);
use Date::Format; 
use Time::localtime;
use strict;

our ($Year, $month, $day);
my $tm=localtime;

($Year, $month, $day) = ($tm->year+1900, ($tm->mon)+1, $tm->mday);
$month = sprintf("%02d", $month);
$day = sprintf("%02d", $day);

our $data="$Year-$month-$day";
our %conf=
(
'server1'	=>'91.216.213.1',
'server2'	=>'91.216.213.2',
'dbtype'	=>'Pg', 
'dbuser'	=>'szmsk2', 
'dbpass'	=>'szmsk2', 
'dbhost'	=>'localhost', 
'dbname'	=>'szmsk2',
);


