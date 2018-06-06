#!/usr/bin/perl

require "/home/szmsk/perl/mt/config.h.pl";

use Net::Telnet;

my $login='boss';
my $passwd='arrakis1992';

my $cmd1="ip neighbor discovery set ether1 discover=no; ip neighbor discovery set wlan1 discover=no";


my $t = new Net::Telnet(Timeout => 10, Prompt => '/[%#>] $/',  Errmode => "return");

$dbh = DBI->connect("dbi:$DBTYPE:dbname=$DBNAME;host=$DBHOST", $DBUSER, $DBPASS);
$sth=$dbh->prepare($Q1);
$sth->execute();                                
while (@row = $sth->fetchrow_array() )
  {
    if ($t->open($row[0]))
    {
        print "$row[0] \n";
	$t->login($login, $passwd);
	@lines = $t->cmd("$cmd1");
	print @lines;
	print "--------------------------- \n";
    }
}  
