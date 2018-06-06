#!/usr/bin/perl

require "/home/szmsk/perl/mt/config.h.pl";

use Time::localtime;
use POSIX qw(strftime);
use Net::Ping;
use Time::HiRes; 
use Net::Telnet;

my $login='boss';
my $passwd='arrakis1992';

my $cmd1="interface wireless registration-table print stats without-paging";
my $cmd2="interface wireless registration-table get number=0 signal-strength";

my $p = Net::Ping->new();
$p->hires();

my $t = new Net::Telnet(Timeout => 10, Prompt => '/[%#>] $/',  Errmode => "return");
my $l, $v, $k, $rx, $tx, $q2, $q3;

$dbh = DBI->connect("dbi:$DBTYPE:dbname=$DBNAME;host=$DBHOST", $DBUSER, $DBPASS);
$sth=$dbh->prepare($Q1);
$sth->execute();                                
while (@row = $sth->fetchrow_array() )
  {
    $host=$row[0];
    ($ret, $duration, $ip) = $p->ping($host); 
   
		if ($ret)
    {
			$d2=1000*$duration;
			$ping = sprintf("%.2f", $d2);						 
			printf("MT: $ip is alive (packet return time: %.2f ms)\n", $d2); 
			
			if ($t->open($row[0]))
			{
				#print "IP: $row[0], ";
				if ($t->login($login, $passwd) )
					{
						@lines = $t->cmd("$cmd1");
						foreach (@lines) 
						{
							@l=split(' ', $_);
							foreach (@l)
								{ 
									#print "$l[1]\n ";
									if ( m/signal-strength=/) 
									{
										@v=split('=', $_);
										$ss=substr($v[1], 3,-9);
										if ( $ss ne '')
											{			
												$signal=$ss;
												print "signal-strength: $signal \n  ";
											}
									}
									if ( m/rx-rate=/)
									{
										@v=split('=', $_);
										$rx=substr($v[1], 4,-5);
										print "rx-rate: $rx, ";
									}
									if ( m/tx-rate=/)
									{
										@v=split('=', $_);
										$tx=substr($v[1], 4,-5);
										print "tx-rate: $tx, ";
									}
									if ( m/uptime=/)
									{
										@v=split('=', $_);
										$uptime=substr($v[1], 3);
										print "uptime: $uptime ";
									}
								}							        
						}
				
					$q2="update adresy_ip set ping=$ping where ip='$row[0]'"; 
					$q3="update cpe set signal_strength=$signal, rx_rate=$rx, tx_rate=$tx, uptime='$uptime', stats='@lines' where id_cpe='$row[1]'";
					#print " $q2 \n";
					#print "@lines \n";
					#print "----------------------------------------------------------------------------------------------------------------- \n";
					$s=$dbh->prepare($q2);
					$s->execute();
                                        $s=$dbh->prepare($q3);
                                        $s->execute();
															
				}
				else
					{
						print "Can't login \n";
					}
			}
			else
				{
					print "Can't connect via telnet \n";
				}
		}
			
		else
			{
				print "$host is offline \n";
			}
								
		print "----------------------------------------------------------------------------------------------------------------- \n";
}  
