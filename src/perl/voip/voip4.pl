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


$Y=time2str("%Y", time);
$m=time2str("%m", time);

#$m="01";
$mn=next_month("$Y-$m-02");

use Time::localtime;
use POSIX qw(strftime);

$now=time();
$yesterday=$now-60*60*24;
print "/n $now $yesterday \n";

$tm=localtime($yesterday);

$month=$tm->mon();
$year=$tm->year()+1900;

print $tm->mday(), "$month $year";

$mm=strftime("%m %Y", localtime($yesterday));
#$mm=scalar(localtime($yesterday));
print "\n $mm \n";
