#!/usr/bin/perl -w

require "/home/szmsk/perl/config.h.pl";

$Q1="select id_abon, nazwa from abonenci where id_abon not like 'ABONI'";

$dbh = DBI->connect("dbi:$DBTYPE:dbname=$DBNAME;host=$HOST", $USER, $PASS);
$sth=$dbh->prepare($Q1);
$sth->execute();

while (@row = $sth->fetchrow_array() )
{
    @str=split(/ /, $row[1]);
    $s="$str[1]"." "."$str[0]";
    $Q2= "update ABONENCI set nazwa='$s' where id_abon='$row[0]'";
    $s=$dbh->prepare($Q2);
    $s->execute();
}
