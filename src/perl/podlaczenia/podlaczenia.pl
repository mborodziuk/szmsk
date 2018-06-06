#!/usr/bin/perl -w

require "/home/szmsk/perl/podlaczenia/config.pl";
use strict 'vars';
#use vars;


our ($data, $Q1,  %conf);

sub DbCon
{
    my $dbh = DBI->connect("dbi:$conf{dbtype}:dbname=$conf{dbname};host=$conf{dbhost}", $conf{dbuser}, $conf{dbpass});
    return $dbh;
}


sub UpdatePodlaczenia
{
  my ($Q, $q1, @r, $sth, $sth2, $sth3);
  $Q="select p.id_pdl, i.id_itl, i.data_zak from podlaczenia p, instalacje i where p.id_itl=i.id_itl and i.wykonana=\'N\'
  and i.data_zak=\'$data\'";
  
  $sth=$_[0]->prepare($Q);
  $sth->execute();
  while ( @r = $sth->fetchrow_array() )
  {
		$q1="update podlaczenia set etap='przeterminowany' where id_pdl=\'$r[0]\'";
		print " $q1 \n";
		$sth2=$_[0]->prepare($q1);
		$sth2->execute();

   }
}
					
my $dbh=DbCon;
UpdatePodlaczenia($dbh);
