<?php

$DBTYPE="pgsql";
$USER="szmsk";
$PASS="szmsk";
$HOST="localhost";
$DBNAME1="szmsk2";

$DBTYPE2="pgsql";
$USER2="lms";
$PASS2="lms";
$HOST2="localhost";
$DBNAME2="lms2";

$DBTYPE3="mysql";
$USER3="node";
$PASS3="jQmNAKrPVTfA2bFY";
$HOST3="172.30.8.250";
$DBNAME3="nodes";

$conf['path']="/home/szmsk2";
$conf['wyswietl_sql']='true';

$firma['nazwa']="NETICO Systemy Informatyczne";
$firma['nazwa2']="mgr inż. Mirosław Borodziuk";
//$firma['nazwa2']="M.Borodziuk, M.Pielorz, K.Rogacki";
$firma['kod']="41-400";
$firma['miasto']="Mysłowice";
$firma['ulica']="Szopena";
$firma['nr_bud']="26";
$firma['adres']="41-400 Mysłowice, ul. Szopena 26";
$firma['wojewodztwo']="śląskie";
$firma['powiat']="Mysłowice";
$firma['gmina']="Mysłowice";
$firma['lokal']="";

$firma['nip']="222-073-85-59";
$firma['regon']="240792386";
$firma['bank']="MBANK";
$firma['konto']="79 1140 2004 0000 3402 7466 4139";
$firma['konto2']="50 1020 5558 1111 1710 9720 0080";
$firma['konto3']="44 2030 0061 3800 0000 0000";
$firma['wyciag']="pko";
$firma['wyciag2']="inteligo";
$firma['wyciag3']="bgz";
$firma['prowizja']="5";
$firma['wystawil']="mgr inż. Mirosław Borodziuk; mgr inż. Michał Pielorz; mgr inż. Krzysztof Rogacki; Kazimiera Borodziuk; mgr Marzena Stelmach";

$firma['strona1']="www.netico.pl";
$firma['strona2']="w w w . n e t i c o . p l";
$firma['email1']="netico@netico.pl";
$firma['email2']="b i u r o @ n e t i c o . p l";
$firma['email3']="finanse@netico.pl";
$firma['telefon1']="32 745 33 33";
$firma['fax']="32 745 33 34";


/////////////Można kopiować//////////////////////////////////////////

error_reporting(E_ERROR | E_WARNING | E_PARSE);
	
if( !isset($_SESSION['login']) )
	$_SESSION['login']=0;
if( !isset($_SESSION['hasło']) )
	$_SESSION['hasło']=0;

$conf['tuser']="szmsk";
$conf['tpwd']="szmsk";
$conf['cuser']="cron";
$conf['cpwd']="norc2013c300";

$conf['upload']=$conf['path']."/upload";
$conf['feed']=$conf['path']."/feed";
$conf['select']=">>>>>";
$conf['bgc_active']="#D7D7D7";
$conf['font1']="Tahoma";

$conf['data']=date("Y-m-d");
$conf['pierwszy']=date("Y-m-01");
$conf['wazne_od']='2000-01-01';
$conf['wazne_do']='2100-01-01';
$conf['ostatnidzm']=date('Y-m-d', mktime(23,59,59,date('m')+1,0,date('Y')));
$conf['poprzednidzien']=date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d'))));
 
$conf['smtp']='smtp.netico.pl';
$conf['szmsk_logo']='graphics/szmsk.jpg';
$conf['url_logo']='<img src=\"../data/FakturaLogo.jpg\" width=\"140\" height=\"30\"/>';
$conf['pdf_logo1']=$conf['path']."/public_html/data/FakturaLogo.jpg";
$conf['krd_logo']=$conf['path']."/public_html/graphics/krdsmall.jpg";
$conf['krdbig_logo']=$conf['path']."/public_html/graphics/krd.jpg";
$conf['table_color']='silver';
$conf['awarie_sms']="serwisnetico1@plusnet.pl; serwisnetico2@plusnet.pl; netico.661873873@plusnet.pl; netico.661874874@plusnet.pl; netico.661875875@plusnet.pl";
//$conf['awarie_sms']="numernetico2@plusnet.pl;";
$conf['awarie_email']="awarie@netico.pl";
$conf['zlecenia_email']="zlecenia@netico.pl";

