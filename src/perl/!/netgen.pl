#!/usr/bin/perl -w
require "/home/szmsk/perl/config.h.pl";


# usuwa biale znaki
sub trim
{
    my $string = shift;
    $string =~ s/^\s+//;
    $string =~ s/\s+$//;
    return $string;
}																																																																		 



# Enable internet for user
sub masq
{
    local (*G)=$_[2];
    
    if (   "$_[1]" ne "" )
	{
    	    $m="-m mac --mac-source $_[1]";
	}
    else 
	{
	    $m="";
	}
	
    print  G ('$IPTABLES -A INPUT'."$m -s $_[0] -j ACCEPT \n");
    print  G ('$IPTABLES -A FORWARD'."$m -s $_[0] -j ACCEPT \n");
}

				
# Redirect to proxy
sub proxy 
{
    local (*G)=$_[2];
    
    if (   $_[1] ne "" )
	{
	    $m="-m mac --mac-source $_[1]";
	}
    else 
	{
	    $m="";
	}
        				
    print G ('$IPTABLES -t nat -A PREROUTING'."$m -s $_[0]".' -p tcp -m mport --dports 80,8080 -d $IP_INET1'." -j RETURN \n");
    print G ('$IPTABLES -t nat -A PREROUTING'."$m -s $_[0]".' -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8080'."\n");
}
				
sub bez_proxy
{
    local (*G)=$_[2];
    
    if (   $_[1] ne "" )
	{
	    $m="-m mac --mac-source $_[1]";
	}
    else 
	{
	    $m="";
	}
					
    print G ('$IPTABLES -t nat -A PREROUTING '."$m -s $1 -p tcp -m mport --dports 80,8080 -j RETURN \n");
}
									 
sub wylacz_net
{
    local (*G)=$_[1];
    
     print G ('$IPTABLES -t nat -A PREROUTING '."-s $_[0]".' -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET1:8083'."\n");
							     
}
									     


# Generate port which will be redirected
sub gen_port
{

    @BYTE = split(/\./, $_[0]);
	
    if ( "$_[1]" eq "gg" )
	{
    	    $BYTE[0]=10;
	}
    if ( "$_[1]" eq "ftp" )
	{
    	    $BYTE[0]=20;
	}
    if ( "$_[1]" eq "emule" )
	{
    	    $BYTE[0]=30;
	}
    if ( "$_[1]" eq "p2p" )
	{
    	    $BYTE[0]=40;
	}
    if ( "$_[1]" eq "oth" )
	{
    	    $BYTE[0]=50;
	}


    if ( $BYTE[2] >=10 )
	{
	    $BYTE[0]=substr($BYTE[0], 0 ,1);
	}
			    
    if ( $BYTE[3] >=10 )
	{
    	    $BYTE[1]="";
	}

#    print "$BYTE[0] $BYTE[1] $BYTE[2] $BYTE[3] \n";			
    return ("$BYTE[0]$BYTE[1]$BYTE[2]$BYTE[3]");

}


sub redirect_port
{
    local (*G)=$_[2];
    
    $PORT=&gen_port($_[0], $_[1]);
    if ( "$_[1]" eq "gg" )
        {
            print G ('$IPTABLES -A INPUT -p tcp --dport'." $PORT".' -i $IF_INET3 -j ACCEPT                                        # GG'."\n");
            print G ('$IPTABLES -t nat -A PREROUTING -p tcp -d $IP_INET3 --dport '."$PORT -j DNAT --to $_[0]:1550   # GG"."\n");
            print G ('$IPTABLES -t nat -A POSTROUTING -p tcp -d '."$_[0]".' --dport 1550 -j SNAT --to $IP_INET3        # GG'."\n");
        }
    if ( "$_[1]" eq "ftp")
        {
            print G ('$IPTABLES'." -A INPUT -p tcp --dport $PORT -i ".'$IF_INET3 -j ACCEPT                                        # FTP'."\n");
            print G ('$IPTABLES'." -t nat -A PREROUTING -p tcp -d ".'$IP_INET3'." --dport $PORT -j DNAT --to $_[0]:21     # FTP"."\n");
            print G ('$IPTABLES'." -t nat -A POSTROUTING -p tcp -d $_[0] --dport 21 -j SNAT --to ".'$IP_INET3          # FTP'."\n");
        }
    if ( "$_[1]" eq "p2p" )
        {
            print G ('$IPTABLES'." -A INPUT -p tcp --dport $PORT -i ".'$IF_INET3 -j ACCEPT                                        # P2P'."\n");
            print G ('$IPTABLES'." -t nat -A PREROUTING -p tcp -d ".'$IP_INET3'." --dport $PORT -j DNAT --to $_[0]:$PORT  # P2P"."\n");
            print G ('$IPTABLES'." -t nat -A POSTROUTING -p tcp -d $_[0] --dport $PORT -j SNAT --to ".'$IP_INET3       # P2P'."\n");
        }
}
																																				

