#!/usr/bin/perl -w

use DBI;
use Digest::MD5 qw(md5_hex);
use Date::Format; 
use Time::localtime;
use strict;
use utf8;

my $czas_dodatkowy=7;
our ($Year, $month, $day);
my $tm=localtime;

($Year, $month, $day) = ($tm->year+1900, ($tm->mon)+1, $tm->mday);
$month = sprintf("%02d", $month);
$day = sprintf("%02d", $day);

# musi byc taka kolejnosc kluczy w tablicy ze wzgledu na algorytm funkcji KrokiWindykacji
our @kroki=('obserwacja', 'info', 'info2', 'blokada', 'pismo', 'krd', 'nota', 'firma', 'pozew', 'sąd', 'odrzucone', 'wykonalność', 'komornik', 'problem', 'niewypłacalny', 'mail', 'sms');
our $data="$Year-$month-$day";
our %conf=
(
'server1'	=>'172.16.7.254',
'server2'	=>'172.16.7.253',
'dbtype'	=>'Pg', 
'dbuser'	=>'szmsk', 
'dbpass'	=>'szmsk', 
'dbhost'	=>'localhost', 
'dbname'	=>'szmsk',
'po_terminie' 	=>'4',
'dir'		=>'/home/szmsk/perl/windykacja',
'info_file1'	=>'/home/szmsk/perl/windykacja/cfg/info1.sh',
'blokada_file1'	=>'/home/szmsk/perl/windykacja/cfg/blokada1.sh',
'info_file2'    =>'/home/szmsk/perl/windykacja/cfg/info2.sh',
'blokada_file2' =>'/home/szmsk/perl/windykacja/cfg/blokada2.sh'
);