$conf['wypowiedzenia_email']="szmsk@netico.pl; rszymanski@netico.pl";
$conf['szmsk_email']="szmsk@netico.pl";
$conf['pismaprzych_email']=$conf['szmsk_email'];
$conf['um_email']="mborodziuk@netico.pl";
$conf['serwis_email']="serwis@netico.pl";


$conf['width2']='100%';
$conf['height2']='75px';


$conf['etapy']= array('tr5'=>$conf['select'], 'tr3'=>"nieruszany", 'tr6'=>"stary", 'tr7'=>"ustalenia", 
'tr8'=>"umr",'tr9'=>"umówiony", 'tr10'=>"zlecenie", 'tr11'=>"realizacja", 'tr12'=>"pu", 'tr13'=>"podłączony", 'tr14'=>"bmt",
'tr15'=>"rezygnacja", 'tr16'=>"przeterminowany", 'tr17'=>"pwu", 'tr18'=>"umowa");


$conf['negotiate']= array('tr5'=>$conf['select'], 'tr3'=>"telefon", 'tr6'=>"wysyłka", 'tr7'=>"oczekiwanie", 
'tr8'=>"zawarta",'tr9'=>"umówiony", 'tr15'=>"rezygnacja", 'tr16'=>"przeterminowany");


$conf['kroki']= array('tr1'=>$conf['select'], 'tr2'=>"obserwacja", 'tr3'=>"mail", 'tr4'=>"sms", 
'tr5'=>"info", 'tr6'=>"info2", 'tr7'=>"blokada", 'tr8'=>"pismo", 'tr9'=>"krd", 'tr10'=>"nota",
'tr11'=>"firma", 'tr12'=>"pozew", 'tr13'=>"sąd", 'tr14'=>"odrzucone", 'tr15'=>"wykonalność", 
'tr16'=>"komornik", 'tr17'=>"problem", 'tr18'=>"niewypłacalny");


$conf['zlecenia_rodzaje']= array( 'tr5'=>$conf['select'], 'tr3'=>"inny", 'tr6'=>"instalacja", 'tr7'=>"demontaż", 
'tr8'=>"przeniesienie",'tr9'=>"konfiguracja_rt");

$bgz['user']="miroslaw.borodziuk";
$bgz['pass']="Foto32Nika08";
$bgz['iden']="2030006138";

//$file['func']="/";

$conf['dzierzawa_stb']='USL0437';
$conf['ipzewn']='USL0236';
$conf['ipzewn2']='USL1393';

$conf['antywirus']='USL0479';
//PLUS
$conf['addsrv1']='USL0547';
// HBO SD
$conf['addsrv2']='USL0548';
// HBO HD
$conf['addsrv3']='USL0546';
// Discovery HD 
$conf['addsrv4']='USL0549';
// Media Player
$conf['addsrv5']='USL0580';
// WiFi
$conf['addsrv6']='USL0581';
// PVR
$conf['addsrv7']='USL0715';
// Cinemax
$conf['addsrv8']='USL0717';
// Canal+ Silver 12 mcy
$conf['addsrv9']='USL0679';
// Canal+ Gold
$conf['addsrv10']='USL0680';
// Canal+ Premium
$conf['addsrv11']='USL0681';
// Discovery HD
$conf['addsrv12']='USL0549';
// Republika TV
$conf['addsrv13']='USL0771';
// Blokada po przekroczeniu pakietu
$conf['addsrv14']='USL0837';
// Canal+ Select
$conf['addsrv15']='USL1138';
// Canal+ Prestige
$conf['addsrv16']='USL1139';

$conf['vmanm']='10';
$conf['vmano']='10';
$conf['vmngm']='9';
$conf['vmngo']='9';
$conf['vlanm']='1';
$conf['vlano']='1';



$session['invoices']['pagination']=$_SESSION['login']."-invoices-pagination";
$session['node']['pagination']=$_SESSION['login']."-node-pagination";
$session['building']['pagination']=$_SESSION['login']."-building-pagination";
$session['payments']['pagination']=$_SESSION['login']."-payments-pagination";
$session['abonent']['update']=$_SESSION['login']."-abonent-update";
$session['komp']['update']=$_SESSION['login']."-komp-update";
$session['komp']['pagination']=$_SESSION['login']."-komp-pagination";

