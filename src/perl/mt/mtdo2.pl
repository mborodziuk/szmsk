#!/usr/bin/perl

require "/home/szmsk/perl/mt/config.h.pl";
use warnings;

use Net::Telnet;

my $login='boss';
my $passwd='arrakis1992';
my @l;

my $cmd1="routing ospf network print";
my $cmd2="routing ospf network add network=172.16.8.0/21 area=backbone";
my $cmd3="system reboot";

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
	@lines = $t->cmd("$cmd2");
	print @lines;
#	@l=split(/\s/, @lines);
#	print @l;
#        @lines = $t->cmd("$cmd2");
	$q2="update cpe set ospf='T' where id_cpe='$row[1]'";
#	print @lines;
	print "--------------------------- \n";
	$s=$dbh->prepare($q2);
	$s->execute();
    }
}  
