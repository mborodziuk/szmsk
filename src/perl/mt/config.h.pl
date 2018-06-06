#!/usr/bin/perl -w
use DBI;
use Digest::MD5 qw(md5_hex);

$DBTYPE="Pg";
$DBUSER="szmsk";
$DBPASS="szmsk";
$DBHOST="localhost";
$DBNAME="szmsk";

$Q1="select a.ip, c.id_cpe from adresy_ip a, inst_vlanu iv, cpe c where iv.id_ivn=a.id_urz and a.ip like '172.16.%' and 
iv.id_wzl=c.id_cpe";# and c.logging='N'";
$Q2="select a.ip, c.id_cpe from adresy_ip a, inst_vlanu iv, cpe c where iv.id_ivn=a.id_urz and a.ip like '172.16.%' and
iv.id_wzl=c.id_cpe and c.ospf='N'";