sub dansguardian
{
    local (*G)=$_[0];
    
    print G ("$_[1] \n");
}

sub dhcp
{

    local (*G)=$_[1];

    $SUBNET="10.$_[0].0.0";
    $GATE="10.$_[0].0.1";
    $NETMASK="255.255.0.0";
    $BROADCAST="10.$_[0].255.255";
    $DNS="10.0.0.1";


    print G ("subnet $SUBNET netmask $NETMASK                                     \n");
    print G ("{                                                                   \n");
    print G ("deny unknown-clients;                                               \n");
    print G ("default-lease-time           86400;  #259200;  # 3 x 24 h           \n");
    print G ("max-lease-time               259200; #604800;  # 7 x 24 h           \n");
    print G ("option subnet-mask           $NETMASK;                              \n");
    print G ("option broadcast-address     $BROADCAST;                            \n");
    print G ("option routers               $GATE;                                 \n");
    print G ("option netbios-name-servers  $GATE;                                 \n");
    print G ('option domain-name           "quarknet.pl";'."                         \n");
    print G ("option domain-name-servers   $DNS, 194.204.145.16, 194.204.159.1;   \n");
    print G ("                                                                    \n");
}
	

sub htb
{
    my @IP;
    my @CI;
    local (*G)=$_[4];
    local (*H)=$_[5];
    $i=$_[3];
    
    if ( "$_[2]" eq "i128" )
        {
            $CEIL=128;
        }
    if ( "$_[2]" eq "i256" || "$_[1]" eq "2i256")
        {
            $CEIL=256;
        }
    if ( "$_[2]" eq "512" )
	{
	    $CEIL=512;
	}
    if ( "$_[2]" eq "i1024" )
        {
            $CEIL=1024;
        }
    
    @IP = split(/\./, $_[1]);
    if ( $IP[1]==0 )
    {
	$CI[0]=2;
	$F=G;
	$IF_LAN='$IF_LAN1';
	$TFADPPI_LAN='$TFADPPI_LAN1';
    }
    if ( $IP[1]==1 )
    {
	$F=H;
	$CI[0]=3;
	local (*G)=$_[5];
	$IF_LAN='$IF_LAN2';
	$TFADPPI_LAN='$TFADPPI_LAN2';	  
    }

    $RATE=$CEIL/2;

    $ceil="$CEIL"."Kbit";
    $rate="$RATE"."Kbit";

    print $F "#---- $row[0] ----------------------------------------------------------------------------------------------------------------------#\n";
    print $F ("tc class add dev $IF_LAN parent "."$CI[0]:1 classid $CI[0]:".$i." htb rate $rate ceil $ceil \n\n");
    #------------------------------

    print $F ("tc class add dev $IF_LAN parent "."$CI[0]:".$i." classid $CI[0]:".$i."1 htb rate $rate ceil $ceil prio 1 \n");
    print $F ("tc qdisc add dev $IF_LAN parent "."$CI[0]:".$i."1 handle $CI[0]".$i."1 sfq perturb 10 \n");
    print $F ("$TFADPPI_LAN protocol 1 0xff flowid $CI[0]:".$i."1 \n");
    print $F ("$TFADPPI_LAN tos 0x10 0xff flowid $CI[0]:".$i."1 \n");
    print $F ("$TFADPPI_LAN protocol 6 0xff match u8 0x05 0x0f at 0 match u16 0x0000 0xffc0 at 2 match u8 0x10 0xff at 33 flowid 2:31 \n\n");

    print $F ("tc class add dev $IF_LAN parent $CI[0]:".$i." classid $CI[0]:".$i."2 htb rate $rate ceil $ceil prio 2 \n");
    print $F ("tc qdisc add dev $IF_LAN parent $CI[0]:".$i."2 handle $CI[0]".$i."2 sfq perturb 10 \n");
    print $F ("$TFADPPI_LAN dst $_[1] 0xffff flowid $CI[0]:".$i."1 \n\n");
}

#--------------------------------------------------------------------------------------------------------------------------------------------------#

system ("rm -f $DANS");
system ("rm -f $NAT");
system ("rm -f $DHCP");
system ("rm -f $HOSTS");
system ("cp /home/szmsk/perl/dane/htb.lan1 $HTB_LAN1 && chmod 744 $HTB_LAN1");
system ("cp /home/szmsk/perl/dane/htb.lan2 $HTB_LAN2 && chmod 744 $HTB_LAN2");

