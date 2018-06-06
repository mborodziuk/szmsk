#!/usr/bin/perl -w
use DBI;
use Digest::MD5 qw(md5_hex);
use utf8;

$DBTYPE="Pg";
$DBUSER="szmsk";
$DBPASS="szmsk";
$DBHOST="localhost";
$DBNAME="szmsk";

$DBUSER2="lms";
$DBPASS2="lms";
$DBNAME2="lms";


$Q1="select distinct a.id_abon, n.nazwa, a.pesel_nip, a.nrdow_regon, a.status, u.kod, u.miasto, u.nazwa, b.numer, s.nr_lok, 
a.platnosc, a.fv_comiesiac, a.fv_email 
from abonenci a,ulice u, budynki b, nazwy n, adresy_siedzib s 
where u.id_ul=b.id_ul and s.id_bud=b.id_bud and a.id_abon=n.id_abon and a.id_abon=s.id_abon and n.wazne_od <= '2015-10-30' and n.wazne_do >= '2015-10-30' and s.wazne_od <= '2015-10-30' and s.wazne_do >= '2015-10-30' 
order by a.id_abon";

$Q2="select distinct t.id_tlv, t.numer, t.data_aktywacji, n.id_abon 
from telefony_voip t left join nazwy n on n.id_abon=t.id_abon and n.wazne_od <= '2015-09-30' and n.wazne_do >= '2015-09-30' 
order by id_tlv ";

$Q3="select distinct id_pds, adres, maska, brama, broadcast, warstwa, via, tabela
from podsieci
order by adres ";

