<?php


$conf[wyswietl_sql]='false';

$firma[nazwa]="NETICO S.C.";
$firma[nazwa2]="M.Pielorz, K.Rogacki, J.Borodziuk";
//$firma[nazwa2]="M.Borodziuk, M.Pielorz, K.Rogacki";
$firma[kod]="41-400";
$firma[miasto]="Mysłowice";
$firma[ulica]="Szopena";
$firma[nr_bud]="26";
$firma[adres]="41-400 Mysłowice, ul. Szopena 26";

$firma[nip]="222-083-95-10";
$firma[regon]="240792386";
$firma[bank]="BGŻ S.A.";
$firma[konto]="22 1020 2528 0000 0402 0205 6158";
$firma[konto2]="50 1020 5558 1111 1710 9720 0080";
$firma[konto3]="44 2030 0061 3800 0000 0000";
$firma[wyciag]="pko";
$firma[wyciag2]="inteligo";
$firma[wyciag3]="bgz";
$firma[prowizja]="5";
$firma[wystawil]="mgr inż. Michał Pielorz; mgr inż. Krzysztof Rogacki; Kazimiera Borodziuk; mgr Marzena Stelmach; mgr inż. Mirosław Borodziuk";
$firma[strona1]="www.netico.pl";
$firma[strona2]="w w w . n e t i c o . p l";
$firma[email1]="netico@netico.pl";
$firma[email2]="b i u r o @ n e t i c o . p l";
$firma[email3]="finanse@netico.pl";
$firma[telefon1]="32 745 33 33";
$firma[fax]="32 745 33 34";

$conf[upload] = "/home/szmsk/upload";
$conf[feed]="/home/szmsk/feed";
$conf[select]=">>>>>";
$conf[bgc_active]="#D7D7D7";
$conf[font1]="Tahoma";

$conf[data]=date("Y-m-d");
$conf[pierwszy]=date("Y-m-01");
$conf[wazne_od]='2000-01-01';
$conf[wazne_do]='2100-01-01';
$conf[smtp]='smtp.netico.pl';
$conf[szmsk_logo]='graphics/szmsk.jpg';
$conf[pdf_logo1]='/home/szmsk/public_html/data/FakturaLogo.jpg';
$conf[krd_logo]='/home/szmsk/public_html/graphics/krdsmall.jpg';
$conf[krdbig_logo]='/home/szmsk/public_html/graphics/krd.jpg';
$conf[table_color]='silver';
$conf[awarie_sms]="serwisnetico1@plusnet.pl; serwisnetico2@plusnet.pl; serwisnetico3@plusnet.pl; serwisnetico4@plusnet.pl";
$conf[awarie_mce]="serwisnetico1@plusnet.pl; serwisnetico2@plusnet.pl";
$conf[awarie_oim]="serwisnetico3@plusnet.pl; serwisnetico4@plusnet.pl";
//$conf[awarie_sms]="numernetico2@plusnet.pl;";
$conf[awarie_email]="awarie@netico.pl";
$conf[zlecenia_email]="zlecenia@netico.pl";
$conf[width2]='980px';
$conf[height2]='75px';

$DBTYPE="pgsql";
$USER="szmsk";
$PASS="szmsk";
$HOST="localhost";
$DBNAME1="szmsk";
//$file[func]="/";

$conf[dzierzawa_stb]='USL0437';
$conf[ipzewn]='USL0236';
$conf[antywirus]='USL0479';
//PLUS
$conf[addsrv1]='USL0547';
// HBO SD
$conf[addsrv2]='USL0548';
// HBO HD
$conf[addsrv3]='USL0546';
// Discovery HD 
$conf[addsrv4]='USL0549';
// Media Player
$conf[addsrv5]='USL0580';
// PVR
$conf[addsrv6]='USL0581';
// Utrzymanie linii
$conf[addsrv7]='USL0636';

$conf[vmanm]='10';
$conf[vmano]='10';
$conf[vmngm]='9';
$conf[vmngo]='9';
$conf[vlanm]='1';
$conf[vlano]='1';

