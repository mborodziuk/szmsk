#!/usr/bin/perl -w
use DBI; 

$HTTP="/home/szmsk/perl/etc/apache/httpd.conf";
$HTTP_ORIG="/home/szmsk/perl/dane/httpd.conf";
$DJBDNS="/home/szmsk/perl/var/service/tinydns/root/data";
$DJBDNS_ORIG="/home/szmsk/perl/dane/data";
$FTP="/home/szmsk/perl/etc/proftpd.conf";
$FTP_ORIG="/home/szmsk/perl/dane/proftpd.conf";
$IP="80.53.51.250";
$DBTYPE="Pg";
$USER="szmsk";
$PASS="szmsk";
$HOST="localhost";
$DBNAME="szmsk";

$Q1="select v.nazwa, v.domena, v.katalog,v.data_utw,  k.login, a.nazwa
     from vhost_www v, konta k , abonenci a 
     where v.id_konta=k.id_konta and a.id_abon=k.id_abon and v.aktywny='T' and k.aktywne='T'";
$Q2="select v.nazwa, v.domena, v.katalog,v.data_utw,  k.login, a.nazwa, v.port
     from vhost_ftp v, konta k , abonenci a 
     where v.id_konta=k.id_konta and a.id_abon=k.id_abon and v.aktywny='T' and k.aktywne='T'";

# usuwa biale znaki
sub trim
{
    my $string = shift;
    $string =~ s/^\s+//;
    $string =~ s/\s+$//;
    return $string;
}																																																																		 
	
																								
sub VHostWWW
{

    local (*F)=$_[0];
    local (*G)=$_[1];
    system("mkdir /home/szmsk/perl/var/log/apache/$_[2]");    

    print F ('+'."$_[2]".'.'."$_[3]:$IP:86400 \n");
    
    print G ("# ABON: $_[7];  Data utworzenia: $_[6]			\n");
    print G ("<VirtualHost	$_[2].$_[3]>				\n");
    print G ('	ServerAdmin 	admin@quarknet.pl			'."\n");
    print G ("	DocumentRoot 	/home/mail/$_[5]/$_[4]			\n");
    print G ("	ServerName 	$_[2].$_[3]				\n");
    print G ("	Port 		80					\n");
    print G ("	ErrorLog 	/var/log/apache/$_[2]/error_log		\n");
    print G ("	CustomLog 	/var/log/apache/$_[2]/access_log common	\n");
    print G ("</VirtualHost>						\n\n");

}

sub VHostFTP
{
    local (*F)=$_[0];
    local (*G)=$_[1];
    
    system("mkdir /home/szmsk/perl/var/log/proftpd/$_[2]");
    print F ('+'."$_[2]".'.'.":$IP:86400 \n");

    print G ("# ABON: $_[7];  Data utworzenia: $_[6]                   	\n");
    print G ("<VirtualHost $_[2].$_[3]>					\n");
    print G ("	ServerAdmin             admin@quarknet.pl		\n");    
    print G ("	ServerName              $_[2].$_[3]			\n");
    print G ("	MaxLoginAttempts        3				\n");
    print G ("	MaxClients              25  				\n");    
    print G ("	Port                    $_[8]				\n");
    print G ("	DefaultRoot             /home/mail/$_[5]/$_[4]		\n");
    print G ("	RequireValidShell       no  				\n");
    print G ("	AllowOverwrite          yes				\n");
    print G ("	User                    $_[5]  				\n");
    print G ("	TransferLog             /var/log/proftpd/$_[2] 		\n");
    print G ("</VirtualHost>  						\n\n");	    
}
						    	
#----------------------------------------------------------------------------------------------------#
system ("cp $HTTP_ORIG $HTTP");
system ("cp $DJBDNS_ORIG $DJBDNS");
system ("cp $FTP_ORIG $FTP");

open (HTTP, 	">>", $HTTP) 	|| die "Nie mo¿na otworzyæ pliku"; 
open (DJBDNS,	">>", $DJBDNS) 	|| die "Nie mo¿na otworzyæ pliku"; 
open (FTP, 	">>", $FTP) 	|| die "Nie mo¿na otworzyæ pliku";

$dbh = DBI->connect("dbi:$DBTYPE:dbname=$DBNAME;host=$HOST", $USER, $PASS);
$sth=$dbh->prepare($Q1);
$sth->execute();
while (@row = $sth->fetchrow_array() )
    {
	print "$row[0] $row[1] $row[2] $row[3] $row[4] $row[5] \n";
	VHostWWW(*DJBDNS, *HTTP, $row[0], $row[1], $row[2], $row[4], $row[3], $row[5]);
    }

$sth=$dbh->prepare($Q2);
$sth->execute();
while (@row = $sth->fetchrow_array() )
    {
	print "$row[0] $row[1] $row[2] $row[3] $row[4] $row[5] $row[6] \n";
    	VHostFTP(*DJBDNS, *FTP, $row[0], $row[1], $row[2], $row[4], $row[3], $row[5], $row[6]);
    }

#system ("/var/service/tinydns/root/make");
#system ("/etc/rc.d/rc.proftpd restart");
#system ("/etc/rc.d/rc.httpd restart ");