open (HOSTS, 	">>", $HOSTS)		|| die "Nie mo¿na otworzyæ pliku"; 
open (NAT, 	">>", $NAT) 		|| die "Nie mo¿na otworzyæ pliku"; 
open (DHCP, 	">>", $DHCP)		|| die "Nie mo¿na otworzyæ pliku"; 
open (DANS, 	">>", $DANS) 		|| die "Nie mozna otworzyc pliku";
open (HTB1, 	">>", $HTB_LAN1)	|| die "Nie mozna otworzyc pliku";
open (HTB2,     ">>", $HTB_LAN2)	|| die "Nie mozna otworzyc pliku";

system ("chmod 744 $NAT");

#print NAT ('#!/bin/bash'."\n");       
print DHCP "ddns-update-style ad-hoc;                                           \n";
#print '0' > /tmp/byte
&dhcp("0", *DHCP);

print  HOSTS ("127.0.0.1  \t  localhost                  	\n");  
print  HOSTS ('$IP_LAN1'."  \t  quark.quarknet.pl  \t  quark  	\n"); 
print  HOSTS ('$IP_INET2'." \t  quark42.quarknet.pl  \t  quark42 	\n"); 
print  HOSTS ('$IP_INET3'." \t  quark34.quarknet.pl  \t  quark34 	\n"); 
print  NAT ("#!/bin/bash \n"); 
print  NAT ("source /etc/conf \n");

print "";

print " Generating config files for  ...";
$dbh = DBI->connect("dbi:$DBTYPE:dbname=$DBNAME;host=$HOST", $USER, $PASS);
$sth=$dbh->prepare($Q1);
$sth->execute();
$i=3;
while (@row = $sth->fetchrow_array() )
    {
#	print "$row[0] $row[1] $row[2] $row[3] $row[4] $row[5] $row[6] $row[7] $row[8]  $row[9] $row[10] $row[11] $row[12] \n";

	print NAT "#---- $row[0] ----------------------------------------------------------------------------------------------------------------------------------------#\n";
	print HOSTS "$row[2] \t  $row[0].quarknet.pl         \t  $row[0]\n";
	if ( "$row[4]" eq "T" )
	    {
		print DHCP "host $row[0] \t\t {hardware ethernet $row[1]; fixed-address $row[2];}\n";
	    }
	if ( "$row[5]" eq "T" )
	    {
		$mac_source="$row[1]";
	    }
	else
	    {
		$mac_source="";
	    }
										    
	if( "$row[6]" eq "T")
	{
	    &masq($row[2],$mac_source, *NAT);
	    
	    &htb($row[0], $row[2], $row[3], $i, *HTB1, *HTB2);
	    ++$i;
	    if ( $row[7] eq "T" )
		{
		    &proxy($row[2], $row[1], *NAT);
		}
	    else
		{
		    &bez_proxy($row[2], $row[1], *NAT);
		}
	    if ( $row[8] eq "T" )
		{
		    &redirect_port($row[2], "gg", *NAT);
		}
	    if ( $row[9] eq "T" )
		{
		    &redirect_port($row[2], "ftp", *NAT);
		}
	    if ( $row[10] eq "T" )
		{
		    &redirect_port($row[2], "emule", *NAT);
		}
           if ( $row[11] eq "T" )
               {
                   &redirect_port($row[2], "p2p", *NAT);
               }
            if ( $row[12] eq "N" )
                {
                    &dansguardian(*DANS, $row[2]);
                }
									    
	}
        else
	    {
        	&wylacz_net($row[2], *NAT);
	    }
    }
											

print DHCP  "}\n";
print NAT  "#----- Nie autoryzowany numer IP -----------------------------------------------------------------------------\n";
print NAT  ('$IPTABLES -t nat -A PREROUTING -s 80.53.51.248/29 -p tcp -m mport --dports 80,8080 -d IP_INET2 -j RETURN'."\n");
print NAT ('$IPTABLES -t nat -A PREROUTING -s ! 10.0.0.100  -i $IF_LAN1 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET2:8081'."\n");
print NAT ('$IPTABLES -t nat -A PREROUTING -s ! 10.0.0.100  -i $IF_LAN2 -p tcp -m mport --dports 80,8080 -j DNAT --to $IP_INET2:8081'."\n");
print NAT ('$IPTABLES -A FORWARD -s $N_LAN1 -j DROP '."\n");
print NAT ('$IPTABLES -A FORWARD -s $N_LAN2 -j DROP'."\n");
print NAT ('$IPTABLES -A INPUT -s $N_LAN1 -j ACCEPT'."\n");
print NAT ('$IPTABLES -A INPUT -s $N_LAN2 -j ACCEPT'."\n");
print NAT ('$IPTABLES -A INPUT -s $N_INET3 -j ACCEPT'."\n");
print NAT ('$IPTABLES -A INPUT -s 80.53.51.248/29 -j ACCEPT'."\n");
