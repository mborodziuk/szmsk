#!/usr/bin/perl -w
use DBI;
use Digest::MD5 qw(md5_hex);

$DBTYPE="Pg";
$USER="szmsk";
$PASS="szmsk";
$HOST="localhost";
$DBNAME="szmsk";

$NAT="/home/szmsk/perl/nat/nat.sh";
$DHCP="/home/szmsk/perl/etc/dhcpd.conf";
$HOSTS="/home/szmsk/perl/etc/hosts";
$DANS="/home/szmsk/perl/etc/dansguardian/exceptioniplist";
$HTB_LAN1="/home/szmsk/perl/etc/htb/htb.lan1";
$HTB_LAN2="/home/szmsk/perl/etc/htb/htb.lan2";
#$LOG="/home/mirth/public_html/sk.log";



$Q1="select a.symbol, af.mac, ai.ip, t.symbol, k.dhcp, k.powiaz_ipmac, k.inet, k.proxy, k.przekier_gg, k.przekier_ftp, k.przekier_emule, k.przekier_inne, k.antyporn
    from abonenci a, towary_sprzedaz t, komputery komp, konfiguracje k, adresy_fizyczne af, adresy_ip ai
        where a.id_abon=komp.id_abon and komp.id_konf=k.id_konf and komp.id_taryfy=t.id_tows and af.ip=ai.ip and ai.id_urz=komp.id_komp order by ai.ip";
	
$Q2="select numer from telefony_voip where aktywny='T' order by numer";