#!/usr/bin/perl

require "/home/szmsk/perl/mt/config.h.pl";

use Net::Telnet;

my $login='boss';
my $passwd='arrakis1992';

my $cmd1="system logging disable 0";
my $cmd2="ip neighbor discovery disable 0; ip neighbor discovery disable 1;";

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
	$q2="update cpe set logging='T' where id_cpe='$row[1]'";
	print @lines;
	print "--------------------------- \n";
	$s=$dbh->prepare($q2);
	$s->execute();
    }
}  