$session['windykacja']['pagination']=$_SESSION['login']."-windykacja-pagination";

$session['mac']['update']=$_SESSION['login']."-mac-update";
$session['router']['update']=$_SESSION['login']."-router-update";
$session['cpe']['update']=$_SESSION['login']."-cpe-update";
$session['onu']['update']=$_SESSION['login']."-onu-update";
$session['node']['update']=$_SESSION['login']."-node-update";
$session['ap']['update']=$_SESSION['login']."-ap-update";
$session['olt']['update']=$_SESSION['login']."-olt-update";
$session['odf']['update']=$_SESSION['login']."-odf-update";
$session['spliter']['update']=$_SESSION['login']."-spliter-update";
$session['pdk']['update']=$_SESSION['login']."-pdk-update";
$session['skt']['update']=$_SESSION['login']."-skt-update";
$session['trt']['update']=$_SESSION['login']."-trt-update";
$session['mufa']['update']=$_SESSION['login']."-mufa-update";
$session['line']['update']=$_SESSION['login']."-line-update";
$session['ifc']['update']=$_SESSION['login']."-ifc-update";
$session['ivn']['update']=$_SESSION['login']."-ivn-update";



$QUERY1="select distinct u.nazwa,b.numer, u.miasto, b.id_bud  from ulice u, budynki b where b.id_ul = u.id_ul  order by u.nazwa,  b.numer, u.miasto";
$QUERY2="select a.id_abon, n.symbol, n.nazwa from abonenci a, nazwy n where a.id_abon=n.id_abon and a.aktywny='T' and n.wazne_od <= '$conf[data]' and n.wazne_do >='$conf[data]' order by n.nazwa, n.symbol";
$QUERY4="select distinct pojemnosc from grupy order by pojemnosc";
$QUERY5="select symbol from towary_sprzedaz where symbol like '%i%' order by symbol";
$QUERY6="select login, id_konta from konta order by login";
$QUERY7="select nazwa from domeny order by nazwa";
$QUERY8="select symbol, id_inst from instytucje order by symbol, id_inst";
$QUERY9="select nazwa, nazwa2, cecha, kod, miasto, gmina, id_ul from ulice order by nazwa, miasto";
$QUERY10="select symbol,id_dost from dostawcy order by symbol";
$QUERY11="select symbol, id_inst from instytucje order by symbol, id_inst";
$QUERY12="select nazwa, id_prac from pracownicy order by nazwa, id_prac";
$QUERY13="select nazwa, id_pracy from prace order by nazwa, id_pracy";
$QUERY14="select u.nazwa, b.numer, m.nr_lok, u.miasto, m.id_msi  from ulice u, budynki b, miejsca_instalacji m where b.id_ul = u.id_ul and b.id_bud=m.id_bud order by u.nazwa,  b.numer, m.nr_lok, u.miasto";


$Q11="select id_sch from scheduler order by id_sch desc limit 1";
$Q12="select adres, maska, id_pds from podsieci  order by adres";
$Q13="select tag, nazwa, id_vln from vlany order by tag";
$Q14="select nr_rej from pojazdy order by nr_rej";
$Q15="select nazwa, id_prac from pracownicy where zatrudniony='T' order by nazwa, id_prac";


$QA1="select id_abon from abonenci order by id_abon desc limit 1";
$QA2="select id_nzw from nazwy order by id_nzw desc limit 1";
$QA3="select id_sdb from adresy_siedzib order by id_sdb desc limit 1";