our $Q1= << "EOF";
select  sum.id_abon , sum.nazwa, sum.saldo, sum(tcena), sum.status, sum.platnosc, sum.id_spw, sum.id_wnd, sum.krok, sum.saldo_dop from
    (
    select a.id_abon, n.nazwa, a.saldo, u.status, sum(t.cena) as tcena, a.platnosc, s.id_spw, w.id_wnd, w.krok, a.saldo_dop from
    ((((abonenci a join umowy_abonenckie u on a.id_abon=u.id_abon and u.status=\'Obowiązująca\')
    join (nazwy n full join (komputery k join pakiety p on p.id_urz=k.id_komp and p.aktywny_od<=\'$data\' and p.aktywny_do>=\'$data\') on n.id_abon=k.id_abon and k.fv=\'T\' and n.wazne_od <= \'$data\' and n.wazne_do >=\'$data\' )
    on a.id_abon=n.id_abon) join towary_sprzedaz t on p.id_usl=t.id_tows)
    left join ( sprawy_windykacyjne s join windykowanie w on s.id_spw=w.id_spw and w.data_zak is null and s.zwindykowana=\'N\') on s.id_abon=a.id_abon)
    group by a.id_abon, n.nazwa, a.saldo, u.status, a.platnosc, s.id_spw, w.id_wnd, w.krok, a.saldo_dop
    union
    select a.id_abon, n.nazwa, a.saldo, u.status, sum(t.cena) as tcena, a.platnosc, s.id_spw, w.id_wnd, w.krok, a.saldo_dop from
    ((((abonenci a join umowy_abonenckie u on a.id_abon=u.id_abon and u.status=\'Obowiązująca\')
    join (nazwy n full join (telefony_voip v  join pakiety p on p.id_urz=v.id_tlv and p.aktywny_od<=\'$data\' and p.aktywny_do>=\'$data\') on n.id_abon=v.id_abon and v.fv=\'T\' and n.wazne_od <= \'$data\' and n.wazne_do >=\'$data\' )
    on a.id_abon=n.id_abon) join towary_sprzedaz t on p.id_usl=t.id_tows)
    left join ( sprawy_windykacyjne s join windykowanie w on s.id_spw=w.id_spw and w.data_zak is null and s.zwindykowana=\'N\') on s.id_abon=a.id_abon)
    group by a.id_abon, n.nazwa, a.saldo, u.status, a.platnosc, s.id_spw, w.id_wnd, w.krok, a.saldo_dop
    union
    select a.id_abon, n.nazwa, a.saldo, u.status, sum(t.cena) as tcena, a.platnosc, s.id_spw, w.id_wnd, w.krok, a.saldo_dop from
    ((((abonenci a join umowy_abonenckie u on a.id_abon=u.id_abon and u.status=\'Obowiązująca\')
    join (nazwy n full join (settopboxy x  join pakiety p on p.id_urz=x.id_stb and p.aktywny_od<=\'$data\' and p.aktywny_do>=\'$data\') on n.id_abon=x.id_abon and x.fv=\'T\' and n.wazne_od <= \'$data\' and n.wazne_do >=\'$data\' )
    on a.id_abon=n.id_abon) join towary_sprzedaz t on p.id_usl=t.id_tows)
    left join ( sprawy_windykacyjne s join windykowanie w on s.id_spw=w.id_spw and w.data_zak is null and s.zwindykowana=\'N\') on s.id_abon=a.id_abon)
    group by a.id_abon, n.nazwa, a.saldo, u.status, a.platnosc, s.id_spw, w.id_wnd, w.krok, a.saldo_dop
    union
    select a.id_abon, n.nazwa, a.saldo, u.status, sum(t.cena) as tcena, a.platnosc, s.id_spw, w.id_wnd, w.krok, a.saldo_dop from
    ((((abonenci a join umowy_abonenckie u on a.id_abon=u.id_abon and u.status=\'Obowiązująca\')
    join (nazwy n full join komputery k on n.id_abon=k.id_abon and k.fv=\'T\' and n.wazne_od <= \'$data\' and n.wazne_do >=\'$data\' )
    on a.id_abon=n.id_abon) join (uslugi_dodatkowe ud join towary_sprzedaz t on ud.id_usl=t.id_tows and ud.aktywna_od<=\'$data\' and ud.aktywna_do>=\'$data\') on k.id_komp=ud.id_urz and ud.fv=\'T\')
    left join ( sprawy_windykacyjne s join windykowanie w on s.id_spw=w.id_spw and w.data_zak is null and s.zwindykowana=\'N\') on s.id_abon=a.id_abon)
    group by a.id_abon, n.nazwa, a.saldo, u.status, a.platnosc, s.id_spw, w.id_wnd, w.krok, a.saldo_dop
    union
    select a.id_abon, n.nazwa, a.saldo, u.status, sum(t.cena) as tcena, a.platnosc, s.id_spw, w.id_wnd, w.krok, a.saldo_dop from
    ((((abonenci a join umowy_abonenckie u on a.id_abon=u.id_abon and u.status=\'Obowiązująca\')
    join (nazwy n full join telefony_voip tl on n.id_abon=tl.id_abon and tl.fv=\'T\' and n.wazne_od <= \'$data\' and n.wazne_do >=\'$data\' )
    on a.id_abon=n.id_abon) join (uslugi_dodatkowe ud join towary_sprzedaz t on ud.id_usl=t.id_tows and ud.aktywna_od<=\'$data\' and ud.aktywna_do>=\'$data\') on tl.id_tlv=ud.id_urz and ud.fv=\'T\')
    left join ( sprawy_windykacyjne s join windykowanie w on s.id_spw=w.id_spw and w.data_zak is null and s.zwindykowana=\'N\') on s.id_abon=a.id_abon)
    group by a.id_abon, n.nazwa, a.saldo, u.status, a.platnosc, s.id_spw, w.id_wnd, w.krok, a.saldo_dop			    
    union
    select a.id_abon, n.nazwa, a.saldo, u.status, sum(t.cena) as tcena, a.platnosc, s.id_spw, w.id_wnd, w.krok, a.saldo_dop from
    ((((abonenci a join umowy_abonenckie u on a.id_abon=u.id_abon and u.status=\'Obowiązująca\')
    join (nazwy n full join settopboxy x on n.id_abon=x.id_abon and x.fv=\'T\' and n.wazne_od <= \'$data\' and n.wazne_do >=\'$data\' )
    on a.id_abon=n.id_abon) join (uslugi_dodatkowe ud join towary_sprzedaz t on ud.id_usl=t.id_tows and ud.aktywna_od<=\'$data\' and ud.aktywna_do>=\'$data\') on x.id_stb=ud.id_urz and ud.fv=\'T\')
    left join ( sprawy_windykacyjne s join windykowanie w on s.id_spw=w.id_spw and w.data_zak is null and s.zwindykowana=\'N\') on s.id_abon=a.id_abon)
    group by a.id_abon, n.nazwa, a.saldo, u.status, a.platnosc, s.id_spw, w.id_wnd, w.krok, a.saldo_dop
    )
    as sum group by sum.id_abon, sum.nazwa, sum.saldo, sum.status, sum.platnosc, sum.id_spw, sum.id_wnd, sum.krok, sum.saldo_dop order by 2;
EOF

our $Q2= << "EOF";
select i.ip, k.id_abon, n.nazwa, a.saldo, a.saldo_dop 
from (( (nazwy n join komputery k on n.id_abon=k.id_abon and k.fv=\'T\' and n.wazne_do>=\'$data\') 
join abonenci a on a.id_abon=n.id_abon and a.saldo<a.saldo_dop)  join adresy_ip i on k.id_komp=i.id_urz)
join ((windykowanie w join sprawy_windykacyjne s on w.id_spw=s.id_spw and w.krok like \'info%\' and w.data_zak is NULL) 
left join odczyt_infa o on o.id_wnd=w.id_wnd) on s.id_abon=n.id_abon
order by n.nazwa;
EOF

our $Q3= << "EOF";
select i.ip, k.id_abon, n.nazwa, count(czas_odczytu)
from nazwy n, komputery k, adresy_ip i, windykowanie w, sprawy_windykacyjne s, odczyt_infa o
where i.id_urz=k.id_komp and w.id_wnd=o.id_wnd and w.id_spw=s.id_spw and k.id_abon=s.id_abon
and w.krok=\'info\' and n.id_abon=k.id_abon and n.wazne_do>=\'$data\' and w.data_zak is NULL
group by i.ip, k.id_abon, n.nazwa
having count(czas_odczytu) < $conf{info_count}
order by n.nazwa;
EOF

our $Q4= << "EOF";
select i.ip, k.id_abon, n.nazwa, a.saldo, a.saldo_dop, a.platnosc
from nazwy n, komputery k, adresy_ip i, windykowanie w, sprawy_windykacyjne s, abonenci a
where i.id_urz=k.id_komp  and w.id_spw=s.id_spw and k.id_abon=s.id_abon and n.id_abon=a.id_abon and a.saldo<a.saldo_dop
and w.krok not in (\'obserwacja\', \'sms\', \'mail\',\'info\', \'info2\') and n.id_abon=k.id_abon and n.wazne_do>=\'$data\' and w.data_zak is NULL
order by n.nazwa;
EOF

