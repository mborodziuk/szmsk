#!/usr/bin/perl -w

require "/home/szmsk/perl/config.h.pl";


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

sub prev_month
	{

		@d=split("-", $_[0]);
		
		if ( $d[1] >= 2 && $d[1] <= 10 )
			{
				--$d[1];
				$month=$d[0]."-"."0".$d[1];
			}
	  if ( $d[1] >= 11 && $d[1] <= 12 )
			{
				--$d[1];
				$month=$d[0]."-".$d[1];

			}	
		if ( $d[1] == 1 )	
			{
				--$d[0];
				$month=$d[0]."-12";
			}
			
		return $month;
	}

$Y=time2str("%Y", time);
$m=time2str("%m", time);
$pm=prev_month("$Y-$m");
@p=split("-", $pm);

#$m="01";
$mn=next_month("$p[0]-$p[1]-02");

$dbh = DBI->connect("dbi:$DBTYPE:dbname=$DBNAME;host=$DBHOST", $DBUSER, $DBPASS);
$sth=$dbh->prepare($Q1);
$sth->execute();				
while (@row = $sth->fetchrow_array() )
  {
		@nr=split(/ /, $row[0]);
		$numer=$nr[0].$nr[1].$nr[2].$nr[3];
		$numer=substr($numer, 1,9);
		$file="/home/szmsk/perl/polaczenia/polaczenia-$numer-$p[0]-$p[1]\.txt";
		$url="http://isas-api.artcom.pl/voip_billing/voip_billing.cgi?phone_no=$numer&month=$p[1]&year=$p[0]";
 
		$wynik=system("/usr/bin/wget --user=$USER --password='$PASS' '$url' -O $file");
		if (! $wynik)
			{			
				$q2="delete from polaczenia_voip where ( nr_zrodlowy='$row[0]' and data >= '$p[0]-$p[1]-02 00:00:00' and data < '$mn 00:00:00')";
				print "$q2 \n\n";
				$sth2=$dbh->prepare($q2);
				$sth2->execute();
				open(UCHWYT, "$file");
				while (<UCHWYT>) 
					{
						$linia = $_;      
				#		print $linia;    
						@l=split(/;/, $linia);
						$n1=substr($l[1], 0,2);
						$n2=substr($l[1], 2,3);
						$n3=substr($l[1], 5,2);
						$n4=substr($l[1], 7,2);
						$n="0".$n1." ".$n2." ".$n3." ".$n4;
						$q3="insert into polaczenia_voip values ('$l[0]','$n', '$l[2]', '$l[3]', '$l[4]', '$l[5]')";
						print "$q3 \n";
						$sth3=$dbh->prepare($q3);
						$sth3->execute();
					}
				close UCHWYT;
			}
		system("/bin/rm $file");
	}
