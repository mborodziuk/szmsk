#!/usr/bin/perl -w

require "/home/szmsk/perl/voip/config.h.pl";

use Time::localtime;
use POSIX qw(strftime);

# wartosc podatku VAT w bierzacym roku w %
$VAT=23;

sub inc 
{

if ( $_[0] < 10 )
    N="$_[1]"."000"."$_[0]";
else if ( $_[0] < 100 )
        N="$_[1]"."00"."$_[0]";
else if ( $_[0] < 1000 )
	    N="$_[1]"."0"."$_[0]";
else
    N="_[0]"."$_[1]";
	
    return $N;
}
		    

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

				open(UCHWYT, "$file");
				while (<UCHWYT>) 
					{
						$linia = $_;      
				#		print $linia;    
						@l=split(/;/, $linia);
						$n1=substr($l[1], 2,2);
						$n2=substr($l[1], 4,3);
						$n3=substr($l[1], 7,2);
						$n4=substr($l[1], 9,2);
						$n=$n1." ".$n2." ".$n3." ".$n4;
						$q3="insert into taryfy_internet values ('$l[0]','$n', '$l[2]', '$l[3]', '$l[5]', '$l[6]', '$VAT')";
						print "$q3 \n";
						$sth3=$dbh->prepare($q3);
						$sth3->execute();
					}
				close UCHWYT;
			}
		#system("/bin/rm $file");
	}
