#!/usr/bin/perl -w
use DBI;
use Digest::MD5 qw(md5_hex);
use Date::Format; 
use Time::localtime;

$DBTYPE="Pg";
$DBUSER="szmsk";
$DBPASS="szmsk";
$DBHOST="localhost";
$DBNAME="szmsk";

$USER="netico";
$PASS="AB&i961^H";

$Q1="select numer from telefony_voip where aktywny=\'T\' order by numer";
