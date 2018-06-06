#!/usr/bin/perl -w

require "/home/szmsk/perl/scheduler/config.pl";
use strict 'vars';
#use vars;


our ($data, $Q1, $Q2, $Q3, $Q4, %conf);

sub DbCon
{
    my $dbh = DBI->connect("dbi:$conf{dbtype}:dbname=$conf{dbname};host=$conf{dbhost}", $conf{dbuser}, $conf{dbpass});
    return $dbh;
}
	

sub Schedule
{
  my ($Q, $q1, $q2, $wyj, @id, $nr, @r, $sth, $sth2, $sth3);
        
  my @d=split(/-/, $_[1]);
    
  $Q="select id_sch, encja, kolumna, wartosc, cecha, argument from scheduler where data<=\'$data\' order by encja, kolumna";
  #print "\n $Q \n";
  $sth=$_[0]->prepare($Q);
  $sth->execute();
  while ( @r = $sth->fetchrow_array() )
  {
		$q1="update $r[1] set $r[2]=\'$r[3]\' where $r[4]=\'$r[5]\'";
		#print " $q1 \n";
		$sth2=$_[0]->prepare($q1);
		$sth2->execute();

		$q2="delete from scheduler where id_sch=\'$r[0]\'";
    #print " $q2 \n";
    $sth3=$_[0]->prepare($q2);
    $sth3->execute();

   }
}

					
my $dbh=DbCon;
Schedule($dbh);
