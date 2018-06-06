#!/usr/bin/perl

require "/home/szmsk/perl/lms/config.h.pl";

use Net::Telnet;

my $login='boss';
my $passwd='arrakis1992';


$dbh = DBI->connect("dbi:$DBTYPE:dbname=$DBNAME;host=$DBHOST", $DBUSER, $DBPASS);
$dbh1 = DBI->connect("dbi:$DBTYPE:dbname=$DBNAME2;host=$DBHOST", $DBUSER2, $DBPASS2);

$sth=$dbh->prepare($Q1);
$sth->execute();
while (@r = $sth->fetchrow_array() )
  {
			@id=split(/N/, $r[0]);
			@n=split(/ /, $r[1]);
			$q1="insert into customers (id, lastname, name, status , type , address , zip , city) 
			values ('$id[1]', '$n[0]', '$n[1]', '3', '0', '$r[7] $r[8] lok. $r[9]', '$r[5]', '$r[6]')";
			print $q1;
			print "--------------------------- \n";
			$s=$dbh1->prepare($q1);
			$s->execute();
    }                              


$sth=$dbh->prepare($Q2);
$sth->execute();  
while (@r = $sth->fetchrow_array() )
  {
			@id=split(/V/, $r[0]);
			@a=split(/N/, $r[3]);
			@nr=split(/ /, $r[1]);
			$numer=$nr[0].$nr[1].$nr[2].$nr[3];
			
			$q2="insert into voipaccounts (id, ownerid, login, passwd, phone, access) 
			values ('$id[1]', '$a[1]', '48$numer', 'klon2010', '$numer', '1')";
			print $q2;
			print "--------------------------- \n";
			$s=$dbh1->prepare($q2);
			$s->execute();
    }

$sth=$dbh->prepare($Q3);
$sth->execute();
while (@r = $sth->fetchrow_array() )
  {        
	      @id=split(/S/, $r[0]);
  
              $q2="insert into networks (id, name, address, mask, gateway, dns, dns2, domain, wins, hostid)
              values ('$id[1]', '$r[1]', '$r[1]', '$r[2]', '$r[3]', '91.216.213.2', '91.216.213.6', 'netico.pl', '91.216.213.1', '0001')";
              
              print $q2;
              print "--------------------------- \n";
              $s=$dbh1->prepare($q2);
              $s->execute();
    }
                                                                                                                                                                                                                                                      