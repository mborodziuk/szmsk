#!/usr/bin/perl -w

require "/home/szmsk/perl/windykacja/config.pl";
use strict 'vars';
#use vars;


our ($data, $Q1, $Q2, $Q3, $Q4, %conf);

sub IncItNum
{
    my ($Q, $wyj, @id, $nr, @row, $sth);
        
    my @d=split(/-/, $_[1]);
    if ($_[2] eq "SPW" )
    {
	$Q="select id_spw from sprawy_windykacyjne where data_zgl like \'$d[0]-$d[1]-%\' order by id_spw desc limit 1";
    }
    elsif ( $_[2] eq "WND" )
    {
	 $Q="select id_wnd from windykowanie where data_rozp like \'$d[0]-$d[1]-%\' order by id_wnd desc limit 1";
    }
    	
    $sth=$_[0]->prepare($Q);
    $sth->execute();
    @row = $sth->fetchrow_array(); 
    
    if ( $row[0] eq "" )
    {
	$wyj="$_[2]/0001/$d[1]/$d[0])";
    }
    else
	{
	    @id=split(/\//, $row[0]);
    	    $nr=$id[1];
    	    ++$nr;
	    $wyj="$id[0]/$nr/$id[2]/$id[3]";
	} 
   return $wyj;
}


sub wylacz_net
{
}

sub InitFile
{
}			    

sub info
{
    open (F, '>', $conf{info_file}) or die "Nie mozna otworzyc pliku: $! \n";
    print F "#---- $_[0] $_[1] -------------------------------------------------------------------------------------------------------# \n";         
    print F "IPT -t nat -I PREROUTING -s $_[2] -p tcp --dport 80 -j DNAT --to IP_LAN_WWW:8085 \n";
    close F;
}
										
sub DbCon
{
    my $dbh = DBI->connect("dbi:$conf{dbtype}:dbname=$conf{dbname};host=$conf{dbhost}", $conf{dbuser}, $conf{dbpass});
    return $dbh;
}

sub array_search 
{ 
    our @kroki;
    my $elem = $_[0];
    my $idx; 
    my $i=0;
    
    foreach my $v (@kroki) 
    { 
	if ($elem eq $v) 
	{ 
	$idx = $i; 
	last; 
	} 
        ++$i;
    }
    return $idx;             
}

sub UsunZwindykacji
{
    my ($q1, $q2);
    $q1="update windykowanie set data_zak=\'$data\' where id_wnd=\'$_[2]\'";
    $q2="update sprawy_windykacyjne set zwindykowana=\'T\' where id_spw=\'$_[1]\'";
    my $dbh = $_[0];
    my $sth=$dbh->prepare($q1);
    $sth->execute();
    $sth=$dbh->prepare($q2);
    $sth->execute();		    
    #print "XXXXXXXXXXXXXXXX";
}

sub KrokWindykacji
{	
    my ($q1, $q2, $q3, $id_spw, $id_wnd, $krok, $sth);
    my $dbh=$_[0];
    our @kroki;
    
    $id_wnd=IncItNum($dbh, $data, "WND");
    if ( defined $_[3] ) # not NULL ?
    {
       my $p = array_search($_[4]);
       ++$p;
       $krok=$kroki[$p];
       if ( $_[5]-10 <= -($p+1)*$_[6] )
       {
        $q1="update windykowanie set data_zak=\'$data\' where id_wnd=\'$_[3]\'";
        $q2="insert into windykowanie values(\'$id_wnd\', \'$data\', NULL, \'$krok\', \'$_[2]\' )";
        if ( $krok eq 'firma' )
	    {
	     $q3="update umowy_abonenckie set status=\'windykowana\' where id_abon=\'$_[3]\' and status=\'Obowiązująca\'";
	    $sth=$dbh->prepare($q3);
	    $sth->execute();
	    print "\n $q3 \n\n";	    
	    }
        print "\n $q1 \n";
	print "$q2 \n";
	$sth=$dbh->prepare($q1);
	$sth->execute();
	$sth=$dbh->prepare($q2);
	$sth->execute();	
	}		
    }
    elsif ( ! defined $_[3] )
    {
    $id_spw=IncItNum($dbh, $data, "SPW");
    $q1="insert into sprawy_windykacyjne values (\'$id_spw\', \'$data\', \'$_[1]\', \'N\', NULL)";
    $q2="insert into windykowanie values(\'$id_wnd\', \'$data\', NULL, \'info\', \'$id_spw\' )";										    

    print "\n $q1 \n";
    print "$q2 \n";	   
    $dbh = $_[0];
    $sth=$dbh->prepare($q1);
    $sth->execute();
    $sth=$dbh->prepare($q2);
    $sth->execute();
    }
}


sub DodajDoWindykacji
{
my ($dbh, $sth, @row, @nr);
our $day;

$dbh = $_[0];
$sth=$dbh->prepare($Q1);
$sth->execute();                      
while (@row = $sth->fetchrow_array() )
  {
    if ( $row[5]+$conf{po_terminie} <= $day )
    {
    #print "\n platnosc $row[5] < $day \n";
	if ( $row[2] == 0 )
	{
	    if ( defined $row[6] )
	    {
		print "\n\n\n $row[1] XXXXXXXXXXXXXXXXXXXXXXxXXXXXXXXXXXXXXX\n\n\n ";
    		UsunZwindykacji($dbh, $row[0], $row[6], $row[7], $row[8]);
	    }
	    else
	    {
		#print "\n not definied : $row[2] ???? $row[3] \n";
	    }
	}
        elsif ( $row[2]-10 <= -2*$row[3] )
	{
	    print "\n $row[0] $row[1] : $row[2] <= -2 * $row[3] \n";	
            KrokWindykacji($dbh, $row[0], $row[6], $row[7], $row[8], $row[2], $row[3]);
	}
#        elsif ( $row[2]-5 <= -1*$row[3] )
#	{
#	    print "\n $row[0] $row[1] : $row[2] <= -1 * $row[3] \n";
#	    KrokWindykacji($dbh, $row[0], $row[6], $row[7], $row[8]);
#	}
	else
	{
            #print "\n $row[0] $row[1] : $row[2]  ??  $row[3] \n";
	}																			    	
    }
 }
}

sub GenInfo
{
my ($dbh, $sth, @r, @nr, @b);

open (F, '>', $conf{info_file1}) or die "Nie mozna otworzyc pliku: $! \n";
print F "#!/bin/bash \n source /etc/conf \n\n";       
system ("/bin/chmod 447 $conf{info_file1}");

open (F2, '>', $conf{info_file2}) or die "Nie mozna otworzyc pliku: $! \n";
print F2 "#!/bin/bash \n source /etc/conf \n\n";
system ("/bin/chmod 447 $conf{info_file2}");

$dbh = $_[0];
$sth=$dbh->prepare($Q2);
$sth->execute();
while (@r = $sth->fetchrow_array() )
    {
	@b=split(/\./, $r[0]);
	if ( ($b[1] < 32 && $b[1] != 9) || ( $b[0] == 178 && $b[2]==223 ) )
	{	
	#print "$r[0] $r[1] $r[2] \n";
	print F "#---- $r[1] $r[2] -------------------------------------------------------------------------------------------------------# \n";
	print F "\$IPT -t nat -I PREROUTING -s $r[0] -p tcp --dport 80 -j DNAT --to \$IP_LAN_WWW:8085 \n";
	}
	else
	{
        #print "$r[0] $r[1] $r[2] \n";
	print F2 "#---- $r[1] $r[2] -------------------------------------------------------------------------------------------------------# \n";
	print F2 "\$IPT -t nat -I PREROUTING -s $r[0] -p tcp --dport 80 -j DNAT --to \$IP_LAN_WWW:8085 \n";			
	}
    }
close F;	
close F2;												  
}

sub GenBlokada
{
my $dbh=$_[0];
my ($ip, @b, $nr, @r, $sth);

open (F, '>', $conf{blokada_file1}) or die "Nie mozna otworzyc pliku: $! \n";
print F "#!/bin/bash\n source /etc/conf \n\n";
system ("/bin/chmod 447 $conf{blokada_file1}");
open (F2, '>', $conf{blokada_file2}) or die "Nie mozna otworzyc pliku: $! \n";
print F2 "#!/bin/bash\n source /etc/conf \n\n";
system ("/bin/chmod 447 $conf{blokada_file2}");

#print "$Q4";
$sth=$dbh->prepare($Q4);
$sth->execute();
while ( @r = $sth->fetchrow_array() )
{
@b=split(/\./, "$r[0]");
if ( $b[1] eq 0 )
{
    $nr="100";
}
elsif ( $b[1]==1  )
{
$nr="101";
}
elsif ( $b[1] == 2  )
{
$nr="102";
}
elsif ( $b[1] == 3  )
{
$nr="103";
}
elsif ( $b[1] == 4  )
{
$nr="104";
}
elsif ( $b[1] == 5  )
{
$nr="105";
}
elsif ( $b[1] == 6  )
{
$nr="106";
}
elsif ( $b[1] == 7  )
{
$nr="107";
}
elsif ( $b[1] == 8  )
{
$nr="108";
}
elsif (  $b[1]==9  )
{
$nr="109";
}
elsif ( $b[2] == 217 && $b[2]==221 )
{
$nr="110";
}
elsif ( $b[1] == 11)
{
$nr="111";
}
elsif ( $b[1] == 12)
{
$nr="112";
}
elsif ( $b[1] == 13)
{
$nr="113";
}
elsif ( $b[1] == 14)
{
$nr="114";
}
elsif ( $b[1] == 15)
{
$nr="115";
}
elsif ( $b[1] == 16)
{
$nr="116";
}
elsif ( $b[1] == 17)
{
$nr="117";
}
elsif ( $b[1] == 18)
{
$nr="118";
}
elsif ( $b[1] == 19)
{
$nr="119";
}
elsif ( $b[1] == 20)
{
$nr="120";
}
elsif ( $b[1] == 21)
{
$nr="121";
}
elsif ( $b[1] == 22)
{
$nr="122";
}
elsif ( $b[1] == 217 && $b[2]==223 )
{
$nr="123";
}

@b=split(/\./, $r[0]);
if ( ($b[1] < 32 && $b[1] != 9) || ( $b[0] == 178 && $b[2]==223 ) )
{			
print F "#---- $r[1] $r[2] -------------------------------------------------------------------------------------------------------# \n";	  
print F "if   \$IPS -T HOSTS_ACCEPT_$nr  $r[0] > /dev/null 2> /dev/null \n";
print F "then \$IPS -D HOSTS_ACCEPT_$nr  $r[0] \n";
print F "fi \n";
print F "if ! \$IPS -T HOSTS_DROP_$nr  $r[0]  > /dev/null 2> /dev/null \n";
print F "then \$IPS -A HOSTS_DROP_$nr  $r[0] \n";
print F "fi \n";
}
else
{
print F2 "#---- $r[1] $r[2] -------------------------------------------------------------------------------------------------------# \n";
print F2 "if   \$IPS -T HOSTS_ACCEPT_$nr  $r[0] > /dev/null 2> /dev/null \n";
print F2 "then \$IPS -D HOSTS_ACCEPT_$nr  $r[0] \n";
print F2 "fi \n";
print F2 "if ! \$IPS -T HOSTS_DROP_$nr  $r[0]  > /dev/null 2> /dev/null \n";
print F2 "then \$IPS -A HOSTS_DROP_$nr  $r[0] \n";
print F2 "fi \n";
}
}
close F
}

#print "\n $Q1 \n";
my $dbh=DbCon;

GenInfo($dbh);
GenBlokada($dbh);

system ("/usr/bin/scp -P 2222 $conf{dir}/cfg/info1.sh szmsk\@$conf{server1}:/etc/nat/sh");
system ("/usr/bin/scp -P 2222 $conf{dir}/cfg/info2.sh szmsk\@$conf{server1}:/etc/nat/sh");
#system ("/usr/bin/ssh $conf{server1} /etc/nat/sh/info1.sh");
system ("/usr/bin/scp -P 2222 $conf{dir}/cfg/info1.sh szmsk\@$conf{server2}:/etc/nat/sh");
#system ("/usr/bin/ssh $conf{server2} /etc/nat/sh/info2.sh");
system ("/usr/bin/scp -P 2222 $conf{dir}/cfg/info2.sh szmsk\@$conf{server2}:/etc/nat/sh");

system ("/usr/bin/scp -P 2222 $conf{dir}/cfg/blokada1.sh szmsk\@$conf{server1}:/etc/nat/sh");
system ("/usr/bin/scp -P 2222 $conf{dir}/cfg/blokada2.sh szmsk\@$conf{server1}:/etc/nat/sh");
#system ("/usr/bin/ssh $conf{server1} /etc/nat/sh/blokada1.sh");
system ("/usr/bin/scp -P 2222 $conf{dir}/cfg/blokada1.sh szmsk\@$conf{server2}:/etc/nat/sh");
system ("/usr/bin/scp -P 2222 $conf{dir}/cfg/blokada2.sh szmsk\@$conf{server2}:/etc/nat/sh");
#system ("/usr/bin/ssh $conf{server2} /etc/nat/sh/blokada2.sh");