$QUERY1="select distinct u.nazwa,b.numer, u.miasto, b.id_bud  from ulice u, budynki b where b.id_ul = u.id_ul  order by u.nazwa,  b.numer, u.miasto";
$QUERY2="select a.id_abon, n.symbol, n.nazwa from abonenci a, nazwy n where a.id_abon=n.id_abon and a.aktywny='T' and n.wazne_od <= '$conf[data]' and n.wazne_do >='$conf[data]' order by n.nazwa, n.symbol";
$QUERY4="select distinct pojemnosc from grupy order by pojemnosc";
$QUERY5="select symbol from towary_sprzedaz where symbol like '%i%' order by symbol";
$QUERY6="select login, id_konta from konta order by login";
$QUERY7="select nazwa from domeny order by nazwa";
$QUERY8="select symbol, id_inst from instytucje order by symbol, id_inst";
$QUERY9="select nazwa, miasto, id_ul from ulice order by nazwa, miasto";
$QUERY10="select symbol,id_dost from dostawcy order by symbol";
$QUERY11="select symbol, id_inst from instytucje order by symbol, id_inst";
$QUERY12="select nazwa, id_prac from pracownicy where zatrudniony='T'order by nazwa, id_prac";
$QUERY13="select nazwa, id_pracy from prace order by nazwa, id_pracy";
$Q11="select id_sch from scheduler order by id_sch desc limit 1";
$Q12="select adres, maska, id_pds from podsieci where aktywna='T' and warstwa in ('dystrybucja', 'dostep_pryw','dostep_publ') order by adres";
$Q13="select tag, nazwa, id_vln from vlany order by tag";
$Q14="select nr_rej from pojazdy order by nr_rej";
$Q15="select nazwa, id_prac from pracownicy where zatrudniony='T' order by nazwa, id_prac";


$QA1="select id_abon from abonenci order by id_abon desc limit 1";
$QA2="select id_nzw from nazwy order by id_nzw desc limit 1";
$QA3="select id_sdb from adresy_siedzib order by id_sdb desc limit 1";

$QA4="select distinct pojemnosc from grupy order by pojemnosc";
$QA5="select symbol, id_tows from towary_sprzedaz where nazwa like 'Dostęp do Internetu %' and vat=23 order by symbol";
$QA6="select login, id_konta from konta order by login";
$QA7="select nazwa from domeny order by nazwa";
$QA8="select distinct uprawnienia from grupy order by uprawnienia";
$QA9="select symbol, id_tows from towary_sprzedaz where nazwa like 'Abonament telefoniczny -%' and vat=23 order by symbol";
$QA10="select producent, nr_seryjny, id_bmk from bramki_voip order by producent, nr_seryjny, id_bmk";
$QA11="select symbol, id_tows from towary_sprzedaz where nazwa like 'Telewizja cyfrowa%' and vat=8 or nazwa like 'Dzierżawa%' order by symbol";
$QA12="select cena from towary_sprzedaz where symbol='ulga-kabel-24'";
$QA13="select k.nazwa_smb, k.id_komp from komputery k, nazwy n where n.id_abon=k.id_abon order by n.nazwa";
$QA14="select w.nazwa, i.nazwa, i.id_ifc from wezly w, interfejsy_wezla i where w.id_wzl=i.id_wzl order by w.nazwa";
$QA15="select id_bud from budynki order by id_bud desc limit 1";
$QA16="select id_ul from ulice order by id_ul desc limit 1";
$QA17="select symbol, id_tows from towary_sprzedaz where nazwa like 'Dzierżawa%' order by symbol";
$QA18="select w.nazwa, w.id_wzl from wezly w order by w.nazwa";
$QA19="(select w.nazwa, a.ip, iv.id_ivn from wezly w, adresy_ip a, inst_vlanu iv, podsieci p where iv.id_wzl=w.id_wzl and a.id_urz=iv.id_ivn and a.id_pds=p.id_pds and p.warstwa in ('dostep_pryw','dostep_publ'))
union
(select c.id_cpe, a.ip, iv.id_ivn from cpe c, adresy_ip a, inst_vlanu iv, podsieci p where iv.id_wzl=c.id_cpe and a.id_urz=iv.id_ivn and a.id_pds=p.id_pds and p.warstwa in ('dostep_pryw','dostep_publ') and c.aktywne='N') order by 1";
?>