$QA4="select distinct pojemnosc from grupy order by pojemnosc";
$QA5="select symbol, id_tows from towary_sprzedaz where nazwa like 'Dostęp do Internetu %' and vat='23' order by symbol";
$QA6="select login, id_konta from konta order by login";
$QA7="select nazwa from domeny order by nazwa";
$QA8="select distinct uprawnienia from grupy order by uprawnienia";
$QA9="select symbol, id_tows from towary_sprzedaz where nazwa like 'Abonament telefoniczny -%' and vat='23' order by symbol";
$QA10="select producent, nr_seryjny, id_bmk from bramki_voip order by producent, nr_seryjny, id_bmk";
$QA11="select symbol, id_tows from towary_sprzedaz where nazwa like 'Telewizja cyfrowa%' and vat='8' or symbol like 'TV%'  order by symbol";
$QA12="select cena from towary_sprzedaz where symbol='ulga-kabel-24'";
$QA13="select k.nazwa_smb, k.id_komp from komputery k, nazwy n where n.id_abon=k.id_abon order by n.nazwa";
$QA14="select i.ssid, i.nazwa, i.id_ifc from nadajniki w, interfejsy_wezla i where w.id_nad=i.id_wzl and i.warstwa='sieć dostępowa' and technologia='WiFi' order by w.nazwa";
$QA15="select id_bud from budynki order by id_bud desc limit 1";
$QA16="select id_ul from ulice order by id_ul desc limit 1";
$QA17="select symbol, id_tows from towary_sprzedaz where nazwa like 'Dzierżawa%' order by symbol";
$QA18="select nazwa, id_wzl from (select w.nazwa, w.id_wzl from wezly w  union all select w.nazwa, w.id_nad from nadajniki w  union all select w.nazwa, w.id_olt from olt w ) as query order by 1";
$QA19="(select w.nazwa, a.ip, iv.id_ivn from wezly w, adresy_ip a, inst_vlanu iv, podsieci p where iv.id_wzl=w.id_wzl and a.id_urz=iv.id_ivn and a.id_pds=p.id_pds and p.warstwa in ('dostep_pryw','dostep_publ'))
union
(select n.nazwa, a.ip, iv.id_ivn from nadajniki n, adresy_ip a, inst_vlanu iv, podsieci p where iv.id_wzl=n.id_nad and a.id_urz=iv.id_ivn and a.id_pds=p.id_pds and p.warstwa in ('dostep_pryw','dostep_publ')) order by 1";
$QA20="select typ, mac, id_stb from settopboxy order by id_stb";
$QA21="select nazwa, id_trf from taryfy_internet where aktywna='T' order by nazwa";
$QA22="(select w.nazwa, i.nazwa, i.id_ifc from wezly w, interfejsy_wezla i where 
w.id_wzl=i.id_wzl and i.rdzen='T' and i.dystrybucja='T' and i.dostep='N' order by w.nazwa)
union
(select w.nazwa, i.nazwa, i.id_ifc from nadajniki w, interfejsy_wezla i where 
w.id_nad=i.id_wzl and i.rdzen='T' and i.dystrybucja='T'  and i.dostep='N' order by w.nazwa)";

$QA23="(select nazwa, id_odf from odf)  union (select nazwa, id_spt from spliter )  order by 1";
$QA24="(select nazwa, id_muf from mufy)  union (select nazwa, id_odf from odf )  order by 1";
$QA25="select l.nazwa, t.kolor_kanal, t.id_trt from line l, trakty t where t.id_lin=l.id_lin and typ_linii='linia kablowa' order by l.nazwa, t.kolor_kanal";
$QA26="(select nazwa, id_wzl from wezly order by nazwa) union (select nazwa, id_nad from nadajniki order by nazwa)";
$QA27="select symbol, id_tows from towary_sprzedaz where nazwa like 'Pakiet telewizyjny%' and vat='8' or nazwa like '%PVR' or nazwa like '%media player' or nazwa like 'Telewizja cyfrowa - WiFi%' order by symbol";
$QA28="select symbol, id_tows from towary_sprzedaz where nazwa like 'Dzierżawa%' order by symbol";
$QA29="select symbol, id_tows from towary_sprzedaz where nazwa like 'Internet mobilny%' order by symbol";
$QA30="select symbol, id_tows from towary_sprzedaz where nazwa like 'Doładowanie%' order by symbol";
$QA31="select distinct s.typ, s.mac, s.id_stb from settopboxy s where  s.aktywny='N' order by s.typ, s.mac";
$QA32="select typ, mac, id_cpe from cpe where aktywne='N' ";
$QA33="select typ, mac, id_onu from onu where where aktywne='N'";
$QA34="select numer, id_tlv from telefony_voip where aktywny='N'";
$QA35="select number, id_sim from sim where active='N'";
$QA36="select model, sn, id_mdm from modem where active='N' ";
$QA37="select distinct typ, mac, id_rtr from router where  aktywny='N'";
$QA38="select numer, id_tlv from telefony_voip order by numer";
$QA39="select symbol, id_tows from towary_sprzedaz where symbol is not null order by symbol";

?>
