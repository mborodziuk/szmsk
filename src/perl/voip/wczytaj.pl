#!/usr/bin/perl -w

require "/home/szmsk/perl/voip/config.h.pl";

use Time::localtime;
use POSIX qw(strftime);

our ( $data, $nrz, $nrd, $czas, $oplata, $rodzaj, $vat);

# wartosc podatku VAT w bierzacym roku w %
$VAT=23;


sub trim
{
    my $string = shift;
    $string =~ s/^\s+//;
    $string =~ s/\s+$//;
    return $string;
}			

sub next_month
{
	my $month;
	@d=split(/-/, $_[0]);
	
	if ( $d[1] >= 1 && $d[1] <= 8 )
		{
			++$d[1];
			$month=$d[0]."-"."0".$d[1]."-".$d[2];
		}
	if ( $d[1] >= 9 && $d[1] <= 11 )
		{
			++$d[1];
			$month=$d[0]."-".$d[1]."-".$d[2];

		}	
	if ( $d[1] >= 12 )	
		{
			++$d[0];
			$month=$d[0]."-01-".$d[2];
		}
		
	return $month;
}

$now=time();
$yesterday=$now-60*60*24;

$d=strftime("%d", localtime($yesterday));
$m=strftime("%m", localtime($yesterday));
$Y=strftime("%Y", localtime($yesterday));
if ( $d == "01" ) 
    { 
	--$m;
	if ( $m < 10 )
	    {
		$m="0"."$m";
	    }
    }

#$m="01";
$mn=next_month("$Y-$m-02");

$dbh = DBI->connect("dbi:$DBTYPE:dbname=$DBNAME;host=$DBHOST", $DBUSER, $DBPASS);

#@nr=split(/ /, $row[0]);
$numer=$nr[0].$nr[1].$nr[2].$nr[3];
#		$numer=substr($numer, 1,9);
$file="/media/samba/files/Bilingi/2018-04.csv";

open(UCHWYT, "$file");
while (<UCHWYT>) 
{
    $linia = $_;      
#		print $linia;    
    @l=split(/;/, $linia);
    $n1=substr($l[4], 3,2);
    $n2=substr($l[4], 5,3);
    $n3=substr($l[4], 8,2);
    $n4=substr($l[4], 10,2);
    $nrz=$n1." ".$n2." ".$n3." ".$n4;
    
    $data=substr($l[1], 1,-1);
    $nrd=substr($l[5], 1,-1);
    $czas=substr($l[3], 1,-1);
    $oplata=substr($l[12], 1,-1);
    substr($oplata,-3,1)="."; 
    
    $rodzaj=substr($l[6], 1,-1);
    if ( $rodzaj eq '')
    {
         $rodzaj="Specjalne";
    }                    	
    $q3="insert into polaczenia_voip values ('$data','$nrz', '$nrd', '$czas', '$oplata', '$rodzaj', '$VAT')";
    print "$q3 \n";
    $sth3=$dbh->prepare($q3);
    $sth3->execute();
}
close UCHWYT;

#system("/bin/rm $file");
