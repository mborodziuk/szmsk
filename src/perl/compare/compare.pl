#!/usr/bin/perl

require "/home/szmsk/perl/voip/config.h.pl";

 
$q="select k.id_abon, k.nazwa_smb, m.mac, ai.ip, ai2.ip, i.download, i.upload,  i.download_p2p, i.download_max, i.download_noc, i.upload_noc,  kf.dhcp, kf.ipmac, kf.net, kf.proxy, kf.dg, kf.info 
from ((komputery k left join konfiguracje kf on k.id_konf=kf.id_konf  ) left join (adresy_ip ai2 join podsieci pd on ai2.id_pds=pd.id_pds and pd.warstwa in ('dostep_zewn') ) on k.id_komp=ai2.id_urz) join (((adresy_ip ai join podsieci pd2 on ai.id_pds=pd2.id_pds and pd2.warstwa in ('dostep_pryw', 'dostep_publ') ) left join adresy_fizyczne m on m.ip=ai.ip) join  (taryfy_internet i join taryfy t on t.id_trf=i.id_trf and t.aktywna_od <= '2013-08-14' and t.aktywna_do >='2013-08-14') on ai.id_urz=t.id_urz ) on ai.id_urz=k.id_komp order by ai.ip";


use Time::localtime;
use POSIX qw(strftime);

@files=("/scripts/GenToSzmsk/nat/cfg.myslowice.5ghz-26" ,
			 "/scripts/GenToSzmsk/nat/cfg.myslowice.5ghz-27" ,
			 "/scripts/GenToSzmsk/nat/cfg.myslowice.5ghz-28" ,
			 "/scripts/GenToSzmsk/nat/cfg.myslowice.5ghz-29" ,
			 "/scripts/GenToSzmsk/nat/cfg.myslowice.5ghz-30" ,
       "/scripts/GenToSzmsk/nat/cfg.oswiecim.5ghz-26" ,            
       "/scripts/GenToSzmsk/nat/cfg.oswiecim.5ghz-27" ,
       "/scripts/GenToSzmsk/nat/cfg.oswiecim.5ghz-28" ,
			 "/scripts/GenToSzmsk/nat/cfg.oswiecim.5ghz-29" ,
			 "/scripts/GenToSzmsk/nat/cfg.oswiecim.5ghz-30" ,

			 "/scripts/GenToSzmsk/nat/cfg.myslowice.publ.29" ,
			 "/scripts/GenToSzmsk/nat/cfg.myslowice.publ.30" ,
       "/scripts/GenToSzmsk/nat/cfg.oswiecim.publ.30" ,
			 "/scripts/GenToSzmsk/nat/cfg.oswiecim.publ.29" );

our ( $komp, $map, $ip, $ipz, $trf, $dhcp, $net);

sub trim
{
    my $string = shift;
    $string =~ s/^\s+//;
    $string =~ s/\s+$//;
    return $string;
}			



$dbh = DBI->connect("dbi:$DBTYPE:dbname=$DBNAME;host=$DBHOST", $DBUSER, $DBPASS);
$lp=1;
foreach $file (@files)
{
open(UCHWYT, $file);
print "\n\n Plik: $file \n \n";
while (<UCHWYT>) 
{
    $linia = $_;      
#		print $linia;    
    @l=split(/\s+/, $linia);
		$komp=$l[0];
		$mac=$l[1];
		$ip=$l[2];
		$ipz=$l[3];
		$trf=$l[4];
		$dhcp=$l[6];
		$net=$l[8];
		
		
		if ( $komp =~ m/_test|-test|_brama|-brama|_BRAMA|\s+/) 
			{
				$flag=1;
			}
		else 
		{
			$flag=0
		}
		$q2 = "select k.id_abon, k.nazwa_smb, a.ip from komputery k, adresy_ip a where a.id_urz=k.id_komp and a.ip='$ip';";
    $sth2=$dbh->prepare($q2);
    $sth2->execute();
		@r = $sth2->fetchrow_array(); 
		if ( (! defined $r[0])  && $flag eq 0 )
    {
			print "$lp. - \t $komp \t $mac \t $ip \t  $trf \t $dhcp \t $net \n";
			++$lp;
    }
		
#    $q3="insert into polaczenia_voip values ('$komp','$mac', '$ip', '$ipz', '$trf', '$dhcp', '$net')";
   # print "$q3 \n";
}
close UCHWYT;
}
#system("/bin/rm $file");
